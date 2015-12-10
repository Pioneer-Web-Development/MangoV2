<?php

$template = 'master';

include($_SERVER["DOCUMENT_ROOT"] . "/includes/bootstrap.php");

function page()
{
    global $db, $session;
    //lets get a user
    $db->select('id,displayname');
    $db->from('core_permission_list');
    $db->order_by('displayname');
    $permissions = $db->fetch();


    $searchFields[]=array('type'=>'text', 'label'=>'Display Name', 'value'=>'', 'field'=>'displayname');

    // this is the bare minimum implementation;
    $table = new Table();
    $table->setRecordActionBase('/pages/permissions/permissionEdit.php');

    $table->setData($permissions);
    $table->setSearch($searchFields);
    $table->setNewButton('New Permission','/pages/permissions/permissionEdit.php');
    $table->generate();

    $GLOBALS['scripts']=array_merge($GLOBALS['scripts'],$table->tableScripts);
}
