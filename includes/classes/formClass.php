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
            'description' => ''
        );
        if(isset($formOptions['data']) && count($formOptions['data'])>0) {
            $this->formRecord = $formOptions['data'][0];
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
        $this->csrf_token = $session->csrf_token;

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
        if(strpos($this->formOptions['action'],"/")>0)
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
    }

    public function generate()
    {
        if(!$this->closed){$this->close();}

        echo $this->formHTML;


    }
    public function openTab($tabName)
    {
        $this->openTab = $tabName;
        $tab = strtolower(str_replace(" ","_",$tabName));

        if($this->tabsHTML == '')
        {
            $this->tabsHTML = "<li role=\"presentation\" class=\"active\"><a href=\"#$tab\" aria-controls=\"$tab\" role=\"tab\" data-toggle=\"tab\">$tabName</a></li>\n";
            $this->formHTML.="<div role=\"tabpanel\" class=\"tab-pane active container\" id=\"$tab\">\n";
        } else {
            $this->tabsHTML.= "<li role=\"presentation\"><a href=\"#$tab\" aria-controls=\"$tab\" role=\"tab\" data-toggle=\"tab\">$tabName</a></li>\n";
            $this->formHTML.="<div role=\"tabpanel\" class=\"tab-pane container\" id=\"$tab\">\n";
        }

    }

    public function closeTab()
    {
        $this->formHTML.="</div> <!-- closing tab for $this->openTab -->\n";
        $this->openTab = '';
    }

    public function openFieldSet($legend)
    {
        $this->formHTML.="<fieldset>\n";
        $this->formHTML.="<legend>$legend</legend>\n";
        $this->openLegend = $legend;
    }

    public function closeFieldSet()
    {
        $this->formHTML.="</fieldset>  <!-- closing fieldset for $this->openLegend -->\n";
        $this->openLegend = '';
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
        $defaults = array('label'=>'Save','name'=>'submitButton','class'=>'default','disabled'=>'');
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
        $field = $options['field'];
        $placeholder = htmlentities(isset($options['placeholder'])? $options['placeholder'] : $this->formData[$field]);
        $value = htmlentities($this->formData[$field]);
        $this->label_open($options);
        $validation = '';
        if(isset($options['validation'])){$validation = $this->validation(array('type'=>'email', 'options' => $options['validation']));}
        //the actual text field
        $this->formHTML.="                <input type=\"text'\" class=\"form-control\" id=\"$field\" name=\"$field\" placeholder=\"$placeholder\" value=\"$value\" $validation>\n";

        $this->label_close();
    }

    function textarea($options)
    {
        $defaults = array('width'=>'100%','height'=>'10', 'editor'=>true);
        $options = array_merge($defaults,$options);

        $placeholder = htmlentities(isset($options['placeholder'])? $options['placeholder'] : $this->formData[$options['field']]);
        $value = htmlentities($this->formData[$options['field']]);
        $this->label_open($options);
        $validation = '';
        if(isset($options['validation'])){$validation = $this->validation(array('type'=>'textarea', 'options' => $options['validation']));}
        //the actual text field
        $this->formHTML.="                <textarea class=\"form-control\" id=\"$options[field]\" name=\"$options[field]\"  $validation>$value</textarea>\n";

        $this->label_close();

        //see if it needs to be a summernote instance
        if($options['editor'])
        {
            $this->formScripts[] = "\$('#$options[field]').summernote({
  toolbar: [
    ['style', ['bold', 'italic', 'underline', 'clear']],
    ['font', ['strikethrough', 'superscript', 'subscript']],
    ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['height', ['height']],
  ]
});\n";
        }
    }

    function email($options)
    {
        $placeholder = htmlentities(isset($options['placeholder'])? $options['placeholder'] : $this->formData[$options['field']]);
        $value = htmlentities($this->formData[$options['field']]);
        $this->label_open($options);
        $validation = '';
        if(isset($options['validation'])){$validation = $this->validation(array('type'=>'email', 'options' => $options['validation']));}

        //the actual text field
        $this->formHTML.="                <input type=\"email\" class=\"form-control\" id=\"$options[field]\" name=\"$options[field]\" placeholder=\"$placeholder\" value=\"$value\" $validation>\n";

        $this->label_close();
    }

    function phone($options)
    {
        $placeholder = htmlentities(isset($options['placeholder'])? $options['placeholder'] : $this->formData[$options['field']]);
        $value = $this->formatPhone($this->formData[$options['field']],'display');
        $this->label_open($options);
        $validation = '';
        if(isset($options['validation'])){$validation = $this->validation(array('type'=>'email', 'options' => $options['validation']));}

        //the actual text field
        $this->formHTML.="                <input type=\"tel\" class=\"form-control\" id=\"$options[field]\" name=\"$options[field]\" placeholder=\"$placeholder\" value=\"$value\" $validation>\n";

        $this->label_close();
        $this->formScripts[]="\$(\"#$options[field]\").mask(\"(999) 999-9999? x99999\");\n";
    }

    function password($options)
    {
        $options = array_merge(array('confirm' => true), $options);
        $placeholder = htmlentities(isset($options['placeholder']) ? $options['placeholder'] : $this->formData[$options['field']]);
        $value = htmlentities($this->formData[$options['field']]);
        $this->label_open($options);
        $validation = '';
        if (isset($options['validation'])) {
            $validation = $this->validation(array('type' => 'password', 'options' => $options['validation']));
        }

        //the actual text field
        $this->formHTML .= "        <div class='col-sm-6'><input type=\"text\" class=\"form-control\" id=\"$options[field]\" name=\"$options[field]\"  $validation></div>\n";
        if ($options['confirm']) {
            $this->formHTML .= "<div class='col-sm-6'><input type=\"text\" class=\"form-control col-sm-6\" id=\"$options[field]_confirm\" name=\"$options[field]_confirm\" placeholder=\"Confirm\" value=\"\" data-match=\"$options[field]\" data-match-error='Passwords do not match'></div>\n";
        }

        $this->label_close();
    }

    function number($options)
    {
        $placeholder = htmlentities(isset($options['placeholder'])? $options['placeholder'] : $this->formData[$options['field']]);
        $value = htmlentities($this->formData[$options['field']]);
        $this->label_open($options);
        $validation = '';
        if(isset($options['validation'])){$validation = $this->validation(array('type'=>'email', 'options' => $options['validation']));}

        //the actual text field
        $this->formHTML.="                <input type=\"number\" class=\"form-control\" id=\"$options[field]\" name=\"$options[field]\" placeholder=\"$placeholder\" value=\"$value\" $validation>\n";

        $this->label_close();
    }


    function date($options)
    {
        $placeholder = htmlentities(isset($options['placeholder'])? $options['placeholder'] : $this->formData[$options['field']]);
        if($this->formData[$options['field']]!='')
        {
            $value=date("m/d/Y",strtotime($this->formData[$options['field']]));
        } else {
            $value=date("m/d/Y",time());
        }

        $this->label_open($options);
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
        $this->label_close();
    }

    function time($options)
    {
        $placeholder = htmlentities(isset($options['placeholder'])? $options['placeholder'] : $this->formData[$options['field']]);
        if($this->formData[$options['field']]!='')
        {
            $value=date("H:i",strtotime($this->formData[$options['field']]));
        } else {
            $value=date("H:i",time());
        }

        $this->label_open($options);
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
        $this->label_close();
    }

    function datetime($options)
    {
        $placeholder = htmlentities(isset($options['placeholder'])? $options['placeholder'] : $this->formData[$options['field']]);
        if($this->formData[$options['field']]!='')
        {
            $value=date("m/d/Y H:i",strtotime($this->formData[$options['field']]));
        } else {
            $value=date("m/d/Y H:i",time());
        }

        $this->label_open($options);
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
        $this->label_close();
    }


    function checkbox($options)
    {
        $value = htmlentities($this->formData[$options['field']]);

        if(isset($options['description']))
        {
            $description = $options['description'];
            unset($options['description']);
        }
        $this->label_open($options);
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

        $this->label_close();
    }

    function label($options)
    {
        $this->label_open($options);
        $this->label_close();
    }

    function hidden($options)
    {
        print "<input type='hidden' id='$options[id]' name='$options[id]' value='".htmlentities($options[value])."' />\n";
    }

    function select($options)
    {
        $value = htmlentities($this->formData[$options['field']]);
        $this->label_open($options);
        $validation = '';
        if(isset($options['validation'])){$validation = $this->validation(array('type'=>'select', 'options' => $options['validation']));}
        //the actual text field

        $this->formHTML.="    <select class=\"form-control\" name=\"$options[field]\" id=\"$options[field]\" $validation>\n";
        // print out the <option> tags
        if(count($options['options'])>0)
        {
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
        $this->label_close();
        if(isset($options['remote']) && $options['remote'])
        {
            //@TODO handle remote data sources
        } else {
            $this->formScripts[]="\$('#$options[field]').select2();\n";
        }
    }

    function selectChain($options)
    {

    }

    function dualSelect($options)
    {
        $values = $options['values'];
        $this->label_open($options);
        if(isset($options['nonSelectedLabel'])){$nonSelectedLabel=$options['nonSelectedLabel'];}else{$nonSelectedLabel='Non-selected';}
        if(isset($options['selectedLabel'])){$selectedLabel=$options['selectedLabel'];}else{$selectedLabel='Selected';}
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
        $this->label_close();
        if($options['showFilter']){$showFilter="showFilterInputs: true,";}else{$showFilter="showFilterInputs: false,";}
        $this->formScripts[]="\$('#$options[field]').bootstrapDualListbox({
  nonSelectedListLabel: '$nonSelectedLabel',
  selectedListLabel: '$selectedLabel',
  preserveSelectionOnMove: 'moved',
  $showFilter
  moveOnSelect: true
});;\n";
    }

    function remoteSelect($options)
    {
        $options['remote'] = true;
        $this->select($options);

       $this->formScripts[]=<<<REMOTESELECT
        $("#$options[field]").select2({
            ajax: {
                url: "$options[url]",
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
                    console.log(data);
                  return {
                    results: data.results
                  };
                },
                cache: true
              },
              escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
              minimumInputLength: 3
            });
