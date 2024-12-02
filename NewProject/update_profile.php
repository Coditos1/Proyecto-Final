<?php
session_start(); // Asegúrate de que la sesión esté iniciada

// Verifica si el usuario está autenticado
if (!isset($_SESSION['id_user']) || !isset($_SESSION['usuario'])) {
    die("No estás autenticado. Por favor inicia sesión.");
}

$conexion = mysqli_connect("127.0.0.1", "root", "", "industrial_maintenance");
if (!$conexion) {
    die("Error en la conexión: " . mysqli_connect_error());
}

// Obtener el ID del usuario desde la sesión
$id_user = $_SESSION['id_user'];

// Si se recibió el formulario de actualización
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger los datos del formulario
    $name = $_POST['name'];
    $lastName = $_POST['lastName'];
    $secLastName = $_POST['secLastName'];
    $numTel = $_POST['numTel'];
    $email = $_POST['email'];

    // Preparar la consulta para actualizar la información del perfil
    $stmt = mysqli_prepare($conexion, "
        UPDATE administrator SET name = ?, lastName = ?, secLastName = ?, numTel = ?, email = ? 
        WHERE id_administrator = ?
    ");
    mysqli_stmt_bind_param($stmt, 'sssssi', $name, $lastName, $secLastName, $numTel, $email, $id_user);

    // Ejecutar la consulta
    $result = mysqli_stmt_execute($stmt);

    // Verificar si la actualización fue exitosa
    if ($result) {
        // Redirigir con mensaje de éxito
        header("Location: update_profile.php?message=success");
    } else {
        // Redirigir con mensaje de error
        header("Location: update_profile.php?message=error");
    }

    // Cerrar la consulta
    mysqli_stmt_close($stmt);
}

// Cerrar la conexión
mysqli_close($conexion);
?>






