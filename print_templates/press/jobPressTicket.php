<?php
//<!--VERSION: .9 **||**-->
error_reporting(0);

//@TODO need to implement fetching data from new system database & includes
?>

<html>
<head>
    <style type='text/css'>
        body {
            font-family:Verdana;
            font-size:12px;
        }
        .fieldlabel
        {
            float:left;
            font-weight:bold;
            width:150px;
            height:30px;
            padding-top:14px;
        }
        .fieldvalue
        {
            float:left;
            height:30px;
            width:200px;
            border-bottom:1px solid black;
        }
        .noteline
        {
            float:left;
            height:30px;
            width:420px;
            border-bottom:1px solid black;
        }
        .checkbox {
            height:20px;
            width:20px;
            border: 1px solid black;
            float:left;
            margin-right:3px;
        }
        .checkitem {
            width:170px;
            font-size:10px;
            float:left;
        }
        .grid table{
            border-spacing:1px;
            font:10px, Verdana, Arial, Helvetica, sans-serif;
            background:#BBBBBB;
            color:#333333;
            width:420px;
        }
        .grid td, .grid th{
            padding:2px;
        }
        .grid td {
            font-size:12px;
        }
        .grid th{
            text-align:center;
            background:#666666;
            color:#FFFFFF;
            font-size:10px;
            border:1px solid #000000;
            text-transform:uppercase;
        }
        .grid th{
            font-weight:bold;
        }
        .grid tr.odd{
            background:#EEEEEE;
            border-top:1px solid #ffffff;
        }
        .grid th a:link, .grid th a:visited{
            color:#FFFFFF;
            padding:2px 0px 0px 6px;
        }
        .grid th a:hover{
            color:#000000;
        }
        .grid tr td{
            height:20px;
            background:#BBBBBB;
            border:1px solid #ffffff;
        }
        .grid tr.odd td{
            background:#EEEEEE;
            border-top:1px solid #ffffff;
        }
        .grid td a:link, .grid td a:visited{
            color:#0033FF;
            text-decoration:none;
            font-weight: bold;
        }
        .grid td a:hover{
            color:#FFFFFF;
            text-decoration:underline;
            font-weight: bold;
        }
        .grid td a{
            margin:0 auto;
            height:12px;
            border-bottom:0;
            padding:2px 0px 0px 2px;
            font-weight:bold;
            color:#0033FF;
        }
        .grid tfoot th, .grid tfoot td{
            padding:2px;
            text-align:center;
            font:10px 'Verdana', Arial, Helvetica, sans-serif;
            font-style:italic;
            font-weight:bold;
            border-bottom:3px solid #cccccc;
            border-top:1px solid #DFDFDF;
        }
        .clear{
            clear:both;
            height:0px;
            line-height:0px;
        }
    </style>
</head>
<?php
if ($_GET['action']=='print')
{
    include("includes/functions_db.php");
    include("includes/functions_formtools.php");
    include("includes/config.php");
    include("includes/layoutGenerator.php");

} else {
    include("includes/mainmenu.php") ;
    $scriptpath='http://'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'] ;
}
?>
<body onload="window.print();">


<?php
//this script will be used to print out a press job sheet
//and to collect the press data at the end of the night

if ($_POST)
{
    $action=$_POST['submit'];
} else {
    $action=$_GET['action'];
}

switch ($action)
{
    case "print":
        job_ticket('print');
        break;
}

