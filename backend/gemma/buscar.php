<?php
// Aqui debe conectarse con db
include 'conexion.php';

// nos deberia confirmar formulario
if (isset($_POST['profession']) && isset($_POST['zone'])) {
    $profession = $_POST['profession'];
    $zone = $_POST['zone'];

    // Consulta SQL para buscar profesionales según la profesión y la zona
    $query = "SELECT * FROM profesionales WHERE profesion LIKE ? AND zona = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $profession, $zone);
    $stmt->execute();

    // resultados
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        echo "<p>" . $row['nombre'] . " - " . $row['zona'] . "</p>";
    }
}
?>
