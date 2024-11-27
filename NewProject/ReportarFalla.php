<?php
include 'includes/header.php';

$conexion = mysqli_connect("127.0.0.1", "root", "", "industrial_maintenance");

if (!$conexion) {
    die("Error en la conexión: " . mysqli_connect_error());
} else {
    echo "";
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
FROM maintenance m
JOIN maintenance_history mh ON m.id_maintenance = mh.maintenance
JOIN equipment e ON m.equipment = e.id_equipment
JOIN technician t ON m.technician = t.id_technician";

if ($result_filter) {
    $sql .= " WHERE mh.results = ?";
}

// Ordenar por fecha de finalización
$sql .= " ORDER BY mh.completionDate DESC;";

$stmt = $conexion->prepare($sql);
if ($result_filter) {
    $stmt->bind_param("s", $result_filter);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<body>
    <h1>Maintenance Reports</h1>
    
    <form method="POST" action="">
        <label for="result_filter">Filter by Result:</label>
        <select name="result_filter" id="result_filter">
            <option value="">All</option>
            <option value="Exitoso" <?php if ($result_filter == 'Exitoso') echo 'selected'; ?>>Exitoso</option>
            <option value="Requiere seguimiento" <?php if ($result_filter == 'Requiere seguimiento') echo 'selected'; ?>>Requiere seguimiento</option>
            <option value="No se pudo completar" <?php if ($result_filter == 'No se pudo completar') echo 'selected'; ?>>No se pudo completar</option>
        </select>
        <button type="submit">Filter</button>
    </form>

    <table class="reportes-tabla">
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
                        case 'Requiere seguimiento':
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
    </table>
</body>
</html>