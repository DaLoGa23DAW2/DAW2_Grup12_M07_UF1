<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['nombre_usuario'], $_SESSION['rol_usuario'], $_SESSION['correo_usuario'])) {
    $nombre_usuario = $_SESSION['nombre_usuario'];
    $rol_usuario = $_SESSION['rol_usuario'];
    $correo_usuario = $_SESSION['correo_usuario'];

    // Función para obtener datos del cliente
    function obtenerDatosCliente($correo, $archivo) {
        $datos_cliente = null;
        if (file_exists($archivo)) {
            $lineas = file($archivo, FILE_IGNORE_NEW_LINES);
            foreach ($lineas as $linea) {
                $elementos = explode(", ", $linea);
                if (count($elementos) >= 4) {
                    $correo_guardado = explode(': ', $elementos[1])[1];
                    if ($correo_guardado === $correo) {
                        $datos_cliente = [
                            'nombre' => explode(': ', $elementos[0])[1],
                            'correo' => $correo_guardado,
                            'hash' => explode(': ', $elementos[2])[1],
                            'rol' => explode(': ', $elementos[3])[1],
                        ];
                        break;
                    }
                }
            }
        } else {
            die("El archivo $archivo no existe.");
        }
        return $datos_cliente;
    }

    $correo_cliente = isset($_SESSION['correo_usuario']) ? $_SESSION['correo_usuario'] : '';

    if (!empty($correo_cliente)) {
        $datos_cliente = obtenerDatosCliente($correo_cliente, 'info_usuarios.txt');
        if ($datos_cliente !== null) {
            // Mostrar los datos del cliente
            echo "<!DOCTYPE html>
            <html lang='es'>
            <head>
                <meta charset='UTF-8'>
                <title>Datos del Cliente</title>
                <link rel='stylesheet' href='css/style_gestionC.css'>
            </head>
            <body>
                <div class='container'>
                    <h1>Datos del Cliente</h1>
                    <p>Nombre: " . htmlspecialchars($datos_cliente['nombre']) . "</p>
                    <p>Correo: " . htmlspecialchars($datos_cliente['correo']) . "</p>
                    <p>Rol: " . htmlspecialchars($datos_cliente['rol']) . "</p>
                    <a href='logout.php' class='logout'>Logout</a>
                </div>
            </body>
            </html>";
        } else {
            echo "No se encontraron datos para el cliente con el correo electrónico proporcionado.";
        }
    } else {
        echo "El correo electrónico del cliente no fue proporcionado.";
    }
} else {
    // Si el usuario no ha iniciado sesión, redirigirlo al formulario de inicio de sesión
    header("Location: login.php");
    exit();
}
?>
