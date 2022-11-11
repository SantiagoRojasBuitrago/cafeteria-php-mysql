<?php include("db_connection.php") ?>
<?php include("includes/header.php") ?>

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
                <form action="querys/save_producto.php" method="POST">
                    <h2 style="text-align: center;">Crear un producto</h2>

                    <div class="form-group p-2">
                        <input type="text" name="nombre" class="form-control" placeholder="Nombre del producto" autofocus required>
                    </div>

                    <div class="form-group p-2">
                        <input type="text" name="referencia" class="form-control" placeholder="Referencia del producto" required>
                    </div>

                    <div class="form-group p-2">
                        <input type="number" step="0.01" name="precio" class="form-control" placeholder="Precio del producto (COP)" required>
                    </div>

                    <div class="form-group p-2">
                        <input type="number" step="0.01" name="peso" class="form-control" placeholder="Peso del producto (Gramos)" required>
                    </div>

                    <div class="form-group p-2">
                        <select name="categoria" class="form-control" required>
                            <option id="select_categoria" value="" disabled selected>Selecciona una categoría</option>
                            <?php
                            $query = "SELECT * FROM categorias_productos";
                            $categorias = mysqli_query($mysqli, $query);

                            while ($row = mysqli_fetch_array($categorias)) {
                                echo "<option value=$row[id]>$row[nombre_categoria]</option>'";
                            }

                            ?>
                        </select>
                    </div>
                    <div class="form-group p-2"><input type="number" name="stock" class="form-control" placeholder="Stock del producto (Unidades)" required></div>
                    <div class="form-group p-2"><input type="submit" class="btn btn-success btn-block form-control" name="save_producto" value="Guardar Producto"></div>
                </form>
            </div>
        </div>



        <div class="col-md-8">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Referencia</th>
                        <th>Precio (COP)</th>
                        <th>Peso (Gramos)</th>
                        <th>Categoría</th>
                        <th>Stock</th>
                        <th>Fecha de Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody><?php
                        $query = "SELECT * from productos";
                        $productos = mysqli_query($mysqli, $query);

                        while ($row = mysqli_fetch_array($productos)) { ?><tr>
                            <td><?php echo $row['nombre_producto'] ?></td>
                            <td><?php echo $row['referencia'] ?></td>
                            <td><?php echo $row['precio'] ?></td>
                            <td><?php echo $row['peso'] ?></td>
                            <?php $query = "SELECT * FROM categorias_productos";
                            $categorias = mysqli_query($mysqli, $query);
                            while ($row_categorias = mysqli_fetch_array($categorias)) {
                                if($row_categorias['id'] == $row['categoria_producto_id']){
                                    $categoria = $row_categorias['nombre_categoria'];
                                }
                            } ?>
                            <td><?php echo $categoria ?></td>
                            <td><?php echo $row['stock'] ?></td>
                            <td><?php echo $row['fecha_creacion'] ?></td>
                            <td><a href="editar_producto.php?id=<?php echo $row['id'] ?>" class="btn btn-secondary"><i class="bi bi-pencil-square"></i></a><a href="querys/eliminar_producto.php?id=<?php echo $row['id'] ?>" class="btn btn-danger"><i class="bi bi-trash"></i></a></td><?php } ?></tbody>
            </table>
        </div>
    </div>
</div><?php include("includes/footer.php") ?>