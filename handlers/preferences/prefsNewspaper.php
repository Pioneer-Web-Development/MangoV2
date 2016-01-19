<?php

//specify which fields can be filled (helps prevent any kind of forged submissions)
//process form differently depending on the tab


$fillable = array('newspaperName',
    'newspaperAreaCode',
    'officeStreetAddress',
    'officeStreetCity',
    'officeStreetState',
    'officeStreetZip',
    'printingStreetAddress',
    'printingStreetCity',
    'printingStreetState',
    'printingStreetZip',
    'defaultState'
);

$this->processForm('core_preferences',$fillable);
