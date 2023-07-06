<?php
session_start();

if ($_POST) {
  $indice = $_POST['indice'];
  $cantidad = $_POST['cantidad'];

  // Actualizar la cantidad del producto en la variable de sesión CARRITO
  $_SESSION['CARRITO'][$indice]['CANTIDAD'] = $cantidad;

  // Devolver el número total de productos en el carrito
  $total = 0;
  foreach ($_SESSION['CARRITO'] as $producto) {
    $total += $producto['CANTIDAD'];
  }
  echo $total;
}
?>