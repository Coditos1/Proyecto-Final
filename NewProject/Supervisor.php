<?php include "includes/header.php";

    $conexion = mysqli_connect("127.0.0.1", "root", "", "industrial_maintenance");

    if (!$conexion) {
        die("Error en la conexión: " . mysqli_connect_error());
    } else {
        echo "";
    }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $tecnico_id = $_POST['tecnico'];
    $equipo_id = $_POST['equipo'];
    $fecha_limite = $_POST['fecha-limite'];
    $tipo_mantenimiento_id = $_POST['tipo-mantenimiento'];
    $descripcion = $_POST['descripcion'];

    $sql_work_order = "INSERT INTO work_orders (description, equipment, technician, supervisor, status) VALUES (?, ?, ?, ?, 'Pendiente')";
    $stmt_work_order = $conexion->prepare($sql_work_order);
    $stmt_work_order->bind_param("siis", $descripcion, $equipo_id, $tecnico_id, $supervisor_id);

    if ($stmt_work_order->execute()) {
        $work_order_id = $conexion->insert_id;

        $sql_maintenance = "INSERT INTO maintenance (assignedDate, description, status, equipment, technician, maintenance_types) VALUES (?, ?, 'Pendiente', ?, ?, ?)";
        $stmt_maintenance = $conexion->prepare($sql_maintenance);
        $stmt_maintenance->bind_param("ssiii", $fecha_limite, $descripcion, $equipo_id, $tecnico_id, $tipo_mantenimiento_id);

        if ($stmt_maintenance->execute()) {
            echo "<div class='alert alert-success'>Work order generated successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error registering maintenance: " . $stmt_maintenance->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Error registering work order: " . $stmt_work_order->error . "</div>";
    }

    // Cerrar conexiones
    $stmt_work_order->close();
    $stmt_maintenance->close();
}
?>

