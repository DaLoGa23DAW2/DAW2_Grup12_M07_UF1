<?php
// modificar_gestor.php
session_start();

if ($_SESSION['rol'] !== 'admin') {
    die("Acceso denegado.");
}

function leerUsuarios($archivo) {
    $usuarios = [];
    if (file_exists($archivo)) {
        $lineas = file($archivo, FILE_IGNORE_NEW_LINES);
        foreach ($lineas as $linea) {
            if (trim($linea) === '') {
                continue;
            }
            $elementos = explode(", ", $linea);
            if (count($elementos) >= 4) {
                $usuarios[] = [
                    'nombre' => explode(': ', $elementos[0])[1],
                    'correo' => explode(': ', $elementos[1])[1],
                    'hash' => explode(': ', $elementos[2])[1],
                    'rol' => explode(': ', $elementos[3])[1],
                ];
            }
        }
    }
    return $usuarios;
}

$usuarios = leerUsuarios('info_usuarios.txt');
$gestores = array_filter($usuarios, function($usuario) {
    return $usuario['rol'] === 'gestor';
});
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Gestor</title>
    <link rel="stylesheet" href="css/style_modificarGestor.css">
</head>
<body>
    <div class="container">
        <h2>Modificar Gestor</h2>
        <?php foreach ($gestores as $gestor): ?>
        <form action="actualizar_gestor.php" method="post">
            <input type="hidden" name="correo_actual" value="<?php echo htmlspecialchars($gestor['correo']); ?>">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($gestor['nombre']); ?>" required>
            
            <label for="correo">Correo Electrónico:</label>
            <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($gestor['correo']); ?>" required>
            
            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" placeholder="Dejar en blanco para no cambiar">

            <button type="submit">Actualizar Gestor</button>
        </form>
        <?php endforeach; ?>
        <a href="index.php">Volver</a>
    </div>
</body>
</html>
