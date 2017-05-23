<div class="container">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url('TestsController/index') ?>">Tests</a></li>
        <li class="breadcrumb-item"><?php echo $this->session->nom_test ?></li>
    </ol>
</div>

<div class="container">
    <div class="row">  
        <div class="col-lg-12 col-md-12" id="contenidor-preguntes">
            <?php if(isset($test) && $test): ?>
                <form id="test-form">
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
                            <h5> <?php echo $pregunta['preg_pregunta']; ?></h5>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-9">
                                <?php foreach($opcions as $opcio): ?>
                                <label for="o<?php echo $cont; ?>" class="radio-inline">
                                    <input type="radio" name="<?php echo $pregunta['preg_codi']; ?>" id="o<?php echo $cont; ?>" value="<?php echo $opcio; ?>" required /> <?php echo $opcio; ?>
                                </label>
                                <br/><br/>
                                <?php $cont++ ?>
                                <?php endforeach; ?>
                            </div>
                            <div class="col-md-3">
                                <?php if($pregunta['preg_imatge'] != 'N'): ?>
                                    <img src="<?php echo base_url() . 'uploads/'.$this->session->codi_test.'/'.$pregunta['preg_imatge'] ?>">
                                <?php endif ?>
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

<br/>

<script>
    var site_url_check = "<?php echo site_url('TestsController/check'); ?>";
    var site_url_enrere= "<?php echo site_url('TestsController/index'); ?>";
</script>