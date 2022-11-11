<?php include("db_connection.php") ?>
<?php include("includes/header.php") ?>


<?php


if (isset($_POST['agregar_producto'])) {



    $cantidad = $_POST["cantidad"];
    $producto = $_POST["producto"];

    $productos = $_SESSION['productos'];
    $cantidades = $_SESSION['cantidades'];

    foreach($productos as $key=>$producto_existente){
        if($producto_existente == $producto){
            $cantidad = $cantidad + $cantidades[$key];
        }
    }

    $query = "SELECT * FROM productos WHERE id = $producto";
    $result = mysqli_query($mysqli, $query);
    $row = mysqli_fetch_array($result);

    if ($cantidad > $row['stock']) {
        echo '<script language="javascript">alert("No hay suficientes productos en stock");</script>';
    } else {
        if (isset($_SESSION['cantidades']) || isset($_SESSION['productos'])) {
            array_push($_SESSION['cantidades'], $cantidad);
            array_push($_SESSION['productos'], $producto);
        } else {

            $_SESSION['cantidades'] = array();
            $_SESSION['productos'] = array();
            array_push($_SESSION['cantidades'], $cantidad);
            array_push($_SESSION['productos'], $producto);
            header("Location: venta_producto.php");
        }
    }
}

if (isset($_POST['borrar_todo'])) {

    session_destroy();
    header("Location: venta_producto.php");
}

if (isset($_POST['finalizar_venta'])) {

    if (!isset($_SESSION['productos'])) {
        echo '<script language="javascript">alert("No hay productos agregados");</script>';
    } else {
        $productos = $_SESSION['productos'];
        $cantidades = $_SESSION['cantidades'];

        $fecha = $fecha = date('Y-m-d');
        $query = "INSERT INTO ventas_factura (fecha) values ('$fecha')";

        $result = mysqli_query($mysqli, $query);
        $id = mysqli_insert_id($mysqli);

        foreach ($productos as $key => $producto) {
            $cantidad = $cantidades[$key];
            $query = "INSERT INTO ventas_producto (id_producto, cantidad, venta_factura_id) values 
            ('$producto','$cantidad','$id')";

            $result = mysqli_query($mysqli, $query);

            $query = "SELECT * FROM productos where id = $producto";
            $result = mysqli_query($mysqli, $query);
            $row = mysqli_fetch_array($result);

            $nueva_cantidad = $row['stock'] - $cantidad;

            $query = "UPDATE productos set stock = '$nueva_cantidad' where id = $producto";
            $result = mysqli_query($mysqli, $query);
        }
        session_destroy();
        header("Location: venta_producto.php");
    }
}





?>

<h1 style="text-align: center;">Venta de productos</h1>


<div class="container p-4">
    <div class="row">
        <div class="col-md-4">

            <?php if (isset($_SESSION['message'])) { ?>
                <div class="alert alert-<?= $_SESSION['message_type']; ?> alert-dismissible fade show" role="alert">
                    <?= $_SESSION['message'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

            <?php session_unset();
            } ?>



            <div class="card card-body">
                <form action="venta_producto.php" method="POST">

                    <h2 style="text-align: center;">Seleccionar productos</h2>

                    <div class="form-group p-2">
                        <select name="producto" class="form-control" required>
                            <option value="" disabled selected>Selecciona un producto</option>
                            <?php
                            $query = "SELECT * FROM productos";
                            $categorias = mysqli_query($mysqli, $query);

                            while ($row = mysqli_fetch_array($categorias)) {
                                echo "<option value=$row[id]>$row[nombre_producto]</option>'";
                            }

                            ?>
                        </select>



                    </div>

                    <div class="form-group p-2"><input type="number" name="cantidad" class="form-control" placeholder="Cantidad" required></div>
                    <div class="form-group p-2"><input type="submit" class="btn btn-success btn-block form-control" name="agregar_producto" value="Guardar Producto"></div>
                </form>
            </div>
        </div>



        <div class="col-md-8">
            <form action="venta_producto.php" method="POST">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Referencia</th>
                            <th>Precio (COP)</th>
                            <th>Peso (Gramos)</th>
                            <th>Categoría</th>
                            <th>En Stock</th>
                            <th>Cantidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody><?php

                            if (isset($_SESSION['cantidades']) || isset($_SESSION['productos'])) {
                                $productos = $_SESSION['productos'];
                                $cantidades = $_SESSION['cantidades'];
                            } else {
                                $productos = [];
                                $cantidades = [];
                            }


                            foreach ($productos as $key => $producto) {
                                $query = "SELECT * FROM productos WHERE id = $producto";
                                $result = mysqli_query($mysqli, $query);
                                $row = mysqli_fetch_array($result)

                            ?><tr>
                                <td><?php echo $row['nombre_producto'] ?></td>
                                <td><?php echo $row['referencia'] ?></td>
                                <td><?php echo $row['precio'] ?></td>
                                <td><?php echo $row['peso'] ?></td>
                                <?php $query = "SELECT * FROM categorias_productos";
                                $categorias = mysqli_query($mysqli, $query);
                                while ($row_categorias = mysqli_fetch_array($categorias)) {
                                    if ($row_categorias['id'] == $row['categoria_producto_id']) {
                                        $categoria = $row_categorias['nombre_categoria'];
                                    }
                                } ?>
                                <td><?php echo $categoria ?></td>
                                <td><?php echo $row['stock'] ?></td>
                                <td><?php echo $cantidades[$key] ?></td>
                                <td><a href="" class="btn btn-danger">
                                        <i class="bi bi-trash"></i></a></td>
                            <?php } ?></tbody>
                </table>
                <div class="form-group p-2"><input type="submit" class="btn btn-danger btn-block form-control" name="borrar_todo" value="Borrar todo"></div>
                <div class="form-group p-2"><input type="submit" class="btn btn-success btn-block form-control" name="finalizar_venta" value="Finalizar venta"></div>
            </form>


        </div>
    </div>



</div><?php include("includes/footer.php") ?>