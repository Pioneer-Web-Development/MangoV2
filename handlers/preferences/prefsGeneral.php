<?php

//specify which fields can be filled (helps prevent any kind of forged submissions)
//process form differently depending on the tab


$fillable = array('systemEmailFromAddress',
    'cronSystemEnabled'
);

$this->processForm('core_preferences',$fillable);
