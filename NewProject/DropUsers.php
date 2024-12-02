<?php
session_start(); // Iniciar sesión para verificar si el administrador está logueado
include "includes/header.php";

// Verificar si el usuario es un administrador
if (!isset($_SESSION['id_user'])) {
    echo "<div class='alert alert-danger'>Error: Administrator ID not found in session. Please log in.</div>";
    exit();
}

$conexion = mysqli_connect("127.0.0.1", "root", "", "industrial_maintenance");

if (!$conexion) {
    die("Error en la conexión: " . mysqli_connect_error());
}

// Obtener el término de búsqueda
$search_user = isset($_POST['search_user']) ? $_POST['search_user'] : '';

// Consulta para obtener todos los técnicos y operadores
$sql = "
    (SELECT id_operator AS id_user, name, lastname, email, numTel FROM operator WHERE name LIKE '%" . mysqli_real_escape_string($conexion, $search_user) . "%' OR lastname LIKE '%" . mysqli_real_escape_string($conexion, $search_user) . "%')
    UNION
    (SELECT id_technician AS id_user, name, lastname, email, numTel FROM technician WHERE name LIKE '%" . mysqli_real_escape_string($conexion, $search_user) . "%' OR lastname LIKE '%" . mysqli_real_escape_string($conexion, $search_user) . "%')
";

// Ejecutar la consulta
$result = $conexion->query($sql);

if (!$result) {
    die("Error en la consulta: " . $conexion->error);
}

// Eliminar usuario
if (isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];

    // Verificar si el usuario tiene procesos pendientes en otras tablas
    $check_sql = "SELECT COUNT(*) as count FROM operator_equipment WHERE operator = ? 
                  UNION ALL 
                  SELECT COUNT(*) as count FROM failure WHERE operator = ?
                  UNION ALL
                  SELECT COUNT(*) as count FROM maintenance_history WHERE id_user = ?";
    $stmt = $conexion->prepare($check_sql);
    $stmt->bind_param("iii", $user_id, $user_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $has_pending_processes = false;
    while ($row = $result->fetch_assoc()) {
        if ($row['count'] > 0) {
            $has_pending_processes = true;
            break;
        }
    }
    $stmt->close();

    if ($has_pending_processes) {
        echo "<script>alert('No se puede eliminar el usuario. Tiene procesos pendientes en otras tablas.');</script>";
    } else {
        // Intentar eliminar de la tabla operator
        $delete_operator_sql = "DELETE FROM operator WHERE id_operator = ?";
        $stmt = $conexion->prepare($delete_operator_sql);
        $stmt->bind_param("i", $user_id);
        try {
            $stmt->execute();
            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            echo "<script>alert('Error al eliminar el usuario.');</script>";
            $stmt->close();
        }

        // Intentar eliminar de la tabla technician
        $delete_technician_sql = "DELETE FROM technician WHERE id_technician = ?";
        $stmt = $conexion->prepare($delete_technician_sql);
        $stmt->bind_param("i", $user_id);
        try {
            $stmt->execute();
            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            echo "<script>alert('Error al eliminar el usuario.');</script>";
            $stmt->close();
        }
    }
}

