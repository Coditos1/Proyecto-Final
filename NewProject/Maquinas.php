<?php
    include 'includes/header.php';

    $conexion = mysqli_connect("127.0.0.1", "root", "", "industrial_maintenance");

    if (!$conexion) {
        die("Error en la conexión: " . mysqli_connect_error());
    } else {
        echo "";
    }

    // Obtener las ubicaciones del equipo
    $sql_location = "SELECT id_location, name FROM equipment_location";
    $result_location = $conexion->query($sql_location); // Ejecutar la consulta

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST["name"]; 
        $model = $_POST["model"];
        $brand = $_POST["brand"];
        $status = $_POST["status"]; 
        $equipment_location = $_POST["equipment_location"];
        
        $sql = "INSERT INTO equipment (name, model, brand, status, equipment_location) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        
        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $conexion->error);
        }
        
        $stmt->bind_param("sssss", $name, $model, $brand, $status, $equipment_location);
        
        if ($stmt->execute()) {
            echo "Nueva máquina registrado exitosamente.";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
?>

<main class="maquinas-container">
        <form id="register-machine-form" action="Maquinas.php" method="POST" class="form-container">
            <h2>Machine Registration</h2>

            <label for="name">Machine Name:</label>
            <input type="text" id="name" name="name" required placeholder="Enter the machine name">

            <label for="model">Model:</label>
            <input type="text" id="model" name="model" required placeholder="Enter the machine model">

            <label for="brand">Brand:</label>
            <input type="text" id="brand" name="brand" required placeholder="Enter the machine brand">

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="Operational">Operational</option>
                <option value="Non-Operational">Non-Operational</option>
            </select>

            <label for="equipment_location">Equipment Location:</label>
            <select id="equipment-location" name="equipment_location" required>
            <option value="">Seleccionar ubicación del equipo</option>
            <?php
                if ($result_location->num_rows > 0) {
                    while ($row = $result_location->fetch_assoc()) {
                        echo "<option value='" . $row['id_location'] . "'>" . $row['name'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No hay ubicaciones disponibles</option>";
                }
            ?>
        </select>

            <button type="submit" id="submit-button" name="submit">Register Machine</button>
        </form>
</main>
</body>
</html>