<?php

require_once __DIR__ . '/includes/common.php';
require_once __DIR__ . '/includes/database.php';

require_once __DIR__ . '/includes/check-session.php';
require_once __DIR__ . '/includes/init-session.php';

?>

<!DOCTYPE html>

<head>
    <title>Blank Page </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php include("includes/header.php"); ?>
    <!--header end-->
    <!--sidebar start-->

    <?php include("includes/left.php"); ?>

    <!--sidebar end-->
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <div class="agile-grid" style="height:620px;">
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Blank Page
                            </header>
                            <div class="panel-body">


                                <form class="form-horizontal bucket-form" method="get">
                                    <div class="form-group">
                                        <label class=" col-sm-3 control-label">Static control</label>
                                        <div class="col-lg-6">
                                            <p class="form-control-static">email@example.com</p>
                                        </div>
                                    </div>
                                    <div class="form-group has-success">
                                        <label class="col-sm-3 control-label col-lg-3" for="inputSuccess">Input with success</label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" id="inputSuccess">
                                        </div>
                                    </div>
                                </form>


                            </div>
                        </section>
                    </div>
                </div>

            </div>
        </section>

        <!-- footer -->
        <?php include("includes/footer.php"); ?>
        <!-- footer -->