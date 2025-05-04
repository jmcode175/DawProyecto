<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../auth/formulario_login.html");
    exit;
}
?>

<!-- Como no tengo la interfaz de Juanma, preparo un html simple para ver funcionamiento  -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin - ServiciosPro</title>
</head>
<body>
    <h1>Panel de administración</h1>
    <p>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?>. Aquí pronto podrás gestionar usuarios y servicios.</p>
    <a href="../auth/logout.php">Cerrar sesión</a>
</body>
</html>
<!-- Cuando Juanma prepare la interfaz la conecto header("Location: ../../privado_admin.html"); -->