<?php
include($_SERVER['DOCUMENT_ROOT']."/includes/bootstrap.php");

function page()
{
    global $db, $user;
    /*
    *   will be generating a json list of jobs for the press calendar
    */

    $start="2015-11-30 00:01";
    $end = "2015-12-04 23:59";

    $start=$_POST['start']." 00:01";
    $end=$_POST['end']." 23:59";

    $jobs = $db->from('jobs')->where_in('site_id',$user->sites())->where_in('pub_id',$user->publications())->between('startdatetime',$start,$end)->fetch();

    $jobs['sql']=$db->last_query();


    echo json_encode($jobs);

}
