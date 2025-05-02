<?php
header("Content-Type: application/json");
require_once '../db/conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contratacion_id = $_POST['contratacion_id'] ?? '';
    $nuevo_estado = $_POST['estado'] ?? '';

    if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'empresa') {
        echo json_encode(["success" => false, "message" => "Acceso denegado"]);
        exit;
    }

    if (empty($contratacion_id) || empty($nuevo_estado)) {
        echo json_encode(["success" => false, "message" => "Todos los campos son obligatorios"]);
        exit;
    }

    try {
        $stmt = $conn->prepare("UPDATE contrataciones SET estado = ? WHERE id = ?");
        $stmt->execute([$nuevo_estado, $contratacion_id]);
        echo json_encode(["success" => true, "message" => "Estado actualizado correctamente"]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Error al actualizar estado"]);
    }
}
?>
