<!-- <?php
<div class="container">
<div class="row">
    <div class="col-4">
        <h4>Proceed to pay</h4>
        <div id="paypal-button-container"></div>
    </div>
    <div class="col-8">

    <script src="https://www.paypal.com/sdk/js?client-id=AaxK6qKq30WlMSwDuiCYx53f26bRbNBRT08c0X3AH5S8cZzwj8Ea-XM0LDWVIAgUHdGcnOaeN8_cGuz_&currency=MXN">
                                </script>
                                <script>
                                    
                                    paypal.Buttons({
                                        style: {
                                            color: 'blue',
                                            shape: 'pill',
                                            label: 'pay',
                                            height: 40

                                        },
                                        createOrder: function(data, actions) {
                                            return actions.order.create({
                                                purchase_units: [{
                                                    amount: {
                                                        value: <?php echo $cadventa['totalventa'];?>
                                                    }
                                                }]
                                            });
                                        },
                                        onApprove: function(data, actions) {
                                            let URL = 'clases/captura.php'
                                            actions.order.capture().then(function(detalles) {
                                                console.log(detalles)
                                                let url = 'clases/captura.php'
                                                window.location.href = 'order-complete.php'
                                                return fetch(url, {
                                                    method: 'post',
                                                    headers: {
                                                        'content-type': 'application/json'
                                                    },
                                                    body: JSON.stringify({
                                                        detalles: detalles
                                                    })
                                                })
                                            });
                                        },
                                        onCancel: function(data) {
                                            alert("Pago cancelado");
                                            console.log(data);
                                        }
                                    }).render("#paypal-button-container");
                                </script>
  /*require_once 'configuracion.php';

// authenticate code from Google OAuth Flow
/*if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($token['access_token']);
  
  // get profile info
  $google_oauth = new Google_Service_Oauth2($client);
  $google_account_info = $google_oauth->userinfo->get();
  $email =  $google_account_info->email;
  $name =  $google_account_info->name;
 
  // now you can use this profile info to create account in your website and make user logged in.
}
?>*/