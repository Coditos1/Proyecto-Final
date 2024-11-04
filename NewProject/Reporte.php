<?php
    include "includes/header.php"
?>
    <main class="reporte-container">
        <section class="reportes-tabla">
            <div class="tabla-header">
                <h2>Historial de Reportes</h2>
                <div class="filtros">
                    <select class="filtro-severidad">
                        <option value="">Todas las severidades</option>
                        <option value="alta">Alta</option>
                        <option value="media">Media</option>
                        <option value="baja">Baja</option>
                    </select>
                </div>
            </div>

            <div class="tabla-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID Reporte</th>
                            <th>Fecha</th>
                            <th>Equipo</th>
                            <th>Reportado por</th>
                            <th>Descripción</th>
                            <th>Severidad</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#REP001</td>
                            <td>2024-02-20</td>
                            <td>Prensa Hidráulica #1</td>
                            <td>Juan Pérez</td>
                            <td>Fuga de aceite en sistema principal</td>
                            <td><span class="severidad alta">Alta</span></td>
                            <td><span class="estado pendiente">Pendiente</span></td>
                            <td>
                                <button class="btn-accion generar">Generar Orden</button>
                                <button class="btn-accion eliminar">Eliminar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tabla-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID Reporte</th>
                            <th>Fecha</th>
                            <th>Equipo</th>
                            <th>Reportado por</th>
                            <th>Descripción</th>
                            <th>Severidad</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#REP001</td>
                            <td>2024-02-20</td>
                            <td>Prensa Hidráulica #1</td>
                            <td>Juan Pérez</td>
                            <td>Fuga de aceite en sistema principal</td>
                            <td><span class="severidad alta">Alta</span></td>
                            <td><span class="estado pendiente">Pendiente</span></td>
                            <td>
                                <button class="btn-accion generar">Generar Orden</button>
                                <button class="btn-accion eliminar">Eliminar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tabla-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID Reporte</th>
                            <th>Fecha</th>
                            <th>Equipo</th>
                            <th>Reportado por</th>
                            <th>Descripción</th>
                            <th>Severidad</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#REP001</td>
                            <td>2024-02-20</td>
                            <td>Prensa Hidráulica #1</td>
                            <td>Juan Pérez</td>
                            <td>Fuga de aceite en sistema principal</td>
                            <td><span class="severidad alta">Alta</span></td>
                            <td><span class="estado pendiente">Pendiente</span></td>
                            <td>
                                <button class="btn-accion generar">Generar Orden</button>
                                <button class="btn-accion eliminar">Eliminar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>