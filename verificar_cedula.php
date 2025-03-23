<?php
// verificar_cedula.php
include 'modelo.php';
session_start();

// Verificar si se proporciona una cédula
if (isset($_GET['cedula'])) {
    $cedula = $_GET['cedula'];
    $_SESSION['cedula'] = $cedula;

    // Obtener la información de todos los clientes
    $clientes = mostrarClientes();

    // Inicializar variables
    $cedulaEncontrada = false;
    $nombre = ''; 

    // Recorrer la lista de clientes y verificar la cédula
    foreach ($clientes as $cliente) {
        if ($cliente['idCedula'] == $cedula) {
            $cedulaEncontrada = true;

            // Almacenar los datos en sesiones
            $_SESSION['cedulaEncontrada'] = true;

            // Redirigir a ventas.php
            header("Location: ventas.php");
            exit();
        }
    }

    // Si la cédula no fue encontrada, establecer la variable de sesión en false
    if (!$cedulaEncontrada) {
        $_SESSION['cedulaEncontrada'] = false;
        // Redirigir a formClientes.php
        header("Location: formClientes.php");
        exit();
    }
} else {
    // Si no se proporciona una cédula, redirigir a pru.php
    header("Location: pru.php");
    exit();
}
?>
