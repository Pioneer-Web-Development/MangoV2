<?php
/*
 * This script bootstraps all loading
 *
 * It will handle all the includes, page construction and output
 */
session_start();

$bootTime = time();
$menuPath = str_replace("/pages/","",$_SERVER['SCRIPT_NAME']);

$baseDir = $_SERVER['DOCUMENT_ROOT'].'/';
$includesDir = $baseDir."includes/";

// detect if this is an ajax page call
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $ajax = true;
} else {
    $ajax = false;
}
//detect if this is a post (which could also be an ajax call
if($_POST)
{
    $post = true;
} else {
    $post = false;
}


include('mangoConfig.php');

if(DISPLAY_DEBUG)
{
    error_reporting(E_WARNING && E_ERROR);
} else {
    error_reporting(0);
}
//include all helper functions
loadFiles($includesDir."/helpers");

//include all class objects
loadFiles($includesDir."/classes");

$randomString = md5(microtime(TRUE) . rand(0, 100000));

if(DISPLAY_DEBUG) {
    /* initialize the logger object */
    $logger = new Logger($bootTime);
    /* always initialize the database */
    $db = new Database($logger); //pass in the logger object as well
}
else {
    $db = new Database();
}
/* initialize the session object */
$session = new Session();

/* then initialize the user object if we have a user token */
if($_SERVER['SCRIPT_NAME']!='logout.php') {
    if ($session->getUser() || $session->loggedin) {
        $user = new User($session->getUser(), $db);
    }
}
/* initialize the messenger object */
$messenger = new Messenger();

// before we do anything, if the user isn't logged in, let's redirect them to the index page (if they are NOT actually trying to log in at this moment
if($session->loggedin == false && $_SERVER['SCRIPT_NAME']!='index.php' && !$post){
    //redirect("/index.php");
}
if($session->loggedin && $_SERVER['PHP_SELF']=='/index.php')
{
    redirect('/pages/dashboard.php');
}

/* initialize some variables */
$scripts = array();

$sites = array(0=>'Global','1'=>'Idaho Press-Tribune', '2'=>'Idaho State Journal');


// now, based on if this is an ajax call or a POST, we load a template
if(!$ajax && !$post && $template != '') {
// load the correct page template if $template variable set in the booting script is not blank.

    //set up a csrf token for all standard pages by default
    $session->csrf_token = $randomString;
    $session->csrf_expire = time() + 60 * 60 * 1;
    session_commit();

    if ($template != '') {
        //see if the file exists first, then load it
        $template = str_replace(".php", "", $template); //in case someone includes that piece
        if (file_exists($baseDir."templates/" . $template . '.php')) {
            include($baseDir."templates/" . $template . '.php');
        } else {
            die ("Template '".$template."' was not found in the templates directory.");
        }
        if(function_exists('template_init')) {
            template_init();
        } else {
            die("Template does not have the required template_init function defined. Please correct before proceeding.");
        }
    } else {
        // no template, so lets just define some basic functions
        if(!function_exists('template_init')) {
            function template_init()
            {
                document_open();
                page_header();
                nav();
                page();
                page_footer();
                document_close();
            }
        }
        if(!function_exists('document_open')) {
            function document_open()
            {

            }
        }
        if(!function_exists('page_header')) {
            function page_header()
            {

            }
        }
        if(!function_exists('nav')) {
            function nav()
            {

            }
        }
        if(!function_exists('page_footer')) {
            function page_footer()
            {

            }
        }
        if(!function_exists('document_close')) {
            function document_close()
            {

            }
        }
        //now we load the execute the page
        template_init();
    }


} elseif($ajax) {
    /* ajax request, we're just going to be responding with a json string */
    page();
    page_cleanup();
} elseif($post)
{
    /* this is a POST */
    page();
    page_cleanup();
} elseif($template=='') {
    print "No template or page function defined for this url.";
} else {
    die ("Not sure how you got here.");
}


/* bootstrap functions */

function loadFiles($folder){
    //grab all the files in the specified directory
    $files = scandir($folder);
    foreach ($files as $filename)
    {
        if($filename != "." && $filename != "..") {
            if (is_dir($filename)) {
                //handle nesting
                loadFiles($filename);
            } else {
                if (strpos($filename, '.php') !== false) {
                    require $folder."/".$filename;
                }
            }
        }

    }
}
