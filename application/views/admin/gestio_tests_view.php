<a class="btn btn-success btn-float-add" id="obrir-modal-afegir-alumne" role="button" data-toggle="modal" href="#modal-afegir-alumne"> <i class="fa fa-plus" aria-hidden="true"></i> </a>

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
                            <input type="text" name="codi" id="codi" class="form-control" placeholder="TEST0001">
                        </div>
                        <div class="form-group col-xs-8 col-md-8">
                            <label for="nom">Nom</label>
                            <input type="text" name="nom" id="nom" class="form-control" placeholder="TEST 0001">
                        </div>
                        <?php if(isset($carnets) && $carnets): ?>
                        <div class="form-group col-xs-12 col-md-12">
                            <label for="carnet">Tipus de carnet</label>
                            <select name="carnet" id="carnet" class="form-control">
                                <?php foreach($carnets as $carnet): ?>
                                    <option value="<?php echo $carnet['codi'] ?>"> <?php echo $carnet['codi'] ?> </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <?php endif ?>
                        <div class="form-group col-xs-12 col-md-12">
                            <label for="rar-file">Importación del archivo con las preguntas</label>
                            <input type="file" name="rar-file" id="rar-file">
                            <small id="fileHelp" class="form-text text-muted">
                                Archivo .zip que incluye un archivo .csv con las preguntas, e imagenes de las respectivas preguntas si són necesarias. <br/>
                            </small>
                        </div>
                        <div class="col-xs-12 col-md-12">
                            <button type="submit" class="btn btn-primary">Crear</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>