<?php
    session_start();
    include 'templates/header.php';
	//include 'conexion.php';
	include 'modelo.php';

    //	$id = $_GET['id'];

    $inventario = mostrarProductos();
    $config= mostrarConfigu();
    $consultarI = consultarInventario($id);
    while ($fila = $consultarI) {
        $fila['idProducto'];
        $fila['codigo'];
        $fila['descripcion'];
        $fila['precioGanUSD'];
        break;
    }
  foreach ($config as $filas) {
    $tasaDCosto = $filas['tasaDolarCosto'];
    $tasaDVenta = $filas['tasaDolarVenta'];
  }
   // include 'modelo.php';
// Verificar si la variable de sesión está definida
$cedulaEncontrada = isset($_SESSION['cedulaEncontrada']) ? $_SESSION['cedulaEncontrada'] : false;
//echo $_SESSION['cedulaEncontrada'];

// Restablecer la variable de sesión
unset($_SESSION['cedulaEncontrada']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Ventas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <style>
        /* Estilos para la ventana emergente */
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 40px;
            width: 60%;
            max-width: 800px;
            max-height: 80%; /* Establece una altura máxima */
            background-color: #fff;
            border: 2px solid #ccc;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            z-index: 9999;
            overflow: auto; /* Agrega barras de desplazamiento cuando sea necesario */
        }

        /* Estilos para el botón de cerrar */
        .close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <!-- División de la página en 3 partes -->
    <div class="row">
        <!-- Primera sección (1ra columna) -->
        <div class="col-md-6 mb-4">
            <!-- Columna 1 -->
            <div class="row">
                <div class="col-md-12">
                    <!-- Contenido del cliente -->
                    <?php 
                    echo "Valor actual de cédula en sesión: " . $_SESSION['cedula'] . "<br>";
                    if (isset($_SESSION['cedula']) && !empty($_SESSION['cedula'])){ ?> 
                        <label for="cliente">CLIENTE (ingrese número de cédula):</label>
                        <input type="text" class="form-control" id="cliente" value="<?php echo $_SESSION['cedula']; ?>">
                    <?php } else { 
                        if($cedulaEncontrada == true){ ?> 
                            <label for="cliente">CLIENTE (ingrese número de cédula):</label>
                            <input type="text" class="form-control" id="cliente" value="<?php echo $_SESSION['cedula']; ?>" onkeydown="verificarCedula(event)">
                    <?php } else { ?> 
                            <label for="cliente">CLIENTE (ingrese número de cédula):</label>
                            <input type="text" class="form-control" id="cliente" placeholder="Ingrese número de cédula" onkeydown="verificarCedula(event)">
                        <?php } 
                        } 
                        ?>           
                </div>
                <div class="col-md-12">
                        <br> <!-- espacio entre cliente y productos -->
                </div>
            </div>
        </div>
        <!-- Segunda sección (2da columna) eliminada -->
        <!-- Tercera sección (fila restante) -->
        <div class="col-md-12 mb-4">
            <!-- Contenido de la tercera sección -->
            <!-- Tabla de Ventas -->
            <div class="row mt-12">
                <div class="col-md-12">
                    <div id="productos-agregados">
                        <table id="tabla-productos" class="table">
                            <thead>
                                <tr>
                                    <th>CÓDIGO</th>
                                    <th>DESCRIPCIÓN</th>
                                    <th>CANTIDAD</th>
                                    <th>PRECIO Bs</th>
                                    <th>TOTAL</th>
                                    <th><button type="button" class="btn btn-primary" onclick="mostrarPopup()">Agregar Productos</button></th> <!-- Botón Agregar Productos -->
                                </tr>
                            </thead>
                            <tbody id="tbody-productos">
                                <!-- Aquí se mostrarán los productos -->
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-12">
                        <label for="comentario">COMENTARIOS:</label>
                        <textarea class="form-control" id="comentario" name="comentario" rows="2" placeholder="Escriba un comentario"></textarea>
                    </div><br>

                </div>
            </div>

            <!-- Tabla Total Bs y Total $ -->
            <div class="row mt-12">
                <div class="col-md-12">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td><strong>TOTAL $.:</strong></td>
                                <td><input type="text" class="form-control" readonly id="totalDolaresInput"></td>
                                <td><strong>TOTAL BS:</strong></td>
                                <td><input type="text" class="form-control" readonly id="totalPagarInput"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>  
            <!-- Botones Guardar Venta, Cancelar Venta, Guardar Crédito -->
            <div class="float-right">
                <button type="button" class="btn btn-success" onclick="mostrarProductosEnBoton()">Guardar Venta (F1)</button>
                <button type="button" class="btn btn-danger" onclick="cancelarVenta()">Cancelar Venta (F5)</button>
            </div>          
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<div class="popup" id="popup" scrolling = "auto" >
    <div class="container mt-4 custom-table">
    <!-- Sección de Inventario -->
    <div class="row">
        <!-- Tabla de Productos Existentes -->
        <div class="col-md">
            <table id="tables" class="table table-striped table-bordered custom-table dataTable" style="width:100%">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Precio (USD)</th>
                        <th>Precio Bs</th>
                        <th>Existencia</th>
                        <th>Opcion</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($inventario as $fila) { ?>
                <tr>
                    <td><?= $fila['codigo']?></td>
                    <td style='text-align:center;'><?= $fila['descripcion']?></td>
                    <td><?= $fila['precioGanUSD']?></td>
                    <td><?= $precioBs= round($tasaDCosto * $fila['precioGanUSD'],2)?></td>
                    <td><?= $fila['existencia']?></td>
    <!-- Otros campos -->
    		<td><a href="javascript:void(0);" onclick="agregarProductoSeleccionado('<?= $fila['codigo']?>', '<?= $fila['descripcion']?>', '<?= $fila['precioGanUSD']?>', '<?= $precioBs ?>', '<?= $fila['existencia']?>')">Seleccionar</a></td>
                </tr>
                
                <?php } ?>
                </tbody>
            </table>

        </div>

    </div>
    <button class="close-button" onclick="closePopup()">X</button>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>



