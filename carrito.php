<?php
session_start();
ob_start();
$mensaje="";
if (isset($_POST['btnAccion'])) 
{
  if (!isset($_SESSION["session_username"])) {
    echo "<script> window.location='register.php';</script>";
  }else{
  switch ($_POST['btnAccion'])
   {
    case 'Add':
      if (is_numeric( openssl_decrypt($_POST['id'],COD,KEY ))) {
        $ID=openssl_decrypt($_POST['id'],COD,KEY);
        $mensaje="Ok ID correcto".$ID."<br>";
      }else {
        $mensaje="Upss... ID incorrecto". $ID. "<br>";
      }
      if (is_string(openssl_decrypt($_POST['nombre'],COD,KEY))) {
        $NOMBRE=openssl_decrypt($_POST['nombre'],COD,KEY);
        $mensaje="Ok Noombre correcto".$NOMBRE."<br>";
      }else {
        $mensaje="Upss... Nombre incorrecto". $NOMBRE. "<br>";
      }
      if (is_numeric(openssl_decrypt($_POST['precio'],COD,KEY))) {
        $PRECIO=openssl_decrypt($_POST['precio'],COD,KEY);
        $mensaje="Ok Precio correcto".$PRECIO."<br>";
      }else {
        $mensaje="Upss... Precio incorrecto". $PRECIO. "<br>";
      }
      if (is_string(openssl_decrypt($_POST['imagen'],COD,KEY))) {
        $IMAGEN=openssl_decrypt($_POST['imagen'],COD,KEY);
        $mensaje="Ok Imagen correcto".$IMAGEN."<br>";
      }else {
        $mensaje="Upss... Imagen incorrecto". $IMAGEN. "<br>";
      }
      if (is_numeric(openssl_decrypt($_POST['cantidad'],COD,KEY))) {
        $CANTIDAD=openssl_decrypt($_POST['cantidad'],COD,KEY);
        $mensaje="Ok Cantidad correcta".$CANTIDAD."<br>";
      }else {
        $mensaje="Upss... Cantidad incorrecta". "<br>";
      }
      
        if (!isset($_SESSION['CARRITO'])) {
            $producto=array(
            'ID'=>$ID,
            'NOMBRE'=>$NOMBRE,
            'PRECIO'=>$PRECIO,
            'IMAGEN'=>$IMAGEN,
            'CANTIDAD'=>$CANTIDAD
            );
            $_SESSION['CARRITO'][0]=$producto;
            $mensaje="Producto agregado al carrito";
        }else {
            $idProductos=array_column($_SESSION['CARRITO'],"ID");
            if (in_array($ID,$idProductos)) {
                echo "<script>alert('El producto ya ha sido seleccionado..');</script>";
                $mensaje="";
            }else {
                $NumeroProductos=count ($_SESSION['CARRITO']);
                $producto=array(
                    'ID'=>$ID,
                    'NOMBRE'=>$NOMBRE,
                    'PRECIO'=>$PRECIO,
                    'IMAGEN'=>$IMAGEN,
                    'CANTIDAD'=>$CANTIDAD
                );
                $_SESSION['CARRITO'][$NumeroProductos]=$producto;
                $mensaje="Producto agregado al carrito";
            }
        }
      break;
        case 'Eliminar':
          if (is_numeric( openssl_decrypt($_POST['id'],COD,KEY ))) {
            $ID=openssl_decrypt($_POST['id'],COD,KEY );
            foreach($_SESSION['CARRITO'] as $indice=>$producto){
              if ($producto['ID']==$ID) {
                unset($_SESSION['CARRITO'][$indice]);
                echo "<script>alert('Elemento Borrado'...);</script>";
              }
            }

          }else {
            $mensaje="Upss... ID incorrecto". $ID. "<br>";
          }
          break;
    default:
      # code...
      break;
  }
}
}

?>