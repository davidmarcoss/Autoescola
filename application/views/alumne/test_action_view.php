<div class="container">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url('TestsController/index') ?>">Tests</a></li>
        <li class="breadcrumb-item"><?php echo $this->session->nom_test ?></li>
    </ol>
</div>

<form id="test-form">
    <div class="container">
        <div class="row">  
            <div class="col-lg-12 col-md-12" id="contenidor-preguntes">
                <?php if(isset($test) && $test): ?>
                    <?php $cont = 0 ?>
                    <?php foreach($test as $pregunta): ?>
                    <?php
                        $opcions = array();
                        
                        array_push($opcions, $pregunta['preg_opcio_correcta']);
                        array_push($opcions, $pregunta['preg_opcio_2']);
                        
                        if($pregunta['preg_opcio_3'] != null) array_push($opcions, $pregunta['preg_opcio_3']);

                        shuffle($opcions);
                    ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4> <?php echo $pregunta['preg_pregunta']; ?></h4>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-9">
                                <?php foreach($opcions as $opcio): ?>
                                <label for="o<?php echo $cont; ?>" class="radio-inline">
                                    <input type="radio"  name="<?php echo $pregunta['preg_codi']; ?>" id="o<?php echo $cont; ?>" value="<?php echo $opcio; ?>"  /> 
                                    <?php echo $opcio; ?>
                                </label>
                                <br/><br/>
                                <?php $cont++ ?>
                                <?php endforeach; ?>
                            </div>
                            <div class="col-md-2 pull-right">
                                <?php if($pregunta['preg_imatge'] != 'N'): ?>
                                    <img src="<?php echo base_url() . 'uploads/'.$this->session->codi_test.'/'.$pregunta['preg_codi'].'.jpg' ?>" width="150px" class="pull-right img-pregunta">
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <?php endforeach ?>
                <?php endif ?>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-success btn-lg btn-float btn-float-add" id="btn-check-test"><i class="fa fa-check" aria-hidden="true"></i></button>
</form>

<a class="btn btn-danger btn-lg btn-float btn-float-del" id="btn-exit-test" data-toggle="modal" href="#modal-exit-test">
    <i class="fa fa-arrow-left" aria-hidden="true" disable></i>
</a>

<div id="modal-exit-test" class="modal fade modal-danger">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Salir del test</h4>
            </div>
            <div class="modal-body">
                Estás seguro que quieres salir del test? Se perderán todas las preguntas que hayas contestado hasta el momento.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a type="submit" href='<?php echo site_url('TestsController/index'); ?>' class="btn btn-danger">Salir</a>
            </div>
        </div>
    </div>
</div>

<div id="bg-semafor" class="bg"></div>
<div id="caixa-semafor" class="caixa-semafor">
    <div id="llum-semafor"></div>
    <img src="<?php echo base_url('assets/img/semafor.png') ?>">
</div>

<script>
    var site_url_check = "<?php echo site_url('TestsController/check'); ?>";
    var site_url_enrere= "<?php echo site_url('TestsController/index'); ?>";
</script>