<main class="collage-container">
        <section id="crear-orden" class="collage-item">
            <div class="card-content">
                <h2><i></i> Create Work Order</h2>
                <form id="orden-form" action="Supervisor.php" method="POST">
                    <label for="tecnico">Technician:</label>
                    <select id="tecnico" name="tecnico" required>
                        <option value="">Select a technician</option>
                        <?php
                        $sql_tecnico = "SELECT id_technician, name FROM technician";
                        $result_tecnico = $conexion->query($sql_tecnico);

                        if ($result_tecnico->num_rows > 0) {
                            while ($row = $result_tecnico->fetch_assoc()) {
                                echo "<option value='" . $row['id_technician'] . "'>" . $row['name'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No technicians available</option>";
                        }
                        ?>
                    </select>

                    <label for="equipo">Equipment:</label>
                    <select id="equipo" name="equipo" required>
                        <option value="">Select equipment</option>
                        <?php
                        $sql_equipo = "SELECT id_equipment, name FROM equipment WHERE status = 'Operativo'";
                        $result_equipo = $conexion->query($sql_equipo);

                        if ($result_equipo->num_rows > 0) {
                            while ($row = $result_equipo->fetch_assoc()) {
                                echo "<option value='" . $row['id_equipment'] . "'>" . $row['name'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No equipment available</option>";
                        }
                        ?>
                    </select>

                    <label for="fecha-limite">Due Date:</label>
                    <input type="date" id="fecha-limite" name="fecha-limite" required>

                    <label for="tipo-mantenimiento">Type of Maintenance:</label>
                    <select id="tipo-mantenimiento" name="tipo-mantenimiento" required>
                        <option value="">Select a type of maintenance</option>
                        <?php
                        $sql_mantenimiento = "SELECT id_maintType, name FROM maintenance_types";
                        $result_mantenimiento = $conexion->query($sql_mantenimiento);

                        if ($result_mantenimiento->num_rows > 0) {
                            while ($row = $result_mantenimiento->fetch_assoc()) {
                                echo "<option value='" . $row['id_maintType'] . "'>" . $row['name'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No maintenance types available</option>";
                        }
                        ?>
                    </select>

                    <label for="descripcion">Description of Work Order:</label>
                    <textarea 
                        id="descripcion" 
                        name="descripcion" 
                        required 
                        rows="6"
                        style="max-height: 150px; min-height: 100px; resize: vertical;"
                        placeholder="Specify: 1. Work to be done&#10;2. Necessary parts&#10;3. Required tools&#10;4. Safety measures">
                    </textarea>

                    <button type="submit">
                        <i></i> Generate Work Order
                    </button>
                </form>
            </div>
        </section>

        <section id="comprar-repuestos" class="collage-item">
            <div class="card-content">
                <h2><i class="fas fa-tools"></i> Spare Parts Inventory</h2>
                <div class="repuestos-grid">
                    <div class="repuesto-card">
                        <span class="stock bajo">Stock: 2</span>
                        <h3>SKF 6205 Bearings</h3>
                        <p class="specs">For Electric Motors</p>
                        <p class="precio">$45.99/unit</p>
                        <a href="Repuesto.php"><button>Request Purchase</button></a>
                    </div>
                    <div class="repuesto-card">
                        <span class="stock critico">Stock: 1</span>
                        <h3>Hydraulic Oil ISO 68</h3>
                        <p class="specs">20L Drum</p>
                        <p class="precio">$189.50</p>
                        <a href="Repuesto.php"><button>Request Purchase</button></a>
                    </div>
                    <div class="repuesto-card">
                        <span class="stock">Stock: 8</span>
                        <h3>A-45 Belts</h3>
                        <p class="specs">Industrial Transmission</p>
                        <p class="precio">$28.75/unit</p>
                        <a href="Repuesto.php"><button>Request Purchase</button></a>
                    </div>
                </div>
                <button>
                <a href="Repuesto.php" style="text-decoration: none; color: white;">
                    <i></i> View Full Inventory
                </a>
                </button>
            </div>
        </section>

        <section id="reportes-mantenimiento" class="collage-item">
            <div class="card-content">
                <h2><i></i> Maintenance Metrics</h2>
                <div class="stats-container">
                    <div class="stat-card">
                        <h4>MTBF</h4>
                        <p class="stat-number">156h</p>
                        <p class="stat-label">Mean Time Between Failures</p>
                    </div>
                    <div class="stat-card">
                        <h4>MTTR</h4>
                        <p class="stat-number">4.2h</p>
                        <p class="stat-label">Mean Time to Repair</p>
                    </div>
                    <div class="stat-card">
                        <h4>OEE</h4>
                        <p class="stat-number">85%</p>
                        <p class="stat-label">Overall Efficiency</p>
                    </div>
                    <div class="stat-card">
                        <h4>Pending</h4>
                        <p class="stat-number">6</p>
                        <p class="stat-label">Active Orders</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="historial-mantenimiento" class="collage-item">
            <div class="card-content">
                <h2><i></i> Maintenance History</h2>
                <div class="timeline">
                    <div class="timeline-item urgente">
                        <div class="date">22/03/2024</div>
                        <div class="content">
                            <strong>Hydraulic Press #1</strong>
                            <p>Changed hydraulic seals and oil</p>
                            <span class="status completado">Completed</span>
                        </div>
                    </div>
                    <div class="timeline-item preventivo">
                        <div class="date">20/03/2024</div>
                        <div class="content">
                            <strong>CNC Lathe Series-2000</strong>
                            <p>Calibration of axes and general lubrication</p>
                            <span class="status en-proceso">In Progress</span>
                        </div>
                    </div>
                    <div class="timeline-item correctivo">
                        <div class="date">19/03/2024</div>
                        <div class="content">
                            <strong>Industrial Compressor K-100</strong>
                            <p>Replacement of filter and safety valve</p>
                            <span class="status pendiente">Pending</span>
                        </div>
                    </div>
                </div>
                <button>
                <a href="Historial.php" style="text-decoration: none; color: white;">
                    <i></i> View Full History
                </a>
                </button>
            </div>
        </section>
    </main>
    
</body>

</html>

