<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <?php foreach($test as $pregunta): ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5> <?php echo $pregunta['pregunta']; ?></h5>
                </div>
                <div class="panel-body">
                    <div class="card-box card-box-test">
                        <div class="text-center">
                            <span class="card-test-accent">TEST 00001</span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>