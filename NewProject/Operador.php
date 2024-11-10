<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operador</title>
    <link rel="stylesheet" href="css/maquinas.css">
</head>
<body>
    <main class="maquinas-container">
        <form id="register-operator-form" action="UserOperador.php" method="POST" class="form-container">
            <h2>Report Failure</h2>

            <label for="equipo">Equipment:</label>
            <select id="Equipo" name="Equipo" required>
                <option value="terreneitor">Terreneitor</option>
                <option value="PBR-31">PBR-1</option>
                <option value="PBE-48">PBE-48</option>
            </select><br>

            <label for="fecha">Date:</label>
            <input type="date" id="fecha" name="fecha" required><br>

            <label for="descripcion">Description:</label>
            <textarea id="descripcion" name="descripcion" required style="max-height: 150px; min-height: 100px; resize: vertical;" placeholder="Enter a description of the failure..."></textarea><br>

            <button type="submit" name="submit">Submit Report</button>
        </form>
    </main>
</body>
</html>