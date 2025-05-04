<?php
session_start(); //iniciamos sesión

// Verificación de acceso (se verifica si usuario logueado y que tiene el rol correcto)
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'cliente') {
    header("Location: ../auth/formulario_login.html");
    exit;
}


//Redirige al fronted de cliente diseñado por Juanma
header("Location: ../../privado_usuario.html");
exit;

?>