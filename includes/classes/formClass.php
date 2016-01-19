<?php
/*
 * THIS SCRIPT HANDLES ALL FORM GENERATION
 * It accepts the previous POST and an array of field data from a database query
 * Validation is handled via ajax on the user side, but is generated via this class
 *
 * Dependencies:
 * Session class passed in
 *
 * javascript libraries
 * bootstrapvalidator : http://1000hz.github.io/bootstrap-validator/
 * bootstrapdatetimepicker  http://eonasdan.github.io/bootstrap-datetimepicker
 * colorpicker http://mjolnic.com/bootstrap-colorpicker/
 * slider http://www.eyecon.ro/bootstrap-slider/
 * maskedinput http://digitalbush.com/projects/masked-input-plugin
 * typeahead https://github.com/twitter/typeahead.js
 * duallistbox http://www.virtuosoft.eu/code/bootstrap-duallistbox/
 * chainedSelects http://www.appelsiini.net/projects/chained
 * select2 https://select2.github.io/
 * summernote http://summernote.org/#/getting-started
 *             summernote example with image uploader http://mycodde.blogspot.com/2014/09/summernote-wyswig-editor-php-tutorial.html
 * base usage is
 *

 * $dbRecord = $db->where('id',1)->fetch_first();
 *
 * $formOptions = array('action'=>$_SERVER['PHP_SELF'],
                        'data' => $dbRecord,
                        'files'=>true,
                        'class' => 'form-horizontal',
                        'sidebar' => true,
                        'title' => '',
                        'description' => ''
        );
 * $form = new Form($formOptions);
 *
 * $
 * $sideBar = array('class'=>'success','title'=>'Crucial information','body'=>'Please make sure to be as complete as possible while completing this form.');
 * $form->setSidebar($sideBar);
 *  $array= {
 *  'label' => 'My label',
 *  'field' => 'my_field',
 *  'description' => 'my description',
 *  'validation' => array(''),
 * }
 *
 * $form->text($array);
 *
 *
 * WHEN YOU HAVE ADDED ALL THE COMPONENTS THEN CALL
 *
 * $form->generate();
 */
class Form
{
    public $formScripts = [];

    private $formDefaults = [];
    private $errors = [];
    private $hasSidebar = true;
    private $formData = [];
    private $post = [];
    private $formRecord = [];
    private $sideBarInfo = '';
    private $formMethod = "POST";
    private $formHTML = '';
    private $closed = false;
    private $validated = false;
    private $submitButton = false;
    private $tabsHTML = '';
    private $openTab = '';
    private $openLegend = '';
    private $csrf_token = '';
    private $tabOpen = false;
    private $fieldsetOpen = false;
    private $successURL = '';

    function __construct($formOptions=array())
    {
        global $session; //depends on a global $session variable being created
        /* set up defaults */
        $this->formDefaults = array('action'=>$_SERVER['PHP_SELF'],
            'id' => 'form_'.$this->generateID(),
            'data' => array(),
            'files'=>true,
            'class' => 'form-horizontal',
            'sidebar' => true,
            'title' => '',
            'successURL' => $_SERVER['PHP_SELF'], //default back to same page
            'description' => ''
        );
        if(isset($formOptions['data']) && count($formOptions['data'])>0) {
            $this->formRecord = $formOptions['data'];
            unset($formOptions['data']); //remove data from form Options since we have it in a separate variable now
            $this->formMethod = "PATCH"; // updating the form
        } else {
            $this->formRecord = array();
            $this->formMethod = "POST";  // this is a new form since we didn't pass in any data
        }
        $this->formOptions=array_merge($this->formDefaults, $formOptions); //merge passed options against the defaults

        if($_POST){$this->post = $_POST;}

        /* post trumps $formRecord data (basically if you post, and the form has to reload for some reason, the post data should take precedence */
        $this->formData = array_merge($this->formRecord,$_POST);
        /* post trumps $formRecord data (basically if you post, and the form has to reload for some reason, the session old post data should take precedence */
        if(isset($session->oldPost) && count($session->oldPost)>0)
        {
            $this->formData = array_merge($this->formRecord,$session->oldPost);
            $session->oldPost = [];
        }
        $this->csrf_token = $session->csrf_token;
        $this->successURL = $this->formOptions['successURL'];
        //grab any form errors from session and assign them
        $this->errors = $session->getFormErrors();
        $this->open();
    }

    public function __destruct()
    {
    }

    public function old($field)
    {
        // see if this is in the post, if so, lets echo it out
        $old = '';
        if(isset($this->post[$field]))
        {
            $old = $this->post[$field];
        }
        echo $old;
    }

    public function errors()
    {
        if(count($this->errors))
        {
            return false;
        } else {
            return true;
        }
    }

    public function showErrors($output=false)
    {
        if(count($this->errors))
        {
            $errors='
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>';
           foreach ($this->errors as $error)
           {
               $errors.= "<li>$error</li>\n";
           }
            $errors.= '
                </ul>
            </div>';
        }
        if($output)
        {
            echo $errors;
        } else {
            return $errors;
        }
    }

    public function __get($key)
    {
        if (array_key_exists($key, $this->formData)) {
            return $this->formData[$key];
        } else {
            return "This key does not exist.";
        }
    }


    /*
     *  OPENS THE FORM
     *  Method is always post, but we'll have a hidden _method field that will be POST or PATCH (patch for an update)
     *
     */
    private function open()
    {
        $action='';
        $files=true;
        $sidebar=true;
        $title='';
        $description='';
        $class='form-horizontal';
        $id='';
        extract($this->formOptions);

        if($action==''){$action=$_SERVER['PHP_SELF'];}
        if($files){$e="enctype='multipart/form-data'";}
        if($sidebar)
        {
            $this->formHTML.= "<div class='row'>\n<div class='col-md-9 col-xs-12'>\n";
            $this->hasSidebar = true;
        } else {
            $this->formHTML.= "<div class='row'>\n<div class='col-md-12'>\n";
        }
        if($title!='')
        {
            $this->formHTML.= "<h3>".$title."</h3>\n";
        }
        if($description!='')
        {
            $this->formHTML.= "<p>".$description."</p>\n";
        }
        if(substr($this->formOptions['action'],0,1)=='/')
        {
            //means we have a specific URL to go to
            $action=$this->formOptions['action'];
            $handler='';
        } else {
            //otherwise we're using the base handler
            $action="/handlers/form_handler.php";
            $handler=$this->formOptions['action'];
        }
        $this->formHTML.=$this->showErrors();
        $this->formHTML.="{{TABS}}\n";
        $this->formHTML.="<form name='$id' id='$id' method='POST' action='$action' $e class='$class' data-toggle='validator' role='form'>\n";
        $this->formHTML.="{{TABCONTENTDIV}}\n";
        $this->formHTML.="<input type='hidden' name='_method' id='_method' value='$this->formMethod' />\n";
        $this->formHTML.="<input type='hidden' name='csrf_token' id='csrf_token' value='$this->csrf_token' />\n";
        $this->formHTML.="<input type='hidden' name='_form_handler' id='_form_handler' value='$handler' />\n";
        $this->formHTML.="<input type='hidden' name='_success_url' id='_success_url' value='$this->successURL' />\n";
        if($this->formMethod=='PATCH')
        {
            //did we pass in a recordID, if so use that instead
            if(isset($this->formOptions['recordID']))
            {
                $recordID=$this->formOptions['recordID'];
            } else {
                $recordID=$this->formRecord['id'];
            }
            $this->formHTML.="<input type='hidden' name='_record_id' id='_record_id' value=\"$recordID\" />\n";
        }

    }

