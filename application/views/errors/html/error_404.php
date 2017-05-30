<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	$base_url = load_class('Config')->config['base_url'];
	$img = $base_url . '/assets/img/error404.jpg';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>404 Page Not Found</title>
<style type="text/css">
	.body404 {
		background: url('<?php echo $img; ?>') no-repeat center center fixed;
		-webkit-background-size: cover;
		-moz-background-size: cover;
		background-size: cover;
		-o-background-size: cover;
	}
</style>
</head>
<body class="body404">

</body>
</html>