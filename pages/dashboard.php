<?php
$template = 'master';

include("../includes/bootstrap.php");

function page()
{
    global $db,$user,$session, $sites;

    /*
     * Lets send a test message to the logged in user
    $message = new Message();
    $message->to(1);
    $message->from(0); //0 will be "system";
    $message->setSubject('This is a second test message');
    $message->setBody("This would be an actual message had this not been a test.");
    $message->send();


    */
    print "Set site is ".$session->current_site;
    ?>
    <h3>Dashboard</h3>
    <section id="widget-grid" class="">

            <!-- row -->
            <div class="row">
                <article class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <?php
                    $test = new Widget;
                    $test->setTitle('My first widget');
                    $action2=array('label'=>'Test','url'=>'/pages/user/users.php','class'=>'danger');
                    $test->setActions($action2);
                    $actions = array('label'=>'Users',
                        'subitems'=>array(
                            array('label'=>'Users2','url'=>'/pages/user/users.php'),
                            array('label'=>'Users3','url'=>'/pages/user/users.php')
                        )
                    );
                    $test->setActions($actions);
                    $test->render();


                    $test2 = new Widget;
                    $test2->setTitle('My second widget');

                    $headers=array('First Name','Last Name');
                    $data=$db->select('firstname,lastname')->from('users')->limit(10)->fetch();
                    $test2->addTable($headers,$data);
                    $test2->render();

                    print "Cookies<br>";
                    if (isset($_COOKIE)) {
                        foreach ($_COOKIE as $name => $value) {
                            $name = htmlspecialchars($name);
                            $value = htmlspecialchars($value);
                            echo "$name : $value <br />\n";
                        }
                    }
                    ?>
                </article>

                <article class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <?php
                    $test3 = new Widget;
                    $test3->setTitle('My third widget');
                    $test3->addContent("<p>Sites allowed:</p>".$user->sites('list'));
                    $test3->render();

                    ?>
                </article>
            </div>
        </section>

    <?php
}
