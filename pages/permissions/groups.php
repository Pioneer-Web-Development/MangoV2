<?php

$template = 'master';

include($_SERVER["DOCUMENT_ROOT"] . "/includes/bootstrap.php");

function page()
{
    global $db, $session;
    //lets get a user
    $db->select('id,group_name');
    $db->from('core_permission_groups');
    $db->order_by('group_name');
    $groups = $db->fetch();


    $searchFields[]=array('type'=>'text', 'label'=>'Group Name', 'value'=>'', 'field'=>'group_name');

    // this is the bare minimum implementation;
    $table = new Table();
    $table->setRecordActionBase('permissions/groupEdit.php');
    $actions[]=array('action'=>'selectpermissions','label'=>"Permissions",'url'=>'permissions/groupPermissions.php');
    $table->setRecordActions($actions);
    $table->setData($groups);
    $table->setSearch($searchFields);
    $table->setNewButton('New Group','permissions/groupEdit.php');
    $table->generate();

    $GLOBALS['scripts']=array_merge($GLOBALS['scripts'],$table->tableScripts);
}
