<?php
$archivo_cesta = "cesta/cesta.txt";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['eliminar'])) {
        $id_eliminar = $_POST['eliminar'];

        $cesta_contenido = file($archivo_cesta, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        $nueva_cesta_contenido = "";

        foreach ($cesta_contenido as $producto_en_cesta) {
            list($id, $nombre, $imagen, $precio, $cantidad) = explode(":", $producto_en_cesta);

            if ($id != $id_eliminar) {
                $nueva_cesta_contenido .= "$id:$nombre:$imagen:$precio:$cantidad\n";
            }
        }
        file_put_contents($archivo_cesta, $nueva_cesta_contenido);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['tramitar'])) {
    $correo = $_GET['correo'];
    $carpeta_cesta = "cesta/$correo";
    if (!file_exists($carpeta_cesta)) {
        mkdir($carpeta_cesta);
    }
    copy($archivo_cesta, "$carpeta_cesta/cesta_usuario.txt");
    file_put_contents($archivo_cesta, "");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cesta de Compra</title>
    <style>
        .producto {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            width: 200px;
            display: inline-block;
        }

        .producto img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <h2>Cesta de Compra</h2>
    <?php
    $cesta_contenido = file($archivo_cesta, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    $total = 0; // Variable para almacenar el total de la compra

    foreach ($cesta_contenido as $producto_en_cesta) {
        list($id, $nombre, $imagen, $precio, $cantidad) = explode(":", $producto_en_cesta);
        $subtotal = $precio * $cantidad; // Calcular el subtotal del producto
        $total += $subtotal; // Sumar el subtotal al total de la compra
        ?>
        <div class="producto">
            <img src="<?php echo $imagen; ?>" alt="<?php echo $nombre; ?>">
            <p><strong><?php echo $nombre; ?></strong></p>
            <p>Precio: <?php echo $precio; ?></p>
            <p>Cantidad: <?php echo $cantidad; ?></p>
            <p>Subtotal: <?php echo $subtotal; ?></p> <!-- Mostrar el subtotal del producto -->
            <form method="post" action="">
                <input type="hidden" name="eliminar" value="<?php echo $id; ?>">
                <input type="submit" value="Eliminar">
            </form>
        </div>
        <?php
    }
    ?>
    <p>Total: <?php echo $total; ?></p> <!-- Mostrar el total de la compra -->
    <form method="get" action="">
        <label for="correo">Correo:</label>
        <input type="text" id="correo" name="correo" required>
        <input type="submit" name="tramitar" value="Tramitar mis productos">
    </form>
    <a href='lista_productos.php'>Productos</a>
    <a href='login.php'>Iniciar Sesión</a>
</body>
</html>
