<!DOCTYPE html>
<html lang="en">
    <?php
        Flight::render('core/head.php', array('pagetitle'=>'Error'));
    ?>
    <body>
        <div class="container">
            <div class="page-header">
                <h1>We've encountered an error!</h1>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <p>
                                This is the error screen, to get here, you probably broke something or forced its
                                existence into this universe.
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-10 errormessage">
                            <p class="small"><span class="glyphicon glyphicon-cog"></span> <?= $message ?> at line <?= $line ?></b></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-10">
                            <p>
                                <a class="btn btn-default" href="http://php.net/manual/en/" role="button">Look at PHP Manual »</a>
                            </p>
                            <p>
                                <a class="btn btn-default" href="http://stackoverflow.com/search?q=[php] <?= $message ?>" role="button">Stack Overflow It »</a>
                            </p>
                            <p>
                                <a class="btn btn-default" href="https://google.com/#q=<?= $message ?>" role="button">Google It »</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 trace">
                    <pre><?= $trace ?></pre>
                </div>
            </div>
        </div>
    </body>
    <?php
        Flight::render('core/footer.php');
    ?>
</html>