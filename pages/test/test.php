<?php
$template='login';
include("../../includes/bootstrap.php");
function page(){
    global $session;
    ?>

    <html>
    <head>
        <title></title>
    </head>
    <body>
    <form method="post" action="/pages/user/test.php"> <!-- forgot to set form to post here, defaulted to get instead -->
        <input type="text" size=40 name="csrf_token" value="<?php echo $session->csrf_token ?>" /> <!-- forgot to set name="" here -->
        <input type="submit" value="Submit" />
    </form>
    </body>
    </html>

<?php } ?>