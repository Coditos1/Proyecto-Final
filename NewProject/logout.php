<?php
session_start();
session_destroy(); // Destruir la sesión
header("Location: loggin.php"); // Redirigir a login.php
exit();
?>