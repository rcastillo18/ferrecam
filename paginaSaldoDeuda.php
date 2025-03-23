<?php
// verificar_cedula.php
include 'templates/header.php';
include 'modelo.php';
session_start();

// Obtener el valor de $_SESSION['deuda']
$deudaTotal = $_SESSION['deuda'];
$cedula = $_SESSION['cedula'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información de Saldo y Deuda</title>
    <!-- Agregar la referencia a Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="mb-4">Información de Saldo y Deuda</h2>

                <div class="mb-3">
                    <strong>Fondos Disponibles en Bs:</strong>
                    <span class="badge badge-success"><?php echo $_SESSION['saldoDisBs']; ?></span>
                </div>

                <div class="mb-3">
                    <strong>Fondos Disponibles en Dólares:</strong>
                    <span class="badge badge-success"><?php echo $_SESSION['saldoDisDol']; ?></span>
                </div>

                <div>
                    <strong>Deuda:</strong>
                    <span class="badge badge-danger"><?php echo $_SESSION['deuda']; ?></span>

                    <!-- Formulario para pagar deuda total -->
                    <form action="modelo.php" method="post" class="form-inline" onsubmit="return confirm('¿Está seguro de que desea pagar la deuda total?');">
                        <input type="hidden" name='accion_ingreso' value='pagoTotal'>
                        <input type="hidden" name='deudaTotal' value='<?php echo $deudaTotal; ?>'>
                        <input type="hidden" name='cedula' value='<?php echo $cedula; ?>'>
                        <button type="submit" class="btn btn-primary">Pagar Deuda Total</button>
                    </form>

                    <!-- Formulario para abonar -->
                    <form action="modelo.php" method="post" class="form-inline" onsubmit="return confirm('¿Está seguro de que desea abonar a la deuda?');">
                        <br><br><button type="button" class="btn btn-secondary" id="abonarBtn">Abonar</button>
                        <div id="abonarInput" style="display: none;">
                            <input type="number" name="cantidadAbono" step=".01" placeholder="Ingrese cantidad que desea abonar" class="form-control mr-2">
                            <input type="hidden" name='accion_ingreso' value='abono'>
                            <input type="hidden" name='deudaTotal' value='<?php echo $deudaTotal; ?>'>
                            <input type="hidden" name='cedula' value='<?php echo $cedula; ?>'>
                            <button type="submit" class="btn btn-success">Abonar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function(){
      $("#abonarBtn").click(function(){
        $("#abonarInput").show(); // Muestra el input al hacer clic en el botón "Abonar"
      });
    });
    </script>

    <!-- Agregar la referencia a Bootstrap JS y Popper.js (necesarios para algunos componentes de Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
