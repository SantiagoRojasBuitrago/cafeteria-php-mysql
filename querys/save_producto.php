<?php include("../db_connection.php") ?>

<?php

if(isset($_POST["save_producto"])){
    $nombre = $_POST["nombre"];
    $referencia = $_POST["referencia"];
    $precio = $_POST["precio"];
    $peso = $_POST["peso"];
    $categoria = $_POST["categoria"];
    $stock = $_POST["stock"];
    $fecha = date('Y-m-d');

    

    $query = "INSERT INTO productos(nombre_producto, referencia, precio, peso, categoria_producto_id, stock, fecha_creacion)
    VALUES ('$nombre', '$referencia', $precio, $peso, $categoria, $stock, '$fecha')";

echo $query;
    $result = mysqli_query($mysqli, $query);

    if(!$result){
        die("Query failed");
    }
    $_SESSION['message'] = "Producto creado correctamente";
    $_SESSION['message_type'] = "success";

    header("Location: ../index.php");

    
}


?>