
<?php
$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];

$hash_guardado = obtenerHash($correo, $nombre_usuario);

if ($hash_guardado !== null && password_verify($contrasena, $hash_guardado)) {
    echo "<h1>¡Bienvenido a tu Área de Usuario, $nombre_usuario!</h1>";
    echo "<p>¿Qué te gustaría hacer?</p>";
    echo "<ul>";
    echo "<li><a href='gestionar_cuenta.php'>Gestionar mi cuenta</a></li>";
    echo "<li><a href='comprar.php'>Comprar</a></li>";
    echo "</ul>";
} else {
    echo "Contraseña incorrecta o usuario no encontrado.";
}
?>
