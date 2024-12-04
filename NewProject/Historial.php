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
            <div class="tabla-header">
                <h2>Maintenance History</h2>
            </div>

            <!-- Formulario de ordenamiento -->
            <form method="POST" action="" class="filter-form">
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


