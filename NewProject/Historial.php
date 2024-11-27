<?php
    include 'includes/header.php';

    $conexion = mysqli_connect("127.0.0.1", "root", "", "industrial_maintenance");

    if (!$conexion) {
        die("Error en la conexión: " . mysqli_connect_error());
    }

    // Inicializar variable para el orden
    $selected_date_order = isset($_POST['filtro_fecha']) ? $_POST['filtro_fecha'] : 'nueva'; // Por defecto, ordenar de más nuevo a más viejo

    // Construir la consulta SQL
    $sql_history = "SELECT mh.id_history, mh.completionDate AS maintenance_date, mh.results, mh.observations, e.name AS equipment
                    FROM maintenance_history mh
                    JOIN equipment e ON mh.equipment = e.id_equipment
                    WHERE 1=1"; // Condición siempre verdadera para facilitar la adición de filtros

    // Agregar orden a la consulta
    if ($selected_date_order == 'antigua') {
        $sql_history .= " ORDER BY mh.completionDate ASC"; // Ordenar de más viejo a más nuevo
    } else {
        $sql_history .= " ORDER BY mh.completionDate DESC"; // Ordenar de más nuevo a más viejo
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

            <!-- Formulario de ordenamiento -->
            <form method="POST" action="">
                <label for="filtro_fecha">Order by Date:</label>
                <select id="filtro_fecha" name="filtro_fecha" onchange="this.form.submit()">
                    <option value="nueva" <?php echo ($selected_date_order == 'nueva') ? 'selected' : ''; ?>>Newest to Oldest</option>
                    <option value="antigua" <?php echo ($selected_date_order == 'antigua') ? 'selected' : ''; ?>>Oldest to Newest</option>
                </select>
            </form>

            <div class="tabla-container">
                <table>
                    <thead>
                        <tr>
                            <th>Maintenance ID</th>
                            <th>Maintenance Date</th>
                            <th>Results</th>
                            <th>Observations</th>
                            <th>Equipment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result_history->num_rows > 0) {
                            while($row = $result_history->fetch_assoc()) {
                                echo "<tr>
                                        <td>#MANT" . $row['id_history'] . "</td>
                                        <td>" . $row['maintenance_date'] . "</td>
                                        <td>" . $row['results'] . "</td>
                                        <td>" . $row['observations'] . "</td>
                                        <td>" . $row['equipment'] . "</td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No maintenance records found.</td></tr>";
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


