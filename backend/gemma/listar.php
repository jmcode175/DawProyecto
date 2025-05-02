<?php
header("Content-Type: application/json");
require_once '../db/conexion.php';
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'empresa') {
    echo json_encode(["success" => false, "message" => "Acceso denegado"]);
    exit;
}

$profesional_id = $_SESSION['usuario_id'];

try {
    $stmt = $conn->prepare("SELECT id, nombre, descripcion, precio FROM servicios WHERE profesional_id = ?");
    $stmt->execute([$profesional_id]);
    $servicios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($servicios);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Error al obtener servicios"]);
}
?>
<?php
header("Content-Type: application/json");
require_once '../db/conexion.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(["success" => false, "message" => "Acceso denegado"]);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$rol = $_SESSION['rol'];

try {
    if ($rol === "cliente") {
        // Obtener contrataciones donde el usuario es el cliente
        $stmt = $conn->prepare("SELECT c.id, s.nombre AS nombre_servicio, c.estado, c.precio_total FROM contrataciones c
                                JOIN servicios s ON c.servicio_id = s.id
                                WHERE c.cliente_id = ?");
    } else {
        // Obtener contrataciones donde el usuario es la empresa (profesional)
        $stmt = $conn->prepare("SELECT c.id, s.nombre AS nombre_servicio, c.estado, c.precio_total FROM contrataciones c
                                JOIN servicios s ON c.servicio_id = s.id
                                WHERE s.profesional_id = ?");
    }

    $stmt->execute([$usuario_id]);
    $contrataciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($contrataciones);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Error al obtener contrataciones"]);
}
?>
