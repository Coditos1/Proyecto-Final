<?php
include 'includes/header.php';

$conexion = mysqli_connect("127.0.0.1", "root", "", "industrial_maintenance");

if (!$conexion) {
    die("Error en la conexión: " . mysqli_connect_error());
}

// Filtrar resultados
$result_filter = isset($_POST['result_filter']) ? $_POST['result_filter'] : '';

// Modificar la consulta SQL para incluir el filtro
$sql = "SELECT 
    e.name AS equipment_name,
    t.name AS technician_name,
    mh.completionDate,
    mh.results,
    mh.observations
FROM maintenance_history mh
JOIN equipment e ON mh.equipment = e.id_equipment
JOIN technician t ON mh.id_user = t.id_technician";

if ($result_filter) {
    $sql .= " WHERE mh.results = ?";
}

$sql .= " ORDER BY mh.completionDate DESC;";

$stmt = $conexion->prepare($sql);
if ($result_filter) {
    $stmt->bind_param("s", $result_filter);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<body>
    <style>
        .tabla-container {
            max-height: 75vh; /* Increase max height of the table container */
            overflow-y: auto; /* Enable vertical scrolling if content exceeds height */
            margin-top: 20px; /* Top margin to separate from filters */
        }

        table {
            width: 100%; /* Ensure table takes full width of container */
            border-collapse: collapse; /* Collapse borders for better design */
        }

        th, td {
            padding: 10px; /* Internal spacing in cells */
            padding-left: 70px;
            text-align: center; /* Center text */
            border-bottom: 1px solid #ddd; /* Bottom line to separate rows */
            width: 20%; /* Ensure each column takes 20% of total width */
        }

        th {
            background-color: #f2f2f2; /* Background color for headers */
        }

        .filter-form {
            margin: 20px 0; /* Espaciado superior e inferior */
            padding: 15px; /* Espaciado interno */
            border: 1px solid #ddd; /* Borde alrededor del formulario */
            border-radius: 5px; /* Bordes redondeados */
            background-color: #f9f9f9; /* Color de fondo */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Sombra sutil */
        }

        .filter-form label {
            font-weight: bold; /* Negrita para las etiquetas */
            margin-right: 10px; /* Espaciado a la derecha */
        }

        .filter-form select {
            padding: 5px; /* Espaciado interno para el select */
            border: 1px solid #ccc; /* Borde del select */
            border-radius: 4px; /* Bordes redondeados */
            margin-right: 10px; /* Espaciado a la derecha */
        }

        .filter-form button {
            padding: 6px 12px; /* Espaciado interno del botón */
            background-color: orange; /* Color de fondo del botón */
            color: white; /* Color del texto del botón */
            border: none; /* Sin borde */
            border-radius: 4px; /* Bordes redondeados */
            cursor: pointer; /* Cambiar cursor al pasar sobre el botón */
            transition: background-color 0.3s; /* Transición suave para el color de fondo */
            width: 150px;
        }

        .filter-form button:hover {
            background-color: darkorange; /* Color de fondo al pasar el mouse */
        }
    </style>
    <main class="reporte-container">
    <section class="reportes-tabla">
    <h1>Maintenance Reports</h1>
    
    <form method="POST" action="" class="filter-form">
        <label for="result_filter">Filter by Result:</label>
        <select name="result_filter" id="result_filter">
            <option value="">All</option>
            <option value="Exitoso" <?php if ($result_filter == 'Exitoso') echo 'selected'; ?>>Exitoso</option>
            <option value="Requiere seguimiento" <?php if ($result_filter == 'Requiere seguimiento') echo 'selected'; ?>>Requiere seguimiento</option>
            <option value="No se pudo completar" <?php if ($result_filter == 'No se pudo completar') echo 'selected'; ?>>No se pudo completar</option>
        </select>
        <button type="submit">Filter</button>
    </form>

    <div class="tabla-container">
        <table>
            <thead>
                <tr>
                <th>Equipment Name</th>
                <th>Technician</th>
                <th>Completion Date</th>
                <th>Results</th>
                <th>Observations</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $estado_class = '';
                    switch ($row['results']) {
                        case 'Exitoso':
                            $estado_class = 'estado exitoso';
                            break;
                        case 'Pendiente':
                            $estado_class = 'estado seguimiento';
                            break;
                        case 'No se pudo completar':
                            $estado_class = 'estado no-completo';
                            break;
                    }
                    echo "<tr>
                            <td>{$row['equipment_name']}</td>
                            <td>{$row['technician_name']}</td>
                            <td>{$row['completionDate']}</td>
                            <td class='{$estado_class}'>{$row['results']}</td>
                            <td>{$row['observations']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No maintenance reports found.</td></tr>";
            }
            ?>
        </tbody>
        </div>
        </section>
    </main>
</body>
</html>