<script>
// Array para almacenar los productos seleccionados
var productosSeleccionados = [];
var totalPagar = 0;
var totalPagarInput = document.getElementById("totalPagarInput");
var totalDolares = 0;
var totalDolaresInput = document.getElementById("totalDolaresInput");
var comentario = "-";

// Función para mostrar la ventana emergente al presionar F8
document.addEventListener('keydown', function(event) {
    if (event.key === 'F8') {
        document.getElementById('popup').style.display = 'block';
    }
});

// Función para mostrar la ventana emergente
function mostrarPopup() {
    document.getElementById('popup').style.display = 'block';
}

// Función para cerrar la ventana emergente
function closePopup() {
    document.getElementById('popup').style.display = 'none';
    //mostrarProductosAgregados(); // Mostrar productos agregados en la ventana emergente

}
    // Función para agregar el producto seleccionado al array
function agregarProductoSeleccionado(codigo, descripcion, precioUSD, precioBs, existencia) {
    var productoExistente = productosSeleccionados.find(producto => producto.codigo === codigo);

    if (productoExistente) {
        // El producto ya existe en el array, actualizar la cantidad
        //productoExistente.cantidadPedido += 1; // Incrementar la cantidad, puedes establecer la cantidad como desees
        alert('Producto ya agregado');
        closePopup();
    } else {
        // El producto no existe en el array, agregarlo
        var producto = {
            codigo: codigo,
            descripcion: descripcion,
            cantidadPedido: "", // Inicializa la cantidad en 1
            precioUSD: precioUSD,
            precioBs: precioBs,
            existencia: existencia,
            costoTotal: "",
            totalVenta: "",
            comentario:"-"
        };
        productosSeleccionados.push(producto);
    }

    closePopup();
    mostrarProductosAgregados();
}

