<?php
include 'functions.php';
page_header() ?>
<?php nav(); ?>
<section id="wiki-content" class="wiki-content">
    <h1>Welcome</h1>
    <p>This is a class for form Generation and processing</p>
    <div class="toc">
        <ul>
            <li><a href="#welcome">Welcome</a><ul>
            <li><a href="#dependencies">Dependencies</a></li>
            <li><a href="#footer">Footer Scripts</a></li>
            <li><a href="#class">Class Structure</a></li>
            <li><a href="#formsetup">Form Initialization</a></li>
            <li><a href="#validation">Validation</a></li>
            <li><a href="#formhandler">Form Handler</a></li>
            <li><a href="#formhandler">Field Types
                <ul>
                    <li><a href="#field_text">Text Field</a></li>
                </ul>
            </li>
        </ul>
    </div>
</section>

<section id="welcome">
    <h3>Form class is designed to streamline the generation of all formfields. </h3>
    <p></p>
</section>

<section id="dependencies">
    <h3>This class depends on a number of javascript libraries to provide additional form field types</h3>
    <ul>
        <li>
            <h4>
                Bootstrap 3
            </h4>
            <p>Link: <a href="http://wwwgetbootstrap.com/">http://wwwgetbootstrap.com/</a></p>
            <p>Basic form CSS</p>
        </li>
        <li>
            <h4>
                bootstrapvalidator
            </h4>
            <p>Link: <a href="http://1000hz.github.io/bootstrap-validator/">http://1000hz.github.io/bootstrap-validator/</a></p>
            <p>Used for client-side validation</p>
        </li>
        <li>
            <h4>
                bootstrapdatetimepicker
            </h4>
            <p>Link: <a href="http://eonasdan.github.io/bootstrap-datetimepicker">http://eonasdan.github.io/bootstrap-datetimepicker</a></p>
            <p>A very flexible date and/or time picker</p>
        </li>
        <li>
            <h4>
                colorpicker
            </h4>
            <p>Link: <a href="http://mjolnic.com/bootstrap-colorpicker/">http://mjolnic.com/bootstrap-colorpicker/</a></p>
            <p>Used for client-side validation</p>
        </li>
        <li>
            <h4>
                slider
            </h4>
            <p>Link: <a href="http://www.eyecon.ro/bootstrap-slider/">http://www.eyecon.ro/bootstrap-slider/</a></p>
            <p>Used for client-side validation</p>
        </li>
        <li>
            <h4>
                maskedinput
            </h4>
            <p>Link: <a href="http://digitalbush.com/projects/masked-input-plugin">http://digitalbush.com/projects/masked-input-plugin</a></p>
            <p>For creating masked input fields such as phone number fields</p>
        </li>
        <li>
            <h4>
                Tags Input
            </h4>
            <p>Link: <a href="https://github.com/bootstrap-tagsinput/bootstrap-tagsinput">https://github.com/bootstrap-tagsinput/bootstrap-tagsinput</a></p>
            <p>Used for tagged information (like YT keywords)</p>
            <p>Examples: <a href="http://bootstrap-tagsinput.github.io/bootstrap-tagsinput/examples/">http://bootstrap-tagsinput.github.io/bootstrap-tagsinput/examples/</a></p>
        </li>
        <li>
            <h4>
                typeahead
            </h4>
            <p>Link: <a href="https://github.com/twitter/typeahead.js">https://github.com/twitter/typeahead.js</a></p>
            <p>Used for auto-completion</p>
        </li>
        <li>
            <h4>
                select2
            </h4>
            <p>Link: <a href="https://select2.github.io/">https://select2.github.io/</a></p>
            <p>Powerful select box replacement with remote load, filtering, etc</p>
        </li>
        <li>
            <h4>
                duallistbox
            </h4>
            <p>Link: <a href="http://www.virtuosoft.eu/code/bootstrap-duallistbox/">http://www.virtuosoft.eu/code/bootstrap-duallistbox/</a></p>
            <p>Used for easy large-scope feature enabling</p>
        </li>
        <li>
            <h4>
                chainedSelects
            </h4>
            <p>Link: <a href="http://www.appelsiini.net/projects/chained">http://www.appelsiini.net/projects/chained</a></p>
            <p>Used for populating a second select box based on the first</p>
        </li>
        <li>
            <h4>
                summernote
            </h4>
            <p>Link: <a href="http://summernote.org/#/getting-started">http://summernote.org/#/getting-started</a></p>
            <p>Slick, lightweight and powerful text editor</p>
        </li>
        <li>
            <h4>
                Dropzone
            </h4>
            <p>Link: <a href="http://www.dropzonejs.com/#">http://www.dropzonejs.com/#</a></p>
            <p>Slick, lightweight and powerful text editor</p>
        </li>
    </ul>
