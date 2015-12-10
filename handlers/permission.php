<?php

//specify which fields can be filled (helps prevent any kind of forged submissions)

$fillable = array('displayname', 'include_js','js_varname','created_at','updated_at');

if($this->checkFields($fillable)) {
    //ok, let's do a database update
    if ($this->method == 'PATCH') {
        //updating a record
        $db->where('id', $this->recordID)->update('core_permission_list', $this->posted);
    } else {
        //create a new record
        $id = $db->insert('core_permission_list', $this->posted);
    }

    redirect('/pages/permissions/permissions.php');
}