    private function close()
    {

        if($this->tabsHTML != '')
        {
            $tabs="<ul class=\"nav nav-tabs\" role=\"tablist\">\n";
            $tabs.=$this->tabsHTML;
            $tabs.="</ul>\n";
            $div="<div class=\"tab-content\" style='margin-top:10px;'>\n";
            $this->formHTML=str_replace("{{TABS}}",$tabs,$this->formHTML);
            $this->formHTML=str_replace("{{TABCONTENTDIV}}",$div,$this->formHTML);
        } else {
            $this->formHTML = str_replace("{{TABS}}", "", $this->formHTML);
            $this->formHTML = str_replace("{{TABCONTENTDIV}}", "", $this->formHTML);
        }

        if($this->hasSidebar)
        {
            if($this->tabsHTML != '')
            {
                $this->formHTML.= "</div><!-- closing tab content area -->\n";
            }
            if(!$this->submitButton){$this->submit();}
            $this->formHTML.="</form>\n";

            $this->formHTML.= "</div>\n";
            $this->formHTML.= "<div class='col-md-3 col-xs-12'>";
            $this->formHTML.= $this->sideBarInfo;
            $this->formHTML.= "\n</div>\n</div>\n";
        } else {
            if($this->tabsHTML != '')
            {
                $this->formHTML.= "</div><!-- closing tab content area -->\n";
            }
            if(!$this->submitButton){$this->submit();}
            $this->formHTML.="</form>\n";

            $this->formHTML.= "</div>\n</div>\n";
        }
        $this->closed=true;

        if($this->validated)
        {
            $this->formScripts[]="\$('#".$this->formDefaults['id']."').validator()\n";
        }

        $GLOBALS['scripts']=array_merge($GLOBALS['scripts'],$this->formScripts);
    }

    public function generate()
    {
        if(!$this->closed){$this->close();}

        echo $this->formHTML;
    }

    public function openTab($tabName)
    {
        if ($this->tabOpen == false) {
            //only allow tab open when the last one is closed
            $this->openTab = $tabName;
            $tab = strtolower(str_replace(" ", "_", $tabName));
            $this->tabOpen = true;
            if ($this->tabsHTML == '') {
                $this->tabsHTML = "<li role=\"presentation\" class=\"active\"><a href=\"#$tab\" aria-controls=\"$tab\" role=\"tab\" data-toggle=\"tab\">$tabName</a></li>\n";
                $this->formHTML .= "<div role=\"tabpanel\" class=\"tab-pane active container\" id=\"$tab\">\n";
            } else {
                $this->tabsHTML .= "<li role=\"presentation\"><a href=\"#$tab\" aria-controls=\"$tab\" role=\"tab\" data-toggle=\"tab\">$tabName</a></li>\n";
                $this->formHTML .= "<div role=\"tabpanel\" class=\"tab-pane container\" id=\"$tab\">\n";
            }
        }
    }

    public function closeTab()
    {
        if($this->tabOpen) {
            $this->formHTML .= "</div> <!-- closing tab for $this->openTab -->\n";
            $this->openTab = '';
            $this->tabOpen = false;
        }
    }

    public function openFieldSet($legend)
    {
        if ($this->fieldsetOpen == false) {
            $this->formHTML .= "<fieldset>\n";
            $this->formHTML .= "<legend>$legend</legend>\n";
            $this->openLegend = $legend;
            $this->fieldsetOpen = true;
        }
    }

    public function closeFieldSet()
    {
        if($this->fieldsetOpen) {
            $this->formHTML .= "</fieldset>  <!-- closing fieldset for $this->openLegend -->\n";
            $this->openLegend = '';
            $this->fieldsetOpen = false;
        }
    }

    public function setSidebar($sidebar)
    {
        $class = (isset($sidebar['class']) ? $sidebar['class'] : 'default');
        $this->sideBarInfo = <<<EOT
\n        <div class="panel panel-$class">
          <div class="panel-heading">
            <h3 class="panel-title">$sidebar[title]</h3>
          </div>
          <div class="panel-body">
              $sidebar[body]
          </div>
        </div>\n
EOT;
    }

    private function label_open($options)
    {
        $description = ($options['description'] != '') ? "    <p class='help-block'>$options[description]</p>\n" : '';

        if ($this->formOptions['class'] == 'form-horizontal') {

        $this->formHTML .= <<<FORMELEMENT
        <div class="form-group">
            <label for="$options[field]" class="col-sm-2 control-label">$options[label]</label>
            <div class="col-sm-10">
            $description
FORMELEMENT;
        } else {
        $this->formHTML .= <<<FORMELEMENT
        <div class="form-group">
            <label for="$options[field]" >$options[label]</label>
            $description
FORMELEMENT;
        }
    }

    private function label_close()
    {
        $this->formHTML.="  <div class='help-block with-errors' aria-hidden=\"true\"></div>\n";
        if ($this->formOptions['class'] == 'form-horizontal') {
            $this->formHTML.="            </div>
        </div>\n";
        } else {
            $this->formHTML.="            </div>\n";
        }
    }

