<?php

class Table {

    public $data = [];
    public $tableScripts = [];

    private $headers = []; //expects an array of array('field'=>$field,'header'=>$header)
    private $dataSource = 'local'; // local or remote are the options
    private $tableID = '';
    private $search = []; //expects an array of arrays ('field','label','options');
    private $options;
    private $errors = [];
    private $searchHTML = '';
    private $tableHTML = '';
    private $recordActions = [];
    private $formActions = [];
    private $base = '';

    public function __construct($tableID='')
    {
        if($tableID!='')
        {
            $this->tableID=$tableID;
        } else {
            $this->tableID='table_'.$this->generateID();
        }
        $this->base = $_SERVER['PHP_SELF'];

        $this->options = array(
            "lengthMenu"=>"[[10, 25, 50, -1], [10, 25, 50, 'All']]",
            "searching"=>"true",
            "lengthChange"=>"true",
            "paginate"=>"true",
            "pageLength"=>25,
            "stateSave"=>"true",
            'autoWidth' => "true"
        );

        $this->recordActions = array(
           array('action'=>'edit', 'label'=>'Edit','confirm' => 'false', 'url'=>$this->base),
           array('action'=>'delete', 'label'=>'Delete','confirm' => 'true', 'confirmTitle'=>"Really delete?", 'confirmMessage'=>"Are you wanna wanna?", 'url'=>$this->base)
        );

        $this->formActions = array(
           array('action'=>'new', 'label'=>$this->newButton,'confirm' => 'false', 'url' => $this->base)
        );

    }

    public function setNewButton($label,$url='')
    {
        //go through form actions to find the 'new' one and update the label
        foreach($this->formActions as &$action)
        {
            if($action['action']=='new')
            {
                $action['label'] = $label;
                if($url != ''){ $action['url'] = $url;}
            }
        }
    }

    public function setOptions($options)
    {
        $this->options = array_merge($this->options,$options);
    }

    public function setFormActions($actions)
    {
        $this->formActions = array_merge($this->formActions,$actions);
    }

    public function setRecordActions($actions)
    {
        $this->recordActions = array_merge($this->recordActions,$actions);
    }

    public function setRecordActionBase($base)
    {
        if(strpos($base,"pages")>0)
        {

        } else {
            if(substr($base,0,1)=='/')
            {
                $base="/pages".$base;
            } else {
                $base="/pages/".$base;
            }
        }
        foreach($this->recordActions as &$action)
        {
            $action['url']=$base;
        }
    }

    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    public function setSearch($searchFields)
    {
        $this->search = $searchFields;
        $this->renderSearch();
    }

    public function renderSearch()
    {
        $this->searchHTML="<div class='row'><div id=\"search$this->tableID\" class='col-xs-12' style=\"display:none;\"><form method='post' action='$this->base' class='form-inline'>";
        foreach($this->search as $element)
        {
            $this->searchHTML.="<div class=\"form-group\">";
            $this->searchHTML.="<label for=\"$element[field]\">$element[label]</label>\n";

            if(isset($_POST[$element[field]]))
            {
                $value=$_POST[$element['field']];
            } else {
                $value=$element['value'];
            }

            switch ($element['type'])
            {
                case "text":
                   $this->searchHTML.="<input type=\"text\" class=\"form-control\" id=\"$element[field]\" name=\"$element[field]\" value=\"$value\">";
                break;


                case "number":
                    $this->searchHTML.="<input type=\"number\" class=\"form-control\" id=\"$element[field]\" name=\"$element[field]\" value=\"$value\">";
                break;

                case "select":
                    $this->searchHTML.="<select class=\"form-control\" id=\"$element[field]\" name=\"$element[field]\" >";
                    $optionField=$element['option_field'];
                    foreach($element['options'] as $option)
                    {
                        $this->searchHTML.="<option value='$option[id]'".($option['id']==$value ? ' selected' : '').">$option[$optionField]</option>\n";
                    }
                    $this->searchHTML.="</select>";
                    $this->tableScripts[]="\$('#$element[field]').select2();\n";
                break;

                case "date":
                    if($value=='')
                    {
                        $value=date("Y-m-d");
                    }
                    $this->searchHTML.="<input type=\"text\" class=\"form-control\" id=\"$element[field]\" name=\"$element[field]\" placeholder=\"\" value=\"$value\">";
                    $this->tableScripts[] = <<<DATEDATA
$('#$element[field]').datetimepicker({
    format: "MM/DD/YYYY",
    useCurrent: true,
    showTodayButton: true,
    icons: {
        time: "fa fa-clock-o",
     }
});\n
DATEDATA;
                break;

                case "check":
                break;
            }
            $this->searchHTML.="</div>\n";
        }
      $this->searchHTML.="
<input type='submit' class='btn btn-primary' value='Search' />
</form></div></div>\n";
    }

