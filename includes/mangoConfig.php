<?php
/*
 * This file contains all "hard-coded" configuration variables and needs to be included on every page load
 */
define( 'DB_HOST', 'localhost' );                               // set database host
define( 'DB_USER', 'mangouser' );                               // set database user
define( 'DB_PASS', '2rafar3aer#fdsD' );                         // set database password
define( 'DB_NAME', 'mangodb' );                                 // set database name
define( 'SEND_ERRORS_TO', 'jhansen@idahopress.com' );           //set email notification email address
define( 'DISPLAY_DEBUG', false );                                //display  errors?
define( 'SERVER_NAME', 'http://'.$_SERVER['SERVER_NAME'].'/' ); //server name
define( 'PAGE_BASE', 'pages' );




$shiptypes=array("pallet"=>"Pallet","boxes"=>"Boxes");

$oses=array(0=>'none installed',1=>'Windows 95',2=>'Windows 98',3=>'Windows 2000',4=>'Windows XP',5=>'Windows Vista',
    6=>'Windows 7',7=>'Windows 8',8=>'Windows Server 2000',9=>'Windows Server 2003',10=>'Windows Server 2008',11=>'Windows Server 2012',12=>'Mac OS 9',13=>'Mac OS 10.4.x',14=>'Mac OS 10.5.x',15=>'Mac OS 10.6.x',16=>'Mac OS 10.7.x',17=>'Mac OS 10.8.x',18=>'Mac OS 10.9.x',19=>'Filler',20=>'Ubuntu 8.04',21=>'Ubuntu 9.04',22=>'Ubuntu 10.04',23=>'Ubuntu 11.04',24=>'Ubuntu 12.04',25=>'Ubuntu 13.04');

