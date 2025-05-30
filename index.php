<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Productos</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1 class="titulo-formulario">Formulario de Producto</h1>
    <form id="form-producto">
        <!-- Código -->
        <div class="form-group">
            <label>Código Producto*</label>
            <input type="text" name="codigo" id="codigo" placeholder="Ej: PROD12">
        </div>

        <!-- Nombre -->
        <div class="form-group">
            <label>Nombre del Producto*</label>
            <input type="text" name="nombre" id="nombre" placeholder="Ej: Set Comedor">
        </div>
        
        <!-- Bodega (cargada dinámicamente) -->
        <div class="form-group">    
            <label>Bodega*</label>
            <select name="bodega" id="bodega">
                <option value="">Seleccione...</option>
                <!-- Opciones cargadas por JS -->
            </select>
        </div>
        
        <!-- Sucursal (carga dinámica por AJAX) -->
        <div class="form-group">
            <label>Sucursal*</label>
            <select name="sucursal" id="sucursal" disabled>
                <option value="">Seleccione...</option>
            </select>
        </div>

        <!-- Monedas (cargada dinámicamente) -->
        <div class="form-group">
            <label>Moneda*</label>
            <select name="moneda" id="moneda">
                <option value="">Seleccione...</option>
                <!-- Opciones cargadas por JS -->
            </select>
        </div>

        <!-- Precio -->
        <div class="form-group">
            <label>Precio*</label>
            <input type="text" name="precio" id="precio" placeholder="Ej: 1500.00">
        </div>
        
        <!-- Materiales (checkboxes) -->
        <div class="form-group">
            <label>Materiales* (Seleccione al menos 2)</label>
            <div id="materiales-container">
                <?php
                include 'conexion.php';
                $materiales = $conn->query("SELECT * FROM materiales");
                while ($row = $materiales->fetch(PDO::FETCH_ASSOC)): ?>
                    <label class="checkbox-label">
                        <input type="checkbox" name="material[]" value="<?= $row['id'] ?>">
                        <?= $row['nombre'] ?>
                    </label>
                <?php endwhile; ?>
            </div>
        </div>

        <!-- Descripción -->
        <div class="form-group">
            <label>Descripción*</label>
            <textarea name="descripcion" id="descripcion" rows="4" placeholder="Ej: Elegante set de comedor..."></textarea>
        </div>
        
        <button type="submit">Guardar Producto</button>
    </form>

    <script src="script.js"></script>
</body>
</html>