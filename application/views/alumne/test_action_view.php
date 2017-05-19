<div class="container">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url('TestsController/index') ?>">Tests</a></li>
        <li class="breadcrumb-item"><?php echo $this->session->nom_test ?></li>
    </ol>
</div>

<div class="container">
    <div class="row">  
        <div class="col-lg-12 col-md-12" id="contenidor-preguntes">
            <?php if($test && count($test) > 0): ?>
                <form id="test-form">
                    <?php $cont = 0 ?>
                    <?php foreach($test as $pregunta): ?>
                    <?php
                        $opcions = array();
                        
                        array_push($opcions, $pregunta['opcio_correcta']);
                        array_push($opcions, $pregunta['opcio_2']);
                        
                        if($pregunta['opcio_3'] != null) array_push($opcions, $pregunta['opcio_3']);

                        shuffle($opcions);
                    ?>
                    <div class="panel panel-default"    >
                        <div class="panel-heading">
                            <h6> <?php echo $pregunta['pregunta']; ?></h6>
                        </div>
                        <div class="panel-body">
                            <div class="card-box">
                                <div class="col-md-9">
                                    <?php foreach($opcions as $opcio): ?>
                                    <label for="o<?php echo $cont; ?>" class="radio-inline">
                                        <input type="radio" name="<?php echo $pregunta['codi']; ?>" id="o<?php echo $cont; ?>" value="<?php echo $opcio; ?>" required /> <?php echo $opcio; ?>
                                    </label>
                                    <br/><br/>
                                    <?php $cont++ ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                            </div>
                        </div>
                    </div>
                    <?php endforeach ?>
                    <button type="submit" class="btn btn-success btn-lg btn-block" id="btn-check-test">Acabar</button>
                </form>
            <?php endif ?>
        </div>
    </div>
</div>

<script>
    var site_url_check = "<?php echo site_url('TestsController/check'); ?>";
    var site_url_enrere= "<?php echo site_url('TestsController/index'); ?>";
</script>

<script type="text/javascript" src="<?php echo base_url("assets/js/app.js"); ?>"></script>