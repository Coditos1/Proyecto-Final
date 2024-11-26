<?php
include 'includes/tecnav.php';
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id_user'];

$conexion = mysqli_connect("127.0.0.1", "root", "", "industrial_maintenance");

if (!$conexion) {
    die("Error en la conexión: " . mysqli_connect_error());
}

$sql_repuestos = "SELECT id_spareParts, name FROM spare_parts";
$result_repuestos = $conexion->query($sql_repuestos);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha_mantenimiento = $_POST['fecha_mantenimiento'];
    $resultados = $_POST['resultados'];
    $observaciones = $_POST['observaciones'];
    $repuesto_id = $_POST['repuesto'];
    $cantidad_usada = $_POST['cantidad_usada'];
    $id_orden = $_POST['id_orden'];

    $sql_insert = "INSERT INTO maintenance_history (completionDate, results, observations, spare_parts, usedQuantity, user_id) 
                   VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql_insert);
    $stmt->bind_param("ssssii", $fecha_mantenimiento, $resultados, $observaciones, $repuesto_id, $cantidad_usada, $user_id);
    $stmt->execute();

    if ($resultados == "Exitoso") {
        $sql_update = "UPDATE work_orders SET status = 'Completado' WHERE id_workOrders = ?";
        $stmt_update = $conexion->prepare($sql_update);
        $stmt_update->bind_param("i", $id_orden);
        $stmt_update->execute();
        $stmt_update->close();
    }
}
?>

<section id="reporte-mantenimiento">
    <h2>Maintenance Report</h2>
    <form method="POST" action="">
        <label for="id_orden">Work Order ID:</label>
        <input type="number" id="id_orden" name="id_orden" required>

        <label for="fecha_mantenimiento">Maintenance Date:</label>
        <input type="date" id="fecha_mantenimiento" name="fecha_mantenimiento" required>

        <label for="resultados">Maintenance Results:</label>
        <select id="resultados" name="resultados" required>
            <option value="Exitoso">Successful</option>
            <option value="No se pudo completar">Could not complete</option>
            <option value="Requiere seguimiento">Requires follow-up</option>
        </select>

        <label for="observaciones">Observations:</label>
        <textarea id="observaciones" name="observaciones" rows="4" required></textarea>

        <label for="repuesto">Spare Parts Used:</label>
        <select id="repuesto" name="repuesto" required>
            <?php while ($row = $result_repuestos->fetch_assoc()): ?>
                <option value="<?php echo $row['id_spareParts']; ?>"><?php echo $row['name']; ?></option>
            <?php endwhile; ?>
        </select>

        <label for="cantidad_usada">Quantity Used:</label>
        <input type="number" id="cantidad_usada" name="cantidad_usada" min="1" required>

        <button type="submit">Submit Report</button>
    </form>
</section>

</main>
</body>
</html>