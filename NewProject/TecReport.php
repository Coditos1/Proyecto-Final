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

// Obtener los equipos disponibles
$sql_equipos = "SELECT id_equipment, name FROM equipment";
$result_equipos = $conexion->query($sql_equipos);

// Obtener los tipos de mantenimiento disponibles
$sql_mantenimientos = "SELECT id_maintType, name FROM maintenance_types";
$result_mantenimientos = $conexion->query($sql_mantenimientos);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha_mantenimiento = $_POST['fecha_mantenimiento'];
    $resultados = $_POST['resultados'];
    $observaciones = $_POST['observaciones'];
    $equipment_id = $_POST['equipment']; // ID del equipo
    $maintenance_id = $_POST['maintenance']; // ID del mantenimiento
    $id_orden = $_POST['id_orden']; // ID de la orden de trabajo

    // Inserción en la tabla maintenance_history
    $sql_insert = "INSERT INTO maintenance_history (completionDate, results, observations, equipment, maintenance, id_user) 
                   VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql_insert);
    
    // Asegúrate de que estás pasando los valores correctos
    $stmt->bind_param("ssssii", $fecha_mantenimiento, $resultados, $observaciones, $equipment_id, $maintenance_id, $user_id);
    
    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Actualizar el estado de la orden de trabajo si es exitoso
        if ($resultados == "Exitoso") {
            // Actualizar el estado de la orden de trabajo
            $sql_update = "UPDATE work_orders SET status = 'Completada' WHERE id_workOrders = ?";
            $stmt_update = $conexion->prepare($sql_update);
            $stmt_update->bind_param("i", $id_orden);
            $stmt_update->execute();
            $stmt_update->close();
        }
    } else {
        // Manejo de errores
        die("Error en la inserción: " . $stmt->error);
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

        <label for="equipment">Equipment:</label>
        <select id="equipment" name="equipment" required>
            <?php while ($row = $result_equipos->fetch_assoc()): ?>
                <option value="<?php echo $row['id_equipment']; ?>"><?php echo $row['name']; ?></option>
            <?php endwhile; ?>
        </select>

        <label for="maintenance">Maintenance Type:</label>
        <select id="maintenance" name="maintenance" required>
            <?php 
            if ($result_mantenimientos->num_rows > 0) {
                while ($row = $result_mantenimientos->fetch_assoc()) {
                    echo '<option value="' . $row['id_maintType'] . '">' . $row['name'] . '</option>';
                }
            } else {
                echo '<option value="">No maintenance types available</option>';
            }
            ?>
        </select>

        <button type="submit">Submit Report</button>
    </form>
</section>

</main>
</body>
</html>