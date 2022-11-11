<?php include("includes/header.php") ?>
<?php include("db_connection.php"); ?>

<?php



$query = "SELECT MAX(stock), nombre_producto FROM productos;";
$result = mysqli_query($mysqli, $query);
$mayor_stock = mysqli_fetch_array($result);

$query = "SELECT productos.nombre_producto, SUM(ventas_producto.cantidad)
FROM productos
INNER JOIN ventas_producto ON productos.id = ventas_producto.id_producto;";
$result = mysqli_query($mysqli, $query);
$mas_vendido = mysqli_fetch_array($result);

?>

<h1>Producto que más stock tiene: </h1>
<?php echo  $mayor_stock['nombre_producto']; ?>
 - Unidades en stock: <?php echo  $mayor_stock['MAX(stock)']; ?>

<h1>Producto más vendido: </h1>
<?php echo  $mas_vendido['nombre_producto']; ?>
 - Unidades vendidas: <?php echo  $mas_vendido['SUM(ventas_producto.cantidad)']; ?>

<?php include("includes/footer.php") ?>