</section>

<section id="class">
    <h3>Footer Scripts</h3>
    <p>Items that need to be in the page footer for some general script initializations</p>
    <pre>
        //for form toggle button field
        $('.btn-toggle').click(function() {
            $(this).find('.btn').toggleClass('active');

            if ($(this).find('.btn-primary').size()>0) {
                $(this).find('.btn').toggleClass('btn-primary');
            }
            if ($(this).find('.btn-danger').size()>0) {
                $(this).find('.btn').toggleClass('btn-danger');
            }
            if ($(this).find('.btn-success').size()>0) {
                $(this).find('.btn').toggleClass('btn-success');
            }
            if ($(this).find('.btn-info').size()>0) {
                $(this).find('.btn').toggleClass('btn-info');
            }

            $(this).find('.btn').toggleClass('btn-default');

        });
        $('.colorpicker').colorpicker();

    </pre>
</section>
<section id="class">
    <h3>Class structure</h3>
    <p>Properties</p>
    <ul>
        <li>public $formScripts = []</li>

        <li>private $formDefaults = []</li>
        <li>private $errors = []</li>
        <li>private $hasSidebar = true</li>
        <li>private $formData = []</li>
        <li>private $post = []</li>
        <li>private $formRecord = []</li>
        <li>private $sideBarInfo = ''</li>
        <li>private $formMethod = "POST"</li>
        <li>private $formHTML = ''</li>
        <li>private $closed = false</li>
        <li>private $validated = false</li>
        <li>private $submitButton = false</li>
        <li>private $tabsHTML = ''</li>
        <li>private $openTab = ''</li>
        <li>private $openLegend = ''</li>
        <li>private $csrf_token = ''</li>
    </ul>
    <p>Methods</p>
    <ul>
       <li>public function showErrors($output=false)<br>
           <em>Output an alert with any form errors that occurred</em>
       </li>
       <li>public function __get($key)<br>
            <em>Returns the specified key from any included form data (typically the record passed in during initialization</em>
       </li>
        <li>private function open()<br>
            <em>Opens the form. Method is always POST, hidden _method field created. If editing, _method is 'PATCH', otherwise 'POST' Then generates the opening tags.</em>
        </li>
        <li>private function close()<br>
            <em>Closes out the form, generates the sidebar, closes tabs and initializes bootstrap form validator</em>
        </li>
        <li>public function generate()<br>
            <em>Outputs the actual form HTML</em>
        </li>
        <li>public function openTab($tabName)<br>
            <em>Allows you to create tabbed content using Bootstrap tab structure.</em>
        </li>
        <li>public function closeTab()<br>
            <em>Closes a previously open tab.</em>
        </li>
        <li>public function openFieldSet($legend)<br>
            <em>Allows you to wrap related form fields in a fieldset with supplied label</em>
        </li>
        <li>public function closeFieldSet()<br>
            <em>Closes a previously open fieldset.</em>
        </li>
        <li>public function setSidebar($sidebar)<br>
            <em>Create a sidebar which is a col-2 column to the right of the form fields</em>
        </li>
        <li>private function label_opens()<br>
            <em>Opens a form label</em>
        </li>
        <li>private function label_close()<br>
            <em>Closes a form label</em>
        </li>
        <li>private function validation($validationOptions) <br>
            <em>Generates the client side form validation code <a href="#validation"> See Validation for more information</a></em>
        </li>
        <li>Other methods are related to specific form field generation, please see <a href="#fields">Fields</a> for more information</li>
    </ul>
</section>


<section id="formsetup">
    <h3>Form Initialization</h3>
    <p>Action by default drives to a form handler script called form_handler.php that does pre-processing of form inputs, then includes a specific handler that is specified in the action string.</p>
    <pre>

        //grab a record to pre-populate from database
        $dbRecord = $db->where('id',1)->from('users')->fetch_first();

        $formOptions = array('action'=>'user.php',
            'id' => { specify or will be auto-generated },
            'data' => $dbRecord,
            'files'=>true,
            'class' => 'form-horizontal',
            'sidebar' => true,
            'title' => '',
            'description' => ''
        );
        $form = new Form($formOptions);

        //add a sidebar
        $sideBar = array('class'=>'success','title'=>'Crucial information','body'=>'Please make sure to be as complete as possible while completing this form.');
        $form->setSidebar($sideBar);
          $array= {
           'label' => 'My label',
           'field' => 'my_field',
           'description' => 'my description',
           'validation' => array(''),
        }

        //add all necessary fields

        //now generate the form

        $form->generate();
    </pre>
</section>

<section id="validation">
    <h3>Form Validation</h3>
    <p></p>
    <pre>
        $validation=array(
            'required' => 'true',
            'error' => 'First and last names are required'
        );
    </pre>
</section>

<section id="fields">
    <h3>Form Fields Fields</h3>
    <p>All standard HTML fields are included, as well as a large number of additional field types such as date pickers, color, addresses, and more.</p>
    <ul>
        <li><a href="#field_hidden">Hidden Field</a></li>
        <li><a href="#field_text">Text Field</a></li>
        <li><a href="#field_textarea">Text Area</a></li>
        <li><a href="#field_texteditor">WYSIWYG Text Editor</a></li>
        <li><a href="#field_email">Email Field</a></li>
        <li><a href="#field_phone">Phone Field</a></li>
        <li><a href="#field_password">Password Field</a></li>
        <li><a href="#field_number">Password Field</a></li>
        <li><a href="#field_date">Date Field</a></li>
        <li><a href="#field_time">Time Field</a></li>
        <li><a href="#field_datetime">DateTime Field</a></li>
        <li><a href="#field_checkbox">Checkbox Field</a></li>
        <li><a href="#field_select">Select Field</a></li>
        <li><a href="#field_selectChain">SelectChain Field</a></li>
        <li><a href="#field_dualSelect">Dual Select Field</a></li>
        <li><a href="#field_checkList">Check List Field</a></li>
        <li><a href="#field_radioList">Radio List Field</a></li>
        <li><a href="#field_file">File Upload Field</a></li>
        <li><a href="#field_dropzone">Dropzone Field</a></li>
        <li><a href="#field_slider">Slider Field</a></li>
        <li><a href="#field_yesNo">YesNo Toggle Field</a></li>
        <li><a href="#field_color">Color Picker Field</a></li>
    </ul>
</section>

<section id="field_hidden">
    <h3>Hidden Field</h3>
    <p>Generates your basic hidden field</p>
    <pre>
        $options = array(
            'field'=> { database field name },
            'label'=>"Middle name",
            'description'=>'',
            'validation' => array()
        );
        $userForm->text($options);
    </pre>
</section>

<section id="field_text">
    <h3>Text Field</h3>
    <p>Generates your basic text field</p>
    <pre>
        $options = array(
            'show_label'=> true, //defaults to true. If false, no wrapping label is generated, simply the input element
            'field'=> { database field name },
            'label'=>"Middle name",
            'description'=>'',
            'validation' => array()
        );
        $userForm->text($options);
    </pre>
</section>

<section id="field_textarea">
    <h3>Textarea Field</h3>
    <p>Generates a textarea element, default </p>
    <pre>
        $options = array(
            'show_label'=> true, //defaults to true. If false, no wrapping label is generated, simply the input element
            'field'=> { database field name },
            'label'=>"Description",
            'description'=>
            'Provide lots of details',
            'validation' => array()
        );
        $userForm->textarea($options);
    </pre>
</section>

<section id="field_texteditor">
    <h3>WYSIWYG Text Editor Field</h3>
    <p>Generates a rich text editor using the Summernote plugin. Actual element is a div, which on blur copies concents to a hidden textarea that is submitted. </p>
    <pre>
        $options = array(
            'show_label'=> true, //defaults to true. If false, no wrapping label is generated, simply the input element
            'field'=> { database field name },
            'label'=>"Description",
            'description'=>'Provide lots of details',
            'validation' => array()
        );
        $userForm->texteditor($options);
    </pre>
</section>

<section id="field_email">
    <h3>Email Field</h3>
    <p>Generates an HTML5 email field. Use additional validation to ensure it's an email!</p>
    <pre>
        $options = array(
            'show_label'=> true, //defaults to true. If false, no wrapping label is generated, simply the input element
            'field'=> { database field name },
            'label'=>"Middle name",
            'description'=>'',
            'validation' => array()
        );
        $userForm->email($options);
    </pre>
</section>

<section id="field_phone">
    <h3>Phone Field</h3>
    <p>Generates an HTML5 tel field. Also uses the maskedinput plugin to provide proper masking</p>
    <pre>
        $options = array(
            'show_label'=> true, //defaults to true. If false, no wrapping label is generated, simply the input element
            'area_code'=> { provide a default areacode },
            'field'=> { database field name },
            'label'=>"Middle name",
            'description'=>'',
            'validation' => array()
        );
        $userForm->phone($options);
    </pre>
</section>

<section id="field_password">
    <h3>Password Field</h3>
    <p>Generates an HTML password field. By default assumes "confirm" as an option passed in and generates a second field. If you don't want this, pass 'confirm'=>false in the options array.</p>
    <pre>
        $options = array(
            'show_label'=> true, //defaults to true. If false, no wrapping label is generated, simply the input element
            'field'=> { database field name },
            'label'=>"Middle name",
            'description'=>'',
            'validation' => array()
        );
        $userForm->password($options);
    </pre>
</section>

<section id="field_number">
    <h3>Number Field</h3>
    <p>Generates an HTML number field. </p>
    <pre>
        $options = array(
            'show_label'=> true, //defaults to true. If false, no wrapping label is generated, simply the input element
            'min'=> { minimum value (not defaulted },
            'max'=> { maximum value (not defaulted },
            'step'=> { allowed increments (not defaulted },
            'field'=> { database field name },
            'label'=>"Middle name",
            'description'=>'',
            'validation' => array()
        );
        $userForm->number($options);
    </pre>
</section>

<section id="field_date">
    <h3>Date Field</h3>
    <p>Generates one or two date fields. Defaults to today if no date is supplied. Uses the bootstrap datetimepicker plugin. Two is used for a range selection</p>
    <pre>
        $options = array(
            'show_label'=> true, //defaults to true. If false, no wrapping label is generated, simply the input element
            'date'=> { date format is "YYYY-MM-DD" },
            'field'=> { database field name },
            'label'=>"Middle name",
            'description'=>'',
            'validation' => array()
        );
        $userForm->date($options);
    </pre>
</section>

<section id="field_time">
    <h3>Time Field</h3>
    <p>Generates one or two time fields. Defaults to now if no time is supplied. Uses the bootstrap datetimepicker plugin. Two is used for a range selection</p>
    <pre>
        $options = array(
            'show_label'=> true, //defaults to true. If false, no wrapping label is generated, simply the input element
            'time'=> { pass in time like "14:23" },
            'field'=> { database field name },
            'label'=>"Middle name",
            'description'=>'',
            'validation' => array()
        );
        $userForm->time($options);
    </pre>
</section>

<section id="field_datetime">
    <h3>DateTime Field</h3>
    <p>Generates one or two date/time combo fields. Defaults to today if no date is supplied. Uses the bootstrap datetimepicker plugin. Two is used for a range selection</p>
    <pre>
        $options = array(
            'show_label'=> true, //defaults to true. If false, no wrapping label is generated, simply the input element
            'datetime'=> { default datetime },
            'field'=> { database field name },
            'label'=>"Middle name",
            'description'=>'',
            'validation' => array()
        );
        $userForm->datetime($options);
    </pre>
</section>

<section id="field_checkbox">
    <h3>Checkbox Field</h3>
    <p>Generates a checkbox field. Automatically creates a hidden field with the same name prefixed with "_check" so that the form handler can always detect the field, even when unchecked</p>
    <pre>
        $options = array(
            'show_label'=> true, //defaults to true. If false, no wrapping label is generated, simply the input element
            'field'=> { database field name },
            'label'=>"Middle name",
            'description'=>'',
            'validation' => array()
        );
        $userForm->checkbox($options);
    </pre>
</section>

<section id="field_select">
    <h3>Select Field</h3>
    <p>Generates a select field. By default it is a select2 plugin enabled field. Also allows for ajax data loading by specifying $options['remote']=path to data + parameters</p>
    <pre>
        $options = array(
            'show_label'=> true, //defaults to true. If false, no wrapping label is generated, simply the input element
            'field'=> { database field name },
            'options'=> array() , //an array of id/values to populate the select box
            'label'=>"Middle name",
            'description'=>'',
            'validation' => array()
        );
        $userForm->select($options);
    </pre>
</section>

<section id="field_state">
    <h3>State Select Field</h3>
    <p>Generates a select field populated with states. By default it is a select2 plugin enabled field. You do not need to pass an 'options' array for this one.</p>
    <pre>
        $options = array(
            'show_label'=> true, //defaults to true. If false, no wrapping label is generated, simply the input element
            'field'=> { database field name },
            'label'=>"Middle name",
            'description'=>'',
            'validation' => array()
        );
        $userForm->select($options);
    </pre>
</section>

<section id="field_selectChain">
    <h3>Select Chain Field</h3>
    <p>Generates a select field that loads a second selects options based on first objects selection. This is artificially limited to 2 selects, but could used for more</p>
    <pre>
        $options = array(
            'show_label'=> true, //defaults to true. If false, no wrapping label is generated, simply the input element
            'field'=> { database field name },
            'options'=> array() , //an array of id/values to populate the first select box
            'field_2'=> { database field name } , //field for second select box
            'options_2'=> array() , //an array of id/values to populate the second select box (for when editing a record where the initial select has been chosen
            'remote'=> {url}, //url to retrieve 2nd select box values from
            'label'=>"Middle name",
            'description'=>'',
            'validation' => array()
        );
        $userForm->selectChain($options);
    </pre>
</section>


<section id="field_dualSelect">
    <h3>Dual Select Field</h3>
    <p>Generates a pair of lists that you can toggle items between. Ideal for large selection sets like permissions.</p>
    <pre>
        $options = array(
            'show_label'=> true, //defaults to true. If false, no wrapping label is generated, simply the input element
            'field'=> { database field name },
            'options'=> array(),  //array of options for the "source" box, options for the "selected" box must come from the values passed in
            'values'=> array(),  //array of selected options for the "selected" box (parsed from DB)
            'label'=>"Middle name",
            'showFilter'=> false, //show a filter, defaults to false
            'nonSelectedLabel'=> '', //label over list of "source" items
            'selectedLabel'=> '', //label over list of "selected" items
            'description'=>'',
            'validation' => array()
        );
        $userForm->dualSelect($options);
    </pre>
</section>

<section id="field_checkList">
    <h3>Check List Field</h3>
    <p>Generates a set of checkboxes spread over "x" columns: $options['columns']=3</p>
    <pre>
        $options = array(
            'show_label'=> true, //defaults to true. If false, no wrapping label is generated, simply the input element
            'columns'=> { default 3 },
            'field'=> { database field name },
            'label'=>"Middle name",
            'description'=>'',
            'validation' => array());
        $userForm->checkList($options);
    </pre>
</section>

<section id="field_radioList">
    <h3>Radio List Field</h3>
    <p>Generates a set of radio buttons spread over "x" columns: $options['columns']=3</p>
    <pre>
        $options = array(
            'show_label'=> true, //defaults to true. If false, no wrapping label is generated, simply the input element
            'columns'=> { default 3 },
            'field'=> { database field name },
            'label'=>"Middle name",
            'description'=>'',
            'validation' => array());
        $userForm->radioList($options);
    </pre>
</section>

<section id="field_file">
    <h3>File Field</h3>
    <p>Generates a standard file input. By default provides an image preview of any existing file. $options['preview']=false to disable</p>
    <pre>
        $options = array(
            'show_label'=> true, //defaults to true. If false, no wrapping label is generated, simply the input element
            'field'=> { database field name },
            'uploadDirectory'=>{ path to uploads },
            'createDirectory'=>{ true/false },
            'description'=>'');
        $userForm->radioList($options);
    </pre>
</section>

<section id="field_dropzone">
    <h3>DropZone Field</h3>
    <p>Generates a dropzone to handle file uploads. This will be inserted into the sidebar since we can't nest forms.</p>
    <pre>
        $options = array(
            'show_label'=> true, //defaults to true. If false, no wrapping label is generated, simply the input element
            'field'=> { database field name },
            'uploadDirectory'=>{ path to uploads },
            'createDirectory'=>{ true/false },
            'deleteHandler'=>{ path to delete handler },
            'description'=>'',
            'validation' => array({things like file size, file types, etc.})
        );
        $userForm->dropzone($options);
    </pre>
</section>

<section id="field_slider">
    <h3>Slider Field</h3>
    <p>Generates a horizontal slider for entering a number visually.</p>
    <pre>
        $options = array(
            'show_label'=> true, //defaults to true. If false, no wrapping label is generated, simply the input element
            'min'=> { default 1 },
            'max'=> { default 100 },
            'step'=> { default 1 },
            'orientation'=> { default horizontal (also 'vertical' is available },
            'range'=> { default false (if true,  value2 must be set },
            'value2'=> { used for range selection },
            'field'=> { database field name },
            'label'=>"Middle name",
            'description'=>''
        );
        $userForm->slider($options);
    </pre>
</section>

<section id="field_yesNo">
    <h3>Yes/No Field</h3>
    <p>Generates a pair of radio buttons wrapped with some special BS classes to create a yes/no (or other binary option) toggle field..</p>
    <pre>
        $options = array(
            'show_label'=> true, //defaults to true. If false, no wrapping label is generated, simply the input element
            'options'=> array(
                 array('label'=>'Yes 1','value'=>'1','default'=>true,'class'=>'primary'),
                 array('label'=>'No','value'=>'0','default'=>false,'class'=>'default')
                ),
            'field'=> { database field name },
            'label'=>"Middle name",
            'description'=>''
        );
        $userForm->yesNo($options);
    </pre>
</section>

<section id="field_color">
    <h3>Color Picker Field</h3>
    <p>Generates a pair of radio buttons wrapped with some special BS classes to create a yes/no (or other binary option) toggle field..</p>
    <pre>
        $options = array(
            'show_label'=> true, //defaults to true. If false, no wrapping label is generated, simply the input element
            'default'=> '#ffffff',
            'field'=> { database field name },
            'label'=>"Color",
            'description'=>''
        );
        $userForm->color($options);
    </pre>
</section>