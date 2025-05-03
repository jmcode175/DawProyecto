<?php
header("Content-Type: application/json");
require_once '../db/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmar_password = $_POST['confirmar_password'] ?? ''; // Nuevo campo
    $rol = $_POST['rol'] ?? 'cliente';
    $tipo_cliente = $_POST['tipo_cliente'] ?? 'persona_fisica';

    // Validar que los campos no estén vacíos
    if (empty($nombre) || empty($email) || empty($password) || empty($confirmar_password)) {
        echo json_encode(["success" => false, "message" => "Todos los campos son obligatorios"]);
        exit;
    }

    // Validar que las contraseñas coincidan
    if ($password !== $confirmar_password) {
        echo json_encode(["success" => false, "message" => "Las contraseñas no coinciden"]);
        exit;
    }

    // Verificar si el email ya está registrado
    try {
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            echo json_encode(["success" => false, "message" => "El email ya está registrado"]);
            exit;
        }

        // Encriptar contraseña
        $password_encriptada = password_hash($password, PASSWORD_DEFAULT);

        // Insertar usuario en la base de datos
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password, rol, tipo_cliente) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nombre, $email, $password_encriptada, $rol, $tipo_cliente]);

        echo json_encode(["success" => true, "message" => "Usuario registrado correctamente"]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Error en el registro"]);
    }
}
?>
