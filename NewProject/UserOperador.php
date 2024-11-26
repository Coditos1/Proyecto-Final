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
    
        // Generar email y usuario automáticamente
        $randomNumbers = rand(1000,9999);
        $email = strtolower($name . '.' . $lastName . $randomNumbers . '@autoindustry.com');
        $user = strtolower(substr($name, 0, 1) . $lastName . $randomNumbers);
        $password = substr(md5(uniqid()), 0, 8);
    
        // Llamar al procedimiento almacenado
        $sql = "CALL RegisterOperator(?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        
        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $conexion->error);
        }
        
        $stmt->bind_param("sssssss", $name, $lastName, $secLastName, $numTel, $email, $user, $password);
        
        if ($stmt->execute()) {
            echo "Nuevo Operador Registrado";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
?>
    <main class="maquinas-container">
        <form id="register-operator-form" action="UserOperador.php" method="POST" class="form-container">
            <h2>Operator Registration</h2>

            <label for="name">First Name:</label>
            <input type="text" id="name" name="name" required placeholder="Enter first name">

            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" name="lastName" required placeholder="Enter last name">

            <label for="secLastName">Middle Name:</label>
            <input type="text" id="secLastName" name="secLastName" placeholder="Enter middle name">

            <label for="numTel">Phone Number:</label>
            <input type="text" id="numTel" name="numTel" required placeholder="Enter phone number">

            <button type="submit" name="submit">Register Operator</button>
        </form>
    </main>
</body>
</html>