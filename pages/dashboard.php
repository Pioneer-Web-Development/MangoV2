<?php
$template = 'master';

include("../includes/bootstrap.php");

function page()
{
    global $db,$user;
    ?>

        <h3>Dashboard</h3>
    <p>Sites allowed:</p>
    <pre>
    <?php
    $sites = $db->select('site_id')->from('user_sites')->where('user_id',$user->userID)->fetch_simple_array();
    print $db->last_query();
    print_r($sites);?>
    </pre>

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
                    ?>
                </article>

                <article class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <?php
                    $test3 = new Widget;
                    $test3->setTitle('My third widget');
                    $this->addContent("<p>Sites allowed:</p>".$user->sites('list'));
                    $test3->render();

                    $test4 = new Widget;
                    $test4->setTitle('My fourth widget');
                    $test4->render();

                    ?>
                </article>
            </div>
        </section>

    <?php
}
