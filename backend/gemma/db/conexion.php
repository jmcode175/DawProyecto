<?php
function getConnection(){
    try {
        $conn = new PDO("mysql:host=localhost;dbname=servicios_pro;charset=utf8", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die("Error en la conexión: " . $e->getMessage());
    }
}
function closeConnection(&$conn){
    $conn = null;
}
?>
