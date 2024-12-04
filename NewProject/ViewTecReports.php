<?php
include 'includes/tecnav.php';
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id_user'];

// Conexión a la base de datos
$conexion = mysqli_connect("127.0.0.1", "root", "", "industrial_maintenance");

if (!$conexion) {
    die("Error en la conexión: " . mysqli_connect_error());
}

// Obtener los reportes de mantenimiento del técnico
$sql_reports = "SELECT mh.id_history, mh.completionDate, mh.results, mh.observations, mh.equipment, mh.maintenance, sp.name AS spare_part_name, sh.usedQuantity, sh.usageDate 
                FROM maintenance_history mh
                LEFT JOIN spare_history sh ON mh.id_history = sh.maintenance_history
                LEFT JOIN spare_parts sp ON sh.spare_parts = sp.id_spareParts
                WHERE mh.id_user = ?";
$stmt_reports = $conexion->prepare($sql_reports);
$stmt_reports->bind_param("i", $user_id);
$stmt_reports->execute();
$result_reports = $stmt_reports->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reportes de Mantenimiento</title>
    <style>
        .modal {
            display: none; /* Ocultar por defecto */
            position: fixed; /* Fijo en la pantalla */
            z-index: 1000; /* Asegurarse de que esté por encima de otros elementos */
            left: 0;
            top: 0;
            width: 100%; /* Ancho completo */
            height: 100%; /* Altura completa */
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

        textarea {
        width: 100%; /* Ancho completo */
        padding: 10px; /* Espaciado interno */
        border: 1px solid #ccc; /* Borde */
        border-radius: 4px; /* Bordes redondeados */
        resize: none; /* Deshabilitar el cambio de tamaño */
        margin-top: 5px; /* Espaciado superior */
    }

    button[type="submit"] {
        background-color: orange; /* Color de fondo del botón */
        color: white; /* Color del texto */
        border: none; /* Sin borde */
        padding: 10px 15px; /* Espaciado interno */
        border-radius: 4px; /* Bordes redondeados */
        cursor: pointer; /* Cambiar cursor al pasar */
        margin-top: 15px; /* Espaciado superior */
            width: 100%; /* Ancho completo */
        }

        button[type="submit"]:hover {
            background-color: darkorange; /* Color de fondo al pasar el mouse */
        }
    </style>
</head>
<body>
    <section id="ordenes">
        <h2>Maintenance Reports</h2>
        <table>
            <thead>
                <tr>
                    <th>Report ID</th>
                    <th>Maintenance Date</th>
                    <th>Results</th>
                    <th>Observations</th>
                    <th>Equipment</th>
                    <th>Used Spare Part</th>
                    <th>Used Quantity</th>
                    <th>Usage Date</th>
                    <th>Actions</th> <!-- New column for actions -->
                </tr>
            </thead>
            <tbody>
                <?php if ($result_reports->num_rows > 0): ?>
                    <?php while ($row = $result_reports->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id_history']); ?></td>
                            <td><?php echo htmlspecialchars($row['completionDate']); ?></td>
                            <td><?php echo htmlspecialchars($row['results']); ?></td>
                            <td><?php echo htmlspecialchars($row['observations']); ?></td>
                            <td><?php echo htmlspecialchars($row['equipment']); ?></td>
                            <td><?php echo htmlspecialchars($row['spare_part_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['usedQuantity']); ?></td>
                            <td><?php echo htmlspecialchars($row['usageDate']); ?></td>
                            <td>
                                <button class="edit-button" onclick="openModal(<?php echo $row['id_history']; ?>, '<?php echo htmlspecialchars($row['observations']); ?>')">Edit</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9">No maintenance reports available.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>

    <!-- Modal for editing observations -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Edit Observations</h2>
            <form id="editForm" method="POST" action="ViewTecReports.php">
                <input type="hidden" id="reportId" name="reportId">
                <label for="observations">Observations:</label>
                <textarea id="observations" name="observations" rows="4" required></textarea>
                <button type="submit">Update Report</button>
            </form>
        </div>
    </div>

    <script>
        // Función para abrir el modal
        function openModal(id, observations) {
            document.getElementById("reportId").value = id; // Establecer el ID del reporte
            document.getElementById("observations").value = observations; // Establecer las observaciones
            document.getElementById("editModal").style.display = "block"; // Mostrar el modal
        }

        // Función para cerrar el modal
        function closeModal() {
            document.getElementById("editModal").style.display = "none"; // Ocultar el modal
        }

        // Cerrar el modal si se hace clic fuera de él
        window.onclick = function(event) {
            var modal = document.getElementById("editModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>

<?php
$stmt_reports->close();
$conexion->close();
?>
