<?php
    include 'includes/header.php';

    $conexion = mysqli_connect("127.0.0.1", "root", "", "industrial_maintenance");

    if (!$conexion) {
        die("Error en la conexión: " . mysqli_connect_error());
    }

    // Inicializar variables para el filtrado
    $filter_date = isset($_POST['filter_date']) ? $_POST['filter_date'] : '';
    $filter_status = isset($_POST['filter_status']) ? $_POST['filter_status'] : '';

    // Construir la consulta SQL con filtros
    $sql_history = "SELECT mh.id_history, mh.completionDate AS maintenance_date, mh.description, e.name AS equipment, o.name AS operator, mh.status
                    FROM maintenance_history
                    JOIN equipment e ON mh.equipment = e.id_equipment
                    JOIN operator o ON mh.operator = o.id_operator
                    WHERE 1=1"; // Condición siempre verdadera para facilitar la adición de filtros

    // Agregar filtros a la consulta
    if (!empty($filter_date)) {
        $sql_history .= " AND mh.completionDate = '$filter_date'";
    }
    if (!empty($filter_status)) {
        $sql_history .= " AND mh.status = '$filter_status'";
    }

    $result_history = $conexion->query($sql_history);

    if (!$result_history) {
        die("Error en la consulta: " . $conexion->error);
    }
?>
    <main class="reporte-container">
        <section class="reportes-tabla">
            <div class="tabla-header">
                <h2>Maintenance History</h2>
            </div>

            <!-- Filter form -->
            <form method="POST" action="">
                <label for="filter_date">Filter by Date:</label>
                <input type="date" id="filter_date" name="filter_date" value="<?php echo $filter_date; ?>">

                <label for="filter_status">Filter by Status:</label>
                <select id="filter_status" name="filter_status">
                    <option value="">All</option>
                    <option value="Completed" <?php if ($filter_status == 'Completado') echo 'selected'; ?>>Completed</option>
                    <option value="Pending" <?php if ($filter_status == 'Pendiente') echo 'selected'; ?>>Pending</option>
                    <option value="In Progress" <?php if ($filter_status == 'En Proceso') echo 'selected'; ?>>In Progress</option>
                </select>

                <button type="submit">Filter</button>
            </form>

            <div class="tabla-container">
                <table>
                    <thead>
                        <tr>
                            <th>Maintenance ID</th>
                            <th>Maintenance Date</th>
                            <th>Description</th>
                            <th>Equipment</th>
                            <th>Operator</th>
                            <th>Status</th>
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
                            echo "<tr><td colspan='6'>No maintenance records found.</td></tr>";
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


