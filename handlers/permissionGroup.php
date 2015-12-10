<?php

$template = 'master';

include($_SERVER["DOCUMENT_ROOT"] . "/includes/bootstrap.php");

function page()
{
    global $db, $session;

    //did we get passed an id?
    $group=[];
    if ($_GET['id']) {
        //build up a record
        $groupID = intval($_GET['id']);
        $group = $db->from('core_permission_groups')->where('id', $groupID)->fetch();
    }


    $formOptions = array('action' => 'permissionGroup.php',
        'data' => $group,
        'title' => 'Group Setup',
    );
    $groupForm = new Form($formOptions);

    $options = array('field'=>'group_name','label'=>"Group name",'description'=>'');
    $groupForm->text($options);

    $groupForm->generate();
}