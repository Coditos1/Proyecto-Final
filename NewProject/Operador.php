<?php
session_start(); // Iniciar la sesión para acceder a las variables de sesión

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

$conexion = mysqli_connect("127.0.0.1", "root", "", "industrial_maintenance");

if (!$conexion) {
    die("Error en la conexión: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha = $_POST['fecha'];
    $descripcion = $_POST['descripcion'];
    $equipo_id = $_POST['equipo'];

    // Obtener el ID del operador desde la sesión
    $operador_id = $_SESSION['id_user']; // Asegúrate de que el ID del operador se almacene en la sesión

    // Insertar la falla
    $sql_failure = "INSERT INTO failure (date, description, operator) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql_failure);
    $stmt->bind_param("ssi", $fecha, $descripcion, $operador_id);

    if ($stmt->execute()) {
        $failure_id = $conexion->insert_id;

        // Insertar el equipo afectado
        $sql_equipment = "INSERT INTO failure_equipment (failure_id, equipment_id) VALUES (?, ?)";
        $stmt_equipment = $conexion->prepare($sql_equipment);
        $stmt_equipment->bind_param("ii", $failure_id, $equipo_id);

        if ($stmt_equipment->execute()) {
            echo "<div class='alert alert-success mt-3'>Reporte enviado exitosamente.</div>";
        } else {
            echo "<div class='alert alert-danger mt-3'>Error al registrar el equipo: " . $stmt_equipment->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger mt-3'>Error al registrar la falla: " . $stmt->error . "</div>";
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
    <title>Operador</title>
    <link rel="stylesheet" href="includes/statics/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Reporte de Fallas</h2>
        <form action="Operador.php" method="POST">
            <div class="form-group">
                <label for="fecha">Fecha de Reporte:</label>
                <input type="date" class="form-control" id="fecha" name="fecha" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción de la Falla:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="equipo">Equipo Afectado:</label>
                <select class="form-control" id="equipo" name="equipo" required>
                    <?php
                    $conexion = mysqli_connect("127.0.0.1", "root", "", "industrial_maintenance");

                    if (!$conexion) {
                        die("Error en la conexión: " . mysqli_connect_error());
                    }

                    $sql_equipo = "SELECT id_equipment, name FROM equipment WHERE status = 'Operativo'";
                    $result = $conexion->query($sql_equipo);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id_equipment'] . "'>" . $row['name'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No hay equipos disponibles</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Enviar Reporte</button>
        </form>
    </div>
</body>
</html>