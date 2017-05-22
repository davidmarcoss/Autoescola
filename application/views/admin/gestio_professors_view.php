<div id="shadow"></div>

<a class="btn btn-success btn-float-add" id="obrir-modal-afegir-professor" role="button" data-toggle="modal" href="#modal-afegir-professor"> 
    <i class="fa fa-user-plus" aria-hidden="true"></i>
</a>

<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h5 style="display: inline-block">Gestión de profesores</h5>
				</div>
				<div class="panel-body">
					<form id="form-alumne-tests" class="form-inline" method="post" action="<?php echo site_url('HomeController/index') ?>">
						<div class="form-group">
							<label for="nif" class="sr-only">NIF</label>
                            <input type="text" name="nif" id="nif" placeholder="NIF" class="form-control">
						</div>
						<div class="form-group">
							<label for="nom" class="sr-only">Nombre </label>
                            <input type="text" name="nom" id="nom" placeholder="Nombre" class="form-control">
						</div>
                        <button type="button" class="btn btn-success btn-autoescola" id="btn-aplicar-filtres-professors">Aplicar</button>
						<div class="form-group" id="div-limpiar-filtros">
						</div>
					</form>
                    <hr/>
                    <?php if(isset($professors)): ?>
					<div class="table-responsive">
						<table class="table table-condensed table-hover table-striped">
							<thead>
								<tr>
									<th class="text-center">NIF</th>
									<th class="text-center">Nombre</th>
									<th class="text-center">Correo electrónico</th>
                                    <th class="text-center">Acción</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($professors as $professor): ?>
                                <tr valign="middle">
                                    <td class="text-center"> <?php echo $professor['nif'] ?> </td>
                                    <?php $nomComplet = $professor['cognoms'] . ', ' . $professor['nom'] ?>
                                    <td class="text-center"> <?php echo $nomComplet ?> </td>
                                    <td class="text-center"> <?php echo $professor['correu'] ?> </td>
                                    <td class="text-center">
                                        <a class="btn btn-warning btn-sm obrir-modal-mod-professor"  role="button" data-toggle="modal" href="#modal-editar-professor" value="<?php echo $professor['nif'].':'.$professor['nom'].':'.$professor['cognoms'].':'.$professor['correu']; ?>">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true" ></i> Editar
                                        </a>
                                        <a class="btn btn-danger btn-sm obrir-modal-del-professor" role="button" data-toggle="modal" href="#modal-eliminar-professor" value="<?php echo $professor['nif'].':'.$professor['nom']; ?>"> 
                                            <i class="fa fa-times " aria-hidden="true" ></i> Eliminar
                                        </a>
                                    </td>
                                </tr>
							<?php endforeach; ?>
							</tbody>
						</table>
					</div>
                    <div class="text-center"><?php echo $this->pagination->create_links() ?></div>
                    <?php else: ?>
                            <p class="text-muted">No hay profesores en nuestro sistema</p>
                    <?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- MODALS -->
<div id="modal-afegir-professor" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?php echo site_url('admin/GestioProfessorsController/insert'); ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Edición del alumno <strong><span id="nom-professor-title"> </span></strong> </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-xs-4 col-md-4">
                            <label for="nif" class="control-label">NIF</label>
                            <input type="text" class="form-control" name="nif" class="form-control" placeholder="00000000A" required>
                        </div>
                        <div class="form-group col-xs-4 col-md-4">
                            <label for="nom" class="control-label">Nom</label>
                            <input type="text" class="form-control" name="nom" placeholder="John" required>
                        </div>
                        <div class="form-group col-xs-4 col-md-4">
                            <label for="cognoms" class="control-label">Cognoms</label>
                            <input type="text" class="form-control" name="cognoms" placeholder="Doe" required>
                        </div>
                        <div class="form-group col-xs-12 col-md-12">
                            <label for="password" class="control-label">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="**********" required>
                        </div>
                        <div class="form-group col-xs-12 col-md-12">
                            <label for="correu" class="control-label">Correu</label>
                            <input type="email" class="form-control" name="correu" placeholder="johndoe@email.com" required>
                        </div>
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

<div id="modal-editar-professor" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?php echo site_url('admin/GestioProfessorsController/update'); ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Edición del profesor <strong><span id="nom-professor-title"> </span></strong> </h4>
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
                        <div class="form-group col-xs-12 col-md-12">
                            <label for="correu-populate" class="control-label">Correu</label>
                            <input type="email" class="form-control" id="correu-populate" name="correu" required>
                        </div>
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

<div id="modal-eliminar-professor" class="modal fade modal-danger">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?php echo site_url('admin/GestioProfessorsController/delete') ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Eliminación del profesor <strong><span id="nom-professor-title-2"> </span></strong></h4>
                </div>
                <div class="modal-body">
                    Estas seguro que quieres eliminar este profesor?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
                <input type="text" name="nif" id="nif-populate-2-professor" hidden>
            </form>
        </div>
    </div>
</div>

<script>
	var site_url = "<?php echo site_url('admin/GestioProfessorsController/index') ?>";
	var site_url_filtre = "<?php echo site_url('admin/GestioProfessorsController/select_where_like') ?>";
</script>

<script type="text/javascript" src="<?php echo base_url("assets/js/modals.js"); ?>"></script>