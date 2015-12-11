<?php
$template = 'login';
include 'includes/bootstrap.php';
/*
*  IF logged in, go ahead and redirect to the dashboard, otherwise show the login form
*/
function page()
{
    global $session, $user;
    if ($user->loggedin) {
        redirect("/pages/dashboard.php");
    }
    ?>

    <header id="header-extra">

        <div id="logo-group">
            <span id="logo"> <img src="/images/logo.png" alt="Mango"> </span>
        </div>

        <span id="extra-page-header-space"> <span class="hidden-mobile hiddex-xs">Need an account?</span> <a
                href="/pages/user/requestAccess.php" class="btn btn-danger">Request Access</a> </span>

    </header>

    <div id="main" role="main">

        <!-- MAIN CONTENT -->
        <div id="content" class="container">

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-8 hidden-xs hidden-sm">
                    <h1 class="txt-color-red login-header-big">Mango
                        <small>Newspaper Management Made Easy</small>
                    </h1>
                    <div class="hero">

                        <div class="pull-left login-desc-box-l">
                            <h4 class="paragraph-header">It's Okay to be Smart. Experience the simplicity of SmartAdmin,
                                everywhere you go!</h4>

                            <div class="login-app-icons">
                                <a href="javascript:void(0);" class="btn btn-danger btn-sm">Frontend Template</a>
                                <a href="javascript:void(0);" class="btn btn-danger btn-sm">Find out more</a>
                            </div>
                        </div>

                        <img src="/images/iphoneview.png" class="pull-right display-image" alt="" style="width:210px">

                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <h5 class="about-heading">About SmartAdmin - Are you up to date?</h5>

                            <p>
                                Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                                laudantium, totam rem aperiam, eaque ipsa.
                            </p>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <h5 class="about-heading">Not just your average template!</h5>

                            <p>
                                Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta
                                nobis est eligendi voluptatem accusantium!
                            </p>
                        </div>
                    </div>

                </div>
                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
                    <div class="well">

                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php
    $GLOBALS['scripts'][] = <<<BLOCK
        $(function () {
            // Validation
           $("#login-form") . validate({
                // Rules for form validation
                rules : {
                email : {
                    required :
                    true,
                        email : true
                    },
                password : {
                    required :
                    true,
                        minlength : 3,
                        maxlength : 20
                    }
            },

                // Messages for form validation
                messages : {
                email : {
                    required :
                    'Please enter your email address',
                        email : 'Please enter a VALID email address'
                    },
                password : {
                    required :
                    'Please enter your password'
                    }
            },

                // Do not change code below
                errorPlacement : function (error, element) {
                error . insertAfter(element . parent());
            }
            });
        });
    };
BLOCK;
}