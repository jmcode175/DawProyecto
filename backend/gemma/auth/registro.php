<?php
header("Content-Type: application/json");
require_once '../db/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $rol = $_POST['rol'] ?? 'cliente';
    

    // Validar que los campos no estén vacíos
    if (empty($nombre) || empty($email) || empty($password)) {
        echo json_encode(["success" => false, "message" => "Todos los campos son obligatorios"]);
        exit;
    }

    // Verificar si el email ya está registrado
    

    try {
        $conn = getConnection();

        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            echo json_encode(["success" => false, "message" => "El email ya está registrado"]);
            closeConnection($conn);
            exit;
        }

        // Encriptar contraseña
        $password_encriptada = password_hash($password, PASSWORD_DEFAULT);

        // Insertar usuario en la base de datos
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombre, $email, $password_encriptada, $rol]);

        echo json_encode(["success" => true, "message" => "Usuario registrado correctamente"]);
        closeConnection($conn);

    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Error en el registro"]);
    }
    
    closeConnection($conn);

}
?>

