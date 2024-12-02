<?php
include 'includes/tecnav.php';
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id_user'];

if ($user_id) {
    echo "ID de usuario en sesión: " . htmlspecialchars($user_id);
} else {
    echo "No se pudo obtener el ID de usuario.";
}

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

// Obtener las órdenes de trabajo pendientes para el id_user del técnico
$sql_work_orders = "SELECT id_workOrders, description, equipment FROM work_orders WHERE status = 'Pendiente' AND technician = ?";
$stmt_work_orders = $conexion->prepare($sql_work_orders);
$stmt_work_orders->bind_param("i", $user_id);
$stmt_work_orders->execute();
$result_work_orders = $stmt_work_orders->get_result();

// Obtener los equipos disponibles
$sql_equipos = "SELECT id_equipment, name FROM equipment";
$result_equipos = $conexion->query($sql_equipos);
$equipos = [];
while ($row = $result_equipos->fetch_assoc()) {
    $equipos[$row['id_equipment']] = $row['name']; // Almacena los equipos en un array
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha_mantenimiento = $_POST['fecha_mantenimiento'];
    $resultados = $_POST['resultados'];
    $observaciones = $_POST['observaciones'];
    $equipment = $_POST['equipment']; // ID del equipo
    $id_orden = $_POST['id_orden']; // ID de la orden de trabajo
    $maintenance_id = $id_orden; // Usar el mismo ID para maintenance

    // Inserción en la tabla maintenance_history
    $sql_insert = "INSERT INTO maintenance_history (completionDate, results, observations, equipment, maintenance, id_user) 
                   VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql_insert);
    
    // Asegúrate de que estás pasando los valores correctos
    $stmt->bind_param("ssssii", $fecha_mantenimiento, $resultados, $observaciones, $equipment, $id_orden, $user_id);
    
    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Actualizar el estado de la orden de trabajo y el estado de mantenimiento según el resultado
        if ($resultados == "Exitoso") {
            // Actualizar el estado de la orden de trabajo y el estado de mantenimiento a 'Completada'
            $sql_update_work_order = "UPDATE work_orders SET status = 'Completada' WHERE id_workOrders = ?";
            $stmt_update_work_order = $conexion->prepare($sql_update_work_order);
            $stmt_update_work_order->bind_param("i", $id_orden);
            $stmt_update_work_order->execute();
            $stmt_update_work_order->close();

            $sql_update_maintenance = "UPDATE maintenance SET status = 'Completado' WHERE id_maintenance = ?";
            $stmt_update_maintenance = $conexion->prepare($sql_update_maintenance);
            $stmt_update_maintenance->bind_param("i", $maintenance_id); // Usar el mismo ID
            $stmt_update_maintenance->execute();
            $stmt_update_maintenance->close();
        } elseif ($resultados == "No se pudo completar" || $resultados == "Requiere seguimiento") {
            // Actualizar el estado de la orden de trabajo y el estado de mantenimiento a 'Pendiente'
            $sql_update_work_order = "UPDATE work_orders SET status = 'Pendiente' WHERE id_workOrders = ?";
            $stmt_update_work_order = $conexion->prepare($sql_update_work_order);
            $stmt_update_work_order->bind_param("i", $id_orden);
            $stmt_update_work_order->execute();
            $stmt_update_work_order->close();

            $sql_update_maintenance = "UPDATE maintenance SET status = 'Pendiente' WHERE id_maintenance = ?";
            $stmt_update_maintenance = $conexion->prepare($sql_update_maintenance);
            $stmt_update_maintenance->bind_param("i", $maintenance_id); // Usar el mismo ID
            $stmt_update_maintenance->execute();
            $stmt_update_maintenance->close();
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
        <select id="id_orden" name="id_orden" required onchange="updateEquipment()">
            <option value="">Seleccione una orden de trabajo</option>
            <?php while ($row = $result_work_orders->fetch_assoc()): ?>
                <option value="<?php echo $row['id_workOrders']; ?>" data-equipment="<?php echo $row['equipment']; ?>">
                    <?php echo htmlspecialchars($row['id_workOrders']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="equipment">Equipment:</label>
        <select id="equipment" name="equipment" required>
            <option value="">Seleccione un equipo</option>
            <?php foreach ($equipos as $id => $name): ?>
                <option value="<?php echo $id; ?>"><?php echo htmlspecialchars($name); ?></option>
            <?php endforeach; ?>
        </select>

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

        <button type="submit">Submit Report</button>
    </form>
</section>

<script>
function updateEquipment() {
    var select = document.getElementById("id_orden");
    var selectedOption = select.options[select.selectedIndex];
    var equipmentId = selectedOption.getAttribute("data-equipment");
    
    var equipmentSelect = document.getElementById("equipment");
    
    // Mostrar solo la opción correspondiente y ocultar las demás
    for (var i = 0; i < equipmentSelect.options.length; i++) {
        if (equipmentSelect.options[i].value == equipmentId) {
            equipmentSelect.selectedIndex = i; // Selecciona el equipo correspondiente
        } else {
            equipmentSelect.options[i].style.display = 'none'; // Oculta las demás opciones
        }
    }
}
</script>

</main>
</body>
</html>