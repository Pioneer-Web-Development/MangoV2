<?php
global $session;
if ($session->hasFlashMessage()){
    $session->showFlashMessages();
}