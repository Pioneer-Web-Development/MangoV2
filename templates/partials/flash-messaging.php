<?php
global $messenger;
if ($messenger->hasFlashMessage()){
    $messenger->showFlashMessages();
}