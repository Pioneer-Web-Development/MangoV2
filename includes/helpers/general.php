<?php


function generate_random_string($length,$numeric=false)
{
    if($numeric)
    {
        $randstr='';
        while(strlen($randstr)<$length)
        {
            $randstr.=mt_rand(0,9);
        }
    } else {
        $randstr = "";
        for($i=0; $i<$length; $i++){
            $randnum = mt_rand(0,61);
            if($randnum < 10){
                $randstr .= chr($randnum+48);
            }else if($randnum < 36){
                $randstr .= chr($randnum+55);
            }else{
                $randstr .= chr($randnum+61);
            }
        }
    }

    return $randstr;
}