<?php
session_start();
require_once('../db/conexion.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? ''; //¿Qué hace el ?? ''? --> Garantiza que si no se envía el campo 'email'
    //  o 'password', la variable no generará un error, sino que tendrá un valor por defecto ('' en este caso)


    // Validar que los campos estén completos
    if (empty($email) || empty($password)) {
        echo json_encode(["success" => false, "message" => "Todos los campos son obligatorios"]);
        exit;
    }

    try {
        $conn = getConnection();

        // Consulta segura con PDO
        $stmt = $conn->prepare("SELECT id, nombre, password, rol FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($password, $usuario['password'])) {
            // Guardar datos en sesión
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];

        // Redirigir según el rol
        if ($usuario['rol'] === 'cliente') {
            header("Location: privado_usuario.html");
        } elseif ($usuario['rol'] === 'profesional') {
            header("Location: privado_empresa.html");
        } elseif ($usuario['rol'] === 'admin') {
            header("Location: admin.php");
        } else {
            echo "Rol no reconocido.";
        }
        exit();

        } else {
            echo json_encode(["success" => false, "message" => "Credenciales incorrectas"]);
        }

        closeConnection($conn);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Error en el login"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido"]);
}
?>
