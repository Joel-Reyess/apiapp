<?php
// ob_start();
// session_start();
include 'admindash/global/ServerConfiguration.php';
include 'admindash/global/DbConnection.php';
include 'carrito.php';
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
              <a href="about.html">About</a>
            </li>
            <li><a href="shop.php">Shop</a></li>
            <li><a href="contact.html">Contact</a></li>
            <li><a href="checkout.php">Checkout</a></li>
          </ul>
        </div>
      </nav>
    </header>

    <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0"><a href="index.php">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Cart</strong></div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
      <?php if (!empty($_SESSION['CARRITO'])) {?>
        <div class="row mb-5">
            <div class="site-blocks-table">
            <form class="col-md-12" method="post">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th class="product-thumbnail">Image</th>
                    <th class="product-name">Product</th>
                    <th class="product-price">Price</th>
                    <th class="product-quantity">Quantity</th>
                    <th class="product-total">Total</th>
                    <th class="product-remove">Remove</th>
                  </tr>
                </thead>
                <tbody>
                <?php $total = 0; ?>
                    <?php foreach ($_SESSION['CARRITO'] as $indice => $producto) { ?>
                      <tr>
                        <td class="product-thumbnail">
                          <img src="<?php echo 'admindash/pages/forms/Images/' . $producto['IMAGEN'] ?>" alt="..." widtd="70" />
                        </td>
                        <td class="product-name">
                          <h2 class="h5 text-black"><?php echo $producto['NOMBRE'] ?></h2>
                        </td>
                        <td>
                          <p id="price">$ <?php echo $producto['PRECIO'] ?></p>
                        </td>
                        <td>
                          <div class="product_count" id="<?php echo $indice; ?>">
                            <span class="input-number-decrement"> <i class="ti-minus"></i></span>
                            <input class="" type="number" id="quantity" value="<?php echo $producto['CANTIDAD'] ?>" min="0" max="10">
                            <span class="input-number-increment"> <i class="ti-plus"></i></span>
                          </div>
                        </td>
                        <td class="total-pr">
                          <p id="total">$ <?php echo number_format($producto['PRECIO'] * $producto['CANTIDAD'], 2); ?></p>
                        </td>
                        <td class="">
                          <form action="" method="post">
                            <input type="hidden" name="id" id="id" value="<?php echo openssl_encrypt($producto['ID'], COD, KEY); ?>">
                            <button class="btn btn-danger" name="btnAccion" value="Eliminar">Eliminar</button>
                          </form>
                        </td>
                      </tr>
                      <?php $total = $total + ($producto['PRECIO'] * $producto['CANTIDAD']); ?>
                    <?php } ?>
                 
                </tbody>
              </table>
              </form>
            </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="row mb-5">
              <div class="col-md-6">
              <form action="paypalpago.php" method="post">
                                <button class="btn btn-outline-primary btn-sm btn-block" type="submit" 
                                name="btnAccion"
                                value="proceder">
                                    Proceder a pagar 
                                </button>

                          </form>
              </div>
            </div>
          </div>
          <div class="col-md-6 pl-5">
            <div class="row justify-content-end">
              <div class="col-md-7">
                <div class="row">
                  <div class="col-md-12 text-right border-bottom mb-5">
                    <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
                  </div>
                </div>
          
                <div class="row mb-5">
                  <div class="col-md-6">
                    <span class="text-black">Total</span>
                  </div>
                  <div id="precioTotal">$<?php echo number_format($total,2); ?></div>
                </div>

                <?php
              if (isset($_SESSION["session_username"])) { //we check if the session username variable has infromation
                //if it does we display a button that says FINALIZAR PEDIDO,
                //it will be executed the form action pedir.php code so the order goes to the database
                echo '<form action="pedir.php" method="post">
                <input type="hidden" name="help" id="help" value="">
                <div class="bg-light px-4 py-3">
                <div class="row align-items-center text-center">
                <div class="row mb-5">
                <div class="col-md-12">
                  <button class="btn btn-outline-primary btn-sm btn-block" href="shop.php">Continue Shopping</button>
                </div>
              </div>
              
                  <div class="col-md-6 text-md-end"><button class="btn btn-outline-dark btn-sm" class="bg-dark" type="submit" name="btnAccion" value="proceder" href="checkout.php">Proceder al pedido<i class="fas fa-long-arrow-alt-right ms-2"></i></button></div>
                </div>
                </div>
              </div>
                </form>';
              }else {
                //but if user is not logged it, we take him to the loggin page using another form action
                //the button looks the same but we redirect the user to loggin page instead 
                echo '<form action="login.php" method="post">
                <div class="bg-light px-4 py-3">
                <div class="row align-items-center text-center">
                <div class="row mb-5">
                <div class="col-md-6">
                  <button class="btn btn-outline-primary btn-sm btn-block" href="shop.php">Continue Shopping</button>
                </div>
              </div>
                  <div class="col-md-6 text-md-end"><div class="row">
                  <div class="col-md-12">
                    <button class="btn btn-primary btn-lg py-3 btn-block" type="submit" name="btnAccion" value="proceder" href="checkout.php">Proceed To Checkout</button>
                  </div>
                </div></div>
                </div>
              </div>
                </form>';
              }
              
            ?>
              </div>
            </div>
          </div>
        </div>
        <?php }else{ ?>
      <div class="alert alert-success">
        No hay productos en el carrito..
      </div>
      <?php } ?>
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
  </div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>

  <script src="js/main.js"></script>
  <script>
    const quantities = document.querySelectorAll("#quantity");
    const prices = document.querySelectorAll("#total");

    document.addEventListener("DOMContentLoaded", ()=>{
        quantities.forEach(quantity => {
            quantity.value = 1;
            actualizarValue();
        });
    });

    quantities.forEach(quantity => {
        quantity.addEventListener("change", ()=>{
            //Poner precios dinamicos
            const price = quantity.parentElement.parentElement.parentElement.querySelector("#price");
            const total = quantity.parentElement.parentElement.parentElement.querySelector("#total");
            const id = quantity.parentElement.id;
            total.textContent = "$ " + (quantity.value) * (price.textContent.replace("$ ", "").replace(".00", "")) + ".00";

            //Intento de actualizar
            actualizarValue();
            actualizarTotal();
        })
    });

    function actualizarTotal() {
        let total = 0;
        const precioTotal = document.querySelector("#precioTotal");
        prices.forEach(price => {
           total+= parseInt(price.textContent.replace("$ ", ""));
        });
        precioTotal.textContent = "$"+total+".00";
    }
    function actualizarValue() {
        const help = document.querySelector("#help");
        help.value = "";
        document.querySelectorAll("#quantity").forEach(element => {
            const id = element.parentElement.id;
            help.value += id+"-"+element.value+"/";
        });
    }
      </script>
  </body>
</html>