<?php include "includes/header.php"?>

    <main class="collage-container">
        <section id="crear-orden" class="collage-item">
            <div class="card-content">
                <h2><i></i> Crear Orden de Trabajo</h2>
                <form id="orden-form">
                    <label for="equipo">ID del Equipo:</label>
                    <input type="text" id="equipo" name="equipo" required placeholder="Ingrese el ID del equipo">

                    <label for="tipo-mantenimiento">Tipo de Mantenimiento:</label>
                    <select id="tipo-mantenimiento" name="tipo-mantenimiento" required>
                        <option value="preventivo">Mantenimiento Preventivo</option>
                        <option value="correctivo">Mantenimiento Correctivo</option>
                        <option value="emergencia">Reparación de Emergencia</option>
                    </select>

                    <label for="descripcion">Descripción del Trabajo:</label>
                    <textarea 
                        id="descripcion" 
                        name="descripcion" 
                        required 
                        rows="6"
                        style="max-height: 150px; min-height: 100px; resize: vertical;"
                        placeholder="Especifique: 1. Falla o trabajo a realizar&#10;2. Repuestos necesarios&#10;3. Herramientas requeridas&#10;4. Medidas de seguridad">
                    </textarea>
                    
                    <label for="prioridad">Prioridad:</label>
                    <select id="prioridad" name="prioridad">
                        <option value="alta">Alta - Parada de Producción</option>
                        <option value="media">Media - Afecta Rendimiento</option>
                        <option value="baja">Baja - Mantenimiento Programado</option>
                    </select>

                    <label for="fecha-limite">Fecha Programada:</label>
                    <input type="date" id="fecha-limite" name="fecha-limite" required>
                    
                    <button type="submit">
                        <i></i> Generar Orden de Trabajo
                    </button>
                </form>
            </div>
        </section>

        <section id="comprar-repuestos" class="collage-item">
            <div class="card-content">
                <h2><i class="fas fa-tools"></i> Inventario de Repuestos</h2>
                <div class="repuestos-grid">
                    <div class="repuesto-card">
                        <span class="stock bajo">Stock: 2</span>
                        <h3>Rodamientos SKF 6205</h3>
                        <p class="specs">Para Motores Eléctricos</p>
                        <p class="precio">$45.99/unidad</p>
                        <a href="Repuesto.html"><button>Solicitar Compra</button></a>
                    </div>
                    <div class="repuesto-card">
                        <span class="stock critico">Stock: 1</span>
                        <h3>Aceite Hidráulico ISO 68</h3>
                        <p class="specs">Bidón 20L</p>
                        <p class="precio">$189.50</p>
                        <a href="Repuesto.html"><button>Solicitar Compra</button></a>
                    </div>
                    <div class="repuesto-card">
                        <span class="stock">Stock: 8</span>
                        <h3>Correas A-45</h3>
                        <p class="specs">Transmisión Industrial</p>
                        <p class="precio">$28.75/unidad</p>
                        <a href="Repuesto.html"><button>Solicitar Compra</button></a>
                    </div>
                </div>
                <a href="Repuesto.html" class="ver-todo btn">
                    <i></i> Ver Inventario Completo
                </a>
            </div>
        </section>

        <section id="reportes-mantenimiento" class="collage-item">
            <div class="card-content">
                <h2><i></i> Métricas de Mantenimiento</h2>
                <div class="stats-container">
                    <div class="stat-card">
                        <h4>MTBF</h4>
                        <p class="stat-number">156h</p>
                        <p class="stat-label">Tiempo Medio Entre Fallas</p>
                    </div>
                    <div class="stat-card">
                        <h4>MTTR</h4>
                        <p class="stat-number">4.2h</p>
                        <p class="stat-label">Tiempo Medio de Reparación</p>
                    </div>
                    <div class="stat-card">
                        <h4>OEE</h4>
                        <p class="stat-number">85%</p>
                        <p class="stat-label">Eficiencia General</p>
                    </div>
                    <div class="stat-card">
                        <h4>Pendientes</h4>
                        <p class="stat-number">6</p>
                        <p class="stat-label">Órdenes Activas</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="historial-mantenimiento" class="collage-item">
            <div class="card-content">
                <h2><i></i> Historial de Mantenimiento</h2>
                <div class="timeline">
                    <div class="timeline-item urgente">
                        <div class="date">22/03/2024</div>
                        <div class="content">
                            <strong>Prensa Hidráulica #1</strong>
                            <p>Cambio de sellos hidráulicos y aceite</p>
                            <span class="status completado">Completado</span>
                        </div>
                    </div>
                    <div class="timeline-item preventivo">
                        <div class="date">20/03/2024</div>
                        <div class="content">
                            <strong>Torno CNC Serie-2000</strong>
                            <p>Calibración de ejes y lubricación general</p>
                            <span class="status en-proceso">En Proceso</span>
                        </div>
                    </div>
                    <div class="timeline-item correctivo">
                        <div class="date">19/03/2024</div>
                        <div class="content">
                            <strong>Compresor Industrial K-100</strong>
                            <p>Reemplazo de filtro y válvula de seguridad</p>
                            <span class="status pendiente">Pendiente</span>
                        </div>
                    </div>
                </div>
                <button>
                    <i></i> Ver Historial Completo
                </button>
            </div>
        </section>
    </main>
    
</body>

</html>
