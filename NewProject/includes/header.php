<?php
session_start(); //Almacenar la sesion
if (isset($_SESSION['username'])) {
    $current_username = $_SESSION['username']; // Asignar el nombre de usuario desde la sesión
} else {
    $current_username = "Invitado"; // Valor predeterminado si no está definido
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Mantenimiento</title>
    <link rel="stylesheet" href="css/styles2.css">
</head>

<body>
    <header>
        <nav>
            <h1><a href="Supervisor.php" style="text-decoration: none; color: inherit;">Supervisor Page</a></h1>
            <ul>
                <li><a href="Reporte.php"><i class="fas fa-exclamation-triangle"></i>View Failure Reports</a></li>
                <li><a href="Repuesto.php"><i class="fas fa-file-alt"></i>Spare Parts for Maintenance</a></li>
                <li><a href="ReportarFalla.php"><i class="fas fa-tools"></i>Maintenance Reports</a></li>
                <li><a href="Historial.php"><i class="fas fa-chart-line"></i>Maintenance History</a></li>
                <li><a href="Maquinas.php"><i class="fas fa-history"></i>Register Equipment</a></li>
                <li><a href="UserOperador.php"><i class="fas fa-history"></i>Register an Operator</a></li>
                <li><a href="UserTecnico.php"><i class="fas fa-history"></i>Register a Technician</a></li>
                <li><a href="UserSupervisor.php"><i class="fas fa-history"></i>Register a Supervisor</a></li>
                <button id="openModal" class="open-modal">Editar Perfil</button>
            </ul>
        </nav>

    </header>
    <!-- Modal (página flotante) -->
<div id="modal" class="modal-container">
    <div class="modal-content">
        <span id="closeModal" class="close-modal">&times;</span>
        <h2>Editar Perfil</h2>
        <form action="update_profile.php" method="POST">
    <label for="username">Nombre de Usuario:</label>
    <input type="text" id="username" name="username" value="<?php echo $current_username; ?>" required>

    <label for="password">Nueva Contraseña:</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Guardar Cambios</button>
</form>

    </div>
</div>
<script src="modal.js"></script>
<?php
if (isset($_GET['message'])) {
    $message = $_GET['message'];

    if ($message == 'success') {
        echo '<div class="alert success">Cambio Exitoso</div>';
    } elseif ($message == 'error') {
        echo '<div class="alert error">Se produjo un error</div>';
    }
}
?>