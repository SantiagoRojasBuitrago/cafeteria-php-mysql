<?php
include("db_connection.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];



    $query = "SELECT * FROM productos WHERE id = $id";
    $result = mysqli_query($mysqli, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
        $nombre_producto = $row['nombre_producto'];
        $referencia = $row['referencia'];
        $precio = $row['precio'];
        $peso = $row['peso'];
        $categoria_producto_id = $row['categoria_producto_id'];
        $stock = $row['stock'];
        $fecha_creacion = $row['fecha_creacion'];
    }

   
}

if(isset($_POST['update'])){
    $id = $_GET['id'];
    $nombre = $_POST["nombre"];
    $referencia = $_POST["referencia"];
    $precio = $_POST["precio"];
    $peso = $_POST["peso"];
    $categoria = $_POST["categoria"];
    $stock = $_POST["stock"];

    $query = "UPDATE productos set 
    nombre_producto = '$nombre', 
    referencia = '$referencia', 
    precio = '$precio', 
    peso = '$peso', 
    categoria_producto_id = '$categoria', 
    stock = '$stock' WHERE id=$id; ";

    $result = mysqli_query($mysqli, $query);

    $_SESSION['message'] = "Producto actualizado correctamente";
    $_SESSION['message_type'] = "warning";
    header("Location: index.php");
}

?>

<?php include("includes/header.php") ?>

<div class="container p-4">
    <div class="row">
        <div class="col-md-4 mx-auto">
            <div class="card card-body">
                <form action="editar_producto.php?id=<?php echo $_GET['id'] ?>" method="POST">
                    <div class="form-group p-2">
                        <input type="text" name="nombre" value="<?php echo $nombre_producto;?>" class="form-control" placeholder="Actualizar nombre">
                    </div>
                    <div class="form-group p-2">
                        <input type="text" name="referencia" value="<?php echo $referencia;?>" class="form-control" placeholder="Actualizar referencia">
                    </div>
                    <div class="form-group p-2">
                        <input type="number" name="precio" value="<?php echo $precio;?>" class="form-control" placeholder="Actualizar precio">
                    </div>
                    <div class="form-group p-2">
                        <input type="number" name="peso" value="<?php echo $peso;?>" class="form-control" placeholder="Actualizar peso">
                    </div>
                    <div class="form-group p-2">
                    <select name="categoria" class="form-control" >
                            <?php
                            $query = "SELECT * FROM categorias_productos";
                            $categorias = mysqli_query($mysqli, $query);

                            while ($row = mysqli_fetch_array($categorias)) {
                               $option =  "<option value=$row[id]";
                               

                                if($row['id'] == $categoria_producto_id){
                                    $option2=" selected";
                                }
                                else{
                                    $option2="";
                                }
                                $option3 = ">$row[nombre_categoria]</option>'";
                                echo $option.$option2.$option3;
                                
                            }


                            ?>
                        </select>
                    </div>
                    <div class="form-group p-2">
                        <input type="number" name="stock" value="<?php echo $stock;?>" class="form-control" placeholder="Actualizar stock">
                    </div>
                    <div class="form-group p-2">
                        <input type="submit" class="btn btn-success btn-block form-control" name="update" value="Guardar Producto">
                    </div>
                </form>
            </div>

        </div>
    </div>

</div>



<?php include("includes/footer.php") ?>