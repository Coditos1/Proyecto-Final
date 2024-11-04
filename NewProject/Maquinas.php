<?php
    include 'includes/header.php';

    require "../NewProject/includes/config/database.php";
    $db = conectarDB();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST["name"]; 
        $model = $_POST["model"];
        $brand = $_POST["brand"];
        $status = $_POST["status"]; 
        $equipment_location = $_POST["equipment_location"];
    
        $query = "INSERT INTO equipment (name, model, brand, status, equipment_location) VALUES (?, ?, ?, ?, ?)";
        
        // Preparar la consulta
        $stmt = $db->prepare($query);
        
        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $db->error);
        }
    
        $stmt->bind_param("sssss", $name, $model, $brand, $status, $equipment_location);
    
        if ($stmt->execute()) {
            echo "Nueva máquina registrada exitosamente.";
        } else {
            echo "Error al registrar máquina" . $stmt->error;
        }
    
        $stmt->close();
        $db->close();
    }
?>

<main class="maquinas-container">
        <form id="register-machine-form" action="insert_machine.php" method="POST" class="form-container">
            <h2>Formulario de Registro</h2>

            <label for="name">Nombre de la Máquina:</label>
            <input type="text" id="machine-name" name="name" required placeholder="Ingrese el nombre de la máquina">

            <label for="model">Modelo:</label>
            <input type="text" id="machine-model" name="model" required placeholder="Ingrese el modelo de la máquina">

            <label for="brand">Marca:</label>
            <input type="text" id="machine-brand" name="brand" required placeholder="Ingrese la marca de la máquina">

            <label for="status">Estado:</label>
            <select id="machine-status" name="status" required>
                <option value="Operativo">Operativo</option>
                <option value="No Operativo">No Operativo</option>
            </select>

            <label for="equipment_location">Ubicación del Equipo:</label>
            <input type="text" id="equipment-location" name="equipment_location" required placeholder="Ingrese la ubicación del equipo">

            <button type="submit" id="submit-button">Registrar Máquina</button>
        </form>
</main>
</body>
</html>