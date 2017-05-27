<div class="container">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Tests</li>
    </ol>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <?php if(isset($tests) && $tests): ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Tests básicos</h4>
                </div>
                <div class="panel-body">
                <?php foreach($tests as $test): ?>
                    <div class="col-md-4">
                        <?php if($test['test_codi'] == $test['alu_test_test_codi']): ?>
                            <a class="btn btn-autoescola btn-block" href="<?php echo site_url('TestsController/show/' . $test['test_codi']); ?>"> <?php echo $test['test_nom']; ?></a>
                        <?php else: ?>
                            <a class="btn btn-default btn-block" href="<?php echo site_url('TestsController/show/' . $test['test_codi']); ?>"> <?php echo $test['test_nom']; ?></a>
                        <?php endif ?>
                        <br/>
                    </div>
                <?php endforeach; ?>
                </div>
            </div>
            <?php else: ?>
                <p>No hay tests por hacer!</p>
            <?php endif ?>
        </div>
    </div>
</div>