$cellcarriers=array(array('id'=>0,'carrier'=>'3 River Wireless ','email'=>'@sms.3rivers.net '),array('id'=>1,'carrier'=>'ACS Wireless ','email'=>'@paging.acswireless.com '),array('id'=>2,'carrier'=>'Alltel ','email'=>'@message.alltel.com '),array('id'=>3,'carrier'=>'AT&T ','email'=>'@txt.att.net '),array('id'=>4,'carrier'=>'Bell Canada ','email'=>'@bellmobility.ca '),array('id'=>5,'carrier'=>'Bell Mobility (Canada) ','email'=>'@txt.bell.ca '),array('id'=>6,'carrier'=>'Bell Mobility ','email'=>'@txt.bellmobility.ca '),array('id'=>7,'carrier'=>'Blue Sky Frog ','email'=>'@blueskyfrog.com '),array('id'=>8,'carrier'=>'Bluegrass Cellular ','email'=>'@sms.bluecell.com '),array('id'=>9,'carrier'=>'Boost Mobile ','email'=>'@myboostmobile.com '),array('id'=>10,'carrier'=>'BPL Mobile ','email'=>'@bplmobile.com '),array('id'=>11,'carrier'=>'Carolina West Wireless ','email'=>'@cwwsms.com '),array('id'=>12,'carrier'=>'Cellular One ','email'=>'@mobile.celloneusa.com '),array('id'=>13,'carrier'=>'Cellular South ','email'=>'@csouth1.com '),array('id'=>14,'carrier'=>'Centennial Wireless ','email'=>'@cwemail.com '),array('id'=>15,'carrier'=>'CenturyTel ','email'=>'@messaging.centurytel.net '),array('id'=>16,'carrier'=>'Cingular (Now AT&T) ','email'=>'@txt.att.net '),array('id'=>17,'carrier'=>'Clearnet ','email'=>'@msg.clearnet.com '),array('id'=>18,'carrier'=>'Comcast ','email'=>'@comcastpcs.textmsg.com '),array('id'=>19,'carrier'=>'Corr Wireless Communications ','email'=>'@corrwireless.net '),array('id'=>20,'carrier'=>'Dobson ','email'=>'@mobile.dobson.net '),array('id'=>21,'carrier'=>'Edge Wireless ','email'=>'@sms.edgewireless.com '),array('id'=>22,'carrier'=>'Fido ','email'=>'@fido.ca '),array('id'=>23,'carrier'=>'Golden Telecom ','email'=>'@sms.goldentele.com '),array('id'=>24,'carrier'=>'Helio ','email'=>'@messaging.sprintpcs.com '),array('id'=>25,'carrier'=>'Houston Cellular ','email'=>'@text.houstoncellular.net '),array('id'=>26,'carrier'=>'Idea Cellular ','email'=>'@ideacellular.net '),array('id'=>27,'carrier'=>'Illinois Valley Cellular ','email'=>'@ivctext.com '),array('id'=>28,'carrier'=>'Inland Cellular Telephone ','email'=>'@inlandlink.com '),array('id'=>29,'carrier'=>'MCI ','email'=>'@pagemci.com '),array('id'=>30,'carrier'=>'Metrocall ','email'=>'@page.metrocall.com '),array('id'=>31,'carrier'=>'Metrocall 2-way ','email'=>'@my2way.com '),array('id'=>32,'carrier'=>'Metro PCS ','email'=>'@mymetropcs.com '),array('id'=>33,'carrier'=>'Microcell ','email'=>'@fido.ca '),array('id'=>34,'carrier'=>'Midwest Wireless ','email'=>'@clearlydigital.com '),array('id'=>35,'carrier'=>'Mobilcomm ','email'=>'@mobilecomm.net '),array('id'=>36,'carrier'=>'MTS ','email'=>'@text.mtsmobility.com '),array('id'=>37,'carrier'=>'Nextel ','email'=>'@messaging.nextel.com '),array('id'=>38,'carrier'=>'OnlineBeep ','email'=>'@onlinebeep.net '),array('id'=>39,'carrier'=>'PCS One ','email'=>'@pcsone.net '),array('id'=>40,'carrier'=>'Presidents Choice ','email'=>'@txt.bell.ca '),array('id'=>41,'carrier'=>'Public Service Cellular ','email'=>'@sms.pscel.com '),array('id'=>42,'carrier'=>'Qwest ','email'=>'@qwestmp.com '),array('id'=>43,'carrier'=>'Rogers AT&T Wireless ','email'=>'@pcs.rogers.com '),array('id'=>44,'carrier'=>'Rogers Canada ','email'=>'@pcs.rogers.com '),array('id'=>45,'carrier'=>'Satellink ','email'=>'.pageme@satellink.net '),array('id'=>46,'carrier'=>'Southwestern Bell ','email'=>'@email.swbw.com '),array('id'=>47,'carrier'=>'Sprint ','email'=>'@messaging.sprintpcs.com '),array('id'=>48,'carrier'=>'Sumcom ','email'=>'@tms.suncom.com '),array('id'=>49,'carrier'=>'Surewest Communicaitons ','email'=>'@mobile.surewest.com '),array('id'=>50,'carrier'=>'T-Mobile ','email'=>'@tmomail.net '),array('id'=>51,'carrier'=>'Telus ','email'=>'@msg.telus.com '),array('id'=>52,'carrier'=>'Tracfone ','email'=>'@txt.att.net '),array('id'=>53,'carrier'=>'Triton ','email'=>'@tms.suncom.com '),array('id'=>54,'carrier'=>'Unicel ','email'=>'@utext.com '),array('id'=>55,'carrier'=>'US Cellular ','email'=>'@email.uscc.net '),array('id'=>56,'carrier'=>'Solo Mobile ','email'=>'@txt.bell.ca '),array('id'=>57,'carrier'=>'US West ','email'=>'@uswestdatamail.com '),array('id'=>58,'carrier'=>'Verizon ','email'=>'@vtext.com '),array('id'=>59,'carrier'=>'Virgin Mobile ','email'=>'@vmobl.com '),array('id'=>60,'carrier'=>'Virgin Mobile Canada ','email'=>'@vmobile.ca '),array('id'=>61,'carrier'=>'West Central Wireless ','email'=>'@sms.wcc.net '),array('id'=>62,'carrier'=>'Western Wireless ','email'=>'@cellularonewest.com'));
$carriers=array("verizon"=>"Verizon","tmobile"=>"T-Mobile","sprint"=>"Sprint","att"=>"AT&amp;T","virgin"=>"Virgin Mobile","nextel"=>"Nextel","cingular"=>"Cingular",'cricket'=>"Cricket");

$pressMonitorLayouts=array("horizontal"=>"Main area layed out horizontally","vertical"=>"Main area layed out vertically");
$stickyLocations=array('press'=>"Off of the press",'inserter'=>'Off of the inserter');
$remakeLabels=array("remake"=>"Remake","chase"=>"Chase Plates");
$folderpins=array("nopin"=>"No Pin","pinlong"=>"Pin Long","pinshort"=>"Pin Short");

