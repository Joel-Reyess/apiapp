<?php
ob_start();
include '../admindash/global/ServerConfiguration.php';
include '../admindash/global/DbConnection.php';
include '../carrito.php';
session_start();

$json = file_get_contents('php://input');
$datos = json_decode($json, true);

echo '<pre>';
print_r($datos);
echo '</pre>';

if(is_array($datos)){

    $id_transaccion = $datos['detalles']['id'];
    $monto = $datos['detalles']['purchase_units'][0]['amount']['value'];
    $status = $datos['detalles']['status'];
    $fecha = $datos['detalles']['update_time'];
    $fecha_nueva = date('Y-m-d H:i:s', strtotime($fecha));
    $email = $datos['detalles']['payer']['email_address'];
    $id_cliente = $datos['detalles']['payer']['payer_id'];

     $ventas = $pdo->prepare("INSERT INTO ventas (id_transaccion, idcliente, fechaventa, correoventa, totalventa, estado) 
    VALUES(:transaccion, :cliente, :fecharegistro, :email, :total, :estado); ");
     $ventas->bindParam(':transaccion', $id_transaccion);
     $ventas->bindParam(':cliente', $id_cliente);
     $ventas->bindParam(':fecharegistro', $fecha_nueva);
     $ventas->bindParam(':email', $email);
     $ventas->bindParam(':total', $monto);
     $ventas->bindParam(':estado', $status);
     $ventas->execute();
     $Idventas = $pdo->lastInsertId();


     foreach ($_SESSION['CARRITO'] as $indice => $producto) {
        $InsertProductsQuery = $pdo->prepare("INSERT INTO detallesventa (idventa, idproducto, precioxunidad, cantidad, nombre)
        VALUES(:IDPEDIDO, :id_producto, :PRECIOUNITARIO, :CANTIDAD, :NOMBREPRODUCTO); ");
        $InsertProductsQuery->bindParam(":IDPEDIDO", $Idventas);
        $InsertProductsQuery->bindParam(":id_producto", $producto['ID']);
        $InsertProductsQuery->bindParam(":PRECIOUNITARIO", $producto['PRECIO']);
        $InsertProductsQuery->bindParam(":CANTIDAD", $producto['CANTIDAD']);
        $InsertProductsQuery->bindParam(":NOMBREPRODUCTO", $producto['NOMBRE']);
        $InsertProductsQuery->execute();
    }
    unset($_SESSION['CARRITO']);
    header("Location: ../ordercomp.php");
    //  if( $Idventas > 0){
    //     $productos = isset($_SESSION['CARRITO']) ? $_SESSION['CARRITO'] : null;

    //     if ($productos != null) {
    //         foreach ($productos as $clave =>$cantidad){

    //         }
    //     }
    //  }
}
?>