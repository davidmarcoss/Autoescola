<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 style="display: inline-block">Importación de tests</h4>
				</div>
                <div class="panel-body">
                    <form method="post" action="<?php echo site_url('admin/GestioTestsController/upload') ?>" enctype="multipart/form-data">
                        <div class="form-group col-xs-4 col-md-4">
                            <label for="codi">Codigo del test</label>
                            <input type="text" name="codi" id="codi" class="form-control" placeholder="TEST0001" required>
                        </div>
                        <div class="form-group col-xs-4 col-md-4">
                            <label for="nom">Nombre</label>
                            <input type="text" name="nom" id="nom" class="form-control" placeholder="TEST 0001" required>
                        </div>
                        <?php if(isset($carnets) && $carnets): ?>
                        <div class="form-group col-xs-2 col-md-2">
                            <label for="carnet">Tipo de carnet</label>
                            <select name="carnet" id="carnet" class="form-control" required>
                                <?php foreach($carnets as $carnet): ?>
                                    <option value="<?php echo $carnet['carnet_codi'] ?>"> <?php echo $carnet['carnet_codi'] ?> </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group col-xs-2 col-md-2">
                            <label for="tipus">Tipo de test</label>
                            <select name="tipus" id="tipus" class="form-control" required>
                                    <option value="basico"> Basico </option>
                                    <option value="avanzado"> Avanzado </option>
                                    <option value="examen"> Examen </option>
                            </select>
                        </div>
                        <?php endif ?>
                        <div class="form-group col-xs-12 col-md-12">
                            <label for="rar-file">Importación de preguntas</label>
                            <input type="file" class="filestyle" name="rar-file" id="rar-file" required>
                            <small id="fileHelp" class="form-text text-muted">
                                Solamente está permitido un archivo .zip (Debe contener .csv con preguntas e imagenes). <br/>
                            </small>
                        </div>
                        <div class="col-xs-12 col-md-12">
                            <button type="submit" class="btn btn-autoescola pull-right">Importar</button>
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
					<h4 style="display: inline-block">Tests importados</h4>
				</div>
                <div class="panel-body">
                    <?php if($tests): ?>
                    <table class="table table-striped table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>Codi</th>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Tipo</th>
                                <th class="text-center">Carnet</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($tests as $test): ?>
                                <tr style="cursor:pointer" data-id="<?php echo $test['test_codi']; ?>" class="accordeon" data-toggle="collapse" href="#desplegar_<?php echo $test['test_codi'] ?>">
                                    <td> <?php echo $test['test_codi'] ?> </td>
                                    <td class="text-center"> <?php echo $test['test_nom'] ?> </td>
                                    <td class="text-center"> <?php echo $test['test_tipus'] ?> </td>
                                    <td class="text-center"> <?php echo $test['test_carnet_codi'] ?> </td>
                                    <td class="text-center"> 
                                        <?php if($test['test_desactivat'] == 0): ?>
                                        <a class="btn btn-danger btn-sm obrir-modal-del-test" role="button" data-toggle="modal" href="#modal-eliminar-test" value="<?php echo $test['test_codi'] ?>"> 
                                            <i class="fa fa-times " aria-hidden="true" ></i> Desactivar
                                        </a>
                                        <?php elseif($test['test_desactivat'] == 1): ?>
                                        <a class="btn btn-success btn-sm obrir-modal-activar-test" role="button" data-toggle="modal" href="#modal-activar-test" value="<?php echo $test['test_codi'] ?>"> 
                                            <i class="fa fa-times " aria-hidden="true" ></i> Activar
                                        </a>
                                        <?php endif ?>
                                    </td>
                                </tr>
								<?php if($test['preguntes']): ?>
								<tr class="tr-no-hover">
									<td colspan="5" class="quitar-borde-superior">
										<div id="desplegar_<?php echo $test['test_codi']; ?>" class="collapse">
											<table class="table table-condensed taula-respostes-test">
												<thead>
													<tr>
														<th> Pregunta </th>
														<th> Opción correcta </th>
                                                        <th> Opción 2 </th>
                                                        <th> Opción 3 </th>
                                                        <th> Acción </th>
													</tr>
												</thead>
												<tbody>
													<?php foreach($test['preguntes'] as $pregunta): ?>
													<tr>
														<td> <?php echo $pregunta['preg_pregunta']; ?> </td>
                                                        <td> <?php echo $pregunta['preg_opcio_correcta']; ?> </td>
                                                        <td> <?php echo $pregunta['preg_opcio_2']; ?> </td>
                                                        <td> <?php echo $pregunta['preg_opcio_3']; ?> </td>
                                                        <td> 
                                                            <a class="btn btn-warning btn-sm obrir-modal-mod-pregunta" role="button" data-toggle="modal" href="#modal-editar-pregunta" data-value="<?php echo html_escape(json_encode($pregunta)) ?>"> 
                                                                <i class="fa fa-pencil" aria-hidden="true" ></i> Editar
                                                            </a>
                                                        </td>
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

<div id="modal-editar-pregunta" class="modal fade modal-warning">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?php echo site_url('admin/GestioTestsController/update_pregunta'); ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Edición de la pregunta <strong><span id="codi-pregunta-populate"> </span></strong> </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="text" id="preg_codi-populate" name="preg_codi" hidden>
                        <div class="form-group col-xs-12 col-md-12">
                            <label for="preg_pregunta-populate" class="control-label">Pregunta</label>
                            <textarea type="text" class="form-control" id="preg_pregunta-populate" name="preg_pregunta" required></textarea>
                        </div>
                        <div class="form-group col-xs-12 col-md-12">
                            <label for="preg_opcio_correcta-populate" class="control-label">Opción correcta</label>
                            <input type="text" class="form-control" id="preg_opcio_correcta-populate" name="preg_opcio_correcta" required>
                        </div>
                        <div class="form-group col-xs-12 col-md-12">
                            <label for="preg_opcio_2-populate" class="control-label">Opción 2</label>
                            <input type="text" class="form-control" id="preg_opcio_2-populate" name="preg_opcio_2" required>
                        </div>
                        <div class="form-group col-xs-12 col-md-12">
                            <label for="preg_opcio_3-populate" class="control-label">Opción 3 (Opcional)</label>
                            <input type="text" class="form-control" id="preg_opcio_3-populate" name="preg_opcio_3">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modal-eliminar-test" class="modal fade modal-danger">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?php echo site_url('admin/GestioTestsController/delete') ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Desactivación del test <strong><span id="test-codi"> </span></strong></h4>
                </div>
                <div class="modal-body">
                    <p>Estas seguro que quieres desactivar este test? Esto NO afectará a los tests realizados por los alumnos.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Desactivar</button>
                </div>
                <input type="text" name="test_codi" id="test-codi-populate" hidden>
            </form>
        </div>
    </div>
</div>

<div id="modal-activar-test" class="modal fade modal-danger">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?php echo site_url('admin/GestioTestsController/activar') ?>">
                <input type="text" name="test_codi" id="test_codi-populate-2" hidden>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Activación del test <strong><span id="test-codi-populate-2"> </span></strong></h4>
                </div>
                <div class="modal-body">
                    <p>Estas seguro que desea volver a activar este test?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Activar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap-filestyle.js"); ?>"></script>