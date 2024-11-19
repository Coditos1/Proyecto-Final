<?php
include 'includes/tecnav.php';

$conexion = mysqli_connect("127.0.0.1", "root", "", "industrial_maintenance");

if (!$conexion) {
    die("Error en la conexión: " . mysqli_connect_error());
}

$sql_repuestos = "SELECT id_spareParts, name FROM spare_parts";
$result_repuestos = $conexion->query($sql_repuestos);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha_mantenimiento = $_POST['fecha_mantenimiento'];
    $resultados = $_POST['resultados'];
    $observaciones = $_POST['observaciones'];
    $repuesto_id = $_POST['repuesto'];
    $cantidad_usada = $_POST['cantidad_usada'];

    $sql_insert = "INSERT INTO maintenance_history (completionDate, results, observations, spare_parts, usedQuantity) 
                   VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql_insert);
    $stmt->bind_param("ssssi", $fecha_mantenimiento, $resultados, $observaciones, $repuesto_id, $cantidad_usada);
    $stmt->execute();
}
?>

<section id="reporte-mantenimiento">
    <h2>Reporte de Mantenimiento</h2>
    <form method="POST" action="">
        <label for="fecha_mantenimiento">Fecha del Mantenimiento:</label>
        <input type="date" id="fecha_mantenimiento" name="fecha_mantenimiento" required>

        <label for="resultados">Resultados del Mantenimiento:</label>
        <select id="resultados" name="resultados" required>
            <option value="Exitoso">Exitoso</option>
            <option value="No se pudo completar">No se pudo completar</option>
            <option value="Requiere seguimiento">Requiere seguimiento</option>
        </select>

        <label for="observaciones">Observaciones:</label>
        <textarea id="observaciones" name="observaciones" rows="4" required></textarea>

        <label for="repuesto">Repuestos Utilizados:</label>
        <select id="repuesto" name="repuesto" required>
            <?php while ($row = $result_repuestos->fetch_assoc()): ?>
                <option value="<?php echo $row['id_spareParts']; ?>"><?php echo $row['name']; ?></option>
            <?php endwhile; ?>
        </select>

        <label for="cantidad_usada">Cantidad Usada:</label>
        <input type="number" id="cantidad_usada" name="cantidad_usada" min="1" required>

        <button type="submit">Enviar Reporte</button>
    </form>
</section>

</main>
</body>
</html>