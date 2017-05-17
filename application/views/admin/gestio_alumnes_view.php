<div id="shadow"></div>
<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h5>Alumnos</h5>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<?php if(isset($alumnes)): ?>
						<table class="table table-condensed table-hover">
							<thead>
								<tr>
									<th>NIF</th>
									<th>Nom</th>
									<th>Correu</th>
									<th>Telefon</th>
                                    <th>Professor assignat</th>
                                    <th>Acció</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($alumnes as $alumne): ?>
                                <tr valign="middle">
                                    <td> <?php echo $alumne['nif'] ?> </td>
                                    <?php $nomComplet = $alumne['cognoms'] . ', ' . $alumne['nom'] ?>
                                    <td> <?php echo $nomComplet ?> </td>
                                    <td> <?php echo $alumne['correu'] ?> </td>
                                    <td> <?php echo $alumne['telefon'] ?> </td>
                                    <?php $nomComplet = $alumne['admin_cognoms'] . ', ' . $alumne['admin_nom'] ?>
                                    <td> <?php echo $nomComplet ?> </td>
                                    <td>
                                        <a class="btn btn-warning btn-sm" id="obrir-modal-mod-alumne" role="button" data-toggle="modal" href="#modal-editar-alumne" value="<?php echo $alumne['nif'].':'.$alumne['nom'].':'.$alumne['cognoms'].':'.$alumne['correu'].':'.$alumne['telefon'].':'.$alumne['poblacio'].':'.$alumne['adreca'] ?>"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> </a>
                                        <a class="btn btn-danger btn-sm" id="obrir-modal-del-alumne" data-toggle="modal" href="#modal-eliminar-alumne" value="<?php echo $alumne['nif'] ?>"> <i class="fa fa-trash-o" aria-hidden="true"></i> </a>
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




<div id="modal-editar-alumne" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Edició de l'alumne <strong><span id="nom-alumne-title"> </span></strong> </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form method="post" action="">
                        <input type="text" id="nif-populate" name="nif" hidden>
                        <div class="form-group col-xs-6 col-md-6">
                            <label for="nom-populate" class="control-label">Nom</label>
                            <input type="text" class="form-control" id="nom-populate" name="nom">
                        </div>
                        <div class="form-group col-xs-6 col-md-6">
                            <label for="cognoms-populate" class="control-label">Cognoms</label>
                            <input type="text" class="form-control" id="cognoms-populate" name="cognoms">
                        </div>
                        <div class="form-group col-xs-8 col-md-8">
                            <label for="correu-populate" class="control-label">Correu</label>
                            <input type="email" class="form-control" id="correu-populate" name="correu">
                        </div>
                        <div class="form-group col-xs-4 col-md-4">
                            <label for="telefon-populate" class="control-label">Telefon</label>
                            <input type="text" class="form-control" id="telefon-populate" name="telefon">
                        </div>
                        <div class="form-group col-xs-6 col-md-6">
                            <label for="poblacio-populate" class="control-label">Poblacio</label>
                            <input type="text" class="form-control" id="poblacio-populate" name="poblacio">
                        </div>
                        <div class="form-group col-xs-6 col-md-6">
                            <label for="adreca-populate" class="control-label">Adreça</label>
                            <input type="text" class="form-control" id="adreca-populate" name="adreca">
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Guardar cambios</button>
            </div>
        </div>
    </div>
</div>

<div id="modal-eliminar-alumne" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Eliminació de l'alumne </h4>
            </div>
            <div class="modal-body">
                <form method="post" action="">
                    <input type="text" name="nom" id="nom-populate" class="form-control">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="<?php echo base_url("assets/js/modals.js"); ?>"></script>