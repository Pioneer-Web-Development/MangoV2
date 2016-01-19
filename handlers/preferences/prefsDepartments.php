<?php

//specify which fields can be filled (helps prevent any kind of forged submissions)
//process form differently depending on the tab


$fillable = array('advertisingDepartmentID',
    'mailroomDepartmentID',
    'pressDepartmentID',
    'advertisingDepartmentID',
    'productionDepartmentID',
    'financeDepartmentID',
    'editorialDepartmentID',
    'circulationDepartmentID'
);

$this->processForm('core_preferences',$fillable);
