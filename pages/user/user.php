<?php

$template = 'master';

include($_SERVER["DOCUMENT_ROOT"] . "/includes/bootstrap.php");

function page()
{
    global $db, $session;

    //did we get passed a userid?
    $user=[];
    if($_GET['id']){
        //build up a user
        $userid=intval($_GET['id']);
        $user=$db->from('users')->where('id',$userid)->fetch();
    }

    //build up all the bits we need for dropdowns
    $departments = $db->select('id,department_name')->from('user_departments')->order_by('department_name')->fetch_as_select_options('department_name');
    $positions = $db->select('id,position_name')->from('user_positions')->order_by('position_name')->fetch_as_select_options('position_name');
    $permissionGroups = $db->select('id,group_name')->from('core_permission_groups')->order_by('group_name')->fetch_as_select_options('group_name');

    $formOptions = array('action'=>'user.php',
        'data' => $user,
        'files'=>true,
        'title' => 'User Setup',
    );
    $userForm = new Form($formOptions);
    $userForm->openTab('Basic Information');

        $sidebar = array('class'=>'warning', 'title'=>'Be careful!', 'body'=>'Be sure you complete all fields');
        $userForm->setSidebar($sidebar);

        $validation=array(
            'required' => 'true',
            'error' => 'First and last names are required'
        );
        $options = array('field'=>'firstname','label'=>"First name",'description'=>'', 'validation' => $validation);
        $userForm->text($options);

        $options = array('field'=>'middlename','label'=>"Middle name",'description'=>'', 'validation' => array());
        $userForm->text($options);

        $validation=array(
            'required' => 'true',
            'error' => 'First and last names are required'
        );
        $options = array('field'=>'lastname','label'=>"Last name",'description'=>'', 'validation' => $validation);
        $userForm->text($options);

        $validation=array(
            'required' => 'true',
            'type' => 'email',
            'error' => 'A valid email address is required.'
        );
        $options = array('field'=>'email','label'=>"Email Address",'description'=>'', 'validation' => $validation);
        $userForm->email($options);

        $userForm->openFieldSet('Phone numbers');
            $options = array('field'=>'business','label'=>"Office Number",'description'=>'This is the full number, not just extension');
            $userForm->phone($options);

            $options = array('field'=>'extension','label'=>"Extension",'description'=>'This is the full number, not just extension');
            $userForm->number($options);

            $options = array('field'=>'home','label'=>"Home Number",'description'=>'');
            $userForm->phone($options);

            $options = array('field'=>'cell','label'=>"Cell Number",'description'=>'');
            $userForm->phone($options);
            $options = array('field'=>'carrier','label'=>"Cell Carrier",'description'=>'', 'options' => $userForm->arrayToOptions($GLOBALS['carriers']));
            $userForm->select($options);
        $userForm->closeFieldSet();

    $userForm->closeTab();


    $userForm->openTab('Advanced');

        $options = array('field'=>'department_id','label'=>"Department",'description'=>'', 'options' => $departments);
        $userForm->select($options);

        $options = array('field'=>'position_id','label'=>"Position",'description'=>'', 'options' => $positions);
        $userForm->select($options);

        //@TODO need to add field for mugshot -- but that needs to be hooked into a graphics library system

        $options = array('field'=>'vision_data_sales_id','label'=>"Vision Data Sales ID",'description'=>'');
        $userForm->text($options);

        $options = array('field'=>'vision_data_sales_name','label'=>"Vision Data Sales Name",'description'=>'');
        $userForm->text($options);

        $options = array('field'=>'email_password','label'=>"Email Password",'description'=>'', 'confirm' => false);
        $userForm->password($options);

        $options = array('field'=>'network_password','label'=>"Network Password",'description'=>'', 'confirm' => false);
        $userForm->password($options);

        $options = array('field'=>'permission_group','label'=>"Permission Group",'description'=>'', 'options' => $permissionGroups);
        $userForm->select($options);

        $options = array('field'=>'temp_employee','label'=>"Temp Employee",'description'=>'');
        $userForm->checkbox($options);

        $options = array('field'=>'debug_user','label'=>"Debug User",'description'=>'');
        $userForm->checkbox($options);

        $options = array('field'=>'super_user','label'=>"Super User",'description'=>'');
        $userForm->checkbox($options);


    $userForm->closeTab();


    $userForm->generate();
}