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
    <script type="text/javascript" src="<?php echo base_url("assets/js/jquery-3.1.1.min.js"); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url("assets/js/app.js"); ?>"></script>
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
                <a class="navbar-brand" href="<?php echo site_url('HomeController/index'); ?>">Autoboxx</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="<?php echo site_url('HomeController/index'); ?>"><b>INICIO</b></a></li>
                    <li><a href="<?php echo site_url('TestsController/index'); ?>"><b>TESTS</b></a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <b><?php echo $this->session->nom; ?></b> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a class="text-muted"><?php echo $this->session->correu; ?></a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="<?php echo site_url('HomeController/logout'); ?>" class="cerrar-sesion"> Cerrar sesión </a></li>
                        </ul>
                    </li>
                    <a href="<?php echo site_url('api/AutoboxxWebservice/results/B/'.$this->session->token) ?>" class="btn btn-autoescola" style="margin-top: 8px">Consultar resultats</a>
                </ul>
            </div>
        </div>
    </nav>


    <?php $this->load->view($content); ?>

   
	<!-- Bootstrap Query -->
	<script type="text/javascript" src="<?php echo base_url("assets/bootstrap/js/bootstrap.min.js"); ?>"></script>
</body>
</html>