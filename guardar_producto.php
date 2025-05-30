<?php
include 'conexion.php';

header('Content-Type: application/json');

try {
    // Validación de datos básica
    $required = ['codigo', 'nombre', 'bodega', 'sucursal', 'moneda', 'precio', 'descripcion'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("El campo $field es requerido");
        }
    }

    // Validar unicidad del código
    $stmt = $conn->prepare("SELECT id FROM productos WHERE codigo = ?");
    $stmt->execute([$_POST['codigo']]);
    if ($stmt->rowCount() > 0) {
        throw new Exception("El código ya existe");
    }

    // Validar materiales
    if (empty($_POST['material']) || count($_POST['material']) < 2) {
        throw new Exception("Debe seleccionar al menos 2 materiales");
    }

    // Insertar producto
    $sql = "INSERT INTO productos (codigo, nombre, bodega_id, sucursal_id, moneda_id, precio, descripcion) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        $_POST['codigo'],
        $_POST['nombre'],
        $_POST['bodega'],
        $_POST['sucursal'],
        $_POST['moneda'],
        $_POST['precio'],
        $_POST['descripcion']
    ]);

    // Insertar materiales seleccionados
    $producto_id = $conn->lastInsertId();
    foreach ($_POST['material'] as $material_id) {
        $stmt = $conn->prepare("INSERT INTO producto_material (producto_id, material_id) VALUES (?, ?)");
        $stmt->execute([$producto_id, $material_id]);
    }

    echo json_encode(['status' => 'success']);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>