<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Formulario de Clientes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <h2>Formulario de Clientes</h2>
            <form action="modelo.php" method="post">
                <div class="form-group">
                    <label for="idCedula">Cédula:</label>
                    <input type="text" class="form-control" id="idCedula" name="idCedula" readonly value="<?php echo $_SESSION['cedula'] ?>">
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="comentarios">Comentario:</label>
                    <textarea class="form-control" id="comentarios" name="comentarios" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono:</label>
                    <input type="tel" class="form-control" id="telefono" name="telefono" pattern="[0-9]{4}[0-9]{7}" placeholder="04140000000" oninput="validarTelefono(this)">
                </div>
                <input type="hidden" name='accion_ingreso' value='agregar_Clientes'>
                <button type="button" class="btn btn-danger" onclick="confirmarCancelar()">Cancelar</button>
                <button type="submit" class="btn btn-success" onclick="return confirmarAgregar()">Agregar Cliente</button>
            </form>
        </div>
    </div>
</div>

<script> //Establecer un FOCUS a Nombre
    // Obtener una referencia al elemento de entrada por su id
    var miInput = document.getElementById("nombre");

    // Establecer el foco en el campo
    miInput.focus();
</script>

<script>
    function validarTelefono(input) {
        // Eliminar cualquier carácter que no sea número
        input.value = input.value.replace(/[^0-9]/g, '');

        // Limitar la longitud a 11 caracteres
        if (input.value.length > 11) {
            input.value = input.value.slice(0, 11);
        }
    }
</script>

<script>
    function confirmarAgregar() {
    // Mostrar un cuadro de diálogo de confirmación
    if (confirm("¿Estás seguro de que quieres agregar?")) {
        <?php $_SESSION['cedula']; ?>;
        // Permitir que el formulario se envíe
        return true;
    }
    // Si el usuario hace clic en "Cancelar", impedir que el formulario se envíe
    return false;
}
    function confirmarCancelar() {
        // Mostrar un cuadro de diálogo de confirmación
        if (confirm("¿Estás seguro de que quieres cancelar?")) {
            // Si el usuario hace clic en "Aceptar", redirigir a la página deseada
            <?php $_SESSION['cedula'] = null; ?> ;
            window.location.href = 'ventas.php';
        }
    }
</script>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