    public function setData($data)
    {
        if(is_array($data))
        {
            $this->data = $data;
            $this->dataSource = 'local';
        } else {
            //means we passed in a string, so we're assuming a url has been passed
            $this->data = $data;
            $this->dataSource = 'remote';
        }
    }

    public function generate()
    {
        if($this->dataSource=='remote') {
            $this->tableScripts[] = <<<INIT
$.fn.dataTable.pipeline = function ( opts ) {
    // Configuration options
    var conf = $.extend( {
        pages: 5,     // number of pages to cache
        url: '',      // script url
        data: null,   // function or object with parameters to send to the server
                      // matching how `ajax.data` works in DataTables
        method: 'GET' // Ajax HTTP method
    }, opts );

    // Private variables for storing the cache
    var cacheLower = -1;
    var cacheUpper = null;
    var cacheLastRequest = null;
    var cacheLastJson = null;

    return function ( request, drawCallback, settings ) {
        var ajax          = false;
        var requestStart  = request.start;
        var drawStart     = request.start;
        var requestLength = request.length;
        var requestEnd    = requestStart + requestLength;

        if ( settings.clearCache ) {
            // API requested that the cache be cleared
            ajax = true;
            settings.clearCache = false;
        }
        else if ( cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper ) {
            // outside cached data - need to make a request
            ajax = true;
        }
        else if ( JSON.stringify( request.order )   !== JSON.stringify( cacheLastRequest.order ) ||
                  JSON.stringify( request.columns ) !== JSON.stringify( cacheLastRequest.columns ) ||
                  JSON.stringify( request.search )  !== JSON.stringify( cacheLastRequest.search )
        ) {
            // properties changed (ordering, columns, searching)
            ajax = true;
        }

        // Store the request for checking next time around
        cacheLastRequest = $.extend( true, {}, request );

        if ( ajax ) {
            // Need data from the server
            if ( requestStart < cacheLower ) {
                requestStart = requestStart - (requestLength*(conf.pages-1));

                if ( requestStart < 0 ) {
                    requestStart = 0;
                }
            }

            cacheLower = requestStart;
            cacheUpper = requestStart + (requestLength * conf.pages);

            request.start = requestStart;
            request.length = requestLength*conf.pages;

            // Provide the same `data` options as DataTables.
            if ( $.isFunction ( conf.data ) ) {
                // As a function it is executed with the data object as an arg
                // for manipulation. If an object is returned, it is used as the
                // data object to submit
                var d = conf.data( request );
                if ( d ) {
                    $.extend( request, d );
                }
            }
            else if ( $.isPlainObject( conf.data ) ) {
                // As an object, the data given extends the default
                $.extend( request, conf.data );
            }

            settings.jqXHR = $.ajax( {
                "type":     conf.method,
                "url":      conf.url,
                "data":     request,
                "dataType": "json",
                "cache":    false,
                "success":  function ( json ) {
                    cacheLastJson = $.extend(true, {}, json);

                    if ( cacheLower != drawStart ) {
                        json.data.splice( 0, drawStart-cacheLower );
                    }
                    json.data.splice( requestLength, json.data.length );

                    drawCallback( json );
                }
            } );
        }
        else {
            json = $.extend( true, {}, cacheLastJson );
            json.draw = request.draw; // Update the echo for each response
            json.data.splice( 0, requestStart-cacheLower );
            json.data.splice( requestLength, json.data.length );

            drawCallback(json);
        }
    }
};

// Register an API method that will empty the pipelined data, forcing an Ajax
// fetch on the next draw (i.e. `table.clearPipeline().draw()`)
$.fn.dataTable.Api.register( 'clearPipeline()', function () {
    return this.iterator( 'table', function ( settings ) {
        settings.clearCache = true;
    } );
} );


//
// DataTables initialisation
//



INIT;
            $this->options = array_merge($this->options, array('processing' => true));
            $this->options = array_merge($this->options, array('serverSide' => true));
            $this->options = array_merge($this->options, array('ajax' => "\$.fn.dataTable.pipeline( {url: '$this->data', pages: 5)}"));

        }
        $options='';
        foreach($this->options as $param=>$value) {
            if($param=='lengthMenu')
            {
                $options .= "\"$param\" : $value,\n";
            } else {
                $options .= "\"$param\" : \"$value\",\n";
            }

        }
        $options=rtrim($options,",\n");
//now set basic initialization
$this->tableScripts[] = <<<INIT
\$('#$this->tableID').DataTable( {
    $options
})
INIT;

        $this->open();
        $this->tableData();
        $this->close();
    }

