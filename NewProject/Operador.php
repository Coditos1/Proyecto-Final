<?php
session_start(); // Start the session to access session variables

// Check if the user is logged in
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

$conexion = mysqli_connect("127.0.0.1", "root", "", "industrial_maintenance");

if (!$conexion) {
    die("Connection error: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['fecha'];
    $description = $_POST['descripcion'];
    $equipment_id = $_POST['equipo'];

    // Get the operator ID from the session
    $operator_id = $_SESSION['id_user']; // Ensure the operator ID is stored in the session

    // Insert the failure
    $sql_failure = "INSERT INTO failure (date, description, operator) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql_failure);
    $stmt->bind_param("ssi", $date, $description, $operator_id);

    if ($stmt->execute()) {
        $failure_id = $conexion->insert_id;

        // Insert the affected equipment
        $sql_equipment = "INSERT INTO failure_equipment (failure, equipment) VALUES (?, ?)";
        $stmt_equipment = $conexion->prepare($sql_equipment);
        $stmt_equipment->bind_param("ii", $failure_id, $equipment_id);

        if ($stmt_equipment->execute()) {
            echo "<div class='alert alert-success mt-3'>Report submitted successfully.</div>";
        } else {
            echo "<div class='alert alert-danger mt-3'>Error registering the equipment: " . $stmt_equipment->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger mt-3'>Error registering the failure: " . $stmt->error . "</div>";
    }

    $stmt->close();
    if (isset($stmt_equipment)) {
        $stmt_equipment->close();
    }
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operator</title>
    <link rel="stylesheet" href="includes/statics/css/bootstrap.min.css">
    <style>
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f7fa;
    margin: 0;
    padding: 20px;
}

form {
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    max-width: 600px;
    margin: auto;
    padding: 20px;
}

h2 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    color: #555;
}

input[type="date"],
textarea,
select {
    width: 100%;
    max-width: 575px; /* Ancho máximo reducido */
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    transition: border-color 0.3s;
}

input[type="date"]:focus,
textarea:focus,
select:focus {
    border-color: #ff8c00; /* Naranja */
    outline: none;
}

textarea {
    resize: none; /* Evita el cambio de tamaño */
    height: 80px; /* Altura fija */
}

.btn {
    background-color: #ff8c00; /* Naranja */
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
    display: block;
    width: 100%;
}

.btn:hover {
    background-color: #e07b00; /* Naranja más oscuro */
}
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Failure Report</h2>
        <form action="Operador.php" method="POST">
            <div class="form-group">
                <label for="fecha">Report Date:</label>
                <input type="date" class="form-control" id="fecha" name="fecha" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Failure Description:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="equipo">Affected Equipment:</label>
                <select class="form-control" id="equipo" name="equipo" required>
                    <?php
                    $conexion = mysqli_connect("127.0.0.1", "root", "", "industrial_maintenance");

                    if (!$conexion) {
                        die("Connection error: " . mysqli_connect_error());
                    }

                    $sql_equipo = "SELECT id_equipment, name FROM equipment WHERE status = 'Operativo'";
                    $result = $conexion->query($sql_equipo);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id_equipment'] . "'>" . $row['name'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No equipment available</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit Report</button>
        </form>
    </div>
</body>
</html>