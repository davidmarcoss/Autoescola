<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12">
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
                                <input type="radio" name="opcions<?php echo $pregunta['codi']; ?>[]" id="o<?php echo $cont; ?>" /> <?php echo $opcio; ?>
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
            <?php endforeach; ?>
        </div>
    </div>
</div>