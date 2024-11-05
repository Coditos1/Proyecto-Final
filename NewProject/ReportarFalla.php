<?php
    include 'includes/header.php';
?>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 1000px;
            margin: auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            height: 80px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <form action="reportar_falla.php" method="post">
        <label for="id_reporte">ID Reporte:</label>
        <input type="text" id="id_reporte" name="id_reporte" required><br>

        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="fecha" required><br>

        <label for="equipo">Equipo:</label>
        <input type="text" id="equipo" name="equipo" required><br>

        <label for="reportado_por">Reportado por:</label>
        <input type="text" id="reportado_por" name="reportado_por" required><br>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea><br>

        <label for="severidad">Severidad:</label>
        <select id="severidad" name="severidad" required>
            <option value="baja">Baja</option>
            <option value="media">Media</option>
            <option value="alta">Alta</option>
        </select><br>

        <label for="estado">Estado:</label>
        <select id="estado" name="estado" required>
            <option value="pendiente">Pendiente</option>
            <option value="en_proceso">En proceso</option>
            <option value="completado">Completado</option>
        </select><br>

        <label for="acciones">Acciones:</label>
        <textarea id="acciones" name="acciones"></textarea><br>

        <input type="submit" value="Enviar Reporte">
    </form>
</body>
</html>