    private function validation($validationOptions)
    {
        $this->validated = true;

        $type   = $validationOptions['type'];
        $rules  = $validationOptions['options'];

        $validation = '';

        switch($type)
        {
            case "email":
                if($rules['error']!='') $validation .= "data-error='".$rules['error']."' ";
                if($rules['required']) $validation .= 'required ';

                break;

            case 'date':
                if(isset($rules['defaultDate'])){$validation .= "defaultDate: moment(\"$rules[defaultDate]\"),\n";}
                if(isset($rules['disabledDays'])){$validation .= "daysOfWeekDisabled: [$rules[disabledDays]],\n";}
                if(isset($rules['minDate'])){$validation .= "minDate: moment(\"$rules[minDate]\"),\n";}
                if(isset($rules['maxDate'])){$validation .= "maxDate: moment(\"$rules[maxDate]\"),\n";}
                if(isset($rules['disabledDates'])){
                    $validation .= "disabledDates: [";
                    $dates='';
                    foreach($rules['disabledDates'] as $date)
                    {
                        $dates .= "moment(\"$date\"),";
                    }
                    $dates=rtrim($dates,",");
                    $validation.=$dates;
                    $validation .=" ],\n";
                }
                break;

            case 'time':
                if(isset($rules['stepping'])){$validation .= "stepping: \"$rules[stepping]\",\n";}
                if(isset($rules['disabledHours'])){$validation .= "disabledHours: \"$rules[stepping]\",\n";}


                break;

            case 'datetime':
                if(isset($rules['defaultDate'])){$validation .= "defaultDate: moment(\"$rules[defaultDate]\"),\n";}
                if(isset($rules['disabledDays'])){$validation .= "daysOfWeekDisabled: [$rules[disabledDays]],\n";}
                if(isset($rules['minDate'])){$validation .= "minDate: moment(\"$rules[minDate]\"),\n";}
                if(isset($rules['maxDate'])){$validation .= "maxDate: moment(\"$rules[maxDate]\"),\n";}
                if(isset($rules['stepping'])){$validation .= "stepping: \"$rules[stepping]\",\n";}
                if(isset($rules['disabledHours'])){$validation .= "disabledHours: \"$rules[stepping]\",\n";}
                if(isset($rules['disabledDates'])){
                    $validation .= "disabledDates: [";
                    $dates='';
                    foreach($rules['disabledDates'] as $date)
                    {
                        $dates .= "moment(\"$date\"),";
                    }
                    $dates=rtrim($dates,",");
                    $validation.=$dates;
                    $validation .=" ],\n";
                }
                break;

            default:
                if($rules['error']!='') $validation .= "data-error='".$rules['error']."' ";
                if($rules['required']) $validation .= 'required ';
                if($rules['min_length']) $validation .= "data-minlength='".$rules['min_length']."' ";
                if($rules['match']) $validation .= "data-match='#".$rules['match']."' data-match-error='Does not match the other field' ";
                if($rules['pattern']) $validation .= "pattern='".$rules['pattern']."' data-match-error='Does not match the requirements' ";

                /* specific for number fields */
                if($rules['min']!='') $validation .= "min='".$rules['min']."' ";
                if($rules['max']!='') $validation .= "max='".$rules['max']."' ";
                if($rules['step']!='') $validation .= "step='".$rules['step']."' ";
                break;
        }
        $validation = rtrim($validation,"\n");
        $validation = rtrim($validation,",");


        return $validation;
    }



    function submit($options=array())
    {
        $this->submitButton = true;
        $defaults = array('label'=>'Save','name'=>'submitButton','class'=>'primary','disabled'=>'');
        $options=array_merge($defaults,$options);
        $onClick='';
        if(isset($options['onclick']) && $options['onclick']!=''){$onClick=" onClick = \"$options[onclick]\" ";}
        $this->formHTML.=<<<FORMBUTTON
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type='submit' id='$options[name]' name='$options[name]' class="btn btn-$options[class]" value='$options[label]' $options[disabled] $onClick />
            </div>
        </div>\n
FORMBUTTON;
    }

    function text($options)
    {
        $defaults = array('show_label'=>true);
        $options = array_merge($defaults,$options);

        $field = $options['field'];
        $placeholder = htmlentities(isset($options['placeholder'])? $options['placeholder'] : $this->formData[$field]);
        $value = stripslashes($this->formData[$field]);
        if($options['show_label']) {
            $this->label_open($options);
        }
        $validation = '';
        if(isset($options['validation'])){$validation = $this->validation(array('type'=>'email', 'options' => $options['validation']));}
        //the actual text field
        $this->formHTML.="                <input type=\"text'\" class=\"form-control\" id=\"$field\" name=\"$field\" placeholder=\"$placeholder\" value=\"$value\" $validation>\n";

        if($options['show_label']) {
            $this->label_close();
        }
    }

    function textarea($options)
    {
        $defaults = array('show_label'=>true, 'width'=>'100%','height'=>'10', 'editor'=>true);
        $options = array_merge($defaults,$options);

        $placeholder = stripslashes(isset($options['placeholder'])? $options['placeholder'] : $this->formData[$options['field']]);
        $value = htmlentities($this->formData[$options['field']]);
        if($options['show_label']) {
            $this->label_open($options);
        }
        $validation = '';
        if(isset($options['validation'])){$validation = $this->validation(array('type'=>'textarea', 'options' => $options['validation']));}
        //the actual text field
        $this->formHTML.="                <textarea class=\"form-control\" id=\"$options[field]\" name=\"$options[field]\"  $validation>$value</textarea>\n";
        if($options['show_label']) {
            $this->label_close();
        }
    }

    function texteditor($options)
    {
        $defaults = array('show_label'=>true, 'width'=>'100%','height'=>'10', 'editor'=>true);
        $options = array_merge($defaults,$options);

        $placeholder = htmlentities(isset($options['placeholder'])? $options['placeholder'] : $this->formData[$options['field']]);
        $value = stripslashes($this->formData[$options['field']]);
        if($options['show_label']) {
            $this->label_open($options);
        }
        $validation = '';
        if(isset($options['validation'])){$validation = $this->validation(array('type'=>'textarea', 'options' => $options['validation']));}
        //the actual text field
        $this->formHTML.="                <div id=\"$options[field]_editor\" >$value</div>\n";
        $this->formHTML.="                <textarea id=\"$options[field]\" name=\"$options[field]\" style='display:none;'>$value</textarea>\n";
        if($options['show_label']) {
            $this->label_close();
        }

        //see if it needs to be a summernote instance

        $this->formScripts[] = "//initialize summernote text editor instances
    \$('#$options[field]_editor').summernote({
        callbacks: {
            onBlur: function() {
                var contents = $(this).summernote(\"code\");
                $('#$options[field]').val(contents);
            }
        },
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
        ],
        minHeight: 150             // set minimum height of editor

    });
        ";

    }

    function email($options)
    {
        $defaults = array('show_label'=>true);
        $options = array_merge($defaults,$options);
        $field = $options['field'];
        $placeholder = htmlentities(isset($options['placeholder'])? $options['placeholder'] : $this->formData[$field]);
        $value = stripslashes($this->formData[$field]);

        if($options['show_label']) {
            $this->label_open($options);
        }
            $validation = '';
        if(isset($options['validation'])){$validation = $this->validation(array('type'=>'email', 'options' => $options['validation']));}

        //the actual text field
        $this->formHTML.="                <input type=\"email\" class=\"form-control\" placeholder=\"$placeholder\" value=\"$value\" id=\"$options[field]\" name=\"$options[field]\" $validation>\n";
        if($options['show_label']) {
            $this->label_close();
        }
    }

