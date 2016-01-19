<?php
$template = 'master';

include($_SERVER["DOCUMENT_ROOT"] . "/includes/bootstrap.php");

function page()
{
    global $db, $session;
    page_title('Preferences');

    $db->where('site_id',$session->current_site);
    $prefs=$db->from('core_preferences')->fetch_first();
    ?>
    <div>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" <?php if($_GET['tab']=='general' || !isset($_GET['tab'])) echo "class=\"active\""; ?>><a href="#general" aria-controls="general" role="tab" data-toggle="tab">General System</a></li>
            <li role="presentation" <?php if($_GET['tab']=='newspaper') echo "class=\"active\""; ?>><a href="#newspaper" aria-controls="newspaper" role="tab" data-toggle="tab">Newspaper Info</a></li>
            <li role="presentation" <?php if($_GET['tab']=='departments') echo "class=\"active\""; ?>><a href="#departments" aria-controls="departments" role="tab" data-toggle="tab">Department Setup</a></li>
            <li role="presentation" <?php if($_GET['tab']=='press') echo "class=\"active\""; ?>><a href="#press" aria-controls="press" role="tab" data-toggle="tab">Press</a></li>
            <li role="presentation" <?php if($_GET['tab']=='mailroom') echo "class=\"active\""; ?>><a href="#mailroom" aria-controls="mailroom" role="tab" data-toggle="tab">Mailroom</a></li>
            <li role="presentation" <?php if($_GET['tab']=='bindery') echo "class=\"active\""; ?>><a href="#bindery" aria-controls="bindery" role="tab" data-toggle="tab">Bindery &amp; Commercial Printing</a></li>
            <li role="presentation" <?php if($_GET['tab']=='prepress') echo "class=\"active\""; ?>><a href="#prepress" aria-controls="prepress" role="tab" data-toggle="tab">Prepress</a></li>
            <li role="presentation" <?php if($_GET['tab']=='circulation') echo "class=\"active\""; ?>><a href="#circulation" aria-controls="circulation" role="tab" data-toggle="tab">Circulation</a></li>
            <li role="presentation" <?php if($_GET['tab']=='infotech') echo "class=\"active\""; ?>><a href="#infotech" aria-controls="infotech" role="tab" data-toggle="tab">InfoTech</a></li>
            <li role="presentation" <?php if($_GET['tab']=='tickets') echo "class=\"active\""; ?>><a href="#tickets" aria-controls="tickets" role="tab" data-toggle="tab">Trouble Tickets</a></li>
            <li role="presentation" <?php if($_GET['tab']=='inventory') echo "class=\"active\""; ?>><a href="#inventory" aria-controls="inventory" role="tab" data-toggle="tab">Inventory &amp; POs</a></li>
            <li role="presentation" <?php if($_GET['tab']=='timelocks') echo "class=\"active\""; ?>><a href="#timelocks" aria-controls="timelocks" role="tab" data-toggle="tab">Timelocks</a></li>
            <li role="presentation" <?php if($_GET['tab']=='misc') echo "class=\"active\""; ?>><a href="#misc" aria-controls="misc" role="tab" data-toggle="tab">Miscellaneous</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane <?php if($_GET['tab']=='general' || !isset($_GET['tab'])) echo "active"; ?>" id="general"><?php prefGeneral($prefs) ?></div>
            <div role="tabpanel" class="tab-pane <?php if($_GET['tab']=='newspaper') echo "active"; ?>" id="newspaper"><?php prefNewspaper($prefs) ?></div>
            <div role="tabpanel" class="tab-pane <?php if($_GET['tab']=='departments') echo "active"; ?>" id="departments"><?php prefDepartments($prefs) ?></div>
            <div role="tabpanel" class="tab-pane <?php if($_GET['tab']=='press') echo "active"; ?>" id="press"><?php prefPress($prefs) ?></div>
            <div role="tabpanel" class="tab-pane <?php if($_GET['tab']=='mailroom') echo "active"; ?>" id="mailroom"><?php prefMailroom($prefs) ?></div>
            <div role="tabpanel" class="tab-pane <?php if($_GET['tab']=='bindery') echo "active"; ?>" id="bindery"><?php prefBindery($prefs) ?></div>
            <div role="tabpanel" class="tab-pane <?php if($_GET['tab']=='prepress') echo "active"; ?>" id="prepress"><?php prefPrepress($prefs) ?></div>
            <div role="tabpanel" class="tab-pane <?php if($_GET['tab']=='circulation') echo "active"; ?>" id="circulation"><?php prefCirculation($prefs) ?></div>
            <div role="tabpanel" class="tab-pane <?php if($_GET['tab']=='infotech') echo "active"; ?>" id="infotech"><?php prefInfotech($prefs) ?></div>
            <div role="tabpanel" class="tab-pane <?php if($_GET['tab']=='tickets') echo "active"; ?>" id="tickets"><?php prefTickets($prefs) ?></div>
            <div role="tabpanel" class="tab-pane <?php if($_GET['tab']=='inventory') echo "active"; ?>" id="inventory"><?php prefInventory($prefs) ?></div>
            <div role="tabpanel" class="tab-pane <?php if($_GET['tab']=='timelocks') echo "active"; ?>" id="timelocks"><?php prefTimelocks($prefs) ?></div>
            <div role="tabpanel" class="tab-pane <?php if($_GET['tab']=='misc') echo "active"; ?>" id="misc"><?php prefMisc($prefs) ?></div>
        </div>

    </div>
<?php


}

