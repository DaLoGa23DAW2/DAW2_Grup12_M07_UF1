<?php
    $nombre = "cla1";
    $correo = "501";
    $contrasena = "";
    $rol = "";
    
    $nombre2 = "cla2";
    $correo2 = "502";
    $contrasena2 = "";
    $rol2 = "";

    $nombre3 = "cla3";
    $correo3 = "503";
    $contrasena3 = "";
    $rol3 = "";

    $nombre4 = "cla4";
    $correo4 = "504";
    $contrasena4 = "";
    $rol4 = "";

    $nombre5 = "cla5";
    $correo5 = "505";
    $contrasena5 = "";
    $rol5 = "";

        $datos_usuario = "Nombre: $nombre, Correo: $correo, Contraseña: $contrasena, Rol: $rol";
        $datos_usuario2 = "Nombre: $nombre2, Correo: $correo2, Contraseña: $contrasena2, Rol: $rol2";
        $datos_usuario3 = "Nombre: $nombre3, Correo: $correo3, Contraseña: $contrasena3, Rol: $rol3";
        $datos_usuario4 = "Nombre: $nombre4, Correo: $correo4, Contraseña: $contrasena4, Rol: $rol4";
        $datos_usuario5 = "Nombre: $nombre5, Correo: $correo5, Contraseña: $contrasena5, Rol: $rol5";

        $ruta_archivo = 'info_usuarios.txt';

        if (file_put_contents($ruta_archivo, )) {
            echo "Datos escritos en el archivo con éxito.";
        } else {
            echo "Error al escribir en el archivo. Verifica los permisos y la ubicación del archivo.";
        }


        echo "<br><a href='index.php'>Volver a la página de inicio</a>";
        exit();

?>
