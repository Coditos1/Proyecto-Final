<?php
    include 'includes/header.php';

    $conexion = mysqli_connect("127.0.0.1", "root", "", "industrial_maintenance");

    if (!$conexion) {
        die("Error en la conexión: " . mysqli_connect_error());
    } else {
        echo "";
    }

    $sql_history = "SELECT mh.id_history, mh.maintenance_date, mh.description, e.name AS equipment, o.name AS operator, mh.status
                    FROM maintenance_history mh
                    JOIN equipment e ON mh.equipment_id = e.id_equipment
                    JOIN operator o ON mh.operator_id = o.id_operator";

    $result_history = $conexion->query($sql_history);

    if (!$result_history) {
        die("Error en la consulta: " . $conexion->error);
    }
?>
    <main class="reporte-container">
        <section class="reportes-tabla">
            <div class="tabla-header">
                <h2>Historial de Mantenimiento</h2>
            </div>

            <div class="tabla-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID de Mantenimiento</th>
                            <th>Fecha de Mantenimiento</th>
                            <th>Descripción</th>
                            <th>Equipo</th>
                            <th>Operador</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result_history->num_rows > 0) {
                            while($row = $result_history->fetch_assoc()) {
                                echo "<tr>
                                        <td>#MANT" . $row['id_history'] . "</td>
                                        <td>" . $row['maintenance_date'] . "</td>
                                        <td>" . $row['description'] . "</td>
                                        <td>" . $row['equipment'] . "</td>
                                        <td>" . $row['operator'] . "</td>
                                        <td>" . $row['status'] . "</td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No se encontraron registros de mantenimiento.</td></tr>";
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