$mailingClasses=array("First Class","Second Class","Third Class","Fourth Class","Bulk");

//this is for part units for inventory
$qtypes=array("unit"=>"Unit/Pieces","gallon"=>"Gallons","pound"=>"Pounds","inch"=>"Inches");
$inventoryUnitTypes=array("count"=>"Count(pieces)","pounds"=>"Pounds","gallons"=>"Gallons","inches"=>"Inches");

$orderstatuses=array(0=>"Any status",1=>"Ordered",2=>"Received",3=>"Processed",4=>"Complete",99=>"Cancelled");
$tempsource=explode(",",$newsprintOrderSources);
$ordersources=array();
$ordersources[0]='Please choose';
foreach($tempsource as $key=>$value)
{
    $ordersources[$value]=$value;
}
$daysofweek=array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
$monthsOfYear=array("1"=>"January",2=>"February",3=>"March",4=>"April",5=>"May",6=>"June",7=>"July",8=>"August",9=>"September",10=>"October",11=>"November",12=>"December");

$recurFrequencies=array("Every Week","Every Other Week","Every 3rd Week","Every 4th Week", "On the first","On the second", "On the third", "On the fourth", "On the last");
/**********************************************************************
 *  THIS IS INFORMATION ABOUT THE INSERTER SETUP
 ***********************************************************************/
$insertertypes=array("oval"=>"oval","inline"=>"inline");
$inserterFileFormats=array("none"=>"none","miracom"=>"miracom");
$inserterHopperTypes=array("normal"=>"Normal","singlesheet"=>"Single Sheet","package"=>"Packages");
$defaultInserter=$prefs['defaultInserter'];
/**********************************************************************
 *  THIS IS INFORMATION ABOUT THE PRESS SETUP
 ***********************************************************************/
$orders=array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20);
$colorconfigs=array("NA","K","K/K","K/S","Y/M/C/K","M/Y/C/K","C/M/Y/K","K/C/M/Y");
$folderconfigs=array("NA","1"=>"1","2"=>"2","3"=>"3","4"=>"4");
$slitterconfigs=array("NA"=>"NA","center"=>"center","gear"=>"gear","operator"=>"operator");
$sectioncolors=array("1"=>"#0033FF","2"=>"#ff0000","3"=>"#009900");
$sections=array("1"=>"Section 1","2"=>"Section 2","3"=>"Section 3");
$producttypes=array("Broadsheet","Tab","Long Tab","Flexi");
$leadtypes=array("Newspaper","Commercial");
$balloontypes=array("NA"=>"NA","gear"=>"gear","operator"=>"operator");
$laps=array("none"=>"none","lap"=>"lap","reverse"=>"reverse");
/*
if($prefs['folderNames']=='')
{
    $folders=array("1"=>"Folder 1","2"=>"Folder 2");
} else {
    $folders=array();
    $f=explode(",",stripslashes($prefs['folderNames']));
    for($loopi=0;$loopi<count($f);$loopi++)
    {
        $folders[$loopi+1]=trim($f[$loopi]);
    }
}
*/
$towertypes=array("printing"=>"printing","folder"=>"folder","ribbon deck"=>"ribbon deck");
$jobTypes=array("newspaper"=>"Newspaper","commercial"=>"Commercial");
$cyan='#00ffff';
$magenta='#ff00ff';
$yellow='#ffff00';
$black='#000000';
/*
$sql="SELECT * FROM press ORDER BY name";
$dbPress=dbselectmulti($sql);
if($dbPress['numrows']>1)
{
    foreach($dbPress['data'] as $press)
    {
        $presses[$press['id']]=stripslashes($press['name']);
    }
} else {
    $presses[0]='No presses defined';
}
*/

/**********************************************************
 * THIS SECTION TURNS ON AND OFF VARIOUS COMPONENTS OF THE
 * SYSTEM, LIKE ACCESS TO PRESTELIGENCE INTEGRATION, ETC
 ********************************************************/

$touchscreenMenus=true; //not fully enabled, but future plans

$enableJobStops=false; //enable capture/reporting of press stops at console
$enableBenchmarks=false; //toggles reporting/capture of benchmarks
/**********************************************************
 * THIS IS THE END OF THE MODULE COMPONENT SECTION
 ********************************************************/

