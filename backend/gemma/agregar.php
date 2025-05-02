<?php
header("Content-Type: application/json");
require_once '../db/conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombreServicio'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $precio = $_POST['precio'] ?? '';

    // Validar sesión de empresa
    if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'empresa') {
        echo json_encode(["success" => false, "message" => "Acceso denegado"]);
        exit;
    }

    $profesional_id = $_SESSION['usuario_id']; // ID de la empresa

    if (empty($nombre) || empty($descripcion) || empty($precio)) {
        echo json_encode(["success" => false, "message" => "Todos los campos son obligatorios"]);
        exit;
    }

    try {
        $stmt = $conn->prepare("INSERT INTO servicios (nombre, descripcion, precio, profesional_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombre, $descripcion, $precio, $profesional_id]);

        echo json_encode(["success" => true, "message" => "Servicio agregado correctamente"]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Error al agregar servicio"]);
    }
}
?>
