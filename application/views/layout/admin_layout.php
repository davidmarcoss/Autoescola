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
                <a class="navbar-brand" href="#">Autoescola</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="<?php echo site_url('admin/GestioHomeController/index'); ?>">Inicio</a></li>
                    <?php if($this->session->rol == 'admin'): ?>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"> Gestión de usuarios<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                        <li><a href="<?php echo site_url('admin/GestioProfessorsController/index'); ?>"> Profesores </a></li>
                        <li><a href="<?php echo site_url('admin/GestioAlumnesController/index'); ?>"> Alumnos </a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo site_url('admin/GestioTestsController/index'); ?>">Gestión de tests</a></li>
                    <li><a href="<?php echo site_url('admin/GestioCarnetsController/index'); ?>">Gestión de carnets</a></li>
                    <?php endif ?>
                    <li><a href="<?php echo site_url('admin/GestioPractiquesController/index'); ?>">Gestión de prácticas</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <?php echo $this->session->nom; ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a class="text-muted"> <?php echo $this->session->correu; ?> </a></li>
                            <li><a href="#">Ajustes</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="<?php echo site_url('HomeController/logout'); ?>" class="cerrar-sesion"> Cerrar sesión </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

	<div class="messages-container">
        <div class="container">
            <?php if($this->session->flashdata('errors')): ?>
                <div class="alert alert-danger">
                    <?php echo $this->session->flashdata('errors') ?>
                </div>
            <?php endif ?>
        </div>

        <div class="container">
            <?php if($this->session->flashdata('exits')): ?>
                <div class="alert alert-success">
                    <?php echo $this->session->flashdata('exits') ?>
                </div>
            <?php endif ?>
        </div>

        <?php $this->load->view($content); ?>
	</div>


	<!-- Bootstrap Query -->
	<script type="text/javascript" src="<?php echo base_url("assets/bootstrap/js/bootstrap.min.js"); ?>"></script>
</body>
</html>