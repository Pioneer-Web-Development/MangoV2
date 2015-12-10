<?php
class Messenger
{

    private $messages = [];


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
            print "
<script>
";
            foreach($this->messages as $message) {
                if ($message('timeout') != 'none') {
                    print "
                    var timeout=$message[timeout];\n";
                } else {
                    print "var timeout=0;\n";
                }
                print "
                var message= {
                    title: \"$message[title]\",
                content: \"$message[content]\",
                color:  \"$message[color]\",
                timeout: timeout,
                icon: \"$message[icon]\",
                type: 'smallBox'
                };
                showMessage(message);
                }\n";

            }
            print "
</script>
";
        }
    }




}