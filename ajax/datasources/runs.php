<?php
include '../../includes/bootstrap.php';

function page()
{
    global $db,$session;
    //passed param is in 'value'

    //validate that we have a secure form request via CSRF Token check
    if($_SERVER['HTTP_X_CSRF_TOKEN']==$session->csrf_token) {
        $pub_id = intval($_GET['pub_id']);
        $runs = $db->select('id,run_name')->from('publications_runs')->where('pub_id', $pub_id)->order_by('run_name')->fetch();
        if ($db->affected_rows > 0) {
            $json = array();
            $json[] = array('' => "Please select");
            $json[] = array('_other' => "Enter a new run name");
            foreach ($runs as $run) {
                $json[] = array($run['id'] => $run['run_name']);
            }
        } else {
            $json = array('status' => 404, 'message' => 'No publications found');
        }
    } else {
        $json = array('status' => 403, 'message' => 'Forged request');
    }
    echo json_encode($json);
}