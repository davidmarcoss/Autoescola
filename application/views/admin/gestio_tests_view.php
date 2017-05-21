<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h5 style="display: inline-block">Importación de tests</h5>
				</div>
                <div class="panel-body">
                    <form method="post" action="<?php echo site_url('admin/GestioTestsController/upload') ?>" enctype="multipart/form-data">
                        <div class="form-group col-xs-4 col-md-4">
                            <label for="codi">Codigo del test</label>
                            <input type="text" name="codi" id="codi" class="form-control input-sm" placeholder="TEST0001" required>
                        </div>
                        <div class="form-group col-xs-4 col-md-4">
                            <label for="nom">Nombre</label>
                            <input type="text" name="nom" id="nom" class="form-control input-sm" placeholder="TEST 0001" required>
                        </div>
                        <?php if(isset($carnets) && $carnets): ?>
                        <div class="form-group col-xs-2 col-md-2">
                            <label for="carnet">Tipo de carnet</label>
                            <select name="carnet" id="carnet" class="form-control input-sm" required>
                                <?php foreach($carnets as $carnet): ?>
                                    <option value="<?php echo $carnet['codi'] ?>"> <?php echo $carnet['codi'] ?> </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group col-xs-2 col-md-2">
                            <label for="tipus">Tipo de test</label>
                            <select name="tipus" id="tipus" class="form-control input-sm" required>
                                    <option value="basico"> Basico </option>
                                    <option value="avanzado"> Avanzado </option>
                                    <option value="examen"> Examen </option>
                            </select>
                        </div>
                        <?php endif ?>
                        <div class="form-group col-xs-12 col-md-12">
                            <label for="rar-file">Importación de preguntas</label>
                            <input type="file" class="filestyle input-sm" name="rar-file" id="rar-file" required>
                            <small id="fileHelp" class="form-text text-muted">
                                Solamente está permitido un archivo .zip (Debe contener .csv con preguntas e imagenes). <br/>
                            </small>
                        </div>
                        <div class="col-xs-12 col-md-12">
                            <button type="submit" class="btn btn-success btn-sm pull-right">Importar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h5 style="display: inline-block">Tests importados</h5>
				</div>
                <div class="panel-body">
                    <?php if($tests): ?>
                    <table class="table table-striped table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>Codi</th>
                                <th class="text-center">Nom</th>
                                <th class="text-center">Tipus</th>
                                <th class="text-center">Carnet</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($tests as $test): ?>
                                <tr style="cursor:pointer" data-id="<?php echo $test['codi']; ?>" class="accordeon" data-toggle="collapse" href="#desplegar_<?php echo $test['codi']; ?>">
                                    <td> <?php echo $test['codi'] ?> </td>
                                    <td class="text-center"> <?php echo $test['nom'] ?> </td>
                                    <td class="text-center"> <?php echo $test['tipus'] ?> </td>
                                    <td class="text-center"> <?php echo $test['carnet_codi'] ?> </td>
                                </tr>
								<?php if($test['preguntes']): ?>
								<tr class="tr-no-hover">
									<td colspan="5" class="quitar-borde-superior">
										<div id="desplegar_<?php echo $test['codi']; ?>" class="collapse">
											<table class="table table-condensed taula-respostes-test">
												<thead>
													<tr>
														<th> Pregunta </th>
														<th> Opció correcta </th>
                                                        <th> Opció 2 </th>
                                                        <th> Opció 3 </th>
													</tr>
												</thead>
												<tbody>
													<?php foreach($test['preguntes'] as $pregunta): ?>
													<tr>
														<td> <?php echo $pregunta['pregunta']; ?> </td>
                                                        <td> <?php echo $pregunta['opcio_correcta']; ?> </td>
                                                        <td> <?php echo $pregunta['opcio_2']; ?> </td>
                                                        <td> <?php echo $pregunta['opcio_3']; ?> </td>
													</tr>
													<?php endforeach; ?>
												</tbody>
											</table>
										</div>
									</td>
								</tr>
								<?php endif; ?>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                        <span class="text-muted">No se han encontrado tests importados anteriormente</span>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap-filestyle.js"); ?>"></script>