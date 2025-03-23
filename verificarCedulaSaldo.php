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
    $saldoDisBs = 0; // Inicializar saldo disponible en bolívares
    $saldoDisDol = 0;
    $deuda = 0; // Inicializar deuda

    // Recorrer la lista de clientes y verificar la cédula
    foreach ($clientes as $cliente) {
        if ($cliente['idCedula'] == $cedula) {
            $cedulaEncontrada = true;

            // Obtener saldo disponible y deuda del cliente
            $saldoDisBs = $cliente['saldoDisBs'];
            $saldoDisDol = $cliente['saldoDisDol'];
            $deuda = $cliente['deuda'];

            // Almacenar los datos en sesiones
            $_SESSION['cedulaEncontrada'] = true;
            $_SESSION['saldoDisBs'] = $saldoDisBs;
            $_SESSION['saldoDisDol'] = $saldoDisDol;
            $_SESSION['deuda'] = $deuda;

            // Redirigir a ventas.php
            header("Location: paginaSaldoDeuda.php");
            exit();
        }
    }

    // Si la cédula no fue encontrada, establecer la variable de sesión en false
    if (!$cedulaEncontrada) {
        $_SESSION['cedulaEncontrada'] = false;
        // Redirigir a formClientes.php
    echo '<script>alert("Cliente no existe");</script>';
    echo '<script>window.location.href = "solicitarCedula.php";</script>';
    $_SESSION['cedula'] = null;
        exit();
    }
} else {
    // Si no se proporciona una cédula, redirigir a pru.php
    header("Location: pru.php");
    exit();
}
?>
