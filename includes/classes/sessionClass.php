<?php
/*
 * This session class also controls cookies since they are both
 */
class Session
{
    private $messages = [];
    private $data = [];
    private $formErrors = [];
    private $cookies = [];
    private $base = [];

    function __construct()
    {
        $this->data = $_SESSION['data'];
        $this->messages = $_SESSION['messages'];
        $this->formErrors = $_SESSION['formErrors'];
        $this->cookies = $_SESSION['cookies'];
        $this->base = $_SESSION['base'];
    }

    public function setFlash($message)
    {
        $this->messages[]=$message;
    }

    public function getFlash()
    {
        $messages=$this->messages;
        $this->messages = [];
        return $messages;
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
        $this->cookies=array_merge($this->cookies,$cookie);
    }

    public function setCookies()
    {
        if(count($this->cookies)>0)
        {
            foreach($this->cookies as $cookieType=>$cookieValues)
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
        if($this->logged_in)
        {
            return $this->user_token;
        } elseif(isset($_COOKIE['mango_user']))
        {
           return ($_COOKIE['mango_user']);
        } elseif($this>user_token!='')
        {
           return ($this>user_token);
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
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        } else {
            return "This key does not exist.";
        }

    }

    public function __set($key,$value)
    {
        $this->data[$key] = $value;
    }

    public function showSession()
    {
        print "<div class='well col-md-12'>\n
        <h4>Session Data:</h4>
            <pre>";
        print_r($this->data);
        print "    </pre>\n";

       print "<h4>Form Errors:</h4>
        <pre>";
        print_r($this->formErrors);
        print "    </pre>\n";

       print "<h4>Base:</h4>
        <pre>";
        print_r($this->base);
        print "    </pre>\n";

        print "<h4>Messages:</h4>
        <pre>";
        print_r($this->messages);
        print "    </pre>\n";

        print "<h4>Cookies:</h4>
        <pre>";
        print_r($this->cookies);
        print "    </pre>\n";

        print "</div>\n";
    }

    public function setFormError($field,$message)
    {
        $this->formErrors[$field] = $message;
    }

    public function getFormErrors()
    {
        if(count($this->formErrors)>0)
        {
            $errors = $this->formErrors;
            $this->formErrors = []; //clear them now that they have been extracted to the Form class
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
        return array('formErrors'=>$this->formErrors,'cookies'=>$this->cookies,'data'=>$this->data,'messages'=>$this->messages, 'base'=>$this->base);
    }

}