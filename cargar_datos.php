<?php
include 'conexion.php';

header('Content-Type: application/json');

try {
    // Cargar bodegas
    if (isset($_GET['tipo']) && $_GET['tipo'] === 'bodegas') {
        $stmt = $conn->query("SELECT id, nombre FROM bodegas");
        $bodegas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($bodegas);
        exit;
    }
    
    // Cargar sucursales por bodega
    elseif (isset($_GET['bodega_id'])) {
        $stmt = $conn->prepare("SELECT id, nombre FROM sucursales WHERE bodega_id = ?");
        $stmt->execute([$_GET['bodega_id']]);
        $sucursales = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($sucursales);
        exit;
    }
    
    // Cargar monedas
    elseif (isset($_GET['tipo']) && $_GET['tipo'] === 'monedas') {
        $stmt = $conn->query("SELECT id, nombre FROM monedas");
        $monedas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($monedas);
        exit;
    }
    
    throw new Exception("Parámetros inválidos");
    
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>