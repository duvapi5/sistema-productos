<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Producto</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="contenedor-formulario">
        <h1>Formulario de Producto</h1>
        
        <form id="form-producto">
            <div class="fila-formulario">
                <!-- Código  -->
                <div class="grupo-campo">
                    <label for="codigo">Código</label>
                    <input type="text" id="codigo" name="codigo" placeholder="PROD01K">
                </div>
                <!-- Nombre -->
                <div class="grupo-campo">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Set Comedor">
                </div>
            </div>
            
            <div class="fila-formulario">
                <!-- Bodega -->
                <div class="grupo-campo">
                    <label for="bodega">Bodega</label>
                    <select id="bodega" name="bodega">
                        <option selected></option>
                    </select>
                </div>
                <!-- Sucursal -->
                <div class="grupo-campo">
                    <label for="sucursal">Sucursal</label>
                    <select id="sucursal" name="sucursal">
                        <option selected></option>
                    </select>
                </div>
            </div>
            <!-- Moneda -->
            <div class="fila-formulario">
                <div class="grupo-campo">
                    <label for="moneda">Moneda</label>
                    <select id="moneda" name="moneda">
                        <option selected></option>
                    </select>
                </div>
                <!-- Precio -->
                <div class="grupo-campo">
                    <label for="precio">Precio</label>
                    <input type="text" id="precio" name="precio" placeholder="1500">
                </div>
            </div>
            <!-- Materiales -->
            <div class="form-group">
                <label>Material del Producto</label>
                <div id="materiales-container">
                    <?php include 'conexion.php';
                    $materiales = $conn->query("SELECT * FROM materiales");
                    while ($row = $materiales->fetch(PDO::FETCH_ASSOC)): ?>
                        <label>
                            <input type="checkbox" name="material[]" value="<?= $row['id'] ?>">
                            <?= $row['nombre'] ?>
                        </label>
                    <?php endwhile; ?>
                </div>
            </div>
            <!-- Descripción -->
            <div class="grupo-campo">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" placeholder="Elegante set de comedor..."></textarea>
            </div>
            <!-- Botón Guardar -->
            <button type="submit">Guardar Producto</button>
        </form>
    </div>

    <script src="script.js"></script>
</body>
</html>