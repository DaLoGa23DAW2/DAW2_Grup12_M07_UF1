<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST["nombre"]);
    $correo = htmlspecialchars($_POST["correo"]);
    $contrasena = $_POST["contrasena"];
    $rol = htmlspecialchars($_POST["rol"]);

    if (empty($nombre) || empty($correo) || empty($contrasena) || empty($rol)) {
        echo "Todos los campos son obligatorios";
    } else {
        $hash_contrasena = password_hash($contrasena, PASSWORD_DEFAULT);
        $datos_usuario = "Nombre: $nombre, Correo: $correo, Contraseña: $hash_contrasena, Rol: $rol" . PHP_EOL;

        $ruta_archivo = 'info_usuarios.txt';

        if (file_put_contents($ruta_archivo, $datos_usuario, FILE_APPEND) !== false) {
            echo "Datos escritos en el archivo con éxito.";
        } else {
            echo "Error al escribir en el archivo. Verifica los permisos y la ubicación del archivo.";
        }

        echo "<br><a href='index.php'>Volver a la página de inicio</a>";
        exit();
    }
}
?>
