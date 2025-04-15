<?php
require_once '../db/conexion.php';

// Verificar que se han enviado los datos por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger datos del formulario
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $rol = $_POST['rol'] ?? 'cliente'; // por defecto
    $tipo_cliente = $_POST['tipo_cliente'] ?? 'persona_fisica'; // por defecto

    // Validaciones básicas
    if (empty($nombre) || empty($email) || empty($password)) {
        echo "⚠️ Todos los campos son obligatorios.";
        exit;
    }

    // Encriptar contraseña
    $password_encriptada = password_hash($password, PASSWORD_DEFAULT);

    // Preparar la consulta
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password, rol, tipo_cliente) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nombre, $email, $password_encriptada, $rol, $tipo_cliente);

    // Ejecutar e informar
    if ($stmt->execute()) {
        echo "✅ Usuario registrado correctamente.";
    } else {
        echo "❌ Error al registrar: " . $stmt->error;
    }

    // Cerrar conexión
    $stmt->close();
    $conn->close();
} else {
    echo "Este archivo solo acepta peticiones POST.";
}
?>
