<div class="container">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Tests</li>
    </ol>
</div>

<div class="container">
    <div class="row">
        <?php if(isset($tests) && $tests): ?>
        <div class="col-lg-4 col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5>Tests básicos</h5>
                </div>
                <div class="panel-body">
                <?php foreach($tests as $test): ?>
                    <?php if($test['test_tipus'] == 'basico'): ?>
                        <?php if($test['test_codi'] == $test['alu_test_test_codi']): ?>
                            <a class="btn btn-success btn-block" href="<?php echo site_url('TestsController/show/' . $test['test_codi']); ?>"> <?php echo $test['test_nom']; ?></a>
                        <?php else: ?>
                            <a class="btn btn-default btn-block" href="<?php echo site_url('TestsController/show/' . $test['test_codi']); ?>"> <?php echo $test['test_nom']; ?></a>
                        <?php endif ?>
                        <br/>
                    <?php endif; ?>
                <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5>Tests avanzados</h5>
                </div>
                <div class="panel-body">
                <?php foreach($tests as $test): ?>
                    <?php if($test['test_tipus'] == 'avanzado'): ?>
                        <a class="btn btn-primary btn-block" href="<?php echo site_url('TestsController/show/' . $test['test_codi']); ?>"> <?php echo $test['test_nom']; ?></a>
                        <br/>
                    <?php endif; ?>
                <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5>Tests examen</h5>
                </div>
                <div class="panel-body">
                <?php foreach($tests as $test): ?>
                    <?php if($test['test_tipus'] == 'examen'): ?>
                        <a class="btn btn-primary btn-block" href="<?php echo site_url('TestsController/show/' . $test['test_codi']); ?>"> <?php echo $test['test_nom']; ?></a>
                        <br/>
                    <?php endif; ?>
                <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php else: ?>
            <p>No hay tests por hacer!</p>
        <?php endif ?>
    </div>
</div>
