<?php
include 'includes/tecnav.php';

$conexion = mysqli_connect("127.0.0.1", "root", "", "industrial_maintenance");

if (!$conexion) {
    die("Error en la conexión: " . mysqli_connect_error());
}

session_start();

$sql_ordenes = "SELECT wo.id_workOrders AS id_order, wo.creationDate AS assigned_date, wo.description, wo.status, e.name AS equipment_name 
                FROM work_orders wo 
                JOIN equipment e ON wo.equipment = e.id_equipment";
$stmt_ordenes = $conexion->prepare($sql_ordenes);
$stmt_ordenes->execute();
$result_ordenes = $stmt_ordenes->get_result();
?>

<section id="ordenes">
    <h2>Órdenes de Trabajo Asignadas</h2>
    <table>
        <thead>
            <tr>
                <th>ID Orden</th>
                <th>Fecha Asignada</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Equipo</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result_ordenes->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id_order']; ?></td>
                    <td><?php echo $row['assigned_date']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['equipment_name']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</section>

</main>
</body>
</html>