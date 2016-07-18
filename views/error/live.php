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
                <div class="col-lg-10 center text-center">
                    <div class="row">
                        <div class="col-md-12">
                            <p>
                                It seems the application as ground to a halt. This is probably due
                                to a mysterious programing bug. You should probably give the hash below to a programmer.
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 center errormessage">
                            <p class="lead" style="padding-top: 10px;"><?= $hash ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <?php
        Flight::render('core/footer.php');
    ?>
</html>