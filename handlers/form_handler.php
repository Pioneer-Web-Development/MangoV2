<?php
/*
 * This script bootstraps all loading
 *
 * It will handle all the includes, page construction and output
 */
session_start();
$bootTime = time();
$menuPath = str_replace("/pages/","",$_SERVER['SCRIPT_NAME']);
$includesDir = $_SERVER["DOCUMENT_ROOT"]."/includes/";
$baseDir = $_SERVER["DOCUMENT_ROOT"]."/";

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


include($includesDir.'mangoConfig.php');

if(DISPLAY_DEBUG)
{
    error_reporting(E_WARNING && E_ERROR);
} else {
    error_reporting(0);
}
//include all class objects
$folder = $includesDir."/classes";
$files = scandir($folder);
foreach ($files as $filename)
{
    if($filename != "." && $filename != "..") {
        if (strpos($filename, '.php') !== false) {
            require $folder."/".$filename;
        }
    }
}


if(DISPLAY_DEBUG) {
    /* initialize the logger object */
    $logger = new Logger();
    /* always initialize the database */
    $db = new Database($logger); //pass in the logger object as well
}
else {
    $db = new Database();
}

//include all helper functions
$folder = $includesDir."/helpers";
$files = scandir($folder);
foreach ($files as $filename)
{
    if($filename != "." && $filename != "..") {
        if (strpos($filename, '.php') !== false) {
            require $folder."/".$filename;
        }
    }
}

/* initialize the session object */

$session = new Session();
/* then initialize the user object if we have a user token */
if($session->getUser() || $session->loggedin){$user = new User($session->getUser(),$db);}

/* initialize the messenger object */
$messenger = new Messenger();

// before we do anything, if the user isn't logged in, let's redirect them to the index page (if they are NOT actually trying to log in at this moment
if($session->loggedin == false && $_SERVER['PHP_SELF']!='/index.php' && !$post){
    redirect("/index.php");
}
if($session->loggedin && $_SERVER['PHP_SELF']=='/index.php')
{
    redirect('/pages/dashboard.php');
}

$handler = new FormProcessor($_POST);


class FormProcessor
{
    private $errors = [];
    private $method = 'POST';
    private $posted;
    private $other; //fields supplied with "other" data than passed options
    private $handler = '';
    private $csrf_token = '';
    private $recordID = 0;

    public function __construct($post)
    {
        global $session;

        $this->ingestPost($post);

        //check for matching csrf tokens
        if(($session->csrf_token == $this->csrf_token) && (time()<$session->csrf_expire))
        {
            //we can proceed! We'll need to load the proper form handler now
            if($this->handler!='')
            {

                if(file_exists($this->handler))
                {
                    $this->handleForm();
                } else {
                    $this->setError('Form handler "'.$this->handler.'" does not exist in the handlers directory.');
                }
            } else {
                $this->setError('A valid handler was not passed in from the form.');
            }
        } else {
            $this->setError('CSRF Token mismatch or timeout.');
        }
        $this->showErrors();
    }

