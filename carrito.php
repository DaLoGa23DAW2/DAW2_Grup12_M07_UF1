<?php
session_start();

$productos = file('productos/productos.txt');
if (empty($productos)) {
    unset($_SESSION['carrito']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['comprar']) && isset($_SESSION['carrito'])) {
        if (!isset($_SESSION['cesta'])) {
            $_SESSION['cesta'] = array();
        }

        foreach ($_SESSION['carrito'] as $producto) {
            $cantidad = isset($_POST['cantidad'][$producto['id']]) ? intval($_POST['cantidad'][$producto['id']]) : 0;

            if ($cantidad > 0) {
                $producto['cantidad'] = $cantidad;
                $_SESSION['cesta'][] = $producto;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        #contenido {
            text-align: center;
        }

        .producto {
            border: 1px solid #ddd; 
            border-radius: 8px; 
            padding: 16px; 
            width: 60%;
            margin: 20px auto; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
        }

        .producto img {
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }

        .cantidad {
            margin-top: 5px;
        }

        #botonComprar {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div id="contenido">
        <h1>Carrito de Compras</h1>
        <?php
        if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
            echo '<form action="" method="post">';
            foreach ($_SESSION['carrito'] as $producto) {
                echo '<div class="producto">';
                echo '<img src="' . $producto['imagen'] . '" alt="' . $producto['nombre'] . '">';
                echo '<p>Nombre: ' . $producto['nombre'] . '</p>';
                echo '<p>Precio: $' . $producto['precio'] . '</p>';
                echo '<p>IVA: ' . $producto['iva'] . '</p>';
                echo '<p>Disponibilidad: ' . $producto['disponibilidad'] . '</p>';
                echo '<label for="cantidad[' . $producto['id'] . ']">Cantidad:</label>';
                echo '<input type="number" name="cantidad[' . $producto['id'] . ']" value="0" min="0" max="' . $producto['disponibilidad'] . '" class="cantidad">';
                echo '</div>';
            }
            echo '<input id="botonComprar" type="submit" name="comprar" value="Comprar">';
            echo '</form>';
        } else {
            echo '<p>El carrito está vacío.</p>';
        }
        ?>
        <a href="cesta.php">Ir a la Cesta</a>
        <a href="logout.php">cerrar sesion</a>
    </div>
</body>
</html>
