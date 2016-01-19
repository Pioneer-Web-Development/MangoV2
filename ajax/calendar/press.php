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

    $data = $db->from('jobs')->where_in('site_id',$user->sites('list'))->where_in('pub_id',$user->publications('list'))->between('startdatetime',$start,$end)->fetch();

    $db->reset_where();
    $pubs = $db->from('publications')->fetch();

    $jobs=[];
    if(count($data)>0)
    {
        foreach($data as $job)
        {
            $jobs[]=array('id'=>$job['id'],
                          'title'=>"Press Job",
                          'start'=>$job['startdatetime'],
                          'end'=>$job['enddatetime'],
                          'color'=>
                );
        }
    }
    echo json_encode($jobs);

}
