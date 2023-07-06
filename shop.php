<?php
ob_start();
//session_start();
include 'admindash/global/ServerConfiguration.php';
include 'admindash/global/DbConnection.php';
include 'carrito.php';
?>

<!DOCTYPE html>
<html lang="en">
<?php
$filter = (isset($_POST['filter'])) ? $_POST['filter'] : "";
?>
<?php
switch ($filter) {
  case 'Parte-1':
    $QueryProductos = $pdo->prepare("SELECT * FROM productos WHERE idcategoria=1");
    $QueryProductos->execute();
    $ProductosLista = $QueryProductos->fetchAll(PDO::FETCH_ASSOC);
    break;
  case 'Parte-2':
    $QueryProductos = $pdo->prepare("SELECT * FROM productos WHERE idcategoria=2");
    $QueryProductos->execute();
    $ProductosLista = $QueryProductos->fetchAll(PDO::FETCH_ASSOC);
    break;
  case 'Parte-5':
    $QueryProductos = $pdo->prepare("SELECT * FROM productos WHERE idcategoria=5");
    $QueryProductos->execute();
    $ProductosLista = $QueryProductos->fetchAll(PDO::FETCH_ASSOC);
    break;

  default:
    $QueryProductos = $pdo->prepare("SELECT * FROM productos");
    $QueryProductos->execute();
    $ProductosLista = $QueryProductos->fetchAll(PDO::FETCH_ASSOC);
    break;
}
?>

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
    <header class="site-navbar" role="banner">
      <div class="site-navbar-top">
        <div class="container">
          <div class="row align-items-center">

            <div class="col-6 col-md-4 order-2 order-md-1 site-search-icon text-left">
              <form action="" class="site-block-top-search">

              </form>
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
              if(!isset($_SESSION['session_idcliente'])){
              ?>
              <li class="nav-item"><a href="./login.php" class="nav-link">Iniciar Sesión</a></li>
              <?php } else { ?>
              <li class="nav-item"><a href="./logout.php" class="nav-link">Cerrar Sesión <?php echo $_SESSION['session_username']?></a></li>
              <?php } ?>
                  <li>
                    <a href="cart.php" class="site-cart">
                      <span class="icon icon-shopping_cart"></span>
                      <span class="count">(<?php echo (empty($_SESSION['CARRITO']))?0:count($_SESSION['CARRITO']); ?>)</span>
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
            <li >
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
          <div class="col-md-12 mb-0"><a href="index.html">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Shop</strong></div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">

        <div class="row mb-5">
          <div class="col-md-9 order-2">
          <div class="bg-light py-3">
      <div class="container">
        
        <form action="" method="POST">
              <div class="d-flex" role="button">
                <div class="dropdown mr-1 ml-md-auto">
                  <button  class="btn btn-secondary btn-sm"  name="filter" value="" type="submit">All</button>
                </div>
                <div class="btn-group">
                  <button  class="btn btn-secondary btn-sm"  name="filter" value="Parte-1" type="submit">Draws</button>
                </div>
                <div class="btn-group">
                  <button  class="btn btn-secondary btn-sm"  name="filter" value="Parte-2" type="submit">Modern</button>
                </div>
                <div class="btn-group">
                  <button  class="btn btn-secondary btn-sm"  name="filter" value="Parte-5" type="submit">Abstract</button>
                </div>
              </div>
            </form>
      </div>
    </div>
            
            
              <?php if($mensaje!=""){?>
        <div class="alert alert-success">
          <?php echo $mensaje; ?>
          <a href="cart.php" class="badge badge-success">Ver carrito</a>
        </div>
        <?php } ?>
              <div class="row mb-5">
                <?php
                foreach ($ProductosLista as $producto) { ?>
                  <div class="col-sm-6 col-lg-4 mb-4" data-aos="fade-up">
                    <div class="block-4 text-center border">
                      <figure class="block-4-image">
                        <a href="shop-single.html"><img src="<?php echo 'admindash/pages/forms/Images/' . $producto['ProductImage']; ?>"  alt="Image placeholder" class="img-fluid"></a>
                      </figure>
                      <div class="block-4-text p-4">
                        <h3><a href="shop-single.html"><?php echo $producto['nombreproducto']; ?></a></h3>
                        <!-- <p class="mb-0">Finding perfect t-shirt</p> -->
                        <p class="text-primary font-weight-bold">$<?php echo $producto['precioproducto']; ?></p>
                      </div>
                      <form action="" method="POST">
                        <input type="hidden" name="id" id="id" value="<?php echo openssl_encrypt($producto['idproducto'], COD, KEY); ?>">
                        <input type="hidden" name="nombre" id="nombre" value="<?php echo openssl_encrypt($producto['nombreproducto'], COD, KEY); ?>">
                        <input type="hidden" name="precio" id="precio" value="<?php echo openssl_encrypt($producto['precioproducto'], COD, KEY); ?>">
                        <input type="hidden" name="imagen" id="imagen" value="<?php echo openssl_encrypt($producto['ProductImage'], COD, KEY); ?>">
                        <input type="hidden" name="cantidad" id="cantidad" value="<?php echo openssl_encrypt(1, COD, KEY); ?>">
                        <button name="btnAccion" value="Add" type="submit" class="btn btn-secondary btn-sm ">Add to cart</button>
                      </form>
                    </div>
                  </div>
                  <?php } ?>
          </div>
        </div>
        
        <div class="col-md-3 order-1 mb-5 mb-md-0">
            <div class="border p-4 rounded mb-4">
              <h3 class="mb-3 h6 text-uppercase text-black d-block">Categories</h3>
              <ul class="list-unstyled mb-0">
                <li class="mb-1"><a href="#" class="d-flex"><span>Draws</span> <span class="text-black ml-auto"></span></a></li>
                <li class="mb-1"><a href="#" class="d-flex"><span>Modern</span> <span class="text-black ml-auto"></span></a></li>
                <li class="mb-1"><a href="#" class="d-flex"><span>Abstract</span> <span class="text-black ml-auto"></span></a></li>
              </ul>
            </div>

            <div class="border p-4 rounded mb-4">
              <div class="mb-4">
                <h3 class="mb-3 h6 text-uppercase text-black d-block">Learn More About Art</h3>
                
                
              </div>

              <div class="mb-4">
                <a class="mb-3 h6 text-uppercase text-black d-block" href="https://artincontext.org/" target="_blank">Here</a>
              </div>
            </div>
          </div>
      </div>
    </div>

    <!-- <div class="row" data-aos="fade-up">
              <div class="col-md-12 text-center">
                <div class="site-block-27">
                  <ul>
                    <li><a href="#">&lt;</a></li>
                    <li class="active"><span>1</span></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a href="#">&gt;</a></li>
                  </ul>
                </div>
              </div>
            </div> -->
  </div>
  </div>

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
            Copyright &copy;<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank" class="text-primary">Some handsome man</a>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </p>
          </div>
          
        </div>
      </div>
    </footer>
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>

  <script src="js/main.js"></script>

</body>

</html>