<div class="container">
	<div class="row">
		<div class="col-lg-4 col-md-4">
			<div class="card-box">
				<div class="text-center">
					<p class="card-body-title"> <span class="card-accent"> <?php echo isset($tests_realitzats) ? $tests_realitzats : 0; ?> </span> / 30 </p>
					<p class="card-body-text">Mis tests realizados</p>
				</div>
			</div>
		</div>

		<div class="col-lg-4 col-md-4">
			<div class="card-box">
				<div class="text-center">
					<p class="card-body-title"> <span class="card-accent"> <?php echo isset($tests_aprobats) ? $tests_aprobats : 0; ?> </span> / <?php echo isset($testsCount) ? $testsCount : 0; ?> </p>
					<p class="card-body-text">Mis tests aprobados</p>
				</div>
			</div>
		</div>

		<div class="col-lg-4 col-md-4">
			<div class="card-box">
				<div class="text-center">
					<p class="card-body-title"> <span class="card-accent"> Intersecciones </span> </p>
					<p class="card-body-text">Temática de preguntas mas acertada!</p>
				</div>
			</div>
		</div>
	</div>
</div>

<br/>

<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h5>Mis tests realizados</h5>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<?php if(isset($tests)): ?>
						<table class="table table-sm table-hover">
							<thead>
								<tr>
									<th>#</th>
									<th>Tipo de test</th>
									<th>Fecha de realización</th>
									<th>Resultado</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($tests as $test): ?>
								<tr style="cursor:pointer" data-id="<?php echo $test['id']; ?>" class="accordeon" data-toggle="collapse" href="#desplegar_<?php echo $test['id']; ?>">
									<td> <?php echo $test['nom']; ?> </td>
									<td> <?php echo $test['tipus']; ?> </td>
									<td> <?php echo $test['data_inici']; ?> </td>
									<?php
										if($test['nota'] == 'excelente') $respostaFormat = 'label-success';
										else if($test['nota'] == 'aprobado') $respostaFormat = 'label-warning';
										else if($test['nota'] == 'suspendido') $respostaFormat = 'label-danger';
									?>
									<td> <span class="label <?php echo $respostaFormat; ?>"> <?php echo $test['nota']; ?> </span> </td>
								</tr>
								<?php if($test['preguntes']): ?>
								<tr class="tr-no-hover">
									<td colspan="4" class="quitar-borde-superior">
										<div id="desplegar_<?php echo $test['id']; ?>" class="collapse">
											<table class="table taula-respostes-test">
												<thead>
													<tr>
														<th> Pregunta </th>
														<th> La meva resposta </th>
														<th> Correcta? </th>
													</tr>
												<thead>
												<tbody>
													<?php foreach($test['preguntes'] as $pregunta): ?>
													<tr>
														<td> <?php echo $pregunta['pregunta']; ?> </td>
														<td> <?php echo $pregunta['resposta_alumne']; ?> </td>
														<td> <?php echo $pregunta['isCorrecta']; ?> </td>
													</tr>
													<?php endforeach; ?>
												</tbody>
											</table>
										</div>
									</td>
								</tr>
								<?php endif; ?>
							<?php endforeach; ?>
							</tbody>
						</table>
						<?php else: ?>
							<p class="text-muted">No has realitzat cap test</p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>