# Prueba técnica – Backend Happymami

## Descripción
Backend simple desarrollado en PHP y MySQL para gestionar clientes, productos y pedidos.

## Estructura de el proyecto
    config
    ├── database.php
    clientes
    ├── crear_cliente.php
    ├── listar_clientes.php
    productos
    ├── crear_producto.php
    ├── listar_productos.php
    pedidos
    ├── crear_pedido.php
    ├── listar_pedidos.php
    README.md

## Tecnologías
- PHP
- MySQL
- PDO (para la conexión a la base de datos)

## Endpoints

### Clientes
POST /clientes/crear_cliente.php → Inserta un cliente en la base de datos  
GET /clientes/listar_clientes.php → Lista todos los clientes

### Productos
POST /productos/crear_producto.php → Inserta un producto  
GET /productos/listar_productos.php → Lista productos

### Pedidos
POST /pedidos/crear_pedido.php → Crea un pedido asociado a un cliente e inserta los productos en la tabla detalle_pedidos, guardando también el precio del producto en el momento de realizar el pedido.

GET /pedidos/listar_pedidos.php → Lista todos los pruductos realizando una consulta con JOIN entre las tablas pedidos, clientes, detalle_pedidos y productos para mostrar la información completa del pedido.

## Base de datos
El sistema utiliza cuatro tablas:

- clientes
- productos
- pedidos
- detalle_pedidos

La tabla `detalle_pedidos` (que es la tabla N:M) permite almacenar los productos de cada pedido y guardar el precio del producto en el momento de tramitar el pedido.