REMOTESELECT;

    }

    function checkList($options)
    {

    }

    function radioList($options)
    {

    }

    function file($options)
    {

    }

    public function dropFile($options)
    {
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

    function form_slider($id,$label,$value,$explaintext='',$min=0,$max=100, $step=1)
    {
        ?>
        <div class="form-group">
            <label for="<?php echo $id ?>" class="col-sm-2 control-label"><?php echo $label ?></label>
            <div class="col-sm-10">
                <?php if($explaintext!=''){print "<small>$explaintext</small><br />";} ?>
                <input id="<?php echo $id ?>" name="<?php echo $id ?>" data-slider-id='<?php echo $id ?>' type="text" data-slider-min="<?php echo $min ?>" data-slider-max="<?php echo $max ?>" data-slider-step="<?php echo $step ?>" data-slider-value="<?php echo $value ?>"/>

            </div>
        </div>

        <?php
        $GLOBALS['inline_scripts'][]=array('origin'=>'Initiating a datetime picker with date only',
            'script'=>"\$('#$id').bootstrapSlider({});");
    }

    function yesNoSwitch($options)
    {
        ?>
        <span class="onoffswitch">
            <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" checked="checked" id="myonoffswitch">
            <label class="onoffswitch-label" for="myonoffswitch"> <span class="onoffswitch-inner" data-swchon-text="YES" data-swchoff-text="NO"></span> <span class="onoffswitch-switch"></span>
            </label>
        </span>
        <?php
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

    private function formatPhone($phone,$dir='display')
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
                $phone="000".substr($phone,0,3)."-".substr($phone,3);
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