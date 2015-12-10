<?php
/* a list of functions that are used internally in the system */

function dd($data)
{
    if(is_array($data))
    {
        print "<pre>";
        print_r($data);
        print "</pre>";
    } else {
        print $data;
    }
    die();
}

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
