<?php

//specify which fields can be filled (helps prevent any kind of forged submissions)

$fillable = array('department_id','position_id','firstname', 'middlename', 'lastname','cell','carrier','extension','business','home','fax','email','username','password',
    'admin','summary','allpubs','site_id','mugshot','permission_group','email_password','network_password','notes','vision_data_sales_id','vision_data_sales_name',
    'debug_user','temp_employee','super_user','last_login','last_login_lat','last_login_lng','last_login_address','created_at','updated_at','reset_token',
    'remember_token','active','token','online','last_online');

if($this->checkFields($fillable)) {
    //ok, let's do a database update
    if ($this->method == 'PATCH') {
        //updating a record
        $db->where('id', $this->recordID)->update('users', $this->posted);
    } else {
        //create a new record
        $id = $db->insert('users', $this->posted);
    }

    redirect('/pages/user/users.php');
}
