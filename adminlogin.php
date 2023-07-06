<?php
// ob_start();
// session_start();
include 'admindash/global/ServerConfiguration.php';
include 'admindash/global/DbConnection.php';
if(isset($_POST["login"])){
    if(!empty($_POST['email']) && !empty($_POST['password'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        //Aqui se verifica que trae la  cuenta usando el correo, si es de administradores, se usa la tabla de administradores/usuarios.
        $query = $pdo->prepare("SELECT * FROM usuarios WHERE correousuario=:email");
        $query->bindParam(":email", $email);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $passBD=$result['contrasenausuario'];
        if(!$result)
        {
            $message="La combinacion del usuario y la contraseña son invalidos";
        }

        else
        {
            if($result['correousuario']==$email)
            {
                if($password == $passBD)
                {
                    $_SESSION['session_username'] = $email;
                    $_SESSION['session_iduser'] = $result['iduser'];
                    $_SESSION['session_name'] = $result['nombreusuario'];
                    header ("Location:admindash/pages/forms/ProductRegistro.php");
                    
                }
                else
                {
                    $message= "Contraseña invalida";

                }
            }else
            {
                $message="Correo incorrecto";

            }
        }
    }
    else
    {
      $message="Todos los campos son requeridos";
    }
}?>
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
            <input type="email" for="user_login" name="email" id="email" class="input" placeholder="Email" required autofocus>
          </div>
          <div class="form-item">
            <span class="form-item-icon material-symbol-reounded">Look</span>
            <input type="password" for="user_pass" name="password" id="password" class="input" placeholder="Password" required>
          </div>

          <div class="form-item-other">
            

            
          </div>
          <div class="form-item-other">
            <?php if (!empty($message)) {
                    echo "<p class = \"error\"\">" . $message . "</p>";
                  } ?> 
          </div>
          <button type="submit" name="login" value="login">Sing In</button>
        </form>
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