    private function ingestPost($post)
    {
        $this->method = $post['_method'];
        $this->handler = $post['_form_handler'];
        $this->csrf_token = $post['csrf_token'];
        $this->successURL = $post['_success_url'];
        if($this->method == 'PATCH')
        {
            $this->recordID = $post['_record_id'];
        }
        //remove unnecessary post elements now
        unset($post['_method']);
        unset($post['_form_handler']);
        unset($post['_success_url']);
        unset($post['_record_id']);
        unset($post['csrf_token']);
        unset($post['submitButton']); //assuming submit button is labelled as default in the form Generator

        //handle checkboxes since those if unchecked won't come through
        $data=[];

        foreach($post as $key=>$value)
        {
            if(is_numeric($value))
            {
                $value=floatval($value);
            } elseif(is_string($value))
            {
                $value=addslashes($value);
            }

            // now we're going to look for checkboxes. all checkbox fields will be prefaced with _check_
            if(substr($key,0,7)=="_check_") {
                $check = str_replace("_check_", "", $key);
                //ok, now is there another key with that value?
                if (array_key_exists($check, $post)) {
                    //ok, it was submitted, so that means it was checked
                    $data[$check] = 1;
                    //since the submitted one will also be the same name and value, we'll just let it replace over this one later
                } else {
                    //doesn't exist otherwise, which means that the checkbox was submitted as unchecked, so value = 0
                    $data[$check] = 0;
                }
            }elseif(substr($key,0,7)=="_other_" && $value!='') {
                //means we have a value submitted a value that is not the in "standard" options provided

                //unset it
                unset($post[$key]);
                //need to know the real key to store
                $key = str_replace("_other_","",$key);
                //now add the value to the correct key
                $data[$key]=$value;
            }elseif(substr($key,0,12)=="_othercheck_" && $value!='') {
                //means we have a value submitted a value that is not the in "standard" options provided

                //unset it
                unset($post[$key]);
                //need to know the real key to store
                $key = str_replace("_othercheck_","",$key);
                //now add the value to the correct key
                $this->other[]=array($key=>$value);
            } else {
                $data[$key]=$value;
            }
        }
        $this->posted = $data;

    }

    private function handleForm()
    {
        global $user, $session, $db;
        //this will now auto handle the form
        if($this->method=='PATCH')
        {
            //add an 'updated_at' timestamp
            $this->posted['updated_at']=date("Y-m-d H:i:s");
        } else {
            $this->posted['created_at']=date("Y-m-d H:i:s");
        }
        include($this->handler);
    }

    public function processForm($table,$fillable=array(), $message = 'Record updated successfully')
    {
        global $db, $session;
        if($this->checkFields($fillable)) {
            //ok, let's do a database update
            if ($this->method == 'PATCH') {
                //updating a record
                $db->where('id', $this->recordID)->update($table, $this->posted);
            } else {
                //create a new record
                $this->recordID = $db->insert($table, $this->posted);
            }
            $session->setFlashSuccess($message);
            page_cleanup($this->successURL);
        }
    }

    function setError($message)
    {
        $this->errors[]=$message;
    }

    function showErrors()
    {
        if(count($this->errors)>0)
        {
            print "<!DOCTYPE html>
            <html lang=\"en-us\" id=\"extr-page\">
            ";
            include $_SERVER['DOCUMENT_ROOT']."/templates/partials/head.php";
            print "<body class=\"fixed-header fixed-navigation fixed-ribbon fixed-page-footer\">";
            include $_SERVER['DOCUMENT_ROOT'] . "/templates/partials/header.php";
            include $_SERVER['DOCUMENT_ROOT'] . "/templates/partials/navigation.php";
            print "<div id=\"main\" role=\"main\">
<div id=\"content\">
<div class='row'>
<div class='col-md-12'>
<div class=\"alert alert-danger\" role=\"alert\">\n";
            print "<h3>The following error".(count($this->errors)>1 ? 's have':' has')." occurred.</h3><ul class='list-unstyled'>";
            foreach($this->errors as $error)
            {
                print "<li>$error</li>\n";
            }
            print "</ul>
</div>
</div>
</div>";
            include $_SERVER['DOCUMENT_ROOT'] . "/templates/partials/footer.php";
            print "</div>
</div>
            </body>
            </html>";

        }
    }

    function checkFields($fillable)
    {
        //make sure all the posted data is represented in the fillable array
        $fillable = array_merge(array('created_at','updated_at'),$fillable); //always include
        if(count($fillable)>0) {
            foreach ($this->posted as $key => $value) {
                if (!in_array($key, $fillable)) {
                    $this->setError("$key is not allowed to be in the database. Please adjust the database accordingly.");
                }
            }
            if (count($this->errors) > 0) {
                return false;
            }
        }
        return true;
    }
}


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