function mostrarProductosAgregados() {
    var tbodyProductos = document.getElementById('tbody-productos');
    tbodyProductos.innerHTML = ''; // Limpiar contenido anterior

    for (var i = 0; i < productosSeleccionados.length; i++) {
        var producto = productosSeleccionados[i];
        var fila = document.createElement('tr');
        //(producto.cantidadPedido * producto.precioBs); 


        fila.innerHTML = `
            <td><input type="text" class="form-control codigo" name="codigo" value="${producto.codigo}" readonly></td>
            <td><input type="text" class="form-control descripcion" name="descripcion" value="${producto.descripcion}" readonly></td>
            <td><input type="text" class="form-control cantidad" name="cantidad" placeholder="Ingrese Cantidad" value="${producto.cantidadPedido}" oninput="actualizarCantidad(${i}, this), calcularCostoTotal(${i}, this), actualizarTotal(${i}, this)"></td>
            <td><input type="text" class="form-control precioBs" name="precioBs" value="${producto.precioBs}" readonly></td>
            <td><input type="text" class="form-control costoTotal" name="costoTotal" id="costoTotal_${i}" placeholder="Ingrese" value="${producto.costoTotal}"readonly></td>
            <td><button type="button" class="btn btn-danger" onclick="eliminarFila(${i})">Eliminar</button></td>

        `;

        tbodyProductos.appendChild(fila);

        actualizarCantidad(i, fila.querySelector('.cantidad'));
        calcularCostoTotal(i, fila.querySelector('.cantidad'));
        asignarEventoInputCostoTotal(i);

    }
}

// Función para eliminar una fila por índice
function eliminarFila(index) {
    productosSeleccionados.splice(index, 1); // Elimina el elemento del array
    mostrarProductosAgregados(); // Vuelve a mostrar la tabla actualizada
    totalPagar = productosSeleccionados.reduce((total, producto) => total + parseFloat(producto.costoTotal || 0), 0);
    
    totalPagarInput.value = totalPagar.toFixed(2) + ' Bs';

    totalDolares = totalPagar / <?php echo json_encode($tasaDCosto)?>;
    totalDolaresInput.value = totalDolares.toFixed(2) + ' $';
}


function calcularCostoTotal(index, input) {
    var cantidad = parseInt(input.value); // Obtener la cantidad ingresada como número entero
    var row = input.parentNode.parentNode; // Obtener la fila actual
    var precioBs = parseFloat(row.querySelector('.precioBs').value); // Obtener el precio en Bs como número flotante

    // Calcular el costo total multiplicando la cantidad por el precio en Bs
    var costo = cantidad * precioBs;

    // Actualizar el valor del campo costoTotal en la fila actual con el nuevo cálculo
    row.querySelector('.costoTotal').value = isNaN(costo) ? '' : costo.toFixed(2);

    // Actualizar el valor en el array productosSeleccionados si es necesario
    productosSeleccionados[index].costoTotal = isNaN(costo) ? 0 : costo;
}

function actualizarTotal(index, input) {
    //alert(input);
    // Actualizar la variable totalPagar con el valor actualizado de productosSeleccionados[index].costoTotal
    totalPagar = productosSeleccionados.reduce((total, producto) => total + parseFloat(producto.costoTotal || 0), 0);
    
    // Actualizar el valor del campo totalPagarInput
    totalPagarInput.value = totalPagar.toFixed(2) + ' Bs';;

    //alert(<?php echo json_encode($tasaDCosto) ?>);
    totalDolares = totalPagar / <?php echo json_encode($tasaDCosto)?>;
    totalDolaresInput.value = totalDolares.toFixed(2) + ' $';;

    productosSeleccionados[index].totalVenta = totalPagar.toFixed(2);
}
// Función para asignar el evento input al campo costoTotal
function asignarEventoInputCostoTotal(index) {
    var campoCostoTotal = document.getElementById(`costoTotal_${index}`);
    campoCostoTotal.addEventListener('input', function() {
        actualizarTotal(index, this);
    });
}

function actualizarCantidad(index, input) {
    var cantidad = parseInt(input.value);
    productosSeleccionados[index].cantidadPedido = cantidad;
    //alert(productosSeleccionados[index].cantidadPedido);
    //alert(index);
}

function guardarComentario() {
    // Obtener el valor del comentario ingresado por el usuario
    var comentarioUsuario = document.getElementById('comentario').value;

    // Asignar el comentario al campo producto.comentario para cada producto en productosSeleccionados
    productosSeleccionados.forEach(function(producto) {
        producto.comentario = comentarioUsuario;
    });
}

