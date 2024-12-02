<?php
include 'includes/header.php';

// Conexión a la base de datos
$conexion = mysqli_connect("127.0.0.1", "root", "", "industrial_maintenance");

if (!$conexion) {
    die("Error in connection: " . mysqli_connect_error());
}

// Verificar si se ha enviado una solicitud para eliminar una orden de trabajo
if (isset($_POST['delete_order'])) {
    $orderId = $_POST['delete_order'];

    // Eliminar la orden de trabajo de la tabla WORK_ORDERS
    $query = "DELETE FROM work_orders WHERE id_workOrders = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $orderId);
    
    if ($stmt->execute()) {
        echo "<script>alert('Work order deleted successfully.');</script>";
    } else {
        echo "<script>alert('Error deleting the work order.');</script>";
    }
    $stmt->close();
}

// Verificar si se ha enviado una solicitud para actualizar la descripción
if (isset($_POST['order_id']) && isset($_POST['new_description'])) {
    $orderId = $_POST['order_id'];
    $newDescription = $_POST['new_description'];

    // Actualizar la descripción de la orden de trabajo
    $query = "UPDATE work_orders SET description = ? WHERE id_workOrders = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("si", $newDescription, $orderId);
    
    if ($stmt->execute()) {
        echo "<script>alert('Description updated successfully.');</script>";
    } else {
        echo "<script>alert('Error updating the description.');</script>";
    }
    $stmt->close();
}

// Obtener el ID del supervisor que ha iniciado sesión
$administratorId = $_SESSION['id_user']; // Asegúrate de que el ID del supervisor esté almacenado en la sesión

if (empty($administratorId)) {
    die("No se ha encontrado el ID del supervisor en la sesión.");
}

// Obtener las órdenes de trabajo del supervisor
$query = "SELECT id_workOrders, description, creationDate, status
          FROM work_orders
          WHERE administrator = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $administratorId);
$stmt->execute();
$result = $stmt->get_result();
?>

<body>
    <main class="ordenes-container">
        <h2>Work Orders</h2>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Description</th>
                    <th>Creation Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['id_workOrders'] . "</td>
                                <td>" . $row['description'] . "</td>
                                <td>" . $row['creationDate'] . "</td>
                                <td>" . $row['status'] . "</td>
                                <td>
                                    <form method='POST' style='display:inline;'>
                                        <input type='hidden' name='delete_order' value='" . $row['id_workOrders'] . "'>
                                        <button type='submit' onclick='return confirm(\"Are you sure you want to delete this work order?\");' style='margin-right: 10px;'>Delete</button>
                                    </form>
                                    <button onclick='openModal(" . $row['id_workOrders'] . ", \"" . addslashes($row['description']) . "\")'>Update</button>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No work orders found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>

    <!-- Modal para actualizar la descripción -->
    <div id="updateModal" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Update Description</h2>
            <form method="POST" id="updateForm">
                <input type="hidden" name="order_id" id="order_id">
                <label for="new_description">New Description:</label>
                <input type="text" name="new_description" id="new_description" required>
                <button type="submit">Update</button>
            </form>
        </div>
    </div>

    <style>
    .modal {
        display: none; /* Ocultar por defecto */
        position: fixed; /* Fijo en la pantalla */
        z-index: 1000; /* Asegurarse de que esté por encima de otros elementos */
        left: 0;
        top: 0;
        width: 100%; /* Ancho completo */
        height: 100%; /* Alto completo */
        overflow: auto; /* Habilitar desplazamiento si es necesario */
        background-color: rgba(0, 0, 0, 0.5); /* Fondo oscuro con opacidad */
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto; /* 15% desde la parte superior y centrado */
        padding: 20px;
        border: 1px solid #888;
        width: 80%; /* Ancho del modal */
        max-width: 500px; /* Ancho máximo del modal */
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
    </style>

    <script>
    function openModal(orderId, currentDescription) {
        document.getElementById('order_id').value = orderId;
        document.getElementById('new_description').value = currentDescription;
        document.getElementById('updateModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('updateModal').style.display = 'none';
    }
    </script>
</body>
</html>

<?php

?>