function prefGeneral($prefs)
{
    global $db;

    $formOptions = array('action'=>'preferences/prefsGeneral.php',
        'data' => $prefs,
        'files'=>true,
        'title' => 'General System',
    );
    $prefForm = new Form($formOptions);

    $options = array('field'=>'systemEmailFromAddress','label'=>"Email From Address",'description'=>'Enter the email address that indicates where system messages originate');
    $prefForm->email($options);

    $options = array('field'=>'cronSystemEnabled','label'=>"Cron System",'description'=>'Check to enable cron system');
    $prefForm->checkbox($options);

    $prefForm->generate();
}

function prefNewspaper($prefs)
{
    global $db;

    $formOptions = array('action'=>'preferences/prefsNewspaper.php',
        'data' => $prefs,
        'files'=>true,
        'title' => 'Newspaper Basics',
    );
    $prefForm = new Form($formOptions);

    $options = array('field'=>'newspaperName','label'=>"Newspaper Name",'description'=>'Name of the host newspaper');
    $prefForm->text($options);

    $options = array('field'=>'newspaperAreaCode','label'=>"Newspaper Area Code",'description'=>'Default Area Code for the paper');
    $prefForm->number($options);

    $options = array('field'=>'officeStreetAddress','label'=>"Office Street Address",'description'=>'Street address of the office facility.');
    $prefForm->text($options);

    $options = array('field'=>'officeStreetCity','label'=>"Office City",'description'=>'City of the office facility.');
    $prefForm->text($options);

    $options = array('field'=>'officeStreetState','label'=>"Office State",'description'=>'State of the office facility.');
    $prefForm->state($options);

    $options = array('field'=>'officeStreetZip','label'=>"Office Zip",'description'=>'Zip code of office facility.');
    $prefForm->number($options);

    $options = array('field'=>'printingStreetAddress','label'=>"Printing Street Address",'description'=>'Street address of the printing facility.');
    $prefForm->text($options);

    $options = array('field'=>'printingStreetCity','label'=>"Printing City",'description'=>'City of the printing facility.');
    $prefForm->text($options);

    $options = array('field'=>'printingStreetState','label'=>"Printing State",'description'=>'State of the printing facility.');
    $prefForm->state($options);

    $options = array('field'=>'printingStreetZip','label'=>"Printing Zip",'description'=>'Zip code of printing facility.');
    $prefForm->number($options);

    $options = array('field'=>'defaultState','label'=>"Default State",'description'=>'Default State for all jobs/locations.');
    $prefForm->state($options);

    $prefForm->generate();

}

function prefDepartments($prefs)
{
    global $db;
    //build up all the bits we need for dropdowns
    $departments = $db->select('id,department_name')->from('user_departments')->order_by('department_name')->fetch_as_select_options('department_name');
    $positions = $db->select('id,position_name')->from('user_positions')->order_by('position_name')->fetch_as_select_options('position_name');
    $permissionGroups = $db->select('id,group_name')->from('core_permission_groups')->order_by('group_name')->fetch_as_select_options('group_name');


    $formOptions = array('action'=>'preferences/prefsDepartments.php',
        'data' => $prefs,
        'files'=>true,
        'title' => 'Department Information',
    );
    $prefForm = new Form($formOptions);

    $options = array('field'=>'advertisingDepartmentID','label'=>"Advertising Dept",'description'=>'Select the advertising department','options'=>$departments);
    $prefForm->select($options);

    $options = array('field'=>'productionDepartmentID','label'=>"Production Dept",'description'=>'Select the production department','options'=>$departments);
    $prefForm->select($options);

    $options = array('field'=>'pressDepartmentID','label'=>"Press Dept",'description'=>'Select the press department','options'=>$departments);
    $prefForm->select($options);

    $options = array('field'=>'mailroomDepartmentID','label'=>"Mailroom Dept",'description'=>'Select the mailroom department','options'=>$departments);
    $prefForm->select($options);

    $options = array('field'=>'financeDepartmentID','label'=>"Finance Dept",'description'=>'Select the finance department','options'=>$departments);
    $prefForm->select($options);

    $options = array('field'=>'editorialDepartmentID','label'=>"Editorial Dept",'description'=>'Select the editorial department','options'=>$departments);
    $prefForm->select($options);

    $options = array('field'=>'circulationDepartmentID','label'=>"Circulation Dept",'description'=>'Select the circulation department','options'=>$departments);
    $prefForm->select($options);

    $prefForm->generate();

}

function prefPress($prefs)
{

}

function prefMailroom($prefs)
{

}

function prefPrepress($prefs)
{

}

function prefBindery($prefs)
{

}

function prefCirculation($prefs)
{

}

function prefInfotech($prefs)
{

}

function prefTickets($prefs)
{

}

function prefInventory($prefs)
{

}

function prefTimelocks($prefs)
{

}

function prefMisc($prefs)
{

}