/**********************************************************
 * THIS IS THE NEWSPRINT SECTION
 ********************************************************/
/*
//get paper types
$sql="SELECT * FROM paper_types WHERE status=1 ORDER BY common_name";
$dbPaper=dbselectmulti($sql);
$papertypes=array();
$papertypes[0]="Please choose";
if ($dbPaper['numrows']>0)
{
    foreach($dbPaper['data'] as $paper)
    {
        $papertypes[$paper['id']]=$paper['common_name'];
    }
}

//get paper sizes
$sql="SELECT * FROM paper_sizes WHERE display=1 ORDER BY width ASC";
$dbSize=dbselectmulti($sql);
$sizes=array();
$sizes[0]="Please choose";
if ($dbSize['numrows']>0)
{
    foreach($dbSize['data'] as $size)
    {
        $sizes[$size['id']]=$size['width'];
    }
}
*/
//these figures area used in calculating newsprint usage
$paperdata[0]['name']='Newsprint';
$paperdata[0]['basissize']='864';
$paperdata[0]['reamarea']='3000';
$paperdata[0]['factor']='.019';
$paperdata[1]['name']='Offset/Book';
$paperdata[1]['basissize']='950';
$paperdata[1]['reamarea']='3300';
$paperdata[1]['factor']='.021';
$paperdata[2]['name']='Bond';
$paperdata[2]['basissize']='374';
$paperdata[2]['reamarea']='1300';
$paperdata[2]['factor']='.021';
/**********************************************************
 * THIS IS THE END OF THE MODULE COMPONENT SECTION
 ********************************************************/

