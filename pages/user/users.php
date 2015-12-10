<?php

$template = 'master';

include($_SERVER["DOCUMENT_ROOT"] . "/includes/bootstrap.php");

function page()
{
    global $db, $session;
    //lets get a user
    $db->select('users.id,firstname,lastname,email,department_name');
    $db->from('users');
    $db->join('user_departments','users.department_id=user_departments.id');
    $db->order_by('lastname');
    $users = $db->fetch();


    $searchFields[]=array('type'=>'text', 'label'=>'Last Name', 'value'=>'', 'field'=>'lastname');

    $db->select('id,department_name');
    $db->from('user_departments');
    $db->order_by('department_name');

    $departments=$db->fetch();

    $searchFields[]=array('type'=>'select', 'value'=>0, 'label'=>'Department', 'field'=>'department_id','options'=>$departments, 'option_field'=>'department_name');

    // this is the bare minimum implementation;
    $table = new Table();
    $table->setRecordActionBase('/pages/user/user.php');

    $table->setData($users);
    $table->setSearch($searchFields);
    $table->setNewButton('New User','/pages/user/user.php');

    $actions[]=array('action'=>'list','label'=>"Permissions",'url'=>'/pages/user/permissions.php');
    $actions[]=array('action'=>'list','label'=>"Groups",'url'=>'/pages/user/groups.php');
    $table->setFormActions($actions);

    $table->generate();

    $GLOBALS['scripts']=array_merge($GLOBALS['scripts'],$table->tableScripts);
}
