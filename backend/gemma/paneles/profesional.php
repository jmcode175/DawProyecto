<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'profesional') {
    header("Location: ../auth/formulario_login.html");
    exit;
}

header("Location: ../../privado_empresa.html");
exit;
?>
