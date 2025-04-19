<?php
header("Content-Type: application/json");
require_once '../db/conexion.php';

$consulta = $_GET['consulta'] ?? '';

if (empty($consulta)) {
    echo json_encode([]);
    exit;
}

try {
    $stmt = $conn->prepare("SELECT nombre, descripcion, precio FROM servicios WHERE nombre LIKE ? OR descripcion LIKE ?");
    $stmt->execute(["%$consulta%", "%$consulta%"]);
    $servicios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($servicios);
} catch (PDOException $e) {
    echo json_encode([]);
}
?>
