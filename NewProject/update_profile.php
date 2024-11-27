<?php
session_start(); // Inicia la sesión

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario']) || !isset($_SESSION['id_user'])) {
    die("No estás autenticado. Por favor inicia sesión.");
}

// Conexión a la base de datos
$conexion = mysqli_connect("127.0.0.1", "root", "", "industrial_maintenance");
if (!$conexion) {
    die("Error en la conexión: " . mysqli_connect_error());
}

// Obtener el ID del usuario desde la sesión
$id_user = $_SESSION['id_user'];
$usuario = $_SESSION['usuario'];

// Verificar si se han enviado los datos para actualizar el perfil
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
    $nuevo_usuario = $_POST['username'];
    $nueva_contraseña = $_POST['password'];

    // Comprobar en qué tabla se encuentra el usuario y actualizar los datos
    // Actualizar el nombre de usuario y la contraseña en la base de datos

    $stmt = mysqli_prepare($conexion, "SELECT * FROM administrator WHERE id_administrator = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id_user);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    // Si el usuario es un administrador
    if (mysqli_num_rows($resultado) > 0) {
        $stmt = mysqli_prepare($conexion, "UPDATE administrator SET user = ?, password = ? WHERE id_administrator = ?");
        mysqli_stmt_bind_param($stmt, 'ssi', $nuevo_usuario, $nueva_contraseña, $id_user);
        if (mysqli_stmt_execute($stmt)) {
            echo "Perfil de administrador actualizado con éxito.";
        } else {
            echo "Error al actualizar el perfil de administrador.";
        }
    } else {
        // Verificar en la tabla de operadores
        $stmt = mysqli_prepare($conexion, "SELECT * FROM operator WHERE id_operator = ?");
        mysqli_stmt_bind_param($stmt, 'i', $id_user);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($resultado) > 0) {
            $stmt = mysqli_prepare($conexion, "UPDATE operator SET user = ?, password = ? WHERE id_operator = ?");
            mysqli_stmt_bind_param($stmt, 'ssi', $nuevo_usuario, $nueva_contraseña, $id_user);
            if (mysqli_stmt_execute($stmt)) {
                echo "Perfil de operador actualizado con éxito.";
            } else {
                echo "Error al actualizar el perfil de operador.";
            }
        } else {
            // Verificar en la tabla de técnicos
            $stmt = mysqli_prepare($conexion, "SELECT * FROM technician WHERE id_technician = ?");
            mysqli_stmt_bind_param($stmt, 'i', $id_user);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($resultado) > 0) {
                $stmt = mysqli_prepare($conexion, "UPDATE technician SET user = ?, password = ? WHERE id_technician = ?");
                mysqli_stmt_bind_param($stmt, 'ssi', $nuevo_usuario, $nueva_contraseña, $id_user);
                if (mysqli_stmt_execute($stmt)) {
                    echo "Perfil de técnico actualizado con éxito.";
                } else {
                    echo "Error al actualizar el perfil de técnico.";
                }
            }
        }
    }

    // Cerrar la consulta
    mysqli_stmt_close($stmt);
}

// Cerrar la conexión
mysqli_close($conexion);
?>
