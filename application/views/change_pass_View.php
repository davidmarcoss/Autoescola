<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="es" class="full">
<head>
	<title>Autoescola</title>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?php echo base_url("assets/bootstrap/css/bootstrap.css"); ?>" />
    <link rel="stylesheet" href="<?php echo base_url("assets/css/estils-login.css"); ?>" />
</head>
<body class="bodyLogin">

    <div class="container">
        <div class="login-container">
            <div class="container-titol">
                <h1 class="titol">Autoescola</h1>
            </div>
            <br/><br/>
            <div class="output">
            <?php if($this->session->flashdata()): ?>
                <?php if($this->session->flashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <?php echo $this->session->flashdata('errors') ?>
                    </div>
                <?php endif ?>
            <?php endif ?>
            </div>
            <?php if(isset($usuari) && $usuari): ?>
            <div class="form-box">
                <form method="POST" action="<?php echo site_url("LoginController/update_password") ?>">
                    <div class="form-group">
                        <label for="correu">Correo electrónico</label>
                        <input type="email" id="correu" name="correu" placeholder="correu@servidor.com" class="form-control" value="<?php echo $usuari[0]['alu_correu'] ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="password" placeholder="********" class="form-control" required>
                    </div>
                    <button class="btn btn-success btn-block" >Cambiar contraseña</button>
                </form>
            </div>
            <?php else: ?>
            <div class="form-box">
                <form method="POST" action="<?php echo site_url("LoginController/send_mail") ?>">
                    <div class="form-group">
                        <label for="correu">Correo electrónico</label>
                        <input type="email" id="correu" name="correu" placeholder="correu@servidor.com" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
                    </div>
                    <button class="btn btn-warning btn-block" >Enviar correo</button>
                </form>
            </div>
            <?php endif ?>
        </div>
    </div>

    <script type="text/javascript" src="<?php echo base_url("assets/js/jquery-3.1.1.min.js"); ?>"></script>
    <!-- Bootstrap Query -->
    <script type="text/javascript" src="<?php echo base_url("assets/bootstrap/js/bootstrap.js"); ?>"></script>
</body>
</html>