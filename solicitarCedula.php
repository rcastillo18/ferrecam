<?php
    session_start();
    include 'templates/header.php';
    //include 'conexion.php';
    include 'modelo.php';
    $_SESSION['cedula'] = null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Cédula</title>
    <!-- Agregar la referencia a Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="mb-4">Ingrese su número de cédula</h2>
                    <div class="form-group">
                        <div class="col-md-12">
                    <!-- Contenido del cliente -->
                    <?php 
                    echo "Valor actual de cédula en sesión: " . $_SESSION['cedula'] . "<br>";
                 //   if (isset($_SESSION['cedula']) && !empty($_SESSION['cedula'])){ ?> 
                        <label for="cliente">CLIENTE (ingrese número de cédula):</label>
                        <input type="text" class="form-control" id="cliente" onkeydown="verificarCedula(event)" value="<?php echo $_SESSION['cedula']; ?>">
                    <?php // }
                        ?>           
                </div>
                    </div>
                    <button type="submit" class="btn btn-primary" onclick="verificarCedula(event)">Enviar</button>
            </div>
        </div>
    </div>

    <!-- Agregar la referencia a Bootstrap JS y Popper.js (necesarios para algunos componentes de Bootstrap) -->
    <script>
function verificarCedula(event) {
    // Verificar si se presionó la tecla INTRO
    if (event && event.type === 'keydown' && event.keyCode === 13) {
        // Obtener el valor de la cédula
        var cedula = document.getElementById('cliente').value;

        // Realizar la verificación en PHP (puedes usar AJAX o redirigir a un script PHP)
        // En este ejemplo, se redirige a un script PHP llamado verificar_cedula.php
        window.location.href = 'verificarCedulaSaldo.php?cedula=' + cedula;
    } else if (event && event.type === 'click') {
        // Si se hizo clic en el botón
        // Obtener el valor de la cédula
        var cedula = document.getElementById('cliente').value;

        // Realizar la verificación en PHP (puedes usar AJAX o redirigir a un script PHP)
        // En este ejemplo, se redirige a un script PHP llamado verificar_cedula.php
        window.location.href = 'verificarCedulaSaldo.php?cedula=' + cedula;
    }
}

    function redirectToFormCliente() {
        // Redirige a formCliente.php
        alert("Cliente no existe");
        //window.location.href = 'formClientes.php';
    }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