    function phone($options)
    {
        $defaults = array('show_label'=>true);
        $options = array_merge($defaults,$options);

        $placeholder = htmlentities(isset($options['placeholder'])? $options['placeholder'] : $this->formData[$options['field']]);
        $value = $this->formatPhone($this->formData[$options['field']],'display',$options['area_code']);
        if($options['show_label']) {
            $this->label_open($options);
        }
        $validation = '';
        if(isset($options['validation'])){$validation = $this->validation(array('type'=>'email', 'options' => $options['validation']));}

        //the actual text field
        $this->formHTML.="                <input type=\"tel\" class=\"form-control\" id=\"$options[field]\" name=\"$options[field]\" placeholder=\"$placeholder\" value=\"$value\" $validation>\n";
        if($options['show_label']) {
            $this->label_close();
        }
        $this->formScripts[]="\$(\"#$options[field]\").mask(\"(999) 999-9999? x99999\");\n";
    }

    function password($options)
    {
        $defaults = array('show_label'=>true,'confirm' => true);
        $options = array_merge($defaults,$options);

        $placeholder = htmlentities(isset($options['placeholder']) ? $options['placeholder'] : $this->formData[$options['field']]);
        $value = stripslashes($this->formData[$options['field']]);
        if($options['show_label']) {
            $this->label_open($options);
        }
        $validation = '';
        if (isset($options['validation'])) {
            $validation = $this->validation(array('type' => 'password', 'options' => $options['validation']));
        }

        //the actual text field
        $this->formHTML .= "        <div class='col-sm-6'><input type=\"text\" class=\"form-control\" id=\"$options[field]\" name=\"$options[field]\"  $validation></div>\n";
        if ($options['confirm']) {
            $this->formHTML .= "<div class='col-sm-6'><input type=\"text\" class=\"form-control col-sm-6\" id=\"$options[field]_confirm\" name=\"$options[field]_confirm\" placeholder=\"Confirm\" value=\"\" data-match=\"$options[field]\" data-match-error='Passwords do not match'></div>\n";
        }
        if($options['show_label']) {
            $this->label_close();
        }
    }

    function number($options)
    {
        $defaults = array('show_label'=>true);
        $options = array_merge($defaults,$options);

        $placeholder = htmlentities(isset($options['placeholder'])? $options['placeholder'] : $this->formData[$options['field']]);
        $value = stripslashes($this->formData[$options['field']]);
        if($options['show_label']) {
            $this->label_open($options);
        }
        $validation = '';
        if(isset($options['validation'])){$validation = $this->validation(array('type'=>'number', 'options' => $options['validation']));}

        //the actual text field
        $this->formHTML.="                <input type=\"number\" class=\"form-control\" id=\"$options[field]\" name=\"$options[field]\" placeholder=\"$placeholder\" value=\"$value\" $validation>\n";
        if($options['show_label']) {
            $this->label_close();
        }
    }


    function date($options)
    {
        $defaults = array('show_label'=>true);
        $options = array_merge($defaults,$options);

        $placeholder = htmlentities(isset($options['placeholder'])? $options['placeholder'] : $this->formData[$options['field']]);
        if($this->formData[$options['field']]!='')
        {
            $value=date("m/d/Y",strtotime($this->formData[$options['field']]));
        } else {
            $value=date("m/d/Y",time());
        }
        if($options['show_label']) {
            $this->label_open($options);
        }
        $validation = '';

        if(!(isset($options['validation']['defaultDate']))){
            $options['validation']['defaultDate']=$value;
        }
        $validation = $this->validation(array('type'=>'date', 'options' => $options['validation']));
        //the actual text field
        //need to control for a start/stop type field with two input fields
        if(isset($options['second_field']))
        {
            $this->formHTML .= "<div class='col-md-6 col-xs-12'>\n <div class='input-group date' id=\"$options[field]\">
                        <input type='text' class=\"form-control\" name=\"$options[field]\" />
                        <span class=\"input-group-addon\">
                            <span class=\"glyphicon glyphicon-calendar\"></span>
                        </span>
                    </div>\n
                    </div>\n";
            $this->formHTML .= "<div class='col-md-6 col-xs-12'>\n <div class='input-group date' id=\"$options[second_field]\">
                        <input type='text' class=\"form-control\" name=\"$options[second_field]\" />
                        <span class=\"input-group-addon\">
                            <span class=\"glyphicon glyphicon-calendar\"></span>
                        </span>
                    </div>\n
                    </div>\n";
            $secondValidation = $this->validation(array('type'=>'date', 'options' => $options['second_validation']));

            $this->formScripts[] = <<<DATEDATA
        $('#$options[field]').datetimepicker({
                    format: "MM/DD/YYYY",
                    useCurrent: true,
                    showTodayButton: true,
                    icons: {
                        time: "fa fa-clock-o",
                     },
                    $validation
                });\n
        $('#$options[second_field]').datetimepicker({
                    format: "MM/DD/YYYY",
                    useCurrent: false,
                    showTodayButton: true,
                    icons: {
                        time: "fa fa-clock-o",
                     },
                    $secondValidation
                });\n
        $("#$options[field]").on("dp.change", function (e) {
            $('#$options[second_field]').data("DateTimePicker").minDate(e.date);
        });
        $("#$options[second_field]").on("dp.change", function (e) {
            $('#$options[field]').data("DateTimePicker").maxDate(e.date);
        });
DATEDATA;
        } else {
            $this->formHTML .= "                <div class='input-group date' id=\"$options[field]\">
                        <input type='text' class=\"form-control\" name=\"$options[field]\" />
                        <span class=\"input-group-addon\">
                            <span class=\"glyphicon glyphicon-calendar\"></span>
                        </span>
                    </div>\n";
            $this->formScripts[] = <<<DATEDATA
        $('#$options[field]').datetimepicker({
                    format: "MM/DD/YYYY",
                    useCurrent: true,
                    showTodayButton: true,
                    $validation
                });\n
DATEDATA;
        }
        if($options['show_label']) {
            $this->label_close();
        }
    }

