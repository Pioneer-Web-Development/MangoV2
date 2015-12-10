<?php
$template = 'master';

include($_SERVER['DOCUMENT_ROOT']."/includes/bootstrap.php");

function page()
{
?>
    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <div class="text-center error-box">
                <h1 class="error-text tada animated"><i class="fa fa-times-circle text-danger error-icon-shadow"></i> Error 500</h1>
                <h2 class="font-xl"><strong>Oooops, Something went wrong!</strong></h2>
                <br />
                <p class="lead semi-bold">
                    <strong>You have experienced a technical error. We apologize.</strong><br><br>
                    <small>
                        We are working hard to correct this issue. Please wait a few moments and try your search again. <br> In the meantime, check out whats new on SmartAdmin:
                    </small>
                </p>
                <ul class="error-search text-left font-md">
                    <li><a href="/pages/dashboard.php">
                            <small>Go to Dashboard <i class="fa fa-arrow-right"></i></small>
                        </a></li>
                </ul>
            </div>


        </div>
    </div>
    <?php
}