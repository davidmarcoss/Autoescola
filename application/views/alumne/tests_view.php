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
                    <div class="card-box card-box-test">
                        <div class="text-center">
                            <a class="card-test-accent" href="<?php echo site_url('TestsController/show/' . $test['codi']); ?>"> <?php echo $test['nom']; ?></a>
                        </div>
                    </div>
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
                    <div class="card-box card-box-test">
                        <div class="text-center">
                            <a class="card-test-accent">TEST 00006</a>
                        </div>
                    </div>
                    <br/>
                    <div class="card-box card-box-test">
                        <div class="text-center">
                            <a class="card-test-accent">TEST 000010</a>
                        </div>
                    </div>
                </div>
            </div>
		</div>

		<div class="col-lg-4 col-md-4">
            <div class="panel panel-default">
				<div class="panel-heading">
					<h5>Tests examen</h5>
				</div>
                <div class="panel-body">
                    <div class="card-box card-box-test">
                        <div class="text-center">
                            <a class="card-test-accent">TEST 00011</a>
                        </div>
                    </div>
                    <br/>
                    <div class="card-box card-box-test">
                        <div class="text-center">
                            <a class="card-test-accent">TEST 00012</a>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>