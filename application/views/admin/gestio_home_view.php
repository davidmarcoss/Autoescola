	<div class="container">
	<div class="row">
		<div class="col-lg-4 col-md-4">
			<div class="card-box">
				<div class="text-center">
					<p class="card-body-title"> <strong><?php echo isset($estadistiques_respostes['count']) ? $estadistiques_respostes['count'] : 0; ?></strong> </p>
					<p class="card-body-text"> Total respostes usuaris </p>
				</div>
			</div>
		</div>

		<div class="col-lg-4 col-md-4">
			<div class="card-box">
				<div class="text-center">
					<p class="card-body-title"> <span class="card-accent"><?php echo isset($estadistiques_respostes['correctes']) ? $estadistiques_respostes['correctes'] : 0; ?></span>  </p>
					<p class="card-body-text"> Respostes correctes </p>
				</div>
			</div>
		</div>

		<div class="col-lg-4 col-md-4">
			<div class="card-box">
				<div class="text-center">
					<p class="card-body-title"> <span class="card-accent" style="color: red"><?php echo isset($estadistiques_respostes['incorrectes']) ? $estadistiques_respostes['incorrectes'] : 0; ?></span> </p>
					<p class="card-body-text"> Respostes incorrectes </p>
				</div>
			</div>
		</div>
	</div>
</div>

<br/>

<div class="container">
	<div class="row">
		
	</div>
</div>