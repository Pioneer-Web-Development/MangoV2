<?php
$template = 'login';
include 'includes/bootstrap.php';
/*
*  IF logged in, go ahead and redirect to the dashboard, otherwise show the login form
*/
function page()
{
    global $user;
    if (isset($user) && isset($user->loggedin) && $user->loggedin) {
        print "have a user object<br>";
        //redirect("/pages/dashboard.php");
    } else {
        print "no user object<br>";
    }
    ?>
    <header id="header-extra">
        <!--
        <div id="logo-group">
            <span id="logo"> <img src="/images/logo.png" alt="Mango"> </span>
        </div>
        -->
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
                    <!--
                       <div class="hero">

                           <div class="pull-left login-desc-box-l">
                               <h4 class="paragraph-header">It's Okay to be Smart. Experience the simplicity of SmartAdmin,
                                   everywhere you go!</h4>
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
   -->
                </div>

                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
                    <div class="well">
                        <?php userForm() ?>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php

}


function userForm()
{
    global $session;
    $form = new Form();
    print "CSRF: ".$session->csrf_token."<br>";
    print "Session Time: ".$session->csrf_expire."<br>";
    print "Current Time: ".time()."<br>";
?>
<form class="form-horizontal" role="form" method="post" action="/pages/user/authorizeUser.php">
    <?php
    $form->showErrors(true);
    ?>
    <input type="text" name="csrf_token" size=38 value="<?php print $session->csrf_token ?>">
    <div class="form-group">
        <label class="col-md-4 control-label">E-Mail Address</label>

        <div class="col-md-8">
            <input type="email" class="form-control" name="email" value="<?php print $_POST['email'] ?>">
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Password</label>

        <div class="col-md-8">
            <input type="password" class="form-control" name="password">
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember"> Remember Me
                </label>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <button type="submit" class="btn btn-primary">Login</button>

            <a class="btn btn-link" href="/pages/user/forgot.php">Forgot Your
                Password?</a>
        </div>
    </div>
</form>
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
