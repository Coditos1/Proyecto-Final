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

    // Nuevas variables para el repuesto y la cantidad
    $spare_part_id = $_POST['spare_part']; // ID del repuesto
    $used_quantity = $_POST['used_quantity']; // Cantidad utilizada

    // Verificar el stock disponible del repuesto
    $sql_check_stock = "SELECT stock FROM spare_parts WHERE id_spareParts = ?";
    $stmt_check_stock = $conexion->prepare($sql_check_stock);
    $stmt_check_stock->bind_param("i", $spare_part_id);
    $stmt_check_stock->execute();
    $result_check_stock = $stmt_check_stock->get_result();
    
    if ($result_check_stock->num_rows > 0) {
        $row = $result_check_stock->fetch_assoc();
        $available_stock = $row['stock'];

        // Validar si hay suficiente stock
        if ($available_stock < $used_quantity) {
            echo "<script>alert('Insufficient stock for the selected spare part.');</script>";
            // Aquí puedes detener el proceso si es necesario
            return; // Detener la ejecución del script
        }
    } else {
        echo "<script>alert('Spare part not found.');</script>";
        return; // Detener la ejecución del script
    }

    // Inserción en la tabla maintenance_history
    $sql_insert = "INSERT INTO maintenance_history (completionDate, results, observations, equipment, maintenance, id_user) 
                   VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql_insert);
    
    // Asegúrate de que estás pasando los valores correctos
    $stmt->bind_param("ssssii", $fecha_mantenimiento, $resultados, $observaciones, $equipment, $id_orden, $user_id);
    
    // Ejecutar la consulta
    if ($stmt->execute()) {
        $id_history = $stmt->insert_id; // Obtén el ID de la última inserción

        // Inserción en la tabla spare_history
        $sql_insert_spare = "INSERT INTO spare_history (spare_parts, usedQuantity, maintenance_history, usageDate) VALUES (?, ?, ?, ?)";
        $stmt_spare = $conexion->prepare($sql_insert_spare);
        $stmt_spare->bind_param("iiis", $spare_part_id, $used_quantity, $id_history, $fecha_mantenimiento);
        $stmt_spare->execute();
        $stmt_spare->close();

        // Actualizar el stock en spare_parts
        $sql_update_stock = "UPDATE spare_parts SET stock = stock - ? WHERE id_spareParts = ?";
        $stmt_update_stock = $conexion->prepare($sql_update_stock);
        $stmt_update_stock->bind_param("ii", $used_quantity, $spare_part_id);
        $stmt_update_stock->execute();
        $stmt_update_stock->close();

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
            <option value="">Select a work order</option>
            <?php while ($row = $result_work_orders->fetch_assoc()): ?>
                <option value="<?php echo $row['id_workOrders']; ?>" data-equipment="<?php echo $row['equipment']; ?>">
                    <?php echo htmlspecialchars($row['id_workOrders']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="equipment">Equipment:</label>
        <select id="equipment" name="equipment" required>
            <option value="">Select an equipment</option>
            <?php foreach ($equipos as $id => $name): ?>
                <option value="<?php echo $id; ?>"><?php echo htmlspecialchars($name); ?></option>
            <?php endforeach; ?>
        </select>

        <label for="fecha_mantenimiento">Maintenance Date:</label>
        <input type="date" id="fecha_mantenimiento" name="fecha_mantenimiento" required onchange="validateDate(this)">

        <label for="resultados">Maintenance Results:</label>
        <select id="resultados" name="resultados" required>
            <option value="Exitoso">Successful</option>
            <option value="No se pudo completar">Could not complete</option>
            <option value="Requiere seguimiento">Requires follow-up</option>
        </select>

        <label for="observaciones">Observations:</label>
        <textarea id="observaciones" name="observaciones" rows="4" required></textarea>

        <label for="spare_part">Repuesto:</label>
        <select id="spare_part" name="spare_part" required>
            <option value="">Select a spare part</option>
            <?php
            // Obtener los repuestos disponibles
            $sql_spare_parts = "SELECT id_spareParts, name FROM spare_parts";
            $result_spare_parts = $conexion->query($sql_spare_parts);
            while ($row = $result_spare_parts->fetch_assoc()): ?>
                <option value="<?php echo $row['id_spareParts']; ?>"><?php echo htmlspecialchars($row['name']); ?></option>
            <?php endwhile; ?>
        </select>

        <label for="used_quantity">Used Quantity:</label>
        <input type="number" id="used_quantity" name="used_quantity" required min="1" onchange="validateQuantity(this)">

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

<script src="functions.js"></script>

</main>
</body>
</html>