    function open()
    {

        $this->tableHTML.="<div id='tableoptions_$this->tableID' class='col-xs-12' style='margin-bottom:10px;'>\n";
        $this->tableHTML.="<div class='row'>";

        $this->generateTableActions();

        if ($this->searchHTML!=''){
            $this->tableHTML.="<button class='pull-right btn btn-primary' onClick=\"\$('#search$this->tableID').toggle();\"><strong>Show Search Options</strong></button></div>\n";
            $this->tableHTML.=$this->searchHTML;
        } else {
            $this->tableHTML.="</div>\n";
        }

            //if only one option, then show single button, otherwise dropdown

        $this->tableHTML.="
        </div>
        <table id='$this->tableID' class='table table-striped table-bordered table-hover' width='100%'>
        <thead>
        <tr>
";

        //get headers, either in the $headers array, or from the first record in the data source
        if(isset($this->headers) && count($this->headers) > 0)
        {
            $headers = $this->headers;
        } else if (isset($this->data) && is_array($this->data) && count($this->data) > 0)
        {
            $tableHeaders = array_keys($this->data[0]);
            foreach($tableHeaders as $header)
            {
                $headers[$header]=$this->field2Label($header);
            }
            $this->headers=$headers;

        } else {
            $this->setError('No headers have been set');
        }

        foreach($headers as $key=>$header)
        {
            $this->tableHTML.= "
                <th>$header</th>";
        }

       $this->tableHTML.='
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
';
    }

    function close()
    {
        $this->tableHTML.='</tbody>
    </table>
    ';
        $this->output();
    }

    private function generateTableActions()
    {
        if(count($this->formActions)==1)
        {
            $formoptions=$this->formActions[0];
            if(isset($_GET['id'])){$pid="&amp;pid=".intval($_GET['id']);}else{$pid='';}
            if(strpos($formoptions['url'],"pages")===0)
            {
                $formoptions['url']="/pages/".$formoptions['url'];
            }
            $this->tableHTML.="<a class=\"btn btn-primary pull-left\" href=\"$formoptions[url]?action=$formoptions[action]".$pid."\" data-confirm=\"$formoptions[confirm]\" ".($formoptions['confirmTitle']!=''? " data-confirm_title=\"$formoptions[confirmTitle]\"" : '').($formoptions['confirmMessage']!=''? " data-confirm_message=\"$formoptions[confirmMessage]\"" : '').">$formoptions[label]</a>\n";
        } else {
            if(isset($_GET['id'])){$pid="pid=".intval($_GET['id'])."&amp;";}else{$pid='';}
            $this->tableHTML .= "<div class='btn-group pull-left'>
                <button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown'>
                    Actions <span class='caret'></span>
                </button>
                <ul class='dropdown-menu' role='menu'>";
            if (count($this->formActions) > 0){

                foreach ($this->formActions as $formoptions) {
                    if(strpos($formoptions['url'],"pages")>0)
                    {} else
                    {
                        $formoptions['url']="/pages/".$formoptions['url'];
                    }
                    $this->tableHTML .= " <li><a href=\"$formoptions[url]?action=$formoptions[action]$pid\" data-confirm=\"$formoptions[confirm]\" ".($formoptions['confirmTitle']!=''? " data-confirm_title=\"$formoptions[confirmTitle]\"" : '').($formoptions['confirmMessage']!=''? " data-confirm_message=\"$formoptions[confirmMessage]\"" : '').">$formoptions[label]</a></li>\n";
                };
            } else {
                $this->setError("No form actions have been set");
            }
            $this->tableHTML.="</ul>
            </div>
            ";

        }
    }

