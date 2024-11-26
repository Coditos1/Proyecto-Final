<?php
include 'includes/header.php';

$conexion = mysqli_connect("127.0.0.1", "root", "", "industrial_maintenance");

if (!$conexion) {
    die("Error en la conexión: " . mysqli_connect_error());
} else {
    echo "";
}

$sql = "SELECT 
    e.name AS equipment_name,
    t.name AS technician_name,
    mh.completionDate,
    mh.results,
    mh.observations
FROM maintenance m
JOIN maintenance_history mh ON m.id_maintenance = mh.maintenance
JOIN equipment e ON m.equipment = e.id_equipment
JOIN technician t ON m.technician = t.id_technician
ORDER BY mh.completionDate DESC;
";

$result = $conexion->query($sql);
?>

<body>
    <h1>Maintenance Reports</h1>
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
                    echo "<tr>
                            <td>{$row['equipment_name']}</td>
                            <td>{$row['technician_name']}</td>
                            <td>{$row['completionDate']}</td>
                            <td>{$row['results']}</td>
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