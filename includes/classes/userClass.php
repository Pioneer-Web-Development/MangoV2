<?php

/**
 * Created by PhpStorm.
 * User: jhansen
 * Date: 10/26/2015
 * Time: 3:41 PM
 */
class User
{
    public $loggedin = false;
    public $isAdmin = false;

    public $username = '';
    public $userID = 0;
    public $messageCount = 0;
    public $projects = [];
    public $sites = array(0=>"Global", 1=>"Idaho Press-Tribune");

    private $allowedSites = [];
    private $allowedPublications = [];
    private $user_token;
    private $user;
    private $localdb;


    function __construct($token,Database $db)
    {
        /* pull in a reference to the global database variable (assumed to be $db */
        $this->localdb = $db;
        $this->user_token = $token;
        $this->login();
    }


    public function login()
    {
        global $session;
        /* look up the user in the users table by token */
        $user = $this->localdb->from('users')->where("token",$this->user_token)->fetch_first();
        $where = array(
                 'token' => $this->user_token
        );
        $data = array(
            'online' => 1,
            'last_login' => date("Y-m-d H:i"),
            'last_online' => date("Y-m-d H:i")
        );
        $this->localdb->where($where)->update('users', $data)->execute();
        $this->userID = $user['id'];
        $this->user = $user;
        $this->loggedin = true;
        $session->logged_in = true;


        /*
         * build up a variety of things that will be queried often
         */
        $this->allowedSites = $this->localdb->select('site_id')->from('user_sites')->where('user_id',$this->userID)->fetch_simple_array('site_id');
        $this->allowedPublications = $this->localdb->select('pub_id')->from('user_publications')->where(array('user_id'=>$this->userID,'value'=>1))->fetch_simple_array('pub_id');
    }

    public function logout()
    {
        $where = array(
            'token' => $this->user_token
        );
        $data = array(
            'online' => 0,
            'last_online' => date("Y-m-d H:i")
        );
        $this->localdb->where($where)->update('users', $data);

        $this->loggedin = false;

    }

    public function showUser()
    {
       ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">User Details for <?php $this->user->firstname ?></h3>
            </div>
            <div class="panel-body">
                <pre>
                <?php
                print_r($this->user);
                ?>
                </pre>
            </div>
        </div>
        <?php
    }

    public function __get($key)
    {
        if (array_key_exists($key, $this->user)) {
            return $this->user[$key];
        } else {
            return "This key does not exist.";
        }

    }

    public function __set($key,$value)
    {
        $this->user[$key] = $value;
    }

    function checkPermission($pageID='',$type='page')
    {
        global $session;
        $valid=false;
        if($pageID=='')
        {
            $pageID=$_SERVER['SCRIPT_NAME'];
        }
        $pageID=str_replace("/","",$pageID);
        if (!is_numeric($pageID))
        {
            $sql="SELECT kiosk FROM core_pages WHERE filename='$pageID'";
            $dbPagePermissions=dbselectsingle($sql);
            if($dbPagePermissions['data']['kiosk']==1)
            {
                //kiosk mode page
                $_SESSION['kiosk']=true;
                return true;
            } else {
                $_SESSION['kiosk']=false;
            }
        }
        if (isset($GLOBALS['standalone']) && $GLOBALS['standalone']==true){$valid=true;}
        if (!isset($_SESSION['cmsuser']['loggedin'])){redirect('index.php?r='.$_SERVER['PHP_SELF']);}

        //if the user has admin privilege, just return true
        if ($_SESSION['cmsuser']['admin']==1)
        {
            return true;
        }
        $userPerms=$_SESSION['cmsuser']['permissions'];
        if (count($userPerms)>0)
        {
            //otherwise, check for existence of specific permission
            if($type=='page')
            {
                if (!is_numeric($pageID))
                {
                    //looking up by script name rather than id
                    //get the permissions for the page that have a value of 1 -- those are required
                    $sql="SELECT A.permissionID, C.displayname FROM core_permission_page A, core_pages B, core_permission_list C WHERE A.value=1 AND A.pageID=B.id AND B.filename='$pageID' AND A.permissionID=C.id";
                    $dbPagePermissions=dbselectmulti($sql);
                } else {
                    //get the permissions for the page that have a value of 1 -- those are required
                    $sql="SELECT permissionID FROM core_permission_page WHERE value=1 AND pageID=$pageID";
                    $dbPagePermissions=dbselectmulti($sql);
                }
                if ($dbPagePermissions['numrows']>0)
                {
                    $valid=false;
                    foreach($dbPagePermissions['data'] as $permission)
                    {
                        $comparisonPermission=$permission['permissionID'];
                        if (in_array($comparisonPermission,$userPerms)){$valid=true;}
                    }
                } else {
                    $valid=true;
                }
            } else {
                //just looking for the existence of a particular permission
                if (in_array($pageID,$userPerms)){$valid=true;}
            }
        } else {
            $valid=false;
        }
        //return true;
        return $valid;
    }

    /*
    *   This method returns an array or comma separated of site ids that the user has access to
    */
    public function sites($type='array')
    {
         if($type=='array')
         {
             return $this->allowedSites;
         } else {
             return implode(",",$this->allowedSites);
         }
    }

    /*
    *   This method returns an array or comma separated of publication ids that the user has access to
    */
    public function publications($type='array')
    {
         if($type=='array')
         {
             return $this->allowedPublications;
         } else {
             return implode(",",$this->allowedPublications);
         }
    }

}