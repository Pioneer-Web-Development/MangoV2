<?php
$template = 'bare';

require_once '../../includes/bootstrap.php';

//every page is wrapped with a page function that is automatically called
function page()
{
    global $user,$session;
    $session->loggedin = false;
    $session->user_token = '';
    $session->queueCookie('user',0,false,true);
    if($user != Null)
        $user->logout();
    session_unset();
    // destroy the session
    session_destroy();
    session_start();
    setcookie('mango_user',null,time()-3600);
    redirect("/index.php");
}
