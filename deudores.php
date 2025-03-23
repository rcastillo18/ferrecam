<?php

    session_start();
    include 'templates/header.php';
    //include 'conexion.php';
    include 'modelo.php';
// Llamada a la función para obtener los clientes con deuda
$clientesConDeuda = mostrarClientesConDeuda();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes con Deuda</title>
    <!-- Agregar la referencia a Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Clientes con Deuda</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID Cédula</th>
                    <th>Nombre</th>
                    <th>Saldo en Bs</th>
                    <th>Saldo en Dólares</th>
                    <th>Deuda</th>
                    <th>Pago Deuda en Dólares</th>
                    <th>Comentarios</th>
                    <th>Teléfono</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientesConDeuda as $cliente): ?>
                    <tr>
                        <td><?php echo $cliente['idCedula']; ?></td>
                        <td><?php echo $cliente['nombre']; ?></td>
                        <td><?php echo $cliente['saldoDisBs']; ?></td>
                        <td><?php echo $cliente['saldoDisDol']; ?></td>
                        <td><?php echo $cliente['deuda']; ?></td>
                        <td><?php echo $cliente['pagoDeudaDol']; ?></td>
                        <td><?php echo $cliente['comentarios']; ?></td>
                        <td><?php echo $cliente['telefono']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Agregar la referencia a Bootstrap JS y Popper.js (necesarios para algunos componentes de Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
