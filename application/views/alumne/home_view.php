<div class="container">
	<div class="row">
		<div class="col-lg-4 col-md-4">
			<div class="card-box">
				<div class="text-center">
					<p class="card-body-title"> <span class="card-accent"><?php echo $this->session->carnet; ?></span> </p>
					<p class="card-body-text">Permiso de conducir</p>
				</div>
			</div>
		</div>

		<div class="col-lg-4 col-md-4">
			<div class="card-box">
				<div class="text-center">
					<p class="card-body-title"> <span class="card-accent"><?php echo isset($tests_realitzats) ? $tests_realitzats : 0; ?></span> <strong>/ 30</strong> </p>
					<p class="card-body-text">Tests realizados</p>
				</div>
			</div>
		</div>

		<div class="col-lg-4 col-md-4">
			<div class="card-box">
				<div class="text-center">
					<p class="card-body-title"> <span class="card-accent"><?php echo isset($tests_aprobats) ? $tests_aprobats : 0; ?></span> / <strong><?php echo isset($tests_realitzats) ? $tests_realitzats : 0; ?></strong> </p>
					<p class="card-body-text">Tests aprobados</p>
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
					<h5>Tests realizados</h5>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<?php if(isset($tests)): ?>
						<table class="table table-sm table-hover">
							<thead>
								<tr>
									<th> </th>
									<th class="text-left">Test</th>
									<th class="text-center">Tipo de test</th>
									<th class="text-center">Fecha de realización</th>
									<th class="text-center">Resultado</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($tests as $test): ?>
								<tr style="cursor:pointer" data-id="<?php echo $test['id']; ?>" class="accordeon" data-toggle="collapse" href="#desplegar_<?php echo $test['id']; ?>">
									<td> <i class="fa fa-eye" aria-hidden="true"></i> </td>
									<td class="text-left"> <?php echo $test['nom']; ?> </td>
									<td class="text-center"> <?php echo $test['tipus']; ?> </td>
									<td class="text-center"> <?php echo $test['data_fi']; ?> </td>
									<?php
										if($test['nota'] == 'excelente') $respostaFormat = 'label-success';
										else if($test['nota'] == 'aprobado') $respostaFormat = 'label-warning';
										else if($test['nota'] == 'suspendido') $respostaFormat = 'label-danger';
									?>
									<td class="text-center"> <span class="label <?php echo $respostaFormat; ?>"> <?php echo $test['nota']; ?> </span> </td>
								</tr>
								<?php if($test['preguntes']): ?>
								<tr class="tr-no-hover">
									<td colspan="5" class="quitar-borde-superior">
										<div id="desplegar_<?php echo $test['id']; ?>" class="collapse">
											<table class="table table-condensed table-striped taula-respostes-test">
												<thead>
													<tr>
														<th> Pregunta </th>
														<th> La meva resposta </th>
														<th class="text-center"> Correcta? </th>
													</tr>
												<thead>
												<tbody>
													<?php foreach($test['preguntes'] as $pregunta): ?>
													<tr>
														<td> <?php echo $pregunta['pregunta']; ?> </td>
														<td> <?php echo $pregunta['resposta_alumne']; ?> </td>
														<?php
															if($pregunta['isCorrecta'] == 'N') 
															{
																$isCorrectaFormat = "label-danger label-resultat";
																$text = 'No';
															}
															else 
															{
																$isCorrectaFormat = 'label-success label-resultat';
																$text = 'Si';
															}
														?>
														<td class="text-center"> <span class="label <?php echo $isCorrectaFormat; ?>"><?php echo $text; ?></span> </td>
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