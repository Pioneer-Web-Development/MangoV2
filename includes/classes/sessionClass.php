<?php
/*
 * This session class also controls cookies since they are both
 */
class Session
{
    function __construct()
    {
        if(isset($_SESSION) && count($_SESSION)>0)
        {
            $this->setCookies();
            $_SESSION['data']['new_session']=0;
            $_SESSION['data']['last_page'] = $_SERVER['HTTP_REFERER'];
        } else {
            $_SESSION['data']=[];
            $_SESSION['cookies']=[];
            $_SESSION['messages']=[];
            $_SESSION['formErrors']=[];
            $_SESSION['base']=$_SESSION;
            $_SESSION['server']=$_SERVER;
            $_SESSION['data']['new_session']=1;
        }
        $_SESSION['data']['current_site'] = $this->getSiteCookie();
    }


    function __destruct()
    {
        $this->close();
    }

    public function setFlash($message)
    {
        $_SESSION['messages'][]=$message;
    }

    public function getFlash()
    {
        return $_SESSION['messages'];
    }

    public function queueCookie($type,$value,$remember=true,$delete=false)
    {
        if($remember)
        {
            $time=time()+60*60*24*30; // remember for 30 days
        } else {
            $time=0; // set for session only
        }
        if($delete){$time=time()-3600;}
        $cookie[$type]=array('value'=>$value,'time'=>$time);
        $_SESSION['cookies']=array_merge($_SESSION['cookies'],$cookie);
    }

    public function setCookies()
    {
        if(count($_SESSION['cookies'])>0)
        {
            foreach($_SESSION['cookies'] as $cookieType=>$cookieValues)
            {
                switch($cookieType)
                {
                    case 'user':
                        setcookie('mango_user',$cookieValues['value'],$cookieValues['time']);
                        break;

                    case 'site':
                        setcookie('mango_current_site',$cookieValues['value'],$cookieValues['time']);
                        break;

                }
            }
        }
    }


    public function getUser()
    {
        if($_SESSION['data']['loggedin'])
        {
            return $_SESSION['data']['user_token'];
        } elseif(isset($_COOKIE['mango_user']))
        {
           return ($_COOKIE['mango_user']);
        }
        return 0;
    }

    public function getSiteCookie()
    {
        if(isset($_COOKIE['mango_current_site']))
        {
           return ($_COOKIE['mango_current_site']);
        }
        return 0;
    }

    public function __get($key)
    {
        if (array_key_exists($key, $_SESSION['data'])) {
            return $_SESSION['data'][$key];
        } else {
            return "This key does not exist.";
        }

    }

    public function __set($key,$value)
    {
        $_SESSION['data'][$key] = $value;
    }

    public function showSession()
    {
        print "<div class='well col-md-12'>\n
        <h4>Session Data:</h4>
            <pre>";
        print_r($_SESSION['data']);
        print "    </pre>\n";

        print "<h4>Server Data:</h4>
        <pre>";
        print_r($_SESSION['server']);
        print "    </pre>\n";

        print "<h4>Form Errors:</h4>
        <pre>";
        print_r($_SESSION['formErrors']);
        print "    </pre>\n";

        print "<h4>Messages:</h4>
        <pre>";
        print_r($_SESSION['messages']);
        print "    </pre>\n";

        print "<h4>Cookies:</h4>
        <pre>";
        print_r($_SESSION['cookies']);
        print "    </pre>\n";

        print "<h4>Base Data:</h4>
        <pre>";
        print_r($_SESSION['base']);
        print "    </pre>\n";

        print "</div>\n";
    }

    public function setFormError($field,$message)
    {
        $_SESSION['formErrors'][$field] = $message;
    }

    public function getFormErrors()
    {
        if(count($_SESSION['formErrors'])>0)
        {
            $errors = $_SESSION['formErrors'];
            $_SESSION['formErrors'] = []; //clear them now that they have been extracted to the Form class
            print "fetched errors<br>";
            return $errors;
        }
        return array();
    }

    //@TODO need to learn more about this!
    /*
    public function __call($method, $parameters)
    {
        if (in_array($method, array('retweet', 'favorite')))
        {
            return call_user_func_array(array($this, $method), $parameters);
        }
    }
    */

    public function close()
    {
        session_commit();
    }
}