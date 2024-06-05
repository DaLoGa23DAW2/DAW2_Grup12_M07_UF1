<?php
session_start();


$productosPath = 'productos/productos.txt';

function agregarProducto($id, $nombre, $imagen, $formato, $precio, $iva, $disponibilidad) {
    $imagen = 'IMATGES/' . $imagen . '.' . $formato;

    $producto = array(
        'id' => $id,
        'nombre' => $nombre,
        'imagen' => $imagen,
        'precio' => $precio,
        'iva' => $iva,
        'disponibilidad' => $disponibilidad,
    );

    if (!is_dir('productos')) {
        mkdir('productos');
    }

    $productoInfo = json_encode($producto) . PHP_EOL;
    file_put_contents($GLOBALS['productosPath'], $productoInfo, FILE_APPEND);

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = array();
    }
    $_SESSION['carrito'][] = $producto;

    header('Location: gestion_productos.php');
    exit();
}

function eliminarProducto($idEliminar) {
    if (!empty($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $key => $producto) {
            if ($producto['id'] === $idEliminar) {
                unset($_SESSION['carrito'][$key]);
                break;
            }
        }
    }

    $productos = file($GLOBALS['productosPath']);
    foreach ($productos as $key => $linea) {
        $productoGuardado = json_decode($linea, true);
        if ($productoGuardado['id'] === $idEliminar) {
            unset($productos[$key]);
            break;
        }
    }
    file_put_contents($GLOBALS['productosPath'], implode('', $productos));

    header('Location: gestion_productos.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'], $_POST['nombre'], $_POST['imagen'], $_POST['formato'], $_POST['precio'], $_POST['iva'], $_POST['disponibilidad'])) {
        agregarProducto($_POST['id'], $_POST['nombre'], $_POST['imagen'], $_POST['formato'], $_POST['precio'], $_POST['iva'], $_POST['disponibilidad']);
    }

    elseif (isset($_POST['id_eliminar'])) {
        eliminarProducto($_POST['id_eliminar']);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
</head>
<body>
    <h1>Gestión de Productos</h1>
    
    <form action="" method="post">
        <label for="id">ID del Producto:</label>
        <input type="text" name="id" required><br>

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required><br>

        <label for="imagen">Imagen (nombre del archivo sin extensión):</label>
        <input type="text" name="imagen" required><br>

        <label for="formato">Formato de la Imagen:</label>
        <select name="formato">
            <option value="jpg">JPG</option>
            <option value="png">PNG</option>
        </select><br>

        <label for="precio">Precio:</label>
        <input type="number" name="precio" min="0" step="0.01" required><br>

        <label for="iva">IVA:</label>
        <input type="number" name="iva" min="0" step="0.01" required><br>

        <label for="disponibilidad">Disponibilidad:</label>
        <input type="number" name="disponibilidad" required><br>

        <input type="submit" value="Agregar Producto">
    </form>

    <form action="" method="post">
        <label for="id_eliminar">ID del Producto a Eliminar:</label>
        <input type="text" name="id_eliminar" required><br>
        <input type="submit" value="Eliminar Producto">
    </form>

    <a href="carrito.php">Ir al Carrito</a>
    <a href="logout.php">Volver</a>
</body>
</html>
