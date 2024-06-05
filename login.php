<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="contenido">
        <h1>Iniciar Sesión</h1>
        <form action="verificar_login.php" method="post">
            Correo: <input type="email" name="correo" required><br>
            Contraseña: <input type="password" name="contrasena" required><br>
            <select name="rol" required>
                <option value=""></option>
                <option value="admin">Admin</option>
                <option value="gestor">Gestor</option>
                <option value="cliente">Cliente</option>
            </select><br>

            <input type="submit" value="Iniciar Sesión">
        </form>
        <br>
        <a href="index.php">Volver a la página principal</a><br>
    </div>
</body>
</html>
