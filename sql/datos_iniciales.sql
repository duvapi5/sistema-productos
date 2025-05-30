-- Bodegas
INSERT INTO bodegas (nombre) VALUES 
('Bodega Central'),
('Bodega Norte'),
('Bodega Sur');

-- Sucursales
INSERT INTO sucursales (nombre, bodega_id) VALUES
('Sucursal A', 1),
('Sucursal B', 1),
('Sucursal C', 2),
('Sucursal D', 3);

-- Monedas
INSERT INTO monedas (nombre) VALUES
('CLP - Peso Chileno'),
('USD - Dólar Estadounidense'),
('EUR - Euro');

-- Materiales
INSERT INTO materiales (nombre) VALUES
('Madera'),
('Metal'),
('Plástico'),
('Vidrio'),
('Tela');