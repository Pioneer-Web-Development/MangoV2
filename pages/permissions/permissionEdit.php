<?php

$template = 'master';

include($_SERVER["DOCUMENT_ROOT"] . "/includes/bootstrap.php");

function page()
{
    global $db, $session;

    //did we get passed a userid?
    $permission=[];
    if ($_GET['id']) {
        //build up a user
        $permissionID = intval($_GET['id']);
        $permission = $db->from('core_permission_list')->where('id', $permissionID)->fetch();
    }

    $formOptions = array('action' => 'permission.php',
        'data' => $permission,
        'files' => true,
        'title' => 'Permission Setup',
    );
    $permissionForm = new Form($formOptions);

    $options = array('field'=>'displayname','label'=>"Display name",'description'=>'');
    $permissionForm->text($options);

    $options = array('field'=>'js_varname','label'=>"JS variable name",'description'=>'');
    $permissionForm->text($options);

    $options = array('field'=>'include_js','label'=>"Include JS in head",'description'=>'');
    $permissionForm->checkbox($options);


    $permissionForm->generate();
}