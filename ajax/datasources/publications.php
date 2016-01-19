<?php
include '../../includes/bootstrap.php';

function page()
{
    global $db;
    //passed param is in 'q'
    $pubs = $db->select('id,pub_name')->from('publications')->like('pub_name',$_POST['q'])->order_by('pub_name')->fetch();
    if($db->affected_rows>0)
    {
        $json=array();
        foreach($pubs as $pub)
        {
            $json['results'][]=array('id'=>$pub['id'],'text'=>$pub['pub_name']);
        }
    } else {
        $json = array('status' => 'error', 'message' => 'No publications found');

    }
    echo json_encode($json);
}