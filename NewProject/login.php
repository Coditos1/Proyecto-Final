<?php
error_reporting(E_ALL);
ini_set('display_errors', 0); // Desactiva la visualización de errores en el navegador
session_start(); // Inicia la sesión para almacenar el estado del usuario

// Conexión a la base de datos
$conexion = mysqli_connect("127.0.0.1", "root", "", "industrial_maintenance");

// Verificar la conexión
if (!$conexion) {
    die("Error en la conexión: " . mysqli_connect_error());
}

// Verificar si se han enviado los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['usuario']) && isset($_POST['contraseña'])) {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    // Intentar comprobar en la tabla de supervisores
    try {
        $stmt = mysqli_prepare($conexion, "SELECT id_administrator, user FROM administrator WHERE user = ? AND password = ?");
        mysqli_stmt_bind_param($stmt, 'ss', $usuario, $contraseña);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        // Verificar si se encontró un supervisor
        if (mysqli_num_rows($resultado) > 0) {
            $row = mysqli_fetch_assoc($resultado);
            $_SESSION['usuario'] = $usuario; // Almacenar el usuario en la sesión
            $_SESSION['id_user'] = $row['id_administrator']; // Almacenar el ID del supervisor en la sesión
            header("Location: Supervisor.php");
            exit();
        }

        // Comprobar en la tabla de operadores
        $stmt = mysqli_prepare($conexion, "SELECT id_operator, user FROM operator WHERE user = ? AND password = ?");
        mysqli_stmt_bind_param($stmt, 'ss', $usuario, $contraseña);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        // Verificar si se encontró un operador
        if (mysqli_num_rows($resultado) > 0) {
            $row = mysqli_fetch_assoc($resultado);
            $_SESSION['usuario'] = $usuario; // Almacenar el usuario en la sesión
            $_SESSION['id_user'] = $row['id_operator']; // Almacenar el ID del operador en la sesión
            header("Location: Operador.php");
            exit();
        }

        // Comprobar en la tabla de técnicos
        $stmt = mysqli_prepare($conexion, "SELECT id_technician, user FROM technician WHERE user = ? AND password = ?");
        mysqli_stmt_bind_param($stmt, 'ss', $usuario, $contraseña);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        // Verificar si se encontró un técnico
        if (mysqli_num_rows($resultado) > 0) {
            $row = mysqli_fetch_assoc($resultado);
            $_SESSION['usuario'] = $usuario; // Almacenar el usuario en la sesión
            $_SESSION['id_user'] = $row['id_technician']; // Almacenar el ID del técnico en la sesión
            header("Location: Tecnico.php");
            exit();
        }

        // Si no se encontró el usuario en ninguna tabla
        echo "<h2>Tus credenciales son incorrectas. Por favor ingresalas correctamente</h2>";
    } catch (mysqli_sql_exception $e) {
        // Manejo de errores: mostrar un mensaje genérico
        echo "<h2>Ocurrió un error al procesar su solicitud. Por favor, inténtelo más tarde.</h2>";
        // Opcional: registrar el error en un archivo de log para revisión
        error_log($e->getMessage());
    }
} else {
    // Mostrar el mensaje solo si no se ha enviado el formulario
    echo "<h1>Por favor, ingresa tus credenciales.</h1>";
}

// Cerrar la conexión
mysqli_close($conexion);
?>