// Actualizar usuario
if (isset($_POST['id_user'])) {
    $id_user = $_POST['id_user'];
    $user_name = $_POST['user_name'];
    $user_lastname = $_POST['user_lastname'];
    $user_email = $_POST['user_email'];
    $user_phone = $_POST['user_phone'];
    $user_type = $_POST['user_type']; // Aunque esté deshabilitado, se puede enviar

    // Preparar la consulta de actualización
    if ($user_type === 'operator') {
        $update_sql = "UPDATE operator SET name = ?, lastname = ?, email = ?, numTel = ? WHERE id_operator = ?";
    } else {
        $update_sql = "UPDATE technician SET name = ?, lastname = ?, email = ?, numTel = ? WHERE id_technician = ?";
    }

    $stmt = $conexion->prepare($update_sql);
    if ($user_type === 'operator') {
        $stmt->bind_param("ssssi", $user_name, $user_lastname, $user_email, $user_phone, $id_user);
    } else {
        $stmt->bind_param("ssssi", $user_name, $user_lastname, $user_email, $user_phone, $id_user);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Usuario actualizado correctamente.');</script>";
    } else {
        echo "<script>alert('Error al actualizar el usuario.');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
</head>
<body>
<style>
    * {
        box-sizing: border-box; /* Asegura que el padding no afecte el ancho total */
    }

    .btn-accion {
        padding: 10px 15px;
        font-size: 12px;
        margin-left: 10px;
        cursor: pointer;
        width: 100px;
        height: auto;
        vertical-align: middle;
        background-color: #ff7f50; /* Orange color */
        border: none;
        border-radius: 5px;
        color: white;
        transition: background-color 0.3s;
    }

    .btn-accion:hover {
        background-color: #e76a3c; /* Darker orange on hover */
    }

    .filtros {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .filtros input[type="text"] {
        margin-right: 10px;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 200px; /* Adjust width as needed */
    }

    .filtro-fecha {
        margin-left: 10px;
    }

    .tabla-container {
        max-height: 75vh; /* Increase max height of the table container */
        overflow-y: auto; /* Enable vertical scrolling if content exceeds height */
        margin-top: 20px; /* Top margin to separate from filters */
        padding: 0; /* Asegúrate de que no haya padding */
    }

    table {
        width: 100%; /* Ensure table takes full width of container */
        border-collapse: collapse; /* Collapse borders for better design */
        margin: 0; /* Asegúrate de que no haya margen */
        padding: 0; /* Asegúrate de que no haya padding */
    }

    th, td {
        padding: 10px; /* Internal spacing in cells */
        text-align: center; /* Center text */
        border-bottom: 1px solid #ddd; /* Bottom line to separate rows */
        width: 20%; /* Ensure each column takes 20% of total width */
    }

    th {
        background-color: #f2f2f2; /* Background color for headers */
    }

    tr:hover {
        background-color: #f5f5f5; /* Color de fondo al pasar el mouse */
    }

    /* Estilos para el modal */
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

    /* Estilo para el select de tipo de usuario */
    select#user_type {
        background-color: #f2f2f2; /* Color de fondo */
        border: 1px solid #ccc; /* Borde */
        border-radius: 5px; /* Bordes redondeados */
        padding: 5px; /* Espaciado interno */
        width: 100%; /* Ancho completo */
        cursor: not-allowed; /* Cambiar el cursor para indicar que no se puede cambiar */
    }
</style>

<main class="reporte-container">
    <section class="reportes-tabla">
        <div class="tabla-header">
            <h2>All Users</h2>
            <div class="filtros">
                <form method="POST">
                    <input type="text" name="search_user" placeholder="Search by User" value="<?php echo htmlspecialchars($search_user); ?>" autocomplete="off">
                    <button type="submit" class="btn-accion">Search</button>
                </form>
            </div>
        </div>
 
        <table class="table-container">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>" . $row["id_user"] . "</td>
                                <td>" . htmlspecialchars($row["name"]) . "</td>
                                <td>" . htmlspecialchars($row["lastname"]) . "</td>
                                <td>" . htmlspecialchars($row["email"]) . "</td>
                                <td>" . htmlspecialchars($row["numTel"]) . "</td>
                                <td>
                                    <form method='POST' action='DropUsers.php' style='display:inline;'>
                                        <input type='hidden' name='user_id' value='" . $row["id_user"] . "'>
                                        <button type='submit' class='btn-accion eliminar' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este usuario?\");'>Eliminar</button>
                                    </form>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No hay usuarios disponibles.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
</main>

<!-- Modal para actualizar información del usuario -->
<div id="userModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeUserModal()">&times;</span>
        <h2>Update User</h2>
        <form id="updateUserForm" method="POST" action="">
            <input type="hidden" name="id_user" id="user_id">
            <label for="user_name">Name:</label>
            <input type="text" name="user_name" id="user_name" required>
            <label for="user_lastname">Last Name:</label>
            <input type="text" name="user_lastname" id="user_lastname" required>
            <label for="user_email">Email:</label>
            <input type="email" name="user_email" id="user_email" required>
            <label for="user_phone">Phone:</label>
            <input type="tel" name="user_phone" id="user_phone" required>
            <label for="user_type">User Type:</label>
            <select name="user_type" id="user_type" required disabled>
                <option value="operator">Operator</option>
                <option value="technician">Technician</option>
            </select>
            <button type="submit" class="btn-accion" style="margin-top: 15px;">Update</button>
        </form>
    </div>
</div>

<script>
function openUserModal(id, name, role, lastname, email, phone) {
    document.getElementById('user_id').value = id;
    document.getElementById('user_name').value = name;
    document.getElementById('user_lastname').value = lastname; // Agregar apellido
    document.getElementById('user_email').value = email; // Agregar email
    document.getElementById('user_phone').value = phone; // Agregar teléfono
    document.getElementById('user_type').value = role.toLowerCase() === 'operator' ? 'operator' : 'technician';
    document.getElementById('user_type').disabled = true; // Deshabilitar el campo
    document.getElementById('userModal').style.display = 'block';
}

function closeUserModal() {
    document.getElementById('userModal').style.display = 'none';
}

// Cerrar el modal si se hace clic fuera de él
window.onclick = function(event) {
    var modal = document.getElementById('userModal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

<?php
$conexion->close(); // Cerrar la conexión a la base de datos
?>
