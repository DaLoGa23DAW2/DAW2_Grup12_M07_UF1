<?php
        $nombre = "cla1";
        $correo = "501";
        $contrasena ="";
        $rol = "";
        
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

?>