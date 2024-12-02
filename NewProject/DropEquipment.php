<!DOCTYPE html>
<html lang="es">
<head>
    <?php include "includes/header.php"; 
        $conexion = mysqli_connect("127.0.0.1", "root", "", "industrial_maintenance");

        if (!$conexion) {
            die("Error en la conexión: " . mysqli_connect_error());
        }
    
        $search_equipment = isset($_POST['search_equipment']) ? $_POST['search_equipment'] : '';

        // Consulta para obtener la lista de equipos
        $sql = "SELECT id_equipment, name, equipment_location FROM equipment";
        
        // Inicializar condiciones
        $conditions = [];
        
        // Si hay condiciones, agregar la cláusula WHERE
        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
    
        $result = $conexion->query($sql);
    
        if (!$result) {
            die("Error en la consulta: " . $conexion->error);
        }

        // Obtener las localizaciones disponibles
        $locations_query = "SELECT DISTINCT equipment_location FROM equipment";
        $locations_result = $conexion->query($locations_query);
        $locations = [];
        if ($locations_result) {
            while ($row = $locations_result->fetch_assoc()) {
                $locations[] = $row['equipment_location'];
            }
        }

        // Lógica para actualizar la información del equipo
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_equipment'])) {
            $id_equipment = $_POST['id_equipment'];
            $equipment_name = $_POST['equipment_name'];
            $equipment_location = $_POST['equipment_location'];

            // Validar que los campos no estén vacíos
            if (!empty($id_equipment) && !empty($equipment_name) && !empty($equipment_location)) {
                // Preparar la consulta de actualización
                $update_sql = "UPDATE equipment SET name = ?, equipment_location = ? WHERE id_equipment = ?";
                
                // Preparar la declaración
                $stmt = mysqli_prepare($conexion, $update_sql);
                mysqli_stmt_bind_param($stmt, "ssi", $equipment_name, $equipment_location, $id_equipment);

                // Ejecutar la declaración
                if (mysqli_stmt_execute($stmt)) {
                    // Redirigir o mostrar un mensaje de éxito
                    header("Location: DropEquipment.php?update=success");
                    exit();
                } else {
                    echo "Error al actualizar el equipo: " . mysqli_error($conexion);
                }

                // Cerrar la declaración
                mysqli_stmt_close($stmt);
            } else {
                echo "Por favor, complete todos los campos.";
            }
        }
    ?>
    <meta charset="UTF-8">
    <title>Lista de Equipos</title>
    <style>
        * {
            box-sizing: border-box; /* Asegura que el padding no afecte el ancho total */
        }

        .btn-accion {
            padding: 10px 15px;
            font-size: 12px;
            margin-left: 10px;
            cursor: pointer;
            width: 100px;
            height: auto;
            vertical-align: middle;
            background-color: #ff7f50; /* Orange color */
            border: none;
            border-radius: 5px;
            color: white;
            transition: background-color 0.3s;
        }

        .btn-accion:hover {
            background-color: #e76a3c; /* Darker orange on hover */
        }

        .filtros {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .filtros input[type="text"] {
            margin-right: 10px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 200px; /* Adjust width as needed */
        }

        .filtro-fecha {
            margin-left: 10px;
        }

        .tabla-container {
            max-height: 75vh; /* Increase max height of the table container */
            overflow-y: auto; /* Enable vertical scrolling if content exceeds height */
            margin-top: 20px; /* Top margin to separate from filters */
            padding: 0; /* Asegúrate de que no haya padding */
        }

        table {
            width: 100%; /* Ensure table takes full width of container */
            border-collapse: collapse; /* Collapse borders for better design */
            margin: 0; /* Asegúrate de que no haya margen */
            padding: 0; /* Asegúrate de que no haya padding */
        }

        th, td {
            padding: 10px; /* Internal spacing in cells */
            text-align: center; /* Center text */
            border-bottom: 1px solid #ddd; /* Bottom line to separate rows */
            width: 20%; /* Ensure each column takes 20% of total width */
        }

        th {
            background-color: #f2f2f2; /* Background color for headers */
        }

        tr:hover {
            background-color: #f5f5f5; /* Color de fondo al pasar el mouse */
        }

        /* Estilos para la sección de equipos */
        .equipment-list {
            margin-top: 20px;
        }

        .equipment-list input[type="text"] {
            margin-right: 10px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 200px; /* Ajustar el ancho según sea necesario */
        }

        .equipment-list .btn-accion {
            margin-left: 10px;
        }

        .tabla-container {
            max-height: 75vh; /* Aumentar la altura máxima del contenedor de la tabla */
            overflow-y: auto; /* Habilitar desplazamiento vertical si el contenido excede la altura */
            margin-top: 20px; /* Margen superior para separar de los filtros */
        }

        table {
            width: 100%; /* Asegurarse de que la tabla ocupe todo el ancho del contenedor */
            border-collapse: collapse; /* Colapsar bordes para un mejor diseño */
        }

        th, td {
            padding: 10px; /* Espaciado interno en las celdas */
            text-align: center; /* Centrar texto */
            border-bottom: 1px solid #ddd; /* Línea inferior para separar filas */
        }

        th {
            background-color: #f2f2f2; /* Color de fondo para encabezados */
        }

        /* Estilos para el modal */
        .modal {
            display: none; /* Ocultar por defecto */
            position: fixed; /* Fijo en la pantalla */
            z-index: 1000; /* Asegurarse de que esté por encima de otros elementos */
            left: 0;
            top: 0;
            width: 100%; /* Ancho completo */
            height: 100%; /* Altura completa */
            overflow: auto; /* Habilitar desplazamiento si es necesario */
            background-color: rgba(0, 0, 0, 0.5); /* Fondo oscuro con opacidad */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% desde la parte superior y centrado */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Ancho del modal */
            max-width: 500px; /* Ancho máximo del modal */
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Estilos para el select */
        select {
            padding: 10px; /* Espaciado interno */
            border: 1px solid #ccc; /* Borde */
            border-radius: 5px; /* Bordes redondeados */
            width: 100%; /* Ancho completo */
            background-color: #fff; /* Color de fondo */
            font-size: 16px; /* Tamaño de fuente */
            appearance: none; /* Eliminar el estilo predeterminado del navegador */
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10"><polygon points="0,0 10,0 5,5" fill="%23333"/></svg>'); /* Flecha personalizada */
            background-repeat: no-repeat; /* No repetir la imagen de fondo */
            background-position: right 10px center; /* Posicionar la flecha */
            background-size: 10px; /* Tamaño de la flecha */
        }

        /* Estilos para el select en hover */
        select:hover {
            border-color: #ff7f50; /* Cambiar el color del borde al pasar el mouse */
        }

        /* Estilos para el select en focus */
        select:focus {
            outline: none; /* Eliminar el contorno predeterminado */
            border-color: #ff7f50; /* Cambiar el color del borde al enfocar */
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<main class="reporte-container">
        
    <?php

    // Obtener el ID del equipo a eliminar
    if (isset($_POST['id'])) {
        $equipment_id = $_POST['id'];

        // Primero, eliminar las dependencias en failure_equipment
        $delete_failures_query = "DELETE FROM failure_equipment WHERE equipment = ?";
        $stmt_failures = mysqli_prepare($conexion, $delete_failures_query);
        mysqli_stmt_bind_param($stmt_failures, "i", $equipment_id);
        mysqli_stmt_execute($stmt_failures);
        mysqli_stmt_close($stmt_failures);

        // Luego, eliminar el equipo
        $delete_query = "DELETE FROM equipment WHERE id_equipment = ?";
        $stmt = mysqli_prepare($conexion, $delete_query);
        mysqli_stmt_bind_param($stmt, "i", $equipment_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // Código para obtener la lista actualizada de equipos
    $query = "SELECT id_equipment, name, equipment_location FROM equipment";
    $result = mysqli_query($conexion, $query);

    // Mostrar la lista de equipos actualizada
    if ($result && mysqli_num_rows($result) > 0) {
        echo "<table><tr><th>ID</th><th>Name</th><th>Ubication</th><th>Action</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>" . $row["id_equipment"] . "</td><td>" . $row["name"] . "</td><td>" . $row["equipment_location"] . "</td>
                  <td><button class='btn-accion' onclick='openModal(" . $row["id_equipment"] . ", \"" . addslashes($row["name"]) . "\", \"" . addslashes($row["equipment_location"]) . "\")'>Actualizar</button>
                      <form method='POST' action='DropEquipment.php' style='display:inline;'>
                          <input type='hidden' name='id' value='" . $row["id_equipment"] . "'>
                          <button type='submit' class='btn-accion eliminar' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este equipo?\");'>Eliminar</button>
                      </form>
                  </td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No hay equipos disponibles.</p>";
    }

    // Cerrar conexión
    mysqli_close($conexion);
    ?>
        </div>
    </section>
</main>

<!-- Modal para actualizar información del equipo -->
<div id="updateModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Update Equipment</h2>
        <form id="updateForm" method="POST" action="DropEquipment.php"> <!-- Cambia a la ruta correcta para procesar la actualización -->
            <input type="hidden" name="id_equipment" id="equipment_id">
            <label for="equipment_name">Name:</label>
            <input type="text" name="equipment_name" id="equipment_name" required>
            <label for="equipment_location">Location:</label>
            <select name="equipment_location" id="equipment_location" required>
                <option value="">Select Location</option>
                <?php foreach ($locations as $location): ?>
                    <option value="<?php echo htmlspecialchars($location); ?>"><?php echo htmlspecialchars($location); ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn-accion" style="margin-top: 15px;">Update</button>
        </form>
    </div>
</div>

<script>
function openModal(id, name, location) {
    document.getElementById('equipment_id').value = id;
    document.getElementById('equipment_name').value = name;
    document.getElementById('equipment_location').value = location;
    document.getElementById('updateModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('updateModal').style.display = 'none';
}

// Cerrar el modal si se hace clic fuera de él
window.onclick = function(event) {
    var modal = document.getElementById('updateModal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

</body>
</html>