/*
$userid=$_SESSION['cmsuser']['userid'];
$sql="SELECT * FROM user_publications WHERE user_id=$userid AND value=1";
if($debug){print "Getting publications with $sql<br>";print_r($_SESSION);}
$dbPubs=dbselectmulti($sql);
if ($dbPubs['numrows']>0)
{
    $pubids=array();
    foreach($dbPubs['data'] as $pub)
    {
        $pubids[]=$pub['pub_id'];
    }
    $pubids=implode(",",$pubids);
    if ($pubids!=''){$pubfilter="WHERE id IN ($pubids)";}else{$pubfilter="";}
} else {
    $pubids="";
}


//get publications
if ($pubfilter=='')
{
    $sql="SELECT * FROM publications WHERE site_id=$siteID ORDER BY sort_order, pub_name";
} else {
    $sql="SELECT * FROM publications $pubfilter AND site_id=$siteID ORDER BY sort_order, pub_name";
}
$dbPubs=dbselectmulti($sql);
$pubs=array();
$pubs[0]="Please choose";
if ($dbPubs['numrows']>0)
{
    foreach($dbPubs['data'] as $pub)
    {
        $pubs[$pub['id']]=$pub['pub_name'];
    }
}

//get sites
$sql="SELECT * FROM core_sites";
$dbSites=dbselectmulti($sql);
$sites=array();
$sites[0]="Please choose";
if ($dbSites['numrows']>0)
{
    foreach($dbSites['data'] as $site)
    {
        $sites[$site['id']]=$site['site_name'];
    }
}

//get employee positions
$sql="SELECT * FROM user_positions WHERE site_id=$siteID ORDER BY position_name";
$dbPositions=dbselectmulti($sql);
$employeepositions=array();
$employeepositions[0]="Please choose";
if ($dbPositions['numrows']>0)
{
    foreach($dbPositions['data'] as $s)
    {
        $employeepositions[$s['id']]=$s['position_name'];
    }
}

//get employee departments
$sql="SELECT * FROM user_departments WHERE site_id=$siteID ORDER BY department_name";
$dbDepartments=dbselectmulti($sql);
$departments=array();
$departments[0]="Please choose";
if ($dbDepartments['numrows']>0)
{
    foreach($dbDepartments['data'] as $s)
    {
        $departments[$s['id']]=$s['department_name'];
    }
}

//get sales reps
$sql="SELECT * FROM users WHERE department_id=$advertisingDepartmentID ORDER BY lastname";
$dbSales=dbselectmulti($sql);
$sales=array();
$sales[0]="Please choose";
if ($dbSales['numrows']>0)
{
    foreach($dbSales['data'] as $s)
    {
        $sales[$s['id']]=$s['firstname']." ".$s['lastname'];
    }
}

//get users
$sql="SELECT * FROM users ORDER BY lastname";
$dbUsers=dbselectmulti($sql);
$users=array();
$users[0]="Please choose";
if ($dbUsers['numrows']>0)
{
    foreach($dbUsers['data'] as $s)
    {
        $users[$s['id']]=$s['firstname']." ".$s['lastname'];
    }
}

//get pressman
$sql="SELECT * FROM users WHERE department_id=$pressDepartmentID ORDER BY lastname";
$dbPressman=dbselectmulti($sql);
$pressmen=array();
$pressmen[0]="Please choose";
if ($dbPressman['numrows']>0)
{
    foreach($dbPressman['data'] as $s)
    {
        $pressmen[$s['id']]=$s['firstname']." ".$s['lastname'];
    }
}

//get mailroom
$sql="SELECT * FROM users WHERE department_id=$mailroomDepartmentID ORDER BY lastname";
$dbMailroom=dbselectmulti($sql);
$mailers=array();
$mailers[0]="Please choose";
if ($dbMailroom['numrows']>0)
{
    foreach($dbMailroom['data'] as $s)
    {
        $mailers[$s['id']]=$s['firstname']." ".$s['lastname'];
    }
}

//get all production staff
$sql="SELECT * FROM users WHERE department_id IN($productionDepartmentID,$pressDepartmentID,$mailroomDepartmentID) ORDER BY firstname";
$dbProduction=dbselectmulti($sql);
$productionStaff=array();
$productionStaff[0]="Please choose";
if ($dbProduction['numrows']>0)
{
    foreach($dbProduction['data'] as $s)
    {
        $productionStaff[$s['id']]=$s['firstname']." ".$s['lastname'];
    }
}



//get advertisers
$sql="SELECT * FROM accounts WHERE account_advertiser=1 ORDER BY account_name";
$dbCustomers=dbselectmulti($sql);
$advertisers=array();
$advertisers[0]="Please choose";
if ($dbCustomers['numrows']>0)
{
    foreach($dbCustomers['data'] as $s)
    {
        if(trim($s['account_name']!=''))
        {
            $advertisers[$s['id']]=stripslashes($s['account_name']);
        }
    }
}

//get vendors
$sql="SELECT * FROM accounts WHERE account_vendor=1 AND newsprint=0 AND glossyprinter=0 ORDER BY account_name";
$dbVendors=dbselectmulti($sql);
$vendors=array();
$vendors[0]="Please choose";
if ($dbVendors['numrows']>0)
{
    foreach($dbVendors['data'] as $s)
    {
        if(trim($s['account_name']!=''))
        {
            $vendors[$s['id']]=stripslashes($s['account_name']);
        }
    }
}

//get newsprint vendors
$sql="SELECT * FROM accounts WHERE account_vendor=1 AND newsprint=1 ORDER BY account_name";
$dbVendors=dbselectmulti($sql);
$newsprintVendors=array();
$newsprintVendors[0]="Please choose";
if ($dbVendors['numrows']>0)
{
    foreach($dbVendors['data'] as $s)
    {
        if(trim($s['account_name']!=''))
        {
            $newsprintVendors[$s['id']]=stripslashes($s['account_name']);
        }
    }
}

//get newsprint vendors
$sql="SELECT * FROM accounts WHERE account_vendor=1 AND glossyprinter=1 ORDER BY account_name";
$dbVendors=dbselectmulti($sql);
$glossyVendors=array();
$glossyVendors[0]="Please choose";
if ($dbCustomers['numrows']>0)
{
    foreach($dbCustomers['data'] as $s)
    {
        if(trim($s['account_name']!=''))
        {
            $glossyVendors[$s['id']]=stripslashes($s['account_name']);
        }
    }
}

//get commercial print customers
$sql="SELECT * FROM accounts WHERE account_commercial=1 ORDER BY account_name";
$dbVendors=dbselectmulti($sql);
$commercialCustomers=array();
$commercialCustomers[0]="Please choose";
if ($dbCustomers['numrows']>0)
{
    foreach($dbCustomers['data'] as $s)
    {
        if(trim($s['account_name']!=''))
        {
            $commercialCustomers[$s['id']]=stripslashes($s['account_name']);
        }
    }
}
*/
