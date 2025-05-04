<?php
    session_start();//necesario para acceder a la sesion actual y poder destruirla
    session_unset();// Elimina todas las variables (id del usuario, rol...) de la sesión
    session_destroy(); // elimina completamente la sesión del servidor
    header("Location: ../auth/login.php");//redirige al formulario del login para que el usuario pueda volver a iniciar sesión
    exit; //asegurar que no se ejecuta más codigo después de la redirección
?>