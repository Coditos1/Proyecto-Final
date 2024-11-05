<?php
    include 'includes/header.php';
    require "../NewProject/includes/config/database.php";
    
    $db = conectarDB();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $lastName = $_POST['lastName'];
        $secLastName = $_POST['secLastName'];
        $numTel = $_POST['numTel'];
        $email = $_POST['email'];
        $user = $_POST['user'];
        $password = $_POST['password'];
        

        $sql = "INSERT INTO supervisor (name, lastName, secLastName, numTel, email, user, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $name, $lastName, $secLastName, $numTel, $email, $user, $password);
        
        if ($stmt->execute()) {
            echo "Nuevo supervisor registrado exitosamente.";
        } else {
            echo "Error: " . $stmt->error;
        }
        

    }
?>
<main class="maquinas-container">
        <form id="register-supervisor-form" action="UserSupervisor.php" method="POST" class="form-container">
            <h2>Formulario de Registro de Supervisor</h2>

            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" required placeholder="Ingrese el nombre">

            <label for="lastName">Apellido Paterno:</label>
            <input type="text" id="lastName" name="lastName" required placeholder="Ingrese el apellido paterno">

            <label for="secLastName">Apellido Materno:</label>
            <input type="text" id="secLastName" name="secLastName" placeholder="Ingrese el apellido materno">

            <label for="numTel">Número de Teléfono:</label>
            <input type="text" id="numTel" name="numTel" required placeholder="Ingrese el número de teléfono">

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required placeholder="Ingrese el correo electrónico">

            <label for="user">Usuario:</label>
            <input type="text" id="user" name="user" required placeholder="Ingrese el nombre de usuario">

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required placeholder="Ingrese la contraseña">

            <button type="submit">Registrar Supervisor</button>
        </form>
    </main>
</body>
</html>