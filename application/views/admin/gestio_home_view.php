<div class="container">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Estadísticas Autoboxx</li>
    </ol>
</div>

<div class="container">
	<div class="row">
		<div class="col-lg-4 col-md-4">
			<div class="card-box">
				<div class="text-center">
					<p class="card-body-title"> <strong><?php echo isset($estadistiques_respostes['count']) ? $estadistiques_respostes['count']-1 : 0; ?></strong> </p>
					<p class="card-body-text"> Total de respuetas de nuestros alumnos </p>
				</div>
			</div>
		</div>

		<div class="col-lg-4 col-md-4">
			<div class="card-box">
				<div class="text-center">
					<p class="card-body-title"> <span class="card-accent"><?php echo isset($estadistiques_respostes['correctes']) ? $estadistiques_respostes['correctes'] : 0; ?></span>  </p>
					<p class="card-body-text"> Respuestas correctas </p>
				</div>
			</div>
		</div>

		<div class="col-lg-4 col-md-4">
			<div class="card-box">
				<div class="text-center">
					<p class="card-body-title"> <span class="card-accent" style="color: red"><?php echo isset($estadistiques_respostes['incorrectes']) ? $estadistiques_respostes['incorrectes'] : 0; ?></span> </p>
					<p class="card-body-text"> Respuestas incorrectas </p>
				</div>
			</div>
		</div>
	</div>
</div>

<br/>

<?php if(isset($alumnes) && $alumnes): ?>
<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>  Informe de usuarios y sus tests  </h4>
		</div>
		<div class="panel-body">
			<form method="post" action="<?php echo site_url('api/AutoboxxWebservice/jasper') ?>">
				<select name="alumnes[]" multiple="multiple" class="form-control" size=10>
					<?php foreach($alumnes as $alumne): ?>
						<option value="<?php echo $alumne['alu_nif'] ?>"><?php echo $alumne['alu_nom'] . ' , ' . $alumne['alu_cognoms'] ?></option>
					<?php endforeach ?>
				</select>
				<span class="text-muted">Selecciona varios usuarios con Ctrl + Click</span>
				<br/><br/>
				<button type="submit" class="btn btn-autoescola">Consultar</button>
			</form>
		</div>
	</div>
</div>
<?php endif ?>

<br/>

<div class="container">
	<div class="row">
		
	</div>
</div>