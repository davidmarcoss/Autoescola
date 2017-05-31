<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="es" class="full">
<head>
	<title>Autoescola</title>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?php echo base_url("/assets/bootstrap/css/bootstrap.css"); ?>" />
    <link rel="stylesheet" href="<?php echo base_url("/assets/css/estils-login.css"); ?>" />
    <link rel="stylesheet" href="<?php echo base_url("/assets/font-awesome/css/font-awesome.min.css"); ?>" />
</head>
<body class="bodyLogin">
    <div class="container">
        <div class="login-container">
            <div class="container-titol">
                <h1 class="titol">Autoboxx</h1>
            </div>
            <br/><br/>
            <div class="output">
            <?php if($this->session->flashdata()): ?>
                <?php if($this->session->flashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <?php echo $this->session->flashdata('errors') ?>
                    </div>
                <?php endif ?>
                <?php if($this->session->flashdata('exits')): ?>
                    <div class="alert alert-success">
                        <?php echo $this->session->flashdata('exits') ?>
                    </div>
                <?php endif ?>
            <?php endif ?>
            </div>
            <div class="form-box">
                <form method="POST" action="<?php echo site_url("LoginController/login") ?>">
                    <div class="form-group">
                        <label for="correu">Correo electrónico</label>
                        <input type="email" id="correu" name="correu" placeholder="correu@servidor.com" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="password" placeholder="********" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-block" name="btnLogin">Entrar</button>
                    <br/>
                    <a name="btnCanviarPassword" href="<?php echo site_url('LoginController/request_mail'); ?>">Has olvidado la contraseña?</a>
                </form>
            </div>
        </div>
        <a href="#map"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
    </div>

    <div>
        <div id="map" style="width: 100%; height: 400px; margin: 0px; margin-top: 300px"></div>
    </div>

    <script type="text/javascript" src="<?php echo base_url("assets/js/jquery-3.1.1.min.js"); ?>"></script>
    <!-- Bootstrap Query -->
    <script type="text/javascript" src="<?php echo base_url("assets/bootstrap/js/bootstrap.js"); ?>"></script>

    <script type="text/javascript">
        function initMap()
        {
            var lat = 41.4991378;
            var long = 1.8096872;

            var locations = ['Masquefa', '41.4991378', '1.8096872'];
            console.info(locations);


            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                scrollwheel: false,
                center: new google.maps.LatLng(lat, long),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            var infowindow = new google.maps.InfoWindow();

            var marker;

            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[1], locations[2]),
                map: map
            });

            google.maps.event.addListener(marker, 'click', (function(marker) {
                return function() {
                    infowindow.setContent('<b>Autoboxy</b> <br/> <span class="text-muted">'+locations[0]+'</span> <br/> <span class="text-muted">Xic de lAnyè 28</span>');
                    infowindow.open(map, marker);
                }
            })(marker));
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyABPwZde8h1cSRUF3VS3DFoUO9CJVS0M78&callback=initMap"></script>
</body>
</html>
