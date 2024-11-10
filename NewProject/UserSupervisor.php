<?php
    include 'includes/header.php';
    
    $conexion = mysqli_connect("127.0.0.1", "root", "", "industrial_maintenance");

    if (!$conexion) {
        die("Error en la conexión: " . mysqli_connect_error());
    } else {
        echo "";
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $lastName = $_POST['lastName'];
        $secLastName = $_POST['secLastName'];
        $numTel = $_POST['numTel'];
        $email = $_POST['email'];
        $user = $_POST['user'];
        $password = $_POST['password'];
        

        $sql = "INSERT INTO supervisor (name, lastName, secLastName, numTel, email, user, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssssss", $name, $lastName, $secLastName, $numTel, $email, $user, $password);
        
        if ($stmt->execute()) {
            echo "Nuevo Supervisor Registrado";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
?>
<main class="maquinas-container">
        <form id="register-supervisor-form" action="UserSupervisor.php" method="POST" class="form-container">
            <h2>Supervisor Registration</h2>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required placeholder="Enter name">

            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" name="lastName" required placeholder="Enter last name">

            <label for="secLastName">Second Last Name:</label>
            <input type="text" id="secLastName" name="secLastName" placeholder="Enter second last name">

            <label for="numTel">Phone Number:</label>
            <input type="text" id="numTel" name="numTel" required placeholder="Enter phone number">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required placeholder="Enter email">

            <label for="user">Username:</label>
            <input type="text" id="user" name="user" required placeholder="Enter username">

            <label for="password">Password:</label>
            <input type="text" id="password" name="password" required placeholder="Enter password">

            <button type="submit" name="submit">Register Supervisor</button>
        </form>
    </main>
</body>
</html>