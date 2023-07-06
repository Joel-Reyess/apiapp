<?php
//ob_start();
include 'admindash/global/ServerConfiguration.php';
include 'admindash/global/DbConnection.php';
session_start();

include('configuracion.php');

$login_button = '';
if(!isset($_SESSION['access_token'])){
  $login_button = $google_client->createAuthUrl();
}

if (isset($_POST["login"])) {
  if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = $pdo->prepare("SELECT * FROM clientes WHERE correocliente = :email");
    $query->bindParam(":email", $email);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $passDB = $result['contrasenacliente'];
    var_dump($passDB);
    var_dump($password);
    var_dump(password_verify($password,$passDB ));
    if (!$result) {
      $message = '<p class="error">El correo o la contraseña son incorrectos</p>';
    } else {
      if ($result['correocliente'] == $email) {
        if (password_verify($password, $passDB)) {
          $_SESSION['session_username'] = $email;
          $_SESSION['session_idcliente'] = $result['idcliente'];
          $_SESSION['session_name'] = $result['nombrecliente'];
          echo "<script> alert('Ingresaste correctamente')</script>";
          header("Location: index.php");
        } else {
          $message = "Contraseña incorrecta";
        }
      } else {
        $message = "Correo incorrecto";
      }
    }
  } else {
    $message = "Todos los campos son requeridos";
  }
}
?>
<?php
/*
//start session on web page
session_start();

//config.php

//Include Google Client Library for PHP autoload file
require_once 'vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.0 Client ID | Copiar "ID DE CLIENTE"
$google_client->setClientId('103296365991-np4pk9e2uacj8uvkdel3frflravigsmr.apps.googleusercontent.com');

//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('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');

//Set the OAuth 2.0 Redirect URI | URL AUTORIZADO
$google_client->setRedirectUri('http://localhost/apiapp/index.php');

// to get the email and profile 
$google_client->addScope('email');

$google_client->addScope('profile');

$login_button = '';
if (!isset($SESSION['access_token'])) {
  $login_button = $google_client->createAuthUrl();
}
*/
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>MemeWorld! &mdash; </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="google-signin-client_id" content="103296365991-np4pk9e2uacj8uvkdel3frflravigsmr.apps.googleusercontent.com">

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

<body class="sesionin">

  <div class="site-wrap">


    <div class="login-card-container">
      <div class="login-card">
        <div class="login-card-logo">
          <div class="shit2">
            <a href="index.php" class="chilli">MemeWorld!</a>
          </div>
        </div>
        <div class=""></div>
        <h2></h2>

        <form class="login-card-form" name="loginform" id="loginform" action="" method="POST">
          <div class="form-item">
            <span class="form-item-icon material-symbols-rounded"></span>
            <input type="email" for="user_login" name="email" id="email" class="input" placeholder="Email">
          </div>
          <div class="form-item">
            <span class="form-item-icon material-symbol-reounded"></span>
            <input type="password" for="user_pass" name="password" id="password" class="input" placeholder="Password">
          </div>

          <div class="form-item-other">
            <div class="checkbox">
              <a href="register.php">Sing Up</a>
            </div>

            <div>
              <a href="adminlogin.php">Are you an administrator?</a>
            </div>
          </div>
          <div class="form-item-other">
            <?php if (!empty($message)) {
                    echo "<p class = \"error\"\">" . $message . "</p>";
                  } ?> 
          </div>
          <button type="submit" name="login" value="login">Sign In</button>
           
        </form>
        <a id="shit" href="<?php echo $login_button ?>"><img class="google-btn" id="googlelink" src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg"/></a>
        <?php
                    if ($login_button == '') {
                       // echo '<div class="card-header">Welcome User</div><div class="card-body">';
                       // echo '<img src="' . $_SESSION["user_image"] . '" class="rounded-circle container"/>';
                       // echo '<h3><b>Name :</b> ' . $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name'] . '</h3>';
                       // echo '<h3><b>Email :</b> ' . $_SESSION['user_email_address'] . '</h3>';
                       // echo '<h3><a href="logout.php">Logout</h3></div>';
                    } else {
                       // echo '<div align="center">' . $login_button . '</div>';
                    }
                    ?>
      </div>
    </div>


    <!-- footer -->

  </div>

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