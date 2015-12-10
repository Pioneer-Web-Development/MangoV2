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
//include all helper functions
loadFiles($includesDir."/helpers");

//include all class objects
loadFiles($includesDir."/classes");

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
                    $this->setError('Form handler does not exist in the handlers directory.');
                }
            } else {
                $this->setError('A valid handler was not passed in from the form.');
            }
        } else {
            $this->setError('CSRF Token mismatch?');
        }
        $this->showErrors();
    }

    private function ingestPost($post)
    {
        $this->method = $post['_method'];
        $this->handler = $post['_form_handler'];
        $this->csrf_token = $post['csrf_token'];
        if($this->method == 'PATCH')
        {
            $this->recordID = $post['_record_id'];
        }
        //remove unnecessary post elements now
        unset($post['_method']);
        unset($post['_form_handler']);
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
            if(substr($key,0,7)=="_check_")
            {
                $check=str_replace("_check_","",$key);
                //ok, now is there another key with that value?
                if(array_key_exists($check,$post))
                {
                    //ok, it was submitted, so that means it was checked
                    $data[$check]=1;
                    //since the submitted one will also be the same name and value, we'll just let it replace over this one later
                } else {
                    //doesn't exist otherwise, which means that the checkbox was submitted as unchecked, so value = 0
                    $data[$check]=0;
                }
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

    function setError($message)
    {
        $this->errors[]=$message;
    }

    function showErrors()
    {
        if(count($this->errors)>0)
        {
            print "<div class=\"alert alert-danger\" role=\"alert\">\n";
            print "<h3>The following error".(count($this->errors)>1 ? 's have':' has')." occurred.</h3><ul class='list-unstyled'>";
            foreach($this->errors as $error)
            {
                print "<li>$error</li>\n";
            }
            print "</ul></div>";
        }
    }

    function checkFields($fillable)
    {
        //make sure all the posted data is represented in the fillable array
        foreach($this->posted as $key=>$value)
        {
            if(!in_array($key,$fillable))
            {
                $this->setError("$key is not allowed to be in the database. Please adjust the database accordingly.");
            }
        }
        if(count($this->errors)>0)
        {
            return false;
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
