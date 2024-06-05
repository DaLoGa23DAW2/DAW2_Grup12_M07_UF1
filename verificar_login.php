<?php
session_start();

$_SESSION['rol'] = $_POST['rol'];

function obtenerHash($correo, &$nombre_usuario, &$rol_usuario) {
    $archivo = 'info_usuarios.txt';
    
    if (file_exists($archivo)) {
        $lineas = file($archivo, FILE_IGNORE_NEW_LINES);
        foreach ($lineas as $linea) {
            if (trim($linea) === '') {
                continue;
            }

            $elementos = explode(", ", $linea);

            if (count($elementos) >= 4) {
                $nombre_guardado = explode(': ', $elementos[0])[1];
                $correo_guardado = explode(': ', $elementos[1])[1];
                $rol_guardado = explode(': ', $elementos[3])[1];
                $hash_guardado = explode(': ', $elementos[2])[1];

                if ($correo_guardado === $correo) {
                    $nombre_usuario = $nombre_guardado;
                    $rol_usuario = $rol_guardado;
                    return $hash_guardado;
                }
            }
        }
    } else {
        die("El archivo $archivo no existe.");
    }

    return null;
}

$nombre_usuario = "";
$rol_usuario = "";
$correo = isset($_POST['correo']) ? $_POST['correo'] : '';
$contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : '';
$rol = isset($_POST['rol']) ? $_POST['rol'] : '';

$hash_guardado = obtenerHash($correo, $nombre_usuario, $rol_usuario);

if ($hash_guardado !== null && password_verify($contrasena, $hash_guardado)) {
    if ($rol_usuario === $rol) {
    // Iniciar sesión y almacenar información del usuario en variables de sesión
    $_SESSION['nombre_usuario'] = $nombre_usuario;
    $_SESSION['rol_usuario'] = $rol_usuario;
    $_SESSION['correo_usuario'] = $correo;
    
        echo "<!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <title>Área de Usuario</title>
            <link rel='stylesheet' href='css/style_verificarLogin.css'>
        </head>
        <body>
            <div class='container'>
                <div class='content'>
                    <h1>Inicio de sesión exitoso como $rol_usuario</h1>
                    <h2>¡Bienvenido a tu Área de Usuario, $nombre_usuario!</h2>
                    <p>¿Qué te gustaría hacer?</p>
                    <ul class='actions'>";
        
        if ($rol === 'cliente') {
            echo "<li><a href='gestionar_cuenta.php'>Gestionar mi cuenta</a></li>";
        }
        if ($rol === 'gestor') {
            echo "<li><a href='registro1.php'>Crear cuenta</a></li>";
            echo "<li><a href='gestionar_productos.php'>Gestionar productos</a></li>";
        }
        if ($rol === 'admin') {
            echo "<li><a href='client_anonim.php'>Creació de clients anònims</a></li>";
            echo "<li><a href='registro2.php'>Crear cuenta</a></li>
                  <li>
                      <form action='eliminar_usuario.php' method='post'>
                          <label for='correoEliminar'>Correo Electrónico:</label>
                          <input type='email' name='correoEliminar' required>
                          <input type='submit' value='Eliminar Usuario'>
                      </form>
                  </li>
                  <li>
                      <form action='visualizar_informacion.php' method='get'>
                          <button type='submit'>Visualizar Información</button>
                      </form>
                  </li>
                  <li><a href='modificar_gestor.php'>Modificar Gestor</a></li>";
        }

        echo "<li><a href='lista_productos.php'>Lista de Productos</a></li>
              </ul>
              <br>
              <a href='logout.php'>Logout</a>
            </div>
        </div>
        </body>
        </html>";
    } else {
        echo "Rol incorrecto para el usuario.<br>";
    }
} else {
    echo "Contraseña incorrecta o usuario no encontrado.<br>";
}
?>
