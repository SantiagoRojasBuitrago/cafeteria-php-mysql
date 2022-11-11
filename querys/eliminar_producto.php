<?php 
include("../db_connection.php");

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM productos WHERE id = $id";
    $result = mysqli_query($mysqli, $query);

    if(!$result){
        die("Query failed");
    }

    $_SESSION['message'] = "Producto eliminado correctamente";
    $_SESSION['message_type'] = "danger";

    header("Location: ../index.php");




}


?>