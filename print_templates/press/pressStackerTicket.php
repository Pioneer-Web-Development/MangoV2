<?php

//@TODO need to convert to new system, db, etc.
?>
<html>
<head>
</head>
<body onload="window.print();">
<?php
include("../includes/functions_db.php");
include("../includes/functions_common.php");
include("../includes/config.php");

global $pubs,$sizes, $producttypes, $papertypes;
$jobid=intval($_GET['jobid']);
/*
Publication
Run Name
Pub Date
Draw
Page Count
Page Width
Press Notes
Bindery Notes
Packaging Notes
If it ¼ folds
Inserting notes
If it inserts
Delivery notes
*/
$sql="SELECT * FROM jobs WHERE id=$jobid";
$dbJob=dbselectsingle($sql);
$job=$dbJob['data'];

$sql="SELECT run_name FROM publications_runs WHERE id=$job[run_id]";
$dbRun=dbselectsingle($sql);
$runname=stripslashes($dbRun['data']['run_name']);

$sql="SELECT * FROM jobs_sections WHERE job_id=$jobid";
if($GLOBALS['debug']){
    print "Section sql is $sql<br />";
}

$scodes=array();
$ptypes=array();
$pagelist='';
$dbSections=dbselectsingle($sql);
if($dbSections['numrows']>0)
{
    $sections=$dbSections['data'];
    if($GLOBALS['debug']){
        print_r($sections);
    }
    for($i=1;$i<=3;$i++)
    {
        $rawpages=0;
        $rawcolorpages=0;
        $rawspotpages=0;
        $sectionformat=$sections['section'.$i.'_producttype'];
        $sectioncode=$sections['section'.$i.'_code'];
        if($sections['section'.$i.'_used']==1)
        {
            $sectioncode=str_replace("0","",$sectioncode);
            $sectioncode=str_replace(" ","",$sectioncode);
            if(!in_array($sectioncode,$scodes)){$scodes[]=$sectioncode;}
            $pagelist.='<br />'.$sectioncode.': ';
            //1 = broadsheet, 2 & 3 == tab, 4=flexi
            $pagesql="SELECT * FROM job_pages WHERE job_id=$jobid AND version=1 AND section_code='$sectioncode'";
            if($GLOBALS['debug']){
                print "Format is $sectionformat i is $i, code is --$sectioncode-- Page sql: $sql<br />";
            }
            $dbPages=dbselectmulti($pagesql);
            if($dbPages['numrows']>0)
            {
                foreach($dbPages['data'] as $page)
                {
                    if($page['color']==1)
                    {
                        $rawcolorpages++;
                        $pagelist.=$page['page_number'].' FC, ';
                    }elseif($page['spot']==1)
                    {
                        $rawspotpages++;
                        $pagelist.=$page['page_number'].' S, ';
                    } else {
                        $pagelist.=$page['page_number'].' BW, ';
                    }
                    $rawpages++;
                }

            }
            switch($sectionformat)
            {
                case 0:
                    $broadsheetpages+=$rawpages;
                    $broadsheetcolorpages+=$rawcolorpages;
                    $broadsheetspotpages+=$rawspotpages;
                    if(!in_array('Bdsht',$ptypes)){$ptypes[]='Bdsht';}
                    break;

                case 1:
                    $broadsheetpages+=$rawpages/2;
                    $broadsheetcolorpages+=$rawcolorpages/2;
                    $broadsheetspotpages+=$rawspotpages/2;
                    if(!in_array('Tab',$ptypes)){$ptypes[]='Tab';}
                    break;

                case 2:
                    $broadsheetpages+=$rawpages/2;
                    $broadsheetcolorpages+=$rawcolorpages/2;
                    $broadsheetspotpages+=$rawspotpages/2;
                    if(!in_array('Tab',$ptypes)){$ptypes[]='Tab';}
                    break;

                case 3:
                    $broadsheetpages+=$rawpages/4;
                    $broadsheetcolorpages+=$rawcolorpages/4;
                    $broadsheetspotpages+=$rawspotpages/4;
                    if(!in_array('Flexi',$ptypes)){$ptypes[]='Flexi';}
                    break;
            }
        }
    }
}
$ptypes=trim(implode(",",$ptypes),',');
$scodes=trim(implode(",",$scodes),',');

//see if there is an insert
$sql="SELECT id FROM inserts WHERE weprint_id=$jobid";
$dbInsert=dbselectsingle($sql);
if($dbInsert['numrows']>0){$insert=true;}else{$insert=false;}
print "<b>Publication:</b> ".$pubs[$job['pub_id']]."<br />\n";
print "<b>Run:</b> $runname<br />\n";
print "<b>Pub Date: </b>".date("m/d/Y",strtotime($job['pub_date']))."<br />\n";
print "<b>Scheduled Start: </b>".date("m/d/Y H:i",strtotime($job['startdatetime']))."<br />\n";
print "<b>Draw: </b>".$job['draw']."<br />\n";
if($job['draw_hd']>0)
{
    print "<b>Draw (Home Delivery):</b> ".$job['draw_hd']."<br />";
}
if($job['draw_sc']>0)
{
    print "<b>Draw (Single Copy):</b> ".$job['draw_sc']."<br />";
}
if($job['draw_mail']>0)
{
    print "<b>Draw (Mail):</b> ".$job['draw_mail']."<br />";
}
if($job['draw_office']>0)
{
    print "<b>Draw (Office Copies):</b> ".$job['draw_office']."<br />";
}
if($job['draw_customer']>0)
{
    print "<b>Draw (Customer):</b> ".$job['draw_customer']."<br />";
}
if($job['draw_other']>0)
{
    print "<b>Draw (Other):</b> ".$job['draw_other']."<br />";
}
print "<b>Lap: </b>".$job['lap']."<br />\n";
print "<b>Paper Type: </b>".$papertypes[$job['papertype']]."<br />\n";
print "<b>Paper Size: </b>".$sizes[$job['rollSize']]."<br />\n";
print "<b>Product Type: </b>$ptypes<br />\n";
print "<b>Broadsheet Pages: </b>$broadsheetpages $pagelist<br />\n";
print "<b>Fold:</b> ".($job['quarterfold'] ? 'Quarterfold' : 'Half-fold')."<br />\n";
print "<b>Gatefold:</b> ".($job['gatefold'] ? 'Has one' : 'None')."<br />\n";
print "<b>Folder:</b> ".$job['folder']."<br />\n";
print "<b>Will be stitched:</b> ".($job['stitch'] ? 'Yes' : 'No')."<br />\n";
print "<b>Will be trimmed:</b> ".($job['trim'] ? 'Yes' : 'No')."<br />\n";
print "<b>Will be inserted:</b> ".($insert ? 'Yes' : 'No')."<br />\n";
print "<b>Notes: </b>".stripslashes($job['notes_job'])."<br />\n";
print stripslashes($job['notes_press'])."<br />\n";
print stripslashes($job['notes_inserting'])."<br />\n";
print stripslashes($job['notes_bindery'])."<br />\n";
print stripslashes($job['notes_delivery'])."<br />\n";

//see if there are any sections, and add up pages

dbclose();
?>
</body>
</html>
