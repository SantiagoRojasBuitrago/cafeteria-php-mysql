<?php

session_start();

//try {
mysqli_report(MYSQLI_REPORT_OFF);
/* @ is used to suppress warnings */
$mysqli = @new mysqli('localhost', 'root', '', 'cafeteria');
if ($mysqli->connect_errno == 1049) {
    $mysqli = @new mysqli('localhost', 'root', '');

    $query = "CREATE DATABASE cafeteria;";
    $result = mysqli_query($mysqli, $query);

    $query = "CREATE TABLE cafeteria.categorias_productos(
   id int NOT NULL AUTO_INCREMENT ,
   nombre_categoria VARCHAR(30) NOT NULL,
   PRIMARY KEY (id)
    );";
    $result = mysqli_query($mysqli, $query);

    $query = "CREATE TABLE cafeteria.productos(
    id int NOT NULL AUTO_INCREMENT,
    nombre_producto VARCHAR(30) NOT NULL,
    referencia VARCHAR(30),
    precio double NOT NULL,
    peso DOUBLE NOT NULL,
    categoria_producto_id int NOT NULL,
    stock int NOT NULL,
    fecha_creacion date NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (categoria_producto_id) REFERENCES categorias_productos(id)
    );";
    $result = mysqli_query($mysqli, $query);

    $query = "CREATE TABLE afeteria.ventas_factura(
        id int NOT NULL AUTO_INCREMENT,
        fecha date NOT NULL,
        PRIMARY KEY (id)
    );";
    $result = mysqli_query($mysqli, $query);

    $query = "CREATE TABLE cafeteria.ventas_producto(
        id int NOT NULL AUTO_INCREMENT,
        id_producto int NOT NULL,
        cantidad int NOT NULL,
        venta_factura_id int NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (id_producto) REFERENCES productos(id),
        FOREIGN KEY (venta_factura_id) REFERENCES ventas_factura(id)
    );";
    $result = mysqli_query($mysqli, $query);

    $query = "INSERT INTO cafeteria.categorias_productos(nombre_categoria) VALUES
    ('Bebidas'),
    ('Lácteos'),
    ('Comida Rápida'),
    ('Panaderáa'),
    ('Repostería'),
    ('Snacks');";
    $result = mysqli_query($mysqli, $query);

    $mysqli = @new mysqli('localhost', 'root', '', 'cafeteria');

} else if ($mysqli->connect_errno == 2002) {
    echo "El nombre del servidor no es correcto";
} else if ($mysqli->connect_errno == 1045) {
    echo "El nombre de usuario o la clave del servidor no es correcto";
} else if ($mysqli->connect_errno) {
    echo "Error ".$mysqli->connect_errno;
}

if (isset($mysqli)) {
    //echo "conectado";
}
