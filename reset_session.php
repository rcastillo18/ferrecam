<?php
session_start();

// Restablecer $_SESSION['cedula'] a null
$_SESSION['cedula'] = null;

// Puedes agregar un mensaje de respuesta si lo necesitas
echo "La sesión ha sido restablecida correctamente a null.";
?>