    function time($options)
    {
        $defaults = array('show_label'=>true);
        $options = array_merge($defaults,$options);

        $placeholder = htmlentities(isset($options['placeholder'])? $options['placeholder'] : $this->formData[$options['field']]);
        if($this->formData[$options['field']]!='')
        {
            $value=date("H:i",strtotime($this->formData[$options['field']]));
        } else {
            $value=date("H:i",time());
        }

        if($options['show_label']) {
            $this->label_open($options);
        }
        $validation = '';

        $validation = $this->validation(array('type'=>'date', 'options' => $options['validation']));
        //the actual text field
        //need to control for a start/stop type field with two input fields
        if(isset($options['second_field']))
        {
            $this->formHTML .= "<div class='col-md-6 col-xs-12'>\n <div class='input-group date' id=\"$options[field]\">
                        <input type='text' class=\"form-control\" name=\"$options[field]\" />
                        <span class=\"input-group-addon\">
                            <span class=\"glyphicon glyphicon-calendar\"></span>
                        </span>
                    </div>\n
                    </div>\n";
            $this->formHTML .= "<div class='col-md-6 col-xs-12'>\n <div class='input-group date' id=\"$options[second_field]\">
                        <input type='text' class=\"form-control\" name=\"$options[second_field]\" />
                        <span class=\"input-group-addon\">
                            <span class=\"glyphicon glyphicon-calendar\"></span>
                        </span>
                    </div>\n
                    </div>\n";
            $secondValidation = $this->validation(array('type'=>'date', 'options' => $options['second_validation']));

            $this->formScripts[] = <<<DATEDATA
        $('#$options[field]').datetimepicker({
                    format: "HH:mm",
                    useCurrent: true,
                    $validation
                });\n
        $('#$options[second_field]').datetimepicker({
                    format: "HH:mm",
                    useCurrent: false,
                    $secondValidation
                });\n
        $("#$options[field]").on("dp.change", function (e) {
            $('#$options[second_field]').data("DateTimePicker").minDate(e.date);
        });
        $("#$options[second_field]").on("dp.change", function (e) {
            $('#$options[field]').data("DateTimePicker").maxDate(e.date);
        });
DATEDATA;
        } else {
            $this->formHTML .= "                <div class='input-group date' id=\"$options[field]\">
                        <input type='text' class=\"form-control\" name=\"$options[field]\" />
                        <span class=\"input-group-addon\">
                            <span class=\"glyphicon glyphicon-calendar\"></span>
                        </span>
                    </div>\n";
            $this->formScripts[] = <<<DATEDATA
        $('#$options[field]').datetimepicker({
                    format: "HH:mm",
                    useCurrent: false,
                    $validation
                });\n
DATEDATA;
        }
        if($options['show_label']) {
            $this->label_close();
        }
    }

    function datetime($options)
    {
        $defaults = array('show_label'=>true);
        $options = array_merge($defaults,$options);

        $placeholder = htmlentities(isset($options['placeholder'])? $options['placeholder'] : $this->formData[$options['field']]);
        if($this->formData[$options['field']]!='')
        {
            $value=date("m/d/Y H:i",strtotime($this->formData[$options['field']]));
        } else {
            $value=date("m/d/Y H:i",time());
        }

        if($options['show_label']) {
            $this->label_open($options);
        }
        $validation = '';

        if(!(isset($options['validation']['defaultDate']))){
            $options['validation']['defaultDate']=$value;
        }
        $validation = $this->validation(array('type'=>'datetime', 'options' => $options['validation']));
        //the actual text field
        //need to control for a start/stop type field with two input fields
        if(isset($options['second_field']))
        {
            $this->formHTML .= "<div class='col-md-6 col-xs-12'>\n <div class='input-group date' id=\"$options[field]\">
                        <input type='text' class=\"form-control\" name=\"$options[field]\" />
                        <span class=\"input-group-addon\">
                            <span class=\"glyphicon glyphicon-calendar\"></span>
                        </span>
                    </div>\n
                    </div>\n";
            $this->formHTML .= "<div class='col-md-6 col-xs-12'>\n <div class='input-group date' id=\"$options[second_field]\">
                        <input type='text' class=\"form-control\" name=\"$options[second_field]\" />
                        <span class=\"input-group-addon\">
                            <span class=\"glyphicon glyphicon-calendar\"></span>
                        </span>
                    </div>\n
                    </div>\n";
            $secondValidation = $this->validation(array('type'=>'date', 'options' => $options['second_validation']));

            $this->formScripts[] = <<<DATEDATA
        $('#$options[field]').datetimepicker({
                    format: "MM/DD/YYYY HH:mm",
                    useCurrent: true,
                    $validation
                });\n
        $('#$options[second_field]').datetimepicker({
                    format: "MM/DD/YYYY HH:mm",
                    useCurrent: true,
                    $secondValidation
                });\n
        $("#$options[field]").on("dp.change", function (e) {
            $('#$options[second_field]').data("DateTimePicker").minDate(e.date);
        });
        $("#$options[second_field]").on("dp.change", function (e) {
            $('#$options[field]').data("DateTimePicker").maxDate(e.date);
        });\n
DATEDATA;
        } else {
            $this->formHTML .= "                <div class='input-group date' id=\"$options[field]\">
                        <input type='text' class=\"form-control\" name=\"$options[field]\" />
                        <span class=\"input-group-addon\">
                            <span class=\"glyphicon glyphicon-calendar\"></span>
                        </span>
                    </div>\n";
            $this->formScripts[] = <<<DATEDATA
        $('#$options[field]').datetimepicker({
                    format: "MM/DD/YYYY HH:mm",
                    useCurrent: true,
                    $validation
                });\n
DATEDATA;
        }
        if($options['show_label']) {
            $this->label_close();
        }
    }


    function checkbox($options)
    {
        $defaults = array('show_label'=>true);
        $options = array_merge($defaults,$options);

        $value = stripslashes($this->formData[$options['field']]);

        if(isset($options['description']))
        {
            $description = $options['description'];
            unset($options['description']);
        }
        if($options['show_label']) {
            $this->label_open($options);
        }
        $validation = '';
        if(isset($options['validation'])){$validation = $this->validation(array('type'=>'email', 'options' => $options['validation']));}
        if($value){$value='checked';}else{$value='';}
        //the actual text field
        $this->formHTML.="             <div class=\"checkbox\">
                    <label>
                        <input type=\"checkbox\" name=\"$options[field]\" id=\"$options[field]\" $value> $description
                    </label>
                    <input type=\"hidden\" name=\"_check_$options[field]\" id=\"_check_$options[field]\" value=''>
                </div>\n";

        if($options['show_label']) {
            $this->label_close();
        }
    }

    function label($options)
    {
        $this->label_open($options);
        $this->label_close();
    }

    function hidden($options)
    {
        $value = stripslashes($this->formData[$options['field']]);
        $this->formHTML.="    <input type='hidden' id='$options[field]' name='$options[field]' value='$value' />\n";
    }

