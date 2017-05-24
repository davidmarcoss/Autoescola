<div class="container">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Inicio</li>
    </ol>
</div>

<div class="container">
	<div class="row">
		<div class="col-lg-4 col-md-4 col-xs-12">
			<div class="card-box">
				<div class="text-center">
					<p class="card-body-title"> <span class="card-accent"><?php echo $this->session->carnet; ?></span> </p>
					<p class="card-body-text">Permiso de conducir</p>
				</div>
			</div>
		</div>

		<div class="col-lg-4 col-md-4 col-xs-12">
			<div class="card-box">
				<div class="text-center">
					<p class="card-body-title"> <span class="card-accent"><?php echo isset($tests_realitzats) ? $tests_realitzats : 0; ?></span> / <strong> 30</strong> </p>
					<p class="card-body-text">Tests realizados</p>
				</div>
			</div>
		</div>

		<div class="col-lg-4 col-md-4 col-xs-12">
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
					<h4>Tests realizados</h4>
				</div>
				<div class="panel-body">
					<form id="form-alumne-tests" class="form-inline" method="post" action="<?php echo site_url('HomeController/index') ?>">
						<div class="form-group">
							<label for="filtre-alumne-tests" class="sr-only">Filtro de búsqueda </label>
							<select class="form-control" name="filtre-alumne-tests" id="filtre-alumne-tests">
								<option value=""> Selecciona un filtro... </option>
								<option value="data_fi"> Fecha de realización &darr; </option>
								<option value="aprobado"> Tests aprobados </option>
								<option value="suspendido"> Tests suspendidos </option>
							</select>
						</div>
						<div class="form-group" id="div-limpiar-filtros">
						</div>
					</form>
					<hr/>
					<?php if($tests && isset($tests)): ?>
					<div class="table-responsive col-md-12">
						<table class="table table-sm table-hover">
							<thead>
								<tr>
									<th> </th>
									<th class="text-center">Test</th>
									<th class="text-center">Tipo de test</th>
									<th class="text-center">Fecha de realización</th>
									<th class="text-center">Resultado</th>
								</tr>
							</thead>
							<tbody id="taula-tests-body">
							<?php foreach($tests as $test): ?>
								<tr style="cursor:pointer" data-id="<?php echo $test['alu_test_id']; ?>" class="accordeon" data-toggle="collapse" href="#desplegar_<?php echo $test['alu_test_id']; ?>">
									<td class="text-center"> <i class="fa fa-eye" aria-hidden="true"></i> </td>
									<td class="text-center"> <?php echo $test['test_nom']; ?> </td>
									<td class="text-center"> <?php echo $test['test_tipus']; ?> </td>
									<td class="text-center"> <?php echo $test['alu_test_data_fi']; ?> </td>
									<?php
										if($test['alu_test_nota'] == 'excelente') $respostaFormat = 'label-success';
										else if($test['alu_test_nota'] == 'aprobado') $respostaFormat = 'label-warning';
										else if($test['alu_test_nota'] == 'suspendido') $respostaFormat = 'label-danger';
									?>
									<td class="text-center"> <span class="label <?php echo $respostaFormat; ?>"> <?php echo $test['alu_test_nota']; ?> </span> </td>
								</tr>
								<?php if($test['preguntes']): ?>
								<tr class="tr-no-hover">
									<td colspan="5" class="quitar-borde-superior">
										<div id="desplegar_<?php echo $test['alu_test_id']; ?>" class="collapse">
											<table class="table table-condensed taula-respostes-test">
												<thead>
													<tr>
														<th> Pregunta </th>
														<th> La meva resposta </th>
														<th class="text-center"> Correcta? </th>
													</tr>
												</thead>
												<tbody>
													<?php foreach($test['preguntes'] as $pregunta): ?>
													<tr>
														<td> <?php echo $pregunta['preg_pregunta']; ?> </td>
														<td> <?php echo $pregunta['alu_resp_resposta_alumne']; ?> </td>
														<?php
															if($pregunta['alu_resp_isCorrecta'] == 'N') 
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
						<div class="text-center"><?php echo $this->pagination->create_links() ?></div>
					</div>
					<?php else: ?>
							<p class="text-muted"><b>No se han encontrado tests realizados.</b></p> 
							<a class="btn btn-autoescola" href="<?php echo site_url('TestsController/index'); ?>">REALIZAR TESTS</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	var site_url = "<?php echo site_url('HomeController/index') ?>";
	var site_url_filtre = "<?php echo site_url('HomeController/filtres_ajax') ?>";
</script>