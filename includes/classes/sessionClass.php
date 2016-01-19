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


    public function setFlashSuccess($message)
    {
        if(!is_array($message))
        {
            $successMessage['title']='Success';
            $successMessage['content']=$message;
        }
        $this->setFlash($successMessage);
    }

    public function setFlash($message)
    {
        $defaults = array(
            'title'=>'',
            'content'=>'',
            'color'=>'#A0DBA4',
            'timeout'=>3000,
            'icon'=>'fa fa-thumbs-up'
        );
        if(!is_array($message))
        {
          $message['content']=$message;
        }
        $message = array_merge($defaults,$message);
        $this->messages[]=$message;
    }

    public function getFlash()
    {
        $messages=$this->messages;
        $this->messages = [];
        return $messages;
    }

    public function hasFlashMessage()
    {
        //see if there is a flash message in the session
        if(count($this->messages)>0)
        {
            return true;
        } else {
            return false;
        }

    }

    public function showFlashMessages()
    {
        if(count($this->messages)>0)
        {
            print "<script>\n";
            foreach($this->messages as $singleMessage) {
            if ($singleMessage['timeout'] == 'none'){$singleMessage['timeout']=0;}
                print "
    var smallMessage= {
        title: \"$singleMessage[title]\",
        content: \"$singleMessage[content]\",
        color: \"$singleMessage[color]\",
        timeout: $singleMessage[timeout],
        icon: \"$singleMessage[icon]\",
        type: \"smallBox\"
    };
    showMessage(smallMessage);
   ";
            }
            print "</script>\n";
            $this->messages=[];
        }
    }

    public function setCookie($type,$value,$remember=true,$delete=false)
    {
        if($remember)
        {
            $time=time()+60*60*24*30; // remember for 30 days
        } else {
            $time=0; // set for session only
        }
        if($delete){$time=time()-3600;}
        $cookie = array('type'=>$type,'value'=>$value,'time'=>$time);
        $this->cookies[]=$cookie;
    }

    private function setCookies()
    {
        if(count($this->cookies)>0)
        {
            foreach($this->cookies as $cookie)
            {
                switch($cookie['type'])
                {
                    case 'user':
                        setcookie('mango_user',$cookie['value'],$cookie['time'], '/');
                        break;

                    case 'site':
                        setcookie('mango_current_site',$cookie['value'],$cookie['time'], '/');
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