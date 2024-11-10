<?php include "includes/header.php"?>

<main class="collage-container">
        <section id="crear-orden" class="collage-item">
            <div class="card-content">
                <h2><i></i> Create Work Order</h2>
                <form id="orden-form">
                    <label for="equipo">Technician:</label>
                    <select id="equipo" name="equipo" required>
                        <option value="">Ricardo Lopez</option>
                        <option value="">Julio Chavez</option>
                        <option value="">Manuel Torres</option>
                    </select>

                    <label for="tipo-mantenimiento">Type of Maintenance:</label>
                    <select id="tipo-mantenimiento" name="tipo-mantenimiento" required>
                        <option value="preventivo">Preventive Maintenance</option>
                        <option value="correctivo">Corrective Maintenance</option>
                        <option value="emergencia">Emergency Repair</option>
                    </select>

                    <label for="descripcion">Description of Work:</label>
                    <textarea 
                        id="descripcion" 
                        name="descripcion" 
                        required 
                        rows="6"
                        style="max-height: 150px; min-height: 100px; resize: vertical;"
                        placeholder="Specify: 1. Failure or work to be done&#10;2. Necessary parts&#10;3. Required tools&#10;4. Safety measures">
                    </textarea>
                    
                    <label for="prioridad">Priority:</label>
                    <select id="prioridad" name="prioridad">
                        <option value="alta">High - Production Stop</option>
                        <option value="media">Medium - Affects Performance</option>
                        <option value="baja">Low - Scheduled Maintenance</option>
                    </select>

                    <label for="fecha-limite">Scheduled Date:</label>
                    <input type="date" id="fecha-limite" name="fecha-limite" required>
                    
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
                <a href="Repuesto.php" class="ver-todo btn">
                    <i></i> View Full Inventory
                </a>
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
                <a href="Historial.php" class="ver-todo btn">
                    <i></i> View Full History
                </a>
            </div>
        </section>
    </main>
    
</body>

</html>
