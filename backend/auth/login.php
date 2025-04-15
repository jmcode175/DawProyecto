<?php
session_start(); // Iniciar sesión

require_once '../db/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger datos del formulario
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validar que no estén vacíos
    if (empty($email) || empty($password)) {
        echo "⚠️ Todos los campos son obligatorios.";
        exit;
    }

    // Buscar usuario por email
    $stmt = $conn->prepare("SELECT id, nombre, email, password, rol FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        // Verificar contraseña
        if (password_verify($password, $usuario['password'])) {
            // Guardar datos en sesión
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];

            echo "✅ Bienvenido, " . $usuario['nombre'] . ". Rol: " . $usuario['rol'];
        } else {
            echo "❌ Contraseña incorrecta.";
        }
    } else {
        echo "❌ No se encontró ningún usuario con ese email.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Este archivo solo acepta peticiones POST.";
}
?>
