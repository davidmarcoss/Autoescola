<div class="container">
	<div class="row">
		<div class="col-lg-4 col-md-4">
            <div class="panel panel-default">
				<div class="panel-heading">
					<h5>Tests básicos</h5>
				</div>
                <div class="panel-body">
                <?php foreach($tests as $test): ?>
                    <?php if($test['tipus'] == 'basico'): ?>
                        <a class="btn btn-default btn-block" href="<?php echo site_url('TestsController/show/' . $test['codi']); ?>"> <?php echo $test['nom']; ?></a>
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
                    <?php if($test['tipus'] == 'avanzado'): ?>
                        <a class="btn btn-primary btn-block" href="<?php echo site_url('TestsController/show/' . $test['codi']); ?>"> <?php echo $test['nom']; ?></a>
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
                    <?php if($test['tipus'] == 'examen'): ?>
                        <a class="btn btn-primary btn-block" href="<?php echo site_url('TestsController/show/' . $test['codi']); ?>"> <?php echo $test['nom']; ?></a>
                        <br/>
                    <?php endif; ?>
                <?php endforeach; ?>
                </div>
            </div>
		</div>
	</div>
</div>