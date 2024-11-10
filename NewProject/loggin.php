<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/maquinas.css"> 
    <link rel="stylesheet" href="css/styles2.css">
</head>
<body>
    <main class="maquinas-container">
        <h2>Login</h2>
        <form action="login.php" method="POST" class="form-container">
            <label for="usuario">Username:</label>
            <input type="text" id="usuario" name="usuario" required placeholder="Enter your username">

            <label for="contraseña">Password:</label>
            <input type="password" id="contraseña" name="contraseña" required placeholder="Enter your password">

            <button type="submit">Log In</button>
        </form>
    </main>
</body>
</html>