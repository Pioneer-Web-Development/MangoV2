<?php
require_once $_SERVER['DOCUMENT_ROOT']."/includes/bootstrap.php";
//every page is wrapped with a page function that is automatically called

function page()
{
    global $logger, $session, $db, $user;
    //handle the check
    $postData = $_POST;
    if(time()<$session->csrf_expire) {
        if ($session->csrf_token === $postData['csrf_token']) {
            $email = $postData['email'];

            $password = $postData['password'];
            if ($postData['remember']) {
                $remember = true;
            } else {
                $remember = false;
            }

            //ok, we're going to search for the user based on the email
            $result = $db->select("id, email, password, token, active")->from('users')->where('email', $email)->fetch_first();
            //if we have a record...
            if ($db->affected_rows > 0) {
                //found a matching user, now lets check the password
                if (password_verify($password, $result['password']) && $result['active']) {
                    //valid user!
                    //do we have a token? if not, create one and then initialize the user object
                    if ($result['token'] == '' || $result['token'] == Null) {
                        $token = generate_random_string(32);
                        $db->where('id', $result['id'])->update('users', array('token' => $token))->execute();

                    } else {
                        $token = $result['token'];
                    }
                    $session->queueCookie('user', $token, $remember);
                    $session->user_token = $token;
                    $session->logged_in = true;
                    $redirect = '/pages/dashboard.php';
                    page_cleanup($redirect);
                } else {
                    // passwords don't match, let's set a formError and return to the index page
                    $session->setFormError('email', 'That email/password combination was not found!');
                    page_cleanup("/index.php");
                }
            } else {
                // user not found, let's set a formError and return to the index page
                $session->setFormError('email', 'That email/password combination was not found.');
                page_cleanup("/index.php");
            }
        } else {

            $session->setFormError('email', 'There was a token mismatch. Hack attempt foiled.');
            page_cleanup("/index.php");
        }
    } else {
        $session->setFormError('email', 'Timed out. Please don\'t let the form sit so long.');
        page_cleanup("/index.php");
    }
    print "Session: ".$session->csrf_token."<br>Form: ".$_POST['csrf_token']."";
}

