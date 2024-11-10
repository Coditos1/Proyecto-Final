<?php
    include "includes/header.php"
?>
    <main class="reporte-container">
        <section class="reportes-tabla">
            <div class="tabla-header">
                <h2>Report History</h2>
                <div class="filtros">
                    <select class="filtro-severidad">
                        <option value="">All Severities</option>
                        <option value="alta">High</option>
                        <option value="media">Medium</option>
                        <option value="baja">Low</option>
                    </select>
                </div>
            </div>

            <div class="tabla-container">
                <table>
                    <thead>
                        <tr>
                            <th>Report ID</th>
                            <th>Date</th>
                            <th>Equipment</th>
                            <th>Reported By</th>
                            <th>Description</th>
                            <th>Severity</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#REP001</td>
                            <td>2024-02-20</td>
                            <td>Hydraulic Press #1</td>
                            <td>Juan Pérez</td>
                            <td>Oil leak in main system</td>
                            <td><span class="severidad alta">High</span></td>
                            <td><span class="estado pendiente">Pending</span></td>
                            <td>
                                <button class="btn-accion generar">Generate Order</button>
                                <button class="btn-accion eliminar">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tabla-container">
                <table>
                    <thead>
                        <tr>
                            <th>Report ID</th>
                            <th>Date</th>
                            <th>Equipment</th>
                            <th>Reported By</th>
                            <th>Description</th>
                            <th>Severity</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#REP001</td>
                            <td>2024-02-20</td>
                            <td>Hydraulic Press #1</td>
                            <td>Juan Pérez</td>
                            <td>Oil leak in main system</td>
                            <td><span class="severidad alta">High</span></td>
                            <td><span class="estado pendiente">Pending</span></td>
                            <td>
                                <button class="btn-accion generar">Generate Order</button>
                                <button class="btn-accion eliminar">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tabla-container">
                <table>
                    <thead>
                        <tr>
                            <th>Report ID</th>
                            <th>Date</th>
                            <th>Equipment</th>
                            <th>Reported By</th>
                            <th>Description</th>
                            <th>Severity</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#REP001</td>
                            <td>2024-02-20</td>
                            <td>Hydraulic Press #1</td>
                            <td>Juan Pérez</td>
                            <td>Oil leak in main system</td>
                            <td><span class="severidad alta">High</span></td>
                            <td><span class="estado pendiente">Pending</span></td>
                            <td>
                                <button class="btn-accion generar">Generate Order</button>
                                <button class="btn-accion eliminar">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>