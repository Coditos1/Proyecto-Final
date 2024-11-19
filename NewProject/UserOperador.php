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
        

        $randomNumbers = rand(1000,9999);

        // Generar email automáticamente
        $email = strtolower($name . '.' . $lastName . $randomNumbers . '@autoindustry.com');
    
        // Generar usuario automáticamente (primera letra del nombre + apellido)
        $user = strtolower(substr($name, 0, 1) . $lastName . $randomNumbers);
    
        // Generar contraseña aleatoria de 8 caracteres
        $password = substr(md5(uniqid()), 0, 8);
        
        $sql = "INSERT INTO operator (name, lastName, secLastName, numTel, email, user, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
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
            <h2>Registro de Operadores</h2>

            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" required placeholder="Ingrese el nombre">

            <label for="lastName">Apellido Paterno:</label>
            <input type="text" id="lastName" name="lastName" required placeholder="Ingrese el apellido paterno">

            <label for="secLastName">Apellido Materno:</label>
            <input type="text" id="secLastName" name="secLastName" placeholder="Ingrese el apellido materno">

            <label for="numTel">Número de Teléfono:</label>
            <input type="text" id="numTel" name="numTel" required placeholder="Ingrese el número de teléfono">

            <button type="submit" name="submit">Registrar Operador</button>
        </form>
    </main>
</body>
</html>