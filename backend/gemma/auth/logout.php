<?php
    session_start();
    session_unset();// Elimina todas las variables de la sesión
    session_destroy(); // elimina completamente la sesión del servidor
    header("Location: ../auth/login.php");//redirige al formulario del login para que el usuario pueda volver a iniciar sesión
    exit;
?>