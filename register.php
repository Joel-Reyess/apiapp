<?php
include 'admindash/global/ServerConfiguration.php';
include 'admindash/global/DbConnection.php';
session_start();
//we check if th button register has a value
if (isset($_POST["register"])) 
{
  //check if the form fields are not empty 
  if (isset($_POST['name']) && !empty($_POST['lastname']) && !empty($_POST['email']) && !empty($_POST['pass'])) 
  {   //save the form fields values into variables
    $txtname = $_POST['name'];
    $txtlastname = $_POST['lastname'];
    $txtemail = $_POST['email'];
    $password = $_POST['pass'];
    

    //here we have the password into another variavble BECAUSE we encrypt it 
    //Make sure your password field  IN YOUR DATABASE is type CHAR and 255 characters
    //the password has functions needs the information to encrypt and the algoritm to hash the password,
    //after that, you save it into $password_hash
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    //Before we save the new client, we check if this client has registered already using the email 
    //We attempt to select the client that matches the email form field we got 
    $query = $pdo->prepare("SELECT * FROM clientes WHERE correocliente=:email");
    $query->bindParam(":email", $txtemail);
    $query->execute();
    //if we find match, then show a message to the client that email is alredy using the email 
    if ($query->rowCount() >0) 
    {
      $message = '<p class="error"> "El correo ya se encuentra registrado"</p>';
    }
    //but if the query is equal to 0, not null or something different 
    else if ($query->rowCount() == 0) 
    {

      //we start the client registration starting the query to insert  the client data into tha database 
      $query = $pdo->prepare("INSERT INTO clientes (nombrecliente, apellidocliente, correocliente, contrasenacliente, fecharegistro) VALUES
      (:names, :lastname, :addresss, :password_hash, now());");
      $query->bindParam(":names", $txtname);
      $query->bindParam(":lastname", $txtlastname);
      $query->bindParam(":addresss", $txtemail);
      $query->bindParam(":password_hash", $password_hash);
      
      //watch out! here you have to send the encrypted password
      $result = $query->execute();
      //if it was succesfully registed into the database, show the following message
      if ($result) {
        $message = "Cuenta creada correctamente";
      } //bit if no, show an error message 
     else 
      {
      $message = "Error al ingresar los datos, intetna de nuevo!";
      }
   }
  }   //if the form fields are empty show this message 
  else 
  {
    $message = "Intentaste enviar el formulario vacio";
  }
}     //if the button doesn't have any value (not clicked) we do nothing here
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

        <form class="login-card-form" name="registerform" id="registerform" method="POST" enctype="multipart/form-data">

            <div class="form-item">
              <label >Name</label>
              <input type="text" for="user_pass" class="form-control" name="name" id="name" placeholder="Name" value="" class="input" required>
            </div>
            <div class="form-item">
              <label >Last Name</label>
              <input type="text" for="user_pass" class="form-control" name="lastname" id="lastname" placeholder="Last Name" value="" class="input" required>
            </div>
            <div class="form-item">
              <label >Email</label>
              <input type="email" for="user_pass" class="form-control" name="email" id="email" placeholder="Email" value="" class="input" required>
            </div>
            <div class="form-item">
              <label >Password</label>
              <input type="password" for="user_pass" class="form-control" name="pass" id="pass" placeholder="Password" value="" class="input" required onChange="onChange()">
            </div>
            <div class="form-item">
              <label >Confirm Password</label>
              <input type="password" for="user_pass" class="form-control" name="confirm-pass" id="confirm-pass" placeholder="Confirm Password" value="" class="input" required onChange="onChange()">
            </div>
            

            <div class="checkbox">
              <a href="login.php">Sing In</a>
            </div>
            <div class="form-item-other" id="message">
        <!-- <?php if(!empty($message)){echo "<p class = \"error\"\">" . $message."</p>";}?> -->
      </div>
              <button type="submit" name="register" id="register" value="register">Submit</button>

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
    
  	<!-- check password confirmation -->
	<script>
		$(() => {
			$('#pass, #confirm-pass').on('keyup', function () {
				if ($('#pass').val() == "" && $('#confirm-pass').val() == "") {
					$('#register').prop('disabled', true);
					$('#message').hide();
				} else if ($('#pass').val() == $('#confirm-pass').val()) {
					$('#register').prop('disabled', false);
					$('#message').show().html('Passwords match').css('color', 'green');
				} else {
					$('#register').prop('disabled', true);
					$('#message').show().html('Passwords not match').css('color', 'red');
				}
			});
		});
	</script>
  </body>
</html>