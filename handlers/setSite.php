<?php
session_start();
$_SESSION['data']['current_site']=intval($_GET['siteID']);
setcookie('mango_current_site',intval($_GET['siteID']),time()+3600*24*30);
redirect($_SERVER['HTTP_REFERER']);

function redirect($url) {
    if (!headers_sent())
        header('Location: '.$url);
    else {
        echo '<script type="text/javascript">';
        echo 'document.location.href="'.$url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>';
    }
}