    function select($options)
    {
        $defaults = array('show_label'=>true);
        $options = array_merge($defaults,$options);

        $value = stripslashes($this->formData[$options['field']]);
        if($options['show_label']) {
            $this->label_open($options);
        }
        $validation = '';
        if(isset($options['validation'])){$validation = $this->validation(array('type'=>'select', 'options' => $options['validation']));}
        //the actual text field
        if($options['other']==true) {
            $this->formHTML.="    <div class='row'><div class='col-sm-12 col-md-8'>";
        }
        $this->formHTML.="    <select class=\"form-control\" name=\"$options[field]\" id=\"$options[field]\" style=\"width:300px\" $validation>\n";
        // print out the <option> tags
        if(count($options['options'])>0)
        {
            $this->formHTML.= "     <option value=''>Please select</option>\n";
            if($options['other']==true) {
                $this->formHTML .= "     <option value='_other'>Enter a new option</option>\n";
            }
            foreach ($options['options'] as $option => $option_label) {

                if ($option==$value) { //compare against key in options[data]
                    $sel=" selected";
                } else {
                    $sel='';
                }
                $this->formHTML.= "     <option value='". ($option) . "' $sel>" . ($option_label) . "</option>\n";
            }
        }

        if($options['other']==true)
        {
            $this->formHTML.= "     <option value='_other'>Enter your own</option>\n";
        }
        $this->formHTML.="        </select>\n";
        if($options['other']==true)
        {
            $this->formHTML.= "     </div><div class='col-sm-12 col-md-4'>
     <span id='_other_$options[field]_span' style='display:none;'><b>Other: </b><input type='text' class='form_control' name='_other_$options[field]' id='_other_$options[field]' /></span>
     </div>
     </div>\n";
        }
        if($options['show_label']) {
            $this->label_close();
        }
        if(isset($options['remote']) && $options['remote'])
        {
            $this->formScripts[]="\$('#$options[field]').select2({
             ajax: {
                    url: '$options[url]'',
                    method: 'POST',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                    return {
                        q: params.term // search term
                      };
                    },
                    processResults: function (data, page) {
                    // parse the results into the format expected by Select2.
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data
                    //console.log(data);
                    return {
                        results: data.results
                      };
                    },
                    cache: true
                  },
                escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
                minimumInputLength: 3
            });
            ";
        } else {
            $this->formScripts[]="\$('#$options[field]').select2();\n";
        }
        if($options['other']==true)
        {
            $this->formScripts[]="\$('#$options[field]').on('change',function(){
                if(\$('#$options[field]').val()=='_other')
                {
                    \$('#_other_$options[field]_span').show();
                } else {
                    \$('#_other_$options[field]').val('');
                    \$('#_other_$options[field]_span').hide();
                }
                console.log(\$('#$options[field]').val()=='_other');
            })\n";
        }
    }

    function state($options)
    {
        $states=array("AL"=>"Alabama",
            "AK"=>"Alaska",
            "AZ"=>"Arizona",
            "AR"=>"Arkansas",
            "CA"=>"California",
            "CO"=>"Colorado",
            "CT"=>"Connecticut",
            "DE"=>"Deleware",
            "DC"=>"District of Columbia",
            "FL"=>"Florida",
            "GA"=>"Georgia",
            "GU"=>"Guam",
            "HI"=>"Hawaii",
            "ID"=>"Idaho",
            "IL"=>"Illinois",
            "IN"=>"Indiana",
            "IA"=>"Iowa",
            "KS"=>"Kansas",
            "KY"=>"Kentucky",
            "LA"=>"Louisiana",
            "ME"=>"Maine",
            "MD"=>"Maryland",
            "MA"=>"Massachusetts",
            "MI"=>"Michigan",
            "MN"=>"Minnesota",
            "MS"=>"Mississippi",
            "MO"=>"Missoui",
            "MT"=>"Montana",
            "NE"=>"Nebraska",
            "NV"=>"Nevada",
            "NH"=>"New Hampshire",
            "NJ"=>"New Jersey",
            "NM"=>"New Mexico",
            "NY"=>"New York",
            "NC"=>"North Carolina",
            "ND"=>"North Dakota",
            "OH"=>"Ohio",
            "OK"=>"Oklahoma",
            "OR"=>"Oregon",
            "PW"=>"Palau",
            "PA"=>"Pennsylvania",
            "PR"=>"Puerto Rico=",
            "RI"=>"Rhode Island",
            "SC"=>"South Carolina",
            "SD"=>"South Dakota",
            "TN"=>"Tennessee",
            "TX"=>"Texas",
            "UT"=>"Utah",
            "VT"=>"Vermont",
            "VA"=>"Virginia",
            "VI"=>"Virgin Islands",
            "WA"=>"Washington",
            "WV"=>"West Virginia",
            "WI"=>"Wisconsin",
            "WY"=>"Wyoming"
        );
        $options['options']=$states;
        $this->select($options);
    }

    function selectChain($options)
    {
        $defaults = array('show_label'=>true);
        $options = array_merge($defaults,$options);


        $value = stripslashes($this->formData[$options['field']]);
        $value2 = stripslashes($this->formData[$options['field_2']]);
        if($options['show_label']) {
            $this->label_open($options);
        }


        //the first select field
        $this->formHTML.="    <div class='row'>\n        <div class='col-sm-12 col-md-4'>";
        $this->formHTML.="        <select class=\"form-control\" name=\"$options[field]\" id=\"$options[field]\">\n";
        // print out the <option> tags
        if(count($options['options'])>0)
        {
            $this->formHTML.= "     <option value=''>Please select</option>\n";
            foreach ($options['options'] as $option => $option_label) {

                if ($option==$value) { //compare against key in options[data]
                    $sel=" selected";
                } else {
                    $sel='';
                }
                $this->formHTML.= "     <option value='". ($option) . "' $sel>" . ($option_label) . "</option>\n";
            }
        }
        $this->formHTML.="        </select>\n";
        $this->formHTML.="        </div>\n      <div class='col-sm-12 col-md-4'>\n";

        $this->formHTML.="        <select class=\"form-control\" name=\"$options[field_2]\" id=\"$options[field_2]\">\n";
        // print out the <option> tags
        $bootstrap='';

        if(count($options['options_2'])>0)
        {
            $bootstrap = " bootstrap : {\n";
            $sel="'selected':";
            $this->formHTML.= "     <option value='none'>Please select</option>\n";
            foreach ($options['options_2'] as $option => $option_label) {

                if ($option==$value2) { //compare against key in options[data]
                    $sel.="'$value2'";
                }
                $bootstrap.="'$option':'$option_label',";
                $this->formHTML.= "     <option value='". ($option) . "' $sel>" . ($option_label) . "</option>\n";
            }
            $bootstrap.="\n}\n";
        }
        $this->formHTML.="        </select>\n";
        if($options['other']==true)
        {
            $this->formHTML.= "     </div><div class='col-sm-12 col-md-4'>
     <span id='_other_$options[field_2]_span' style='display:none;'><b>Other: </b><input type='text' class='form_control' name='_other_$options[field_2]' id='_other_$options[field_2]' /></span>
     </div>
     </div>\n";
        }
        if($options['show_label']) {
            $this->label_close();
        }
        $this->formScripts[]="\$('#$options[field_2]').remoteChained({
        parents : '#$options[field]',
        url : '$options[remote]',
        $bootstrap
    });\n";
        $this->formScripts[]="\$('#$options[field]').select2();\n";
        $this->formScripts[]="\$('#$options[field_2]').select2();\n";
        if($options['other']==true)
        {
            $this->formScripts[]="\$('#$options[field_2]').on('change',function(){
                if(\$('#$options[field_2]').val()=='_other')
                {
                    \$('#_other_$options[field_2]_span').show();
                } else {
                    \$('#_other_$options[field_2]').val('');
                    \$('#_other_$options[field_2]_span').hide();
                }
            })\n";
        }
    }

    function dualSelect($options)
    {
        $defaults = array('show_label'=>true, 'nonSelectedLabel'=>'Non-selected','selectedLabel'=>'Selected');
        $options = array_merge($defaults,$options);

        $values = $options['values'];
        if($options['show_label']) {
            $this->label_open($options);
        }
        $nonSelectedLabel=$options['nonSelectedLabel'];
        $selectedLabel=$options['selectedLabel'];
        $validation = '';
        if(isset($options['validation'])){$validation = $this->validation(array('type'=>'select', 'options' => $options['validation']));}
        //the actual text field

        $this->formHTML.="    <select class=\"form-control\" name=\"$options[field][]\" id=\"$options[field]\" multiple $validation>\n";
        // print out the <option> tags
        if(count($options['options'])>0)
        {
            foreach ($options['options'] as $option => $option_label) {
                if (in_array($option,$values)) { //compare against key in options[data]
                    $sel=" selected";
                } else {
                    $sel='';
                }
                $this->formHTML.= "     <option value='". ($option) . "'$sel>" . ($option_label) . "</option>\n";
            }

        }
        $this->formHTML.="        </select>\n";

        if($options['show_label']) {
            $this->label_close();
        }
        if($options['showFilter']){$showFilter="showFilterInputs: true,";}else{$showFilter="showFilterInputs: false,";}
        $this->formScripts[]="\$('#$options[field]').bootstrapDualListbox({
  nonSelectedListLabel: '$nonSelectedLabel',
  selectedListLabel: '$selectedLabel',
  preserveSelectionOnMove: 'moved',
  $showFilter
  moveOnSelect: true
});;\n";
    }

    function checkList($options)
    {
        //@TODO needs to be completed!

        $defaults = array('show_label'=>true,'columns'=>3);
        $options = array_merge($defaults,$options);

        $mdColWidth = ceil(12/$options['columns']); //this will be how many columns wide to made each check

        $values = $options['values'];
        $nonSelectedLabel=$options['nonSelectedLabel'];
        $selectedLabel=$options['selectedLabel'];
        $validation = '';
        if(isset($options['validation'])){$validation = $this->validation(array('type'=>'select', 'options' => $options['validation']));}

        if($options['show_label']) {
            $this->label_open($options);
        }
        //the actual checkbox fields
        $this->formHTML.="<div class='row'>\n";
        foreach($options['options'] as $checkID=>$checkDisplay)
        {
            if(in_array($checkID,$values)){$checked = 'checked';}else{$checked='';}
            $this->formHTML.="<div class='col-sm-$mdColWidth'>\n";
            $this->formHTML.="   <div class=\"checkbox\">
    <label>
      <input name='".$options['field']."[]' value='$checkID' type=\"checkbox\" $checked> $checkDisplay
    </label>
  </div>";
            $this->formHTML.="</div>\n";
        }
        if($options['other']==true) {
            $this->formHTML.="<div class='col-sm-$mdColWidth'>\n";
            $this->formHTML.="<div class=\"checkbox\">
    <label>
      <input id='_other_$options[field]' type=\"checkbox\"> Other (please specify)
    </label>
  </div>";
            $this->formHTML.="</div>\n";
        }

        $this->formHTML.="</div>\n";

        if($options['other']==true)
        {
            $this->formHTML.= "     <div class='row'>
         <div class='col-sm-12'>
        <span id='_other_$options[field]_span' style='display:none;'><b>Other: </b>
            <input type='text' class='form_control' name='_othercheck_$options[field]' id='_othercheck_$options[field]' />
        </span>
        </div>
   </div>\n";
        }

        if($options['show_label']) {
            $this->label_close();
        }
        if($options['other']==true)
        {
            $this->formScripts[]="\$('#_other_$options[field]').on('change',function(){
                if(\$('#_other_$options[field]').prop('checked'))
                {
                    \$('#_other_$options[field]_span').show();
                } else {
                    \$('#_other_$options[field]').val('');
                    \$('#_other_$options[field]_span').hide();
                }
            })\n";
        }

    }

    function radioList($options)
    {
        $defaults = array('show_label'=>true);
        $options = array_merge($defaults,$options);

        //@TODO needs to be completed!
        $options=array_merge(array('columns'=>3,$options));
        if($options['show_label']) {
        }
        if($options['other']==true)
        {
            $this->formHTML.= "     <br><input type='text' class='form_control' name='_other_$options[field]' id='_other_$options[field]' />\n";
        }

    }

    function file($options)
    {
        $defaults = array('show_label'=>true, 'preview'=>true,'createDirectory'=>true);
        $options = array_merge($defaults,$options);

        $placeholder = htmlentities(isset($options['placeholder'])? $options['placeholder'] : $this->formData[$options['field']]);
        $value = stripslashes($this->formData[$options['field']]);
        if($options['show_label']) {
            $this->label_open($options);
        }
        $validation = '';
        if(isset($options['validation'])){$validation = $this->validation(array('type'=>'file', 'options' => $options['validation']));}
        //the actual field

        if($options['createDirectory'])
        {
            if(!file_exists($options['uploadDirectory']))
            {
                mkdir($options['uploadDirectory']);
            }
        }
        if($options['preview'])
        {
            $value = htmlentities($this->formData[$options['field']]);
            if($value=='')
            {
                $src = '';
            } else {
                $img = $options['uploadDirectory']."/".$value;
                $img = str_replace("//","/",$img);
                $src = "<img src='$img' class='img-bordered' width=200 />";
            }

            $this->formHTML.="                <div class='row'><div class='col-md-4 col-sm-12'>$src</div><div class='col-md-8 col-sm-12'>";
            $this->formHTML.="                <input type=\"file'\" class=\"form-control\" id=\"$options[field]\" name=\"$options[field]\" $validation>\n";
            $this->formHTML.="                </div></div>";
        } else {
            $this->formHTML.="                <input type=\"file'\" class=\"form-control\" id=\"$options[field]\" name=\"$options[field]\" $validation>\n";
        }

        if($options['show_label']) {
            $this->label_close();
        }
    }

    public function dropzone($options)
    {
        //@TODO needs to be completed!
        $defaults = array('show_label'=>true);
        $options = array_merge($defaults,$options);

        $uploadHandler='';$deleteHandler='';$uploadDirectory='';$subDir='';$successUploadFunction='';$successDeleteFunction='';
        print "<form action='$uploadHandler' class='dropzone' id='dropzoneWidget'>
        <input type='hidden' id='uploadDirectory' name='uploadDirectory' value='$uploadDirectory' />
        <input type='hidden' id='subDir' name='subDir' value='$subDir' />
        </form>";

        $GLOBALS['page_scripts'][]=array('origin'=>'ad dropzone','script'=>"/js/dropzone/dropzone.min.js");
        $GLOBALS['inline_scripts'][]=array('origin'=>'ad dropzone initialzer','script'=>"
            Dropzone.options.dropzoneWidget = {
              paramName: 'file', // The name that will be used to transfer the file
              maxFilesize: 50, // MB
              addRemoveLinks : true,
              init: function() {
                this.on('addedfile', function(file) { ".$successUploadFunction."(file); });
                this.on('removedfile', function(file) {
                    \$.ajax({
                        url: '$deleteHandler',
                        type: 'POST',
                        data: ({uploadDirectory:'$uploadDirectory',subDir:'$subDir',filename:file.name}),
                        dataType: 'json',
                        success: function(response){
                            ".$successDeleteFunction."(response);
                        }
                    });
                });
              }
            }");
    }

    function slider($options)
    {
        $defaults = array('show_label'=>true, 'min'=>1,'max'=>100,'step'=>1,'orientation'=>'horizontal','range'=>false,'value2'=>'');
        $options = array_merge($defaults,$options);

        $field = $options['field'];

        $placeholder = htmlentities(isset($options['placeholder'])? $options['placeholder'] : $this->formData[$field]);

        $value = stripslashes($this->formData[$field]);
        if($options['range']==true && $options['value2']!='')
        {
            $value2=stripslashes($options['value2']);
            $value = "[$value,$value2]";
        }
        if($options['show_label']) {
            $this->label_open($options);
        }
        //the actual text field
        $this->formHTML.="          <input id=\"$field\" name=\"$field\" type=\"text\" value=\"\"
                       data-slider-id='$field'
                       data-slider-orientation='$options[orientation]'
                       data-slider-min=\"$options[min]\"
                       data-slider-max=\"$options[max]\"
                       data-slider-step=\"$options[step]\"
                       data-slider-value=\"$value\"/>\n";
        if($options['show_label']) {
            $this->label_close();
        }
        $this->formScripts[]="\$('#$field').slider({});\n";

    }

    function yesNo($options)
    {
        $defaults = array('show_label'=>true, 'options'=>array(
            array('label'=>'Label 1','value'=>'Value 1','default'=>true,'class'=>'primary'),
            array('label'=>'Label 2','value'=>'Value 2','default'=>false,'class'=>'default')
        ));
        $options = array_merge($defaults,$options);

        $field = $options['field'];
        $value = htmlentities($this->formData[$field]);

        $opt = $options['options'];

        if($options['show_label']) {
            $this->label_open($options);
        }
        if($value!='')
        {
            if($opt[0]['value']==$value)
            {
                $check1 = 'checked';
                $active1 = 'active';
                $check2 = '';
                $active2 = '';

            }
            if($opt[0]['value']==$value)
            {
                $check1 = '';
                $active1 = '';
                $check2 = 'checked';
                $active2 = 'active';
            }
        } else {
            if($opt[0]['default']==true)
            {
                $check1 = 'checked';
                $active1 = 'active';
                $check2 = '';
                $active2 = '';
            } else {
                $check1 = '';
                $active1 = '';
                $check2 = 'checked';
                $active2 = 'active';
            }
        }

        //the actual text field
        $this->formHTML.="
                <div class=\"btn-group btn-toggle\" data-toggle=\"buttons\">
                    <label class=\"btn btn-".$opt[0]['class']." $active1\">
                        <input type=\"radio\" id=\"".$field."_0\" name=\"$field\" value=\"".$opt[0]['value']." $check1 \">". $opt[0]['label'] . "
                    </label>
                    <label class=\"btn btn-".$opt[1]['class']."\" $active2>
                        <input type=\"radio\" id=\"".$field."_1\" name=\"$field\" value=\"".$opt[1]['value']." $check2 \">". $opt[1]['label'] . "
                    </label>
                </div>
        \n";
        if($options['show_label']) {
           $this->label_close();
        }
    }

    function color($options)
    {
        $defaults = array('show_label'=>true, 'default'=>'#ffffff');
        $options = array_merge($defaults,$options);

        $field = $options['field'];
        $placeholder = htmlentities(isset($options['placeholder'])? $options['placeholder'] : $this->formData[$field]);

        $value = htmlentities($this->formData[$field]);
        if($options['show_label']) {
            $this->label_open($options);
        }
        //the actual text field
        $this->formHTML.="                 <div class='row'><div class='col-sm-12 col-md-4'><div class=\"input-group colorpicker\">
                     <input type=\"text'\" class=\"form-control\" id=\"$field\" name=\"$field\" placeholder=\"$placeholder\" value=\"$value\" >
                     <span class=\"input-group-addon\"><i></i></span>
                 </div></div></div>\n";
        if($options['show_label']) {
            $this->label_close();
        }
    }

    private function generateID()
    {

        $randstr = "";
        for($i=0; $i<8; $i++){
            $randnum = mt_rand(0,61);
            if($randnum < 10){
                $randstr .= chr($randnum+48);
            }else if($randnum < 36){
                $randstr .= chr($randnum+55);
            }else{
                $randstr .= chr($randnum+61);
            }
        }

        return $randstr;
    }

    private function formatPhone($phone,$dir='display',$defaultAreaCode='000')
    {
        $phone=str_replace("(","",$phone);
        $phone=str_replace(")","",$phone);
        $phone=str_replace(" ","",$phone);
        $phone=str_replace(".","",$phone);
        $phone=str_replace("-","",$phone);
        if($dir=='display')
        {
            if(strlen($phone)<10)
            {
                //no area code
                $phone=$defaultAreaCode.substr($phone,0,3)."-".substr($phone,3);
            } else {
                $phone="(".substr($phone,0,3).") ".substr($phone,3,3)."-".substr($phone,6,4)." x".substr($phone,10);
            }
        }
        return $phone;
    }

    public function arrayToOptions($array,$field='',$id='id')
    {
        //this function takes any generic array of data and extracts them as a simple array of id and value for a select element
        $new_array = [];
        if($field=='')
        {
            return $array;
        } else {
            foreach ($array as $element) {
                $new_array[$element[$id]] = $element[$field];
            }
        }
        return $new_array;
    }
}