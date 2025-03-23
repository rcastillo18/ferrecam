<?php
//include 'conexion.php'; 
include 'modelo.php'; 

$productos = mostrarProductos();

echo '<title>Catálogo de Productos de Ferretería</title>';
if (!$productos['error']) {
    echo '<div class="catalogo">';
    foreach ($productos as $producto) {
        echo '<div class="producto">';
        echo '<img src="' . $producto['codigo'] . '.jpg" alt="' . $producto['descripcion'] . '">';
        echo '<h2>' . $producto['descripcion'] . '</h2>';
        echo '<p class="precio">$' . $producto['precioGanUSD'] . '</p>';
        echo '<p>Existencia: ' . $producto['existencia'] . '</p>';
        echo '<a href="https://wa.me/+584147411816" class="boton-comprar">Comprar</a>';
        echo '</div>';
    }
    echo '</div>';
} else {
    echo '<p>Error al cargar los productos: ' . $productos['mensaje'] . '</p>';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos de Ferretería</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .catalogo {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }
        .producto {
            background: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin: 10px;
            padding: 15px;
            width: 200px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .producto img {
            max-width: 100%;
            height: auto;
        }
        .precio {
            font-size: 1.2em;
            color: green;
        }
        .boton-comprar {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
            text-align: center;
            display: block;
            margin-top: 10px;
        }
        .cantidad {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }
        .cantidad input {
            width: 50px;
            text-align: center;
            margin: 0 5px;
        }
        .boton-cantidad {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>

