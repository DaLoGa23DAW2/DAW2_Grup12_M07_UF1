<?php
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
    } else {
        die("El archivo $archivo no existe.");
    }
    return $usuarios;
}

$usuarios = leerUsuarios('info_usuarios.txt');

$admins = [];
$gestores = [];
$clientes = [];

foreach ($usuarios as $usuario) {
    switch ($usuario['rol']) {
        case 'admin':
            $admins[] = $usuario;
            break;
        case 'gestor':
            $gestores[] = $usuario;
            break;
        case 'cliente':
            $clientes[] = $usuario;
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Información de Usuarios</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="content">
        <h1>Información de Usuarios</h1>
        <section>
            <h2>Administradores</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admins as $admin): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($admin['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($admin['correo']); ?></td>
                        <td><?php echo htmlspecialchars($admin['rol']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <section>
            <h2>Gestores</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($gestores as $gestor): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($gestor['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($gestor['correo']); ?></td>
                        <td><?php echo htmlspecialchars($gestor['rol']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <section>
            <h2>Clientes</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $cliente): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($cliente['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($cliente['correo']); ?></td>
                        <td><?php echo htmlspecialchars($cliente['rol']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <br>
        <a href="index.php" class="button">Volver</a>
    </div>
</body>
</html>
