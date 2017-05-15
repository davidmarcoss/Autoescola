<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Autoescola</title>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?php echo base_url("assets/bootstrap/css/bootstrap.css"); ?>" />
    <link rel="stylesheet" href="<?php echo base_url("assets/css/main.css"); ?>" />
    <link rel="stylesheet" href="<?php echo base_url("assets/font-awesome/css/font-awesome.css"); ?>" />
</head>
<body>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Autoescola</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="#">Inicio</a></li>
                    <li><a href="#">Gestión de usuarios</a></li>
                    <li><a href="#">Gestión de tests</a></li>
                    <li><a href="#">Gestión de prácticas</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> John Doe <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a class="text-muted">johndoe@gmail.com</a></li>
                            <li><a href="#">Ajustes</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#" class="cerrar-sesion"> Cerrar sesión </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

	<div class="container">
        <?php $this->load->view($content); ?>
	</div>

    <script type="text/javascript" src="<?php echo base_url("assets/js/jquery-3.1.1.min.js"); ?>"></script>
	<!-- Bootstrap Query -->
	<script type="text/javascript" src="<?php echo base_url("assets/bootstrap/js/bootstrap.min.js"); ?>"></script>
</body>
</html>