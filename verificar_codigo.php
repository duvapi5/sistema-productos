<?php
include 'conexion.php';

header('Content-Type: application/json');

try {
    // Verificar si se ha proporcionado el código del producto
    if (!isset($_GET['codigo']) || empty(trim($_GET['codigo']))) {
        throw new Exception('Código no proporcionado');
    }
    
    $codigo = trim($_GET['codigo']);
    $stmt = $conn->prepare("SELECT id FROM productos WHERE codigo = :codigo");
    $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);
    $stmt->execute();
    
    echo json_encode([
        'existe' => ($stmt->rowCount() > 0)
    ]);
    
} catch (PDOException $e) {
    error_log("Error en verificar_codigo: " . $e->getMessage());
    echo json_encode([
        'error' => 'Error de base de datos'
    ]);
} catch (Exception $e) {
    error_log("Error general en verificar_codigo: " . $e->getMessage());
    echo json_encode([
        'error' => $e->getMessage()
    ]);
}
?>