function job_ticket()
{
    global $papertypes, $producttypes, $folderpins;
    $jobid=$_GET['jobid'];
    //get job info
    $sql="SELECT * FROM jobs WHERE id=$jobid";
    $dbJob=dbselectsingle($sql);
    $job=$dbJob['data'];
    $layoutid=$job['layout_id'];
    $pubid=$job['pub_id'];
    $lap=$job['lap'];
    $draw=$job['draw'];
    $stitch=$job['stitch'];
    $trim=$job['trim'];
    $pagewidth=$job['pagewidth'];
    if($job['slitter']){$slitter='On';}else{$slitter='Off';}
    $folderpin=$job['folder_pin'];
    if ($stitch || $trim){$stitch=" YES!";}else{$stitch="";}
    $quarterfold=$job['quarterfold'];
    $notes=$job['notes_job'];
    $printdate=date("D m/d",strtotime($job['startdatetime']));
    $printtime=date("H:i",strtotime($job['startdatetime']));
    if ($job['quarterfold']){$quarterfold='Yes';}else{$quarterfold='No';}
    $pubdate=date("D m/d/Y",strtotime($job['pub_date']));
    $paper=$papertypes[$job['papertype']];
    if($job['papertype_cover']!=0)
    {
        $coverpaper=$papertypes[$job['papertype_cover']];
    }
    $jobmessage=stripslashes($job['job_message']);
    $sql="SELECT * FROM publications WHERE id=$job[pub_id]";
    $dbPub=dbselectsingle($sql);
    $pubInfo=$dbPub['data'];
    $sql="SELECT * FROM publications_runs WHERE id=$job[run_id]";
    $dbRun=dbselectsingle($sql);
    $runInfo=$dbRun['data'];
    $sql="SELECT * FROM jobs_sections WHERE job_id='$jobid'";
    $dbSections=dbselectsingle($sql);
    $sections=$dbSections['data'];
    $totalpages=0;
    //ok, lets get how many color/bw pages by section
    //section1
    $section1_overrun=$sections['section1_overrun'];
    if ($section1_overrun>0){$overrun=true;}
    $section1_name=$sections['section1_name'];
    $section1_code=$sections['section1_code'];
    $section1_totalpages=0;
    $section1_colorpages=0;
    $section1_bwpages=0;
    $section1_format=$producttypes[$sections['section1_producttype']];
    $section1_lead=$leadtypes[$sections['section1_leadtype']];
    if ($sections['section1_gatefold']){$section1_gate='Has gatefold';}else{$section1_gate='';}
    if ($sections['section1_doubletruck']){$section1_double='Has doubletruck';}else{$section1_double='';}
    $sql="SELECT * FROM job_pages WHERE job_id=$jobid AND section_code='$sections[section1_code]' AND version=1 ORDER BY page_number ASC";
    $dbPages=dbselectmulti($sql);
    if ($dbPages['numrows']>0)
    {
        foreach($dbPages['data'] as $page)
        {
            $section1_totalpages++;
            if ($page['color']){$section1_colorpages++;}else{$section1_bwpages++;}
        }
    }
    $totalpages+=$section1_totalpages;
    //section2
    $section2_overrun=$sections['section2_overrun'];
    if ($section2_overrun>0){$overrun=true;}
    $section2_name=$sections['section2_name'];
    $section2_code=$sections['section2_code'];
    $section2_totalpages=0;
    $section2_colorpages=0;
    $section2_bwpages=0;
    $section2_format=$producttypes[$sections['section2_producttype']];
    $section2_lead=$leadtypes[$sections['section2_leadtype']];
    if ($sections['section2_gatefold']){$section2_gate='Has gatefold';}else{$section2_gate='';}
    if ($sections['section2_doubletruck']){$section2_double='Has doubletruck';}else{$section2_double='';}
    $sql="SELECT * FROM job_pages WHERE job_id=$jobid AND section_code='$sections[section2_code]' AND version=1 ORDER BY page_number ASC";
    $dbPages=dbselectmulti($sql);
    if ($dbPages['numrows']>0)
    {
        foreach($dbPages['data'] as $page)
        {
            $section2_totalpages++;
            if ($page['color']){$section2_colorpages++;}else{$section2_bwpages++;}
        }
    }
    $totalpages+=$section2_totalpages;
    //section3
    $section3_overrun=$sections['section3_overrun'];
    if ($section3_overrun>0){$overrun=true;}
    $section3_name=$sections['section3_name'];
    $section3_code=$sections['section3_code'];
    $section3_totalpages=0;
    $section3_colorpages=0;
    $section3_bwpages=0;
    $section3_format=$producttypes[$sections['section3_producttype']];
    $section3_lead=$leadtypes[$sections['section3_leadtype']];
    if ($sections['section3_gatefold']){$section3_gate='Has gatefold';}else{$section3_gate='';}
    if ($sections['section3_doubletruck']){$section3_double='Has doubletruck';}else{$section3_double='';}
    $sql="SELECT * FROM job_pages WHERE job_id=$jobid AND section_code='$sections[section3_code]' AND version=1 ORDER BY page_number ASC";
    $dbPages=dbselectmulti($sql);
    if ($dbPages['numrows']>0)
    {
        foreach($dbPages['data'] as $page)
        {
            $section3_totalpages++;
            if ($page['color']){$section3_colorpages++;}else{$section3_bwpages++;}
        }
    }
    $totalpages+=$section3_totalpages;


    print "<div id='layout' style='width:690px;height:900px;'>\n";
    if ($jobmessage!='')
    {
        print "<div style='width:690px;padding:4px;border:1px solid black;'>$jobmessage</div>\n";
    }
    //display the layout
    print "<div id='leftside' style='margin-right:10px;float:left;width:220px;'>\n";
    print "<div id='pressconfig' style='border: thin solid black;padding:4px;background-color:white;'>\n";
    configureDiagram($layoutid,true,false,true);
    print "</div>\n";

    print "<div style='margin-top:10px;background-color:white;padding:4px;'>\n";
    //pull in any checklist items
    $sql="SELECT * FROM checklist WHERE checklist_category='Pressroom' ORDER BY checklist_order ASC";
    $dbCheck=dbselectmulti($sql);
    if ($dbCheck['numrows']>0)
    {
        print "<p style='font-weight:bold;text-size:14px;'>Daily Checklist items</p>\n";
        foreach($dbCheck['data'] as $item)
        {
            print "<div class='checkbox'></div><div class='checkitem'>$item[checklist_item]</div><div style='clear:both;'></div>\n";

        }
    }
    print "</div>\n";

    print "<div style='background-color:white;padding:4px;'>\n";
    print "<div style='margin-left:50px;font-weight:bold;'>DOWNTIME</div>\n";
    print "<div style='margin-left:30px;float:left;'>Stop</div>\n";
    print "<div style='margin-left:30px;float:left;'>Start</div>\n";
    print "<div style='margin-left:30px;float:left;'>QTY</div>\n";
    print "<div class='clear'></div>\n";

    print "<div class='fieldlabel' style='width:10px;height:20px;'>1: </div>
            <div style='padding-top:10px;height:20px;width:50px;border-bottom:thin solid black;float:left;margin-left:10px;'></div>
            <div style='padding-top:10px;height:20px;width:50px;border-bottom:thin solid black;float:left;margin-left:10px;'></div>
            <div style='padding-top:10px;height:20px;width:50px;border-bottom:thin solid black;float:left;margin-left:10px;'></div>
            <div style='clear:both;height:0px;'></div>\n";
    print "<div class='fieldlabel' style='width:46px;height:20px;'>Reason: </div>
            <div style='padding-top:10px;height:20px;width:130px;border-bottom:thin solid black;float:left;margin-left:10px;'></div>
            <div class='clear'></div>\n";

    print "<div class='fieldlabel' style='width:10px;height:20px;'>2: </div>
            <div style='padding-top:10px;height:20px;width:50px;border-bottom:thin solid black;float:left;margin-left:10px;'></div>
            <div style='padding-top:10px;height:20px;width:50px;border-bottom:thin solid black;float:left;margin-left:10px;'></div>
            <div style='padding-top:10px;height:20px;width:50px;border-bottom:thin solid black;float:left;margin-left:10px;'></div>
            <div class='clear'></div>\n";
    print "<div class='fieldlabel' style='width:46px;height:20px;'>Reason: </div>
            <div style='padding-top:10px;height:20px;width:130px;border-bottom:thin solid black;float:left;margin-left:10px;'></div>
            <div class='clear'></div>\n";

    print "<div class='fieldlabel' style='width:10px;height:20px;'>3: </div>
            <div style='padding-top:10px;height:20px;width:50px;border-bottom:thin solid black;float:left;margin-left:10px;'></div>
            <div style='padding-top:10px;height:20px;width:50px;border-bottom:thin solid black;float:left;margin-left:10px;'></div>
            <div style='padding-top:10px;height:20px;width:50px;border-bottom:thin solid black;float:left;margin-left:10px;'></div>
            <div class='clear'></div>\n";
    print "<div class='fieldlabel' style='width:46px;height:20px;'>Reason: </div>
            <div style='padding-top:10px;height:20px;width:130px;border-bottom:thin solid black;float:left;margin-left:10px;'></div>
            <div class='clear'></div>\n";

    print "<div class='fieldlabel' style='width:10px;height:20px;'>4: </div>
            <div style='padding-top:10px;height:20px;width:50px;border-bottom:thin solid black;float:left;margin-left:10px;'></div>
            <div style='padding-top:10px;height:20px;width:50px;border-bottom:thin solid black;float:left;margin-left:10px;'></div>
            <div style='padding-top:10px;height:20px;width:50px;border-bottom:thin solid black;float:left;margin-left:10px;'></div>
            <div class='clear'></div>\n";
    print "<div class='fieldlabel' style='width:46px;height:20px;'>Reason: </div>
            <div style='padding-top:10px;height:20px;width:130px;border-bottom:thin solid black;float:left;margin-left:10px;'></div>
            <div class='clear'></div>\n";


    print "</div>\n";

    print "</div>\n";

    print "<div id='rightside' style='width:450px;float:left;'>\n";
    print "<span style='text-align:center;font-weight:bold;font-size:16px;'>$pubInfo[pub_name] - $runInfo[run_name]</span><br>\n";
    print "<div style='width:300px;float:left;'>\n";
    print "<b>Run: </b>$runInfo[run_name]<br>\n";
    print "<b>Pub Date: </b>$pubdate<br>\n";
    print "<b>Print Date: </b>$printdate<br>\n";
    print "<b>Print Time: </b>$printtime<br>\n";
    print "<b>Paper type: </b>$paper<br>\n";
    if($coverpaper!='')
    {
        print "<span style='color:red;font-weight:bold;'>SPECIAL NOTE: Cover is on $coverpaper</span><br>\n";
    }
    print "<b>Page width: </b>$pagewidth<br>";
    print "</div>\n";
    print "<div style='width:150px;float:left;'>\n";
    print "<b>Total Pages: </b>$totalpages<br>\n";
    print "<b>Draw: </b>$draw<br>\n";
    print "<b>Quarterfold: </b>$quarterfold<br>\n";
    print "<b>Lap: </b>$lap<br>\n";
    print "<b>Folder Pin: </b>$folderpins[$folderpin]<br>\n";
    print "<b>Slitter: </b>$slitter<br>\n";
    print "<b>Stitch &amp; Trim: </b>$stitch<br>\n";
    print "</div>\n";
    print "<div style='clear:both;'></div>\n";
    if ($overrun)
    {
        print "<p style='font-weight:bold;'>This job has an OVERRUN! Please enter the FINAL stop counter after the overrun, DO NOT use the stop counter of the main portion. Calculations will be performed automagically.</p>\n";
    }
    //look in inserts for this pub date, pub id and sticky_note=1
    $sql="SELECT A.*, B.account_name FROM inserts A, accounts B WHERE A.pub_id='$pubid' AND A.pub_date='$pubdate' AND A.sticky_note=1 AND A.advertiser_id=B.id";
    $dbStickyNote=dbselectsingle($sql);
    if($dbStickyNote['numrows']>0)
    {
        print "<p style='font-weight:bold;'>There is a sticky note from ".$dbStickyNote['data']['account_name']." for this publication today!</p>\n";
    }
    print "<hr>\n";
    print "<div style='font-family:Tahoma;font-weight:bold;font-size:8px;'>\n";
    print "<table class='grid' style='width:420px;'>\n";
    print "<tr><th>Section Name</th><th>Letter</th><th>Format</th><th>Pages</th><th>Color</th><th>BW</th><th>Overrun</th></tr>\n";
    print "<tr>";
    print "<td>$section1_name</td>";
    print "<td>$section1_code</td>";
    print "<td>$section1_format</td>";
    print "<td>$section1_totalpages</td>";
    print "<td>$section1_colorpages</td>";
    print "<td>$section1_bwpages</td>";
    print "<td>$section1_overrun</td>";
    print "</tr>\n";
    if ($section2_name!='')
    {
        print "<tr>";
        print "<td>$section2_name</td>";
        print "<td>$section2_code</td>";
        print "<td>$section2_format</td>";
        print "<td>$section2_totalpages</td>";
        print "<td>$section2_colorpages</td>";
        print "<td>$section2_bwpages</td>";
        print "<td>$section2_overrun</td>";
        print "</tr>\n";
    }
    if ($section3_name!='')
    {
        print "<tr>";
        print "<td>$section3_name</td>";
        print "<td>$section3_code</td>";
        print "<td>$section3_format</td>";
        print "<td>$section3_totalpages</td>";
        print "<td>$section3_colorpages</td>";
        print "<td>$section3_bwpages</td>";
        print "<td>$section3_overrun</td>";
        print "</tr>\n";
    }
    print "<tr>";
    print "<td><b>Totals:</b></td>";
    print "<td></td>";
    print "<td></td>";
    print "<td><b>$totalpages</b></td>";
    print "<td><b>".($section1_colorpages+$section2_colorpages+$section3_colorpages)."</b></td>";
    print "<td><b>".($section1_bwpages+$section2_bwpages+$section3_bwpages)."</b></td>";
    print "<td>----</td>";
    print "</tr>\n";
    print "</table>\n";
    print "</div>\n";
    print "<div class='fieldlabel'>Counter Start: </div><div class='fieldvalue'></div><div style='clear:both;height:0px;'></div>\n";
    print "<div class='fieldlabel'>Startup Spoils: </div><div class='fieldvalue'></div><div style='clear:both;height:0px;'></div>\n";
    print "<div class='fieldlabel'>Counter Stop: </div><div class='fieldvalue'></div><div style='clear:both;height:0px;'></div>\n";
    print "<div class='fieldlabel'>Actual draw: </div><div class='fieldvalue'></div><div style='clear:both;height:0px;'></div>\n";

    print "<div class='fieldlabel'>Start Time: </div><div class='fieldvalue'></div><div style='clear:both;height:0px;'></div>\n";
    print "<div class='fieldlabel'>Good Copy: </div><div class='fieldvalue'></div><div style='clear:both;height:0px;'></div>\n";
    print "<div class='fieldlabel'>Stop Time: </div><div class='fieldvalue'></div><div style='clear:both;height:0px;'></div>\n";

    print "<div class='fieldlabel'>Original Plates Count: </div>
    <div class='fieldvalue'></div><div style='clear:both;height:0px;'></div>\n";
    print "<div class='fieldlabel' style='width:120px;'>Waste Plates: </div>
    <div class='fieldvalue' style='width:80px;'></div>
    <div class='fieldlabel' style='margin-left:10px;width:120px;'>Chase Plates: </div>
    <div class='fieldvalue' style='width:80px;'></div>
    <div style='clear:both;height:0px;'></div>\n";
    print "<div class='fieldlabel' style='width:120px;'>Color Pages: </div>
    <div class='fieldvalue' style='width:80px;'></div>
    <div class='fieldlabel' style='margin-left:10px;width:120px;'>BW Pages: </div>
    <div class='fieldvalue' style='width:80px;'></div>
    <div style='clear:both;height:0px;'></div>\n";
    print "<div class='fieldlabel'>Lead Pressman: </div><div class='fieldvalue'></div><div style='clear:both;height:0px;'></div>\n";
    print "<div class='fieldlabel' style='width:120px;'>Pressman Count: </div>
    <div class='fieldvalue' style='width:80px;'></div>
    <div class='fieldlabel' style='margin-left:10px;width:120px;'>Mailroom Count: </div>
    <div class='fieldvalue' style='width:80px;'></div>
    <div style='clear:both;height:0px;'></div>\n";
    print "<div class='fieldlabel'>Page Numbers Checked: </div>
    <div class='fieldvalue'></div><div style='clear:both;height:0px;'></div>\n";

    print "<br />\n";
    print "<br><b>Notes:</b><br>\n";
    print "<div style='font-size:10px;'>$notes</div>\n";
    print "<div class='noteline'></div><br>\n";
    print "<div class='noteline'></div><br>\n";
    print "<div class='noteline'></div><br>\n";

    print "</div>\n";
    print "<div class='clear'></div>\n";

}

function job_data()
{
    print "<div id='wrapper'>\n";

    print "</div>\n";
}

dbclose();
?>

</body>
</html>