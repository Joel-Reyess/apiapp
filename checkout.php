<?php
ob_start();
// session_start();
include 'admindash/global/ServerConfiguration.php';
include 'admindash/global/DbConnection.php';
include 'carrito.php';


if (!isset($_SESSION["session_username"])) { //we use this to block the access to users 
  //that type this page on the browser and aren't logged in
  header("Location:login.php"); //redirect them to login page or you could show a denied access page and a link to login 
} else {  //but if there is a logged in user then we can show the page
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <title>MemeWorld! &mdash; </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700">
    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">


    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="/images/memeworldlogo.png" />

  </head>

  <body>

    <div class="site-wrap">
      <header class="site-navbar">
        <div class="site-navbar-top">
          <div class="container">
            <div class="row align-items-center">

              <div class="col-6 col-md-4 order-2 order-md-1 site-search-icon text-left">

              </div>

              <div class="col-12 mb-3 mb-md-0 col-md-4 order-1 order-md-2 text-center">
                <div class="site-logo">
                  <a href="index.php" class="chilli">MemeWorld!</a>
                </div>
              </div>

              <div class="col-6 col-md-4 order-3 order-md-3 text-right">
                <div class="site-top-icons">
                  <ul>
                    <?php
                    if (!isset($_SESSION['session_idcliente'])) {
                    ?>
                      <li class="nav-item"><a href="./login.php" class="nav-link">Iniciar Sesión</a></li>
                    <?php } else { ?>
                      <li class="nav-item"><a href="./logout.php" class="nav-link">Cerrar Sesión <?php echo $_SESSION['session_username'] ?></a></li>
                    <?php } ?>
                    <li>
                      <a href="cart.php" class="site-cart">
                        <span class="icon icon-shopping_cart"></span>
                        <span class="count">(<?php echo (empty($_SESSION['CARRITO'])) ? 0 : count($_SESSION['CARRITO']); ?>)</span>
                      </a>
                    </li>
                    <li class="d-inline-block d-md-none ml-md-0"><a href="#" class="site-menu-toggle js-menu-toggle"><span class="icon-menu"></span></a></li>
                  </ul>
                </div>
              </div>

            </div>
          </div>
        </div>
        <nav class="site-navigation text-right text-md-center" role="navigation">
          <div class="container">
            <ul class="site-menu js-clone-nav d-none d-md-block">
              <li>
                <a href="index.php">Home</a>
              </li>
              <li class="">
                <a href="about.php">About</a>
              </li>
              <li><a href="shop.php">Shop</a></li>
              <li><a href="contact.php">Contact</a></li>
              <li><a href="checkout.php">Checkout</a></li>
              <li><a href="deliveries.php">Deliveries</a></li>
            </ul>
          </div>
        </nav>
      </header>

      <div class="bg-light py-3">
        <div class="container">
          <div class="row">
            <div class="col-md-12 mb-0"><a href="index.html">Home</a> <span class="mx-2 mb-0">/</span> <a href="cart.html">Cart</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Checkout</strong></div>
          </div>
        </div>
      </div>
      <!--================ confirmation part start =================-->
      <?php
      $QueryPedidos = $pdo->prepare("SELECT id_pedido, idcliente, fecha_pedido, total_pago  FROM pedido 
    Where idcliente = :id ORDER BY fecha_pedido DESC");
      $QueryPedidos->bindParam(':id', $_SESSION['session_idcliente']);
      $QueryPedidos->execute();
      $PedidosLista = $QueryPedidos->fetchAll(PDO::FETCH_ASSOC);
      $Pedido = $QueryPedidos->fetch(PDO::FETCH_LAZY);
      ?>

      <div class="site-section">
        <?php
        foreach ($PedidosLista as $cadpedido) {
        ?>
          <div class="col-lg-12">
            <div class="confirmation_tittle">
              <span>Gracias por ordenar. Tu pedido ha sido recibido</span>
              <?php
              if (!isset($_SESSION["session_username"])) //here we don't show the email of the user if it isn't logged in
              {
                echo '';
              } else //but if there is a session then we show the email
              {
                echo $_SESSION['session_username'];
              }
              ?>
              <div class="container">

                <!-- ORDER SUMMARY-->
                <table class="table site-block-order-table mb-5">
                  <thead>
                    <th>Order Number</th>
                    <th>Date</th>
                    <th>Total</th>
                  </thead>
                  <tbody>
                    <tr>
                      <td><span class="text-muted small"><?php echo $cadpedido['id_pedido']; ?></span></td>
                      <td><span class="text-muted small"><?php echo $cadpedido['fecha_pedido']; ?></span></td>
                      <td><span>$<?php echo $cadpedido['total_pago']; ?></span></td>
                    </tr>

                  </tbody>
                </table>
                <div class="row">
                  <div class="col-md-12">
                    <div class="row mb-12">
                      <div class="col-md-12">
                        <h2 class="h3 mb-3 text-black">Your Order Details</h2>
                        <div class="p-3 p-lg-5 border">
                          <table class="table site-block-order-table mb-5">
                            <?php
                            $PedidosQuery = $pdo->prepare("SELECT id_pedido, fecha_pedido, nombrecliente, id_estado, nombreproducto,
                   cantidad_producto, precioproducto, total_pago , ProductImage , estadopedido
                    FROM detallespedido INNER JOIN pedido USING (id_pedido) INNER JOIN productos USING 
                    (idproducto) INNER JOIN clientes USING (idcliente) INNER JOIN estado USING (id_estado)
                     WHERE idcliente = :id AND id_pedido = :idPedido  ORDER BY fecha_pedido DESC;");
                            $PedidosQuery->bindParam(':id', $_SESSION['session_idcliente']);
                            $PedidosQuery->bindParam(':idPedido', $cadpedido['id_pedido']);
                            $PedidosQuery->execute();
                            $ListadoPedido = $PedidosQuery->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($ListadoPedido as $dpedido) {
                            ?>
                              <thead>
                                <th>Product</th>
                                <th>Status</th>
                                <th>Image</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                              </thead>
                              <tbody>
                                <tr>
                                  <td><?php echo $dpedido['nombreproducto']; ?><strong class="mx-2"></strong></td>
                                  <td><?php echo $dpedido['estadopedido']; ?></td>
                                  <td><img class="" src="<?php echo 'admindash/pages/forms/Images/' . $dpedido['ProductImage']; ?>" width="50px" height="50px" alt="..."></td>
                                  <td><?php echo $dpedido['cantidad_producto']; ?></td>
                                  <td>$<?php echo $dpedido['precioproducto']; ?></td>
                                  <td>$<?php echo $cadpedido['total_pago']; ?></td>
                                </tr>
                              </tbody>
                            <?php } ?>
                          </table>
                          </div>
                        </div>
                        <!-- </form> -->
                      </div>
                    </div>
                  </div>
                <?php } ?>


                <footer class="site-footer border-top">
                  <div class="container">
                    <div class="row">
                      <div class="col-lg-6 mb-5 mb-lg-0">
                        <div class="row">
                          <div class="col-md-12">
                            <h3 class="footer-heading mb-4">Navigations</h3>
                          </div>
                          <div class="col-md-6 col-lg-4">
                            <ul class="list-unstyled">
                              <li><a href="shop.php">Shop</a></li>
                              <li><a href="about.php">About Us</a></li>

                            </ul>
                          </div>
                          <div class="col-md-6 col-lg-4">
                            <ul class="list-unstyled">
                              <li><a href="shop.php">Categories</a></li>
                              <li><a href="cart.php">Shopping cart</a></li>
                            </ul>
                          </div>
                          <div class="col-md-6 col-lg-4">
                            <ul class="list-unstyled">
                              <li><a href="checkout.php">Checkout</a></li>
                              <li><a href="contact.php">Contact Us</a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                        <h3 class="footer-heading mb-4">Be happy</h3>
                        <a href="#" class="block-6">
                          <img src="images/hero_1.jpg" alt="Image placeholder" class="img-fluid rounded mb-4">
                        </a>
                      </div>
                      <div class="col-md-6 col-lg-3">
                        <div class="block-5 mb-5">
                          <h3 class="footer-heading mb-4">Contact Info</h3>
                          <ul class="list-unstyled">
                            <li class="address">UTTN, Tamaulipas, MX</li>
                            <li class="phone"><a href="tel://23923929210">+2 392 3929 210</a></li>
                            <li class="email">emailaddress@domain.com</li>
                          </ul>
                        </div>


                      </div>
                    </div>
                    <div class="row pt-5 mt-5 text-center">
                      <div class="col-md-12">
                        <p>
                          <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                          Copyright &copy;<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
                          <script>
                            document.write(new Date().getFullYear());
                          </script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank" class="text-primary">Some handsome man</a>
                          <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        </p>
                      </div>

                    </div>
                  </div>
                </footer>
                </div>

                <script src="js/jquery-3.3.1.min.js"></script>
                <script src="js/jquery-ui.js"></script>
                <script src="js/popper.min.js"></script>
                <script src="js/bootstrap.min.js"></script>
                <script src="js/owl.carousel.min.js"></script>
                <script src="js/jquery.magnific-popup.min.js"></script>
                <script src="js/aos.js"></script>
                <!-- <script src="https://www.paypal.com/sdk/js?client-id=AaxK6qKq30WlMSwDuiCYx53f26bRbNBRT08c0X3AH5S8cZzwj8Ea-XM0LDWVIAgUHdGcnOaeN8_cGuz_&currency=MXN"> -->
                </script>

                <script src="paypal.js"></script>
                <script src="js/main.js"></script>

  </body>

  </html>
<?php
} //this is the closing braket of the first condition (if(!isset($_SESSION["session_username"])
?>