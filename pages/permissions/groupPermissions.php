<?php

$template = 'master';

include($_SERVER["DOCUMENT_ROOT"] . "/includes/bootstrap.php");

function page()
{
    global $db, $session;

    //did we get passed an id?
    $selectedPermissions=[];
    if ($_GET['id']) {
        //build up a record
        $groupID = intval($_GET['id']);
        $selectedPermissions = $db->select('id,permission_id')->from('core_permission_group_xref')->where('group_id', $groupID)->fetch_simple_array('permission_id');
    } else {
        $groupID=0;
    }
    //build list of permissions
    $permissions = $db->from('core_permission_list')->order_by('displayname')->fetch_as_select_options('displayname');

    $formOptions = array('action' => 'addPermissionsToGroup.php',
        'data' => $selectedPermissions,
        'recordID' => $groupID,
        'title' => 'Group Permissions',
        'description' => "Move permissions to the second list to add them to this permission group."
    );
    $groupForm = new Form($formOptions);
    $options = array('field'=>'permission','nonSelectedLabel'=>'Available Permissions','selectedLabel'=>'Applied Permissions','values'=>$selectedPermissions,'label'=>"Permissions",'description'=>'','options'=>$permissions);
    $groupForm->dualSelect($options);

    $groupForm->generate();

    $GLOBALS['scripts']=array_merge($GLOBALS['scripts'],$groupForm->formScripts);
}