<?php
    include 'includes/header.php';
?>
    <h2>Formulario de Reporte de Falla</h2>
    <form action="reportar_falla.php" method="post">
        <label for="id_reporte">ID Reporte:</label>
        <input type="text" id="id_reporte" name="id_reporte" required><br><br>

        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="fecha" required><br><br>

        <label for="equipo">Equipo:</label>
        <input type="text" id="equipo" name="equipo" required><br><br>

        <label for="reportado_por">Reportado por:</label>
        <input type="text" id="reportado_por" name="reportado_por" required><br><br>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea><br><br>

        <label for="severidad">Severidad:</label>
        <select id="severidad" name="severidad" required>
            <option value="baja">Baja</option>
            <option value="media">Media</option>
            <option value="alta">Alta</option>
        </select><br><br>

        <label for="estado">Estado:</label>
        <select id="estado" name="estado" required>
            <option value="pendiente">Pendiente</option>
            <option value="en_proceso">En proceso</option>
            <option value="completado">Completado</option>
        </select><br><br>

        <label for="acciones">Acciones:</label>
        <textarea id="acciones" name="acciones"></textarea><br><br>

        <input type="submit" value="Enviar Reporte">
    </form>
</body>
</html>