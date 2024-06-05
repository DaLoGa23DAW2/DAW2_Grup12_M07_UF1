<?php
$archivo_productos = "productos/productos.txt";
$productos = file($archivo_productos, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cantidades = $_POST['cantidades'];

    $cesta_contenido = "";

    foreach ($productos as $producto) {
        list($id, $nombre, $imagen, $precio, $disponibilidad) = explode(":", $producto);

        $cantidad = isset($cantidades[$id]) ? intval($cantidades[$id]) : 0;

        if ($cantidad > 0) {
            $cesta_contenido .= "$id:$nombre:$imagen:$precio:$cantidad\n";
        }
    }

    if (!empty($cesta_contenido)) {
        file_put_contents("cesta/cesta.txt", $cesta_contenido);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Productos</title>
    <link rel="stylesheet" href="css/style_product.css">
</head>
<body>
    <div class="container">
        <h2>Lista de Productos</h2>
        <form method="post" action="">
            <div class="product-grid">
                <?php
                foreach ($productos as $producto) {
                    list($id, $nombre, $imagen, $precio, $disponibilidad) = explode(":", $producto);
                    ?>
                    <div class="producto">
                        <img src="<?php echo $imagen; ?>" alt="<?php echo $nombre; ?>">
                        <div class="product-details">
                            <p class="product-name"><strong><?php echo $nombre; ?></strong></p>
                            <p class="product-price">Precio: <?php echo $precio; ?></p>
                            <p class="product-availability">Disponibilidad: <?php echo $disponibilidad; ?></p>
                            <label for="cantidad_<?php echo $id; ?>">Cantidad:</label>
                            <input type="number" id="cantidad_<?php echo $id; ?>" name="cantidades[<?php echo $id; ?>]" min="0" max="<?php echo $disponibilidad; ?>" value="0">
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="form-actions">
                <input type="submit" value="Agregar a la Cesta" class="btn">
                <a href='cesta.php' class="btn">Ver Cesta</a>
                <a href='login.php' class="btn">Login</a>
            </div>
        </form>
    </div>
</body>
</html>
