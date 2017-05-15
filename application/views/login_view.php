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
    <!--<nav class="navbar navbar-default navbar-static-top">
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
        </div>
    </nav>-->

    <div class="container container-titol">
        <h1 class="titol">Autoescola</h1>
    </div>

    <div class="container">
        <div class="login-container">
            <div id="output"></div>
            <div class="avatar"></div>
            <div class="form-box">
                <form method="POST" action="<?php echo site_url("LoginController/login") ?>">
                    <div class="form-group">
                        <label for="correu">Correo electrónico</label>
                        <input type="email" id="correu" name="correu" placeholder="correu@servidor.com" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="password" placeholder="********" minlength="4" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-block" name="btnLogin">Entrar</button>
                    <br/>
                    <a name="btnCanviarPassword" href="#">Has oblidat la contrassenya?</a>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="<?php echo base_url("assets/js/jquery-3.1.1.min.js"); ?>"></script>
    <!-- Bootstrap Query -->
    <script type="text/javascript" src="<?php echo base_url("assets/bootstrap/js/bootstrap.js"); ?>"></script>
</body>
</html>