    private function output()
    {
        if(count($this->errors)>0)
        {
            $this->showErrors();
        } else {
            print $this->tableHTML;
        }

    }

    private function field2Label($field)
    {
        //look for 3 things, '_', '-', and a capital in an all lowercase word
        $label='';
        if(strpos($field,"_")>0)
        {
            $parts=explode('_',$field);
            foreach($parts as $part)
            {
                $label.=ucfirst($part)." ";
            }
        } elseif(strpos($field,"-")>0)
        {
            $parts=explode("-",$field);
            foreach($parts as $part)
            {
                $label.=ucfirst($part)." ";
            }
        } else {
            //lets look for an uppercase letter
            $i=0;
            $start=0;
            while($i<strlen($field))
            {
                if(substr($field,$i,1)===strtoupper(substr($field,$i,1)))
                {
                    $label.=substr($field,$start,$i-1);
                    $start=$i;
                }
                $i++;
            }
            if($label=='')
            {
                $label=ucfirst($field);
            }
        }
        //always fully uppercase "ID"
        $label=str_replace("Id","ID",$label);
        return rtrim($label," ");
    }

    private function tableData()
    {
        if(isset($this->data) && count($this->data)>0)
        {

            foreach($this->data as $record)
            {
                //ok at this point we have data and headers, so let's put the data in the same order as the headers
                $new_keys = array_keys($this->headers);
                $new_data = array();
                foreach ($new_keys as $key) {
                    $new_data[$key] = $record[$key];
                }
                $this->tableHTML.=$this->tableRow($new_data);
            }
        } else {
            $this->setError("No data supplied for table");
        }
    }

    function tableRow($row)
    {
        $id=$row['id']; // we must always have a key here
        $rowHTML="<tr>\n";
        foreach($row as $key=>$value)
        {
            $rowHTML.="<td>$value</td>\n";
        }
        $rowHTML.="<td>";
        $rowHTML.=$this->rowActions($id);
        $rowHTML.="</td>\n";
        $rowHTML.="</tr>\n";
        return $rowHTML;
    }

    private function rowActions($recordID)
    {
        if(count($this->recordActions)==1)
        {
            //just a single action
            $recAction = $this->recordActions[0];
            if(strpos($recAction['url'],"pages")>0)
            {} else
            {
                $recAction['url']="/pages/".$recAction['url'];
            }
            $action = "<a id='recordAction-$recordID-$recAction[action]' class='btn btn-primary' href=\"".$recAction['url']."?id=$recordID&action=$recAction[action]\" data-confirm='$recAction[confirm]' ".($recAction['confirmTitle']!=''? " data-confirm_title=\"$recAction[confirmTitle]\"" : '').($recAction['confirmMessage']!=''? " data-confirm_message=\"$recAction[confirmMessage]\"" : '').">$recAction[label]</a>\n";
        } else {
           $action=<<<ACTION
    <div class="btn-group">
        <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">
    Action <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu">
ACTION;
            //now go through record actions
            foreach($this->recordActions as $recAction)
            {
                if(strpos($recAction['url'],"pages")>0)
                {} else
                {
                    $recAction['url']="/pages/".$recAction['url'];
                }

                //@TODO need permissions being checked at this point
                $action.="<li><a id='recordAction-$recordID-$recAction[action]' href=\"".$recAction['url']."?id=$recordID&amp;action=$recAction[action]\" data-confirm='$recAction[confirm]' ".($recAction['confirmTitle']!=''? " data-confirm_title=\"$recAction[confirmTitle]\"" : '').($recAction['confirmMessage']!=''? " data-confirm_message=\"$recAction[confirmMessage]\"" : '').">$recAction[label]</a></li>\n";
            }
            $action.="</ul>\n</div>\n";
        }
        return $action;
    }

    private function setError($message)
    {
        $this->errors[]=$message;
    }

    private function showErrors()
    {
        if(count($this->errors)>0)
        {
            print "<div class=\"alert alert-danger\" role=\"alert\">\n";
            print "<h3>The following error".(count($this->errors)>1 ? 's':'')." have occurred.</h3><ul class='list-unstyled'>";
            foreach($this->errors as $error)
            {
                print "<li>$error</li>\n";
            }
            print "</ul></div>";
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
}