<a class="btn btn-success btn-float-add" id="obrir-modal-afegir-alumne" role="button" data-toggle="modal" href="#modal-afegir-alumne"> <i class="fa fa-user-plus" aria-hidden="true"></i></a>

<div id="shadow"></div>

<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h5 style="display: inline-block">Gestión de alumnos</h5>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<?php if(isset($alumnes)): ?>
						<table class="table table-condensed table-hover">
							<thead>
								<tr>
									<th class="text-center">NIF</th>
									<th class="text-center">Nombre</th>
									<th class="text-center">Correo electrónico</th>
									<th class="text-center">Teléfono de contacto</th>
                                    <th class="text-center">Profesor asignado</th>
                                    <th class="text-center">Acción</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($alumnes as $alumne): ?>
                                <tr valign="middle">
                                    <td class="text-center"> <?php echo $alumne['nif'] ?> </td>
                                    <?php $nomComplet = $alumne['cognoms'] . ', ' . $alumne['nom'] ?>
                                    <td class="text-center"> <?php echo $nomComplet ?> </td>
                                    <td class="text-center"> <?php echo $alumne['correu'] ?> </td>
                                    <td class="text-center"> <?php echo $alumne['telefon'] ?> </td>
                                    <?php $nomComplet = $alumne['admin_cognoms'] . ', ' . $alumne['admin_nom'] ?>
                                    <td class="text-center"> <?php echo $nomComplet ?> </td>
                                    <td class="text-center">
                                        <a class="btn btn-warning btn-sm obrir-modal-mod-alumne" role="button" data-toggle="modal" href="#modal-editar-alumne" value="<?php echo $alumne['nif'].':'.$alumne['nom'].':'.$alumne['cognoms'].':'.$alumne['correu'].':'.$alumne['telefon'].':'.$alumne['poblacio'].':'.$alumne['adreca'].':'.$alumne['professor_nif'] ?>"> 
                                            <i class="fa fa-pencil-square-o" aria-hidden="true" ></i>
                                        </a>
                                        <a class="btn btn-danger btn-sm obrir-modal-del-alumne" role="button" data-toggle="modal" href="#modal-eliminar-alumne" value="<?php echo $alumne['nif'].':'.$alumne['nom'] ?>"> 
                                            <i class="fa fa-times " aria-hidden="true" ></i>
                                        </a>
                                    </td>
                                </tr>
							<?php endforeach; ?>
							</tbody>
						</table>
						<?php else: ?>
							<p class="text-muted">No hay alumnos en nuestro sistema</p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- MODALS -->
<div id="modal-afegir-alumne" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?php echo site_url('admin/GestioAlumnesController/insert'); ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"> Añadir alumno </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-xs-4 col-md-4">
                            <label for="nif" class="control-label">NIF</label>
                            <input type="text" class="form-control" name="nif" class="form-control" placeholder="00000000A" id="nif" required>
                        </div>
                        <div class="form-group col-xs-4 col-md-4">
                            <label for="nom" class="control-label">Nom</label>
                            <input type="text" class="form-control" name="nom" placeholder="John" id="nom" required>
                        </div>
                        <div class="form-group col-xs-4 col-md-4">
                            <label for="cognoms" class="control-label">Cognoms</label>
                            <input type="text" class="form-control" name="cognoms" placeholder="Doe" id="cognoms" required>
                        </div>
                        <div class="form-group col-xs-8 col-md-8">
                            <label for="correu" class="control-label">Correu</label>
                            <input type="email" class="form-control" name="correu" placeholder="johndoe@email.com" id="correu" required>
                        </div>
                        <div class="form-group col-xs-4 col-md-4">
                            <label for="telefon" class="control-label">Telefon</label>
                            <input type="text" class="form-control" name="telefon" placeholder="999999999" id="telefon">
                        </div>
                        <div class="form-group col-xs-6 col-md-6">
                            <label for="poblacio" class="control-label">Poblacio</label>
                            <input type="text" class="form-control" name="poblacio" placeholder="Igualada" id="poblacio" required>
                        </div>
                        <div class="form-group col-xs-6 col-md-6">
                            <label for="adreca" class="control-label">Adreça</label>
                            <input type="text" class="form-control" name="adreca" placeholder="Emili Vallès 4" id="carrer" required>
                        </div>
                        <?php if($professors && count($professors) > 0): ?>
                        <div class="form-group col-xs-12 col-md-12">
                            <label for="professor" class="control-label">Professor</label>
                            <select class="form-control" name="professor_nif" id="professor" required>
                            <?php foreach($professors as $professor): ?>
                                <option value="<?php echo $professor['nif'] ?>"> <?php echo $professor['cognoms'] . ', ' . $professor['nom'] ?> </option>
                            <?php endforeach ?>
                            </select>
                        </div>
                        <?php endif ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modal-editar-alumne" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?php echo site_url('admin/GestioAlumnesController/update'); ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Edición del alumno <strong><span id="nom-alumne-title"> </span></strong> </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="text" id="nif-populate" name="nif" hidden>
                        <div class="form-group col-xs-6 col-md-6">
                            <label for="nom-populate" class="control-label">Nom</label>
                            <input type="text" class="form-control" id="nom-populate" name="nom" required>
                        </div>
                        <div class="form-group col-xs-6 col-md-6">
                            <label for="cognoms-populate" class="control-label">Cognoms</label>
                            <input type="text" class="form-control" id="cognoms-populate" name="cognoms" required>
                        </div>
                        <div class="form-group col-xs-8 col-md-8">
                            <label for="correu-populate" class="control-label">Correu</label>
                            <input type="email" class="form-control" id="correu-populate" name="correu" required>
                        </div>
                        <div class="form-group col-xs-4 col-md-4">
                            <label for="telefon-populate" class="control-label">Telefon</label>
                            <input type="text" class="form-control" id="telefon-populate" name="telefon">
                        </div>
                        <div class="form-group col-xs-6 col-md-6">
                            <label for="poblacio-populate" class="control-label">Poblacio</label>
                            <input type="text" class="form-control" id="poblacio-populate" name="poblacio" required>
                        </div>
                        <div class="form-group col-xs-6 col-md-6">
                            <label for="adreca-populate" class="control-label">Adreça</label>
                            <input type="text" class="form-control" id="adreca-populate" name="adreca" required>
                        </div>
                        <?php if($professors && count($professors) > 0): ?>
                        <div class="form-group col-xs-12 col-md-12">
                            <label for="professor-populate" class="control-label">Professor</label>
                            <select class="form-control" name="professor_nif" id="professor-populate" required>
                            <?php foreach($professors as $professor): ?>
                                <option value="<?php echo $professor['nif'] ?>"> <?php echo $professor['cognoms'] . ', ' . $professor['nom'] ?> </option>
                            <?php endforeach ?>
                            </select>
                        </div>
                        <?php endif ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-warning">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modal-eliminar-alumne" class="modal fade modal-danger">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?php echo site_url('admin/GestioAlumnesController/delete') ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Eliminación del alumno <strong><span id="nom-alumne-title-2"> </span></strong></h4>
                </div>
                <div class="modal-body">
                    Estas seguro que quieres eliminar este alumno?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
                <input type="text" name="nif" id="nif-populate-2" hidden>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url("assets/js/modals.js"); ?>"></script>