function mostrarProductosEnBoton() {
    var botonGuardarVenta = document.querySelector('.btn-success');
    var textoBoton = 'Guardar Venta (F1): ';

    for (var i = 0; i < productosSeleccionados.length; i++) {
        var producto = productosSeleccionados[i];
      //  producto.numeroVenta += 1;

		if (typeof producto.cantidadPedido === 'number' && producto.cantidadPedido > 0) {
            // Si la cantidad es un número y mayor que cero
            //var c = parseFloat(producto.costoTotal.value);
            //var ce = c.toFixed(2);// Redondear a dos decimales  
            //producto.numeroVenta = numeroVenta; // Asignar el mismo número de venta a todos los productos
            producto.totalVenta = totalPagar.toFixed(2);
            // Llamar a la función para guardar el comentario antes de enviar los productos
                guardarComentario();

            
            textoBoton += `Código: ${producto.codigo}, Cantidad: ${producto.cantidadPedido}, Costo: ${producto.costoTotal}, totalVenta: ${producto.totalVenta} - `; // Asignar el texto con la información de los productos al botón
    		
        } else {
            // Si la cantidad no es un número válido o es menor o igual a cero
            // Manejo del error o mensaje de advertencia
            alert('La cantidad ingresada no es válida para el producto con código: ' + producto.codigo);
        }
    }

        botonGuardarVenta.textContent = textoBoton;
    // Suponiendo que tienes la variable productosSeleccionados con datos en JavaScript

    // Convertir productosSeleccionados a formato JSON
    var datosAEnviar = JSON.stringify(productosSeleccionados);

    // Realizar una solicitud AJAX para enviar los datos a un archivo PHP en el servidor
    $.ajax({
        type: "POST", // Método de envío
        url: "guardarProductos.php", // Ruta al archivo PHP que procesará los datos
        data: {productos: datosAEnviar}, // Datos a enviar (en este caso, la variable productosSeleccionados)
        success: function(response) {
            // Manejar la respuesta del servidor si es necesario
           // alert(response);
        },
        error: function(xhr, status, error) {
            // Manejar errores si ocurre alguno durante la solicitud AJAX
            console.error(xhr.responseText);
        }
    });

    if (confirm("¿Estás seguro de que quieres agregar?")) {
        window.location.href = 'ventas.php';
        // Permitir que el formulario se envíe
        return true;
    }
    // Si el usuario hace clic en "Cancelar", impedir que el formulario se envíe
    return false;
}

</script>

<script>
    function verificarCedula(event) {
        // Verificar si la tecla presionada es "INTRO" (código 13)
        if (event.keyCode === 13) {
            // Obtener el valor de la cédula
            var cedula = document.getElementById('cliente').value;

            // Realizar la verificación en PHP (puedes usar AJAX o redirigir a un script PHP)
            // En este ejemplo, se redirige a un script PHP llamado verificar_cedula.php
            window.location.href = 'verificar_cedula.php?cedula=' + cedula;

           //console.log( window.location.href);
        }
    }

    function redirectToFormCliente() {
        // Redirige a formCliente.php
        window.location.href = 'formClientes.php';
    }
</script>

<script>
// Agregar un event listener para el evento 'keydown' en el documento
document.addEventListener('keydown', function(event) {
    // Verificar si la tecla presionada es F5 (código 116)
    if (event.keyCode === 116) {
        // Llamar a la función cancelarVenta
        cancelarVenta();

    }
});

function cancelarVenta() {
    // Verificar si hay productos seleccionados para guardar
    if (productosSeleccionados.length === 0 || productosSeleccionados.length > 0)  {
        // Realizar una solicitud AJAX a reset_session.php para restablecer $_SESSION['cedula'] a null
        $.ajax({
            type: 'POST',
            url: 'reset_session.php',
            success: function(response) {
                console.log(response); // Imprimir la respuesta del servidor en la consola
                window.location.href = 'ventas.php'; // Recargar la página después de restablecer la sesión
            },
            error: function(xhr, status, error) {
                console.error(error); // Manejar errores si ocurre alguno durante la solicitud AJAX
            }
        });
    } else {
        window.location.href = 'ventas.php'; // Si hay productos seleccionados, simplemente recargar la página
    }
}

function cerrarVenta() {   
        // Realizar una solicitud AJAX a reset_session.php para restablecer $_SESSION['cedula'] a null
        $.ajax({
            type: 'POST',
            url: 'reset_session.php',
            success: function(response) {
                console.log(response); // Imprimir la respuesta del servidor en la consola
                window.location.href = 'ventas.php'; // Recargar la página después de restablecer la sesión
            },
            error: function(xhr, status, error) {
                console.error(error); // Manejar errores si ocurre alguno durante la solicitud AJAX
            }
        });
}
</script>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
    $('#tables').DataTable();
});
</script>






