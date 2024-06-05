<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="css/style_registro2.css">
</head>
<body>

    <div class="container">
        <div class="content">
    <h2>Registro de Usuario</h2>

    <form action="registrar_cliente.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required>

        <label for="correo">Correo:</label>
        <input type="email" name="correo" required>

        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" required>

        <select name="rol" required>
            <option value=""></option>
            <option value="cliente">Cliente</option>
        </select><br>

        <button type="submit">Registrar</button>
    </form>
        </div>
    </div>


</body>
</html>


