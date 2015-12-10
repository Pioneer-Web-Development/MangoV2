<?php

$template = 'master';

include("../includes/bootstrap.php");

function page()
{
    global $db, $session;
    //lets get a user
    $user = $db->from('users')->where('id',1);


    $formOptions = array('action'=>$_SERVER['PHP_SELF'],
        'id' => 'testForm',
        'data' => $user,
        'files'=>true,
        'class' => 'form-horizontal',
        'sidebar' => true,
        'title' => '',
        'description' => ''
    );
    $form = new Form($formOptions, $session);

    $sidebar = array('class'=>'warning', 'title'=>'Be careful!', 'body'=>'Be sure you complete all fields');
    $form->setSidebar($sidebar);

    $emailValidation=array(
        'required' => 'true',
        'error' => 'Please supply a valid email address'
    );
    $email = array('field'=>'email','label'=>"Email",'description'=>'', 'validation' => $emailValidation);
    $form->email($email);


    $firstNameValidation=array(

    );
    $firstName = array('field'=>'firstname','label'=>"First Name",'description'=>'', 'validation' => $firstNameValidation);
    $form->text($firstName);

    $lastName = array('field'=>'lastname','label'=>"Last Name",'description'=>'Fill in your last name');
    $form->text($lastName);

    $taName = array('field'=>'descriptionField','label'=>"Last Name",'description'=>'Fill in your last name');
    $form->textarea($taName);

    $phoneOptions = array('field'=>'phone','label'=>"Phone",'description'=>'Home Phone');
    $form->phone($phoneOptions);

    $checkOptions = array('field'=>'checkTest','label'=>"Check here",'description'=>'You authorize everything');
    $form->checkbox($checkOptions);

    $passwordValidation = array('pattern'=>'(?=^.{6,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$');
    $passwordOptions = array('field'=>'password','label'=>"Password",'description'=>'Enter a password at least 6 characters, with at least one symbol and number.', 'validation'=>$passwordValidation);
    $form->password($passwordOptions);

/*
    $dateValidation = array('disabledDays'=>'0,1','disabledDates'=>array("11/23/2015", "12/25/2015"), 'minDate'=>'11/1/2015', 'maxDate'=>'1/30/2016');
    $secondDateValidation = array('disabledDays'=>'0,1','disabledDates'=>array("11/23/2015", "12/25/2015"), 'minDate'=>'11/1/2015', 'maxDate'=>'1/30/2016');
    $dateOptions = array('field'=>'startdate', 'label'=>'Start/Stop Dates', 'description' =>'Enter a start  and stop date', 'validation' => $dateValidation,
        'second_field'=>'enddate',  'second_validation' => $secondDateValidation );
    $form->date($dateOptions);

    $timeValidation = array('stepping'=>5,'disabledDays'=>'0,1','disabledDates'=>array("11/23/2015", "12/25/2015"), 'minDate'=>'11/1/2015', 'maxDate'=>'1/30/2016');
    $secondTimeValidation = array('disabledDays'=>'0,1','disabledDates'=>array("11/23/2015", "12/25/2015"), 'minDate'=>'11/1/2015', 'maxDate'=>'1/30/2016');
    $dateOptions = array('field'=>'starttime', 'label'=>'Start/Stop Times', 'description' =>'Enter a start  and stop time', 'validation' => $timeValidation,
        'second_field'=>'endtime',  'second_validation' => $secondTimeValidation );
    $form->time($dateOptions);
*/

    $timeValidation = array('stepping'=>5,'disabledDays'=>'0,1','disabledDates'=>array("11/23/2015", "12/25/2015"), 'minDate'=>'11/1/2015', 'maxDate'=>'1/30/2016');
    $secondTimeValidation = array('stepping'=>5,'disabledDays'=>'0,1','disabledDates'=>array("11/23/2015", "12/25/2015"), 'minDate'=>'11/1/2015', 'maxDate'=>'1/30/2016');
    $dateOptions = array('field'=>'startdatetime', 'label'=>'Start/Stop Date Times', 'description' =>'Enter a start  and stop date time', 'validation' => $timeValidation,
        'second_field'=>'enddatetime',  'second_validation' => $secondTimeValidation );
    $form->datetime($dateOptions);

    $options=array('field'=>'department',
        'options'=>array(0=>'Advertising',1=>"Circulation",2=>'Production'),'label'=>'Department','description'=>'Select your department');
    $form->select($options);

    $options=array('field'=>'publications', 'url'=>'/ajax/forms/publications.php','label'=>'Publication','description'=>'Select a publication');
    $form->remoteSelect($options);

    $form->generate();
    //var_dump($this->formScripts);
    //grab any form scripts and append them to the global scripts array
    $GLOBALS['scripts']=array_merge($GLOBALS['scripts'],$form->formScripts);
}
