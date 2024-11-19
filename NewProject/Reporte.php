<?php
    include "includes/header.php";
 
    $conexion = mysqli_connect("127.0.0.1", "root", "", "industrial_maintenance");

    if (!$conexion) {
        die("Error en la conexión: " . mysqli_connect_error());
    } else {
        echo "";
    }

   
    $selected_severity = isset($_POST['filtro_severidad']) ? $_POST['filtro_severidad'] : '';

   
    $sql = "SELECT f.id_failure, f.date, f.description, o.name AS reported_by
            FROM failure f
            JOIN operator o ON f.operator = o.id_operator";

   
    if ($selected_severity) {
        $sql .= " WHERE f.severity = '$selected_severity'";
    }

    $result = $conexion->query($sql);

    
    if (!$result) {
        die("Error en la consulta: " . $conn->error);
    }

    if (isset($_POST['id_failure'])) {
        $id_failure = $_POST['id_failure'];

       
        $sql = "DELETE FROM failure WHERE id_failure = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id_failure);
    }
?>

    <style>
        .btn-accion {
            padding: 5px 10px;
            font-size: 12px;
            margin: 2px; 
            cursor: pointer;
            width: 100px;
            height: 50px;
            vertical-align: middle;
        }
    </style>
    <main class="reporte-container">
        <section class="reportes-tabla">
            <div class="tabla-header">
                <h2>Historial de Reportes</h2>
                <div class="filtros">
                    <form method="POST">
                        <select name="filtro_severidad" class="filtro-severidad" onchange="this.form.submit()">
                            <option value="">Todas las Severidades</option>
                            <option value="alta" <?php echo ($selected_severity == 'alta') ? 'selected' : ''; ?>>Alta</option>
                            <option value="media" <?php echo ($selected_severity == 'media') ? 'selected' : ''; ?>>Media</option>
                            <option value="baja" <?php echo ($selected_severity == 'baja') ? 'selected' : ''; ?>>Baja</option>
                        </select>
                    </form>
                </div>
            </div>

            <div class="tabla-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID de Reporte</th>
                            <th>Fecha</th>
                            <th>Descripción</th>
                            <th>Reportado Por</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>#REP" . $row['id_failure'] . "</td>
                                        <td>" . $row['date'] . "</td>
                                        <td>" . $row['description'] . "</td>
                                        <td>" . $row['reported_by'] . "</td>
                                        <td>
                                            <form method='POST' action='Supervisor.php' style='display:inline;'>
                                                <input type='hidden' name='id_failure' value='" . $row['id_failure'] . "'>
                                                <button type='submit' class='btn-accion generar'>Generar Orden</button>
                                            </form>
                                            <form method='POST' action='Reporte.php' style='display:inline;'>
                                                <input type='hidden' name='id_failure' value='" . $row['id_failure'] . "'>
                                                <button type='submit' class='btn-accion eliminar' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este reporte?\");'>Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No se encontraron reportes.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
<?php
    $conexion->close();
?>