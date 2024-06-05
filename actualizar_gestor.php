<?php
// actualizar_gestor.php
session_start();

if ($_SESSION['rol'] !== 'admin') {
    die("Acceso denegado.");
}

function actualizarUsuario($correo_actual, $nombre, $correo, $contrasena) {
    $archivo = 'info_usuarios.txt';
    $lineas = file($archivo, FILE_IGNORE_NEW_LINES);
    $nuevoContenido = "";

    foreach ($lineas as $linea) {
        if (trim($linea) === '') {
            continue;
        }

        $elementos = explode(", ", $linea);

        if (count($elementos) >= 4) {
            $correo_guardado = explode(': ', $elementos[1])[1];

            if ($correo_guardado === $correo_actual) {
                $elementos[0] = "nombre: $nombre";
                $elementos[1] = "correo: $correo"; // Actualizamos el correo electrónico
                if (!empty($contrasena)) {
                    $hash_nuevo = password_hash($contrasena, PASSWORD_DEFAULT);
                    $elementos[2] = "hash: $hash_nuevo";
                }
            }

            $nuevoContenido .= implode(", ", $elementos) . "\n";
        }
    }

    file_put_contents($archivo, $nuevoContenido);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo_actual = $_POST['correo_actual'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo']; // Agregamos la variable $correo
    $contrasena = $_POST['contrasena'];

    actualizarUsuario($correo_actual, $nombre, $correo, $contrasena);
    header("Location: modificar_gestor.php");
    exit();
}
?>
