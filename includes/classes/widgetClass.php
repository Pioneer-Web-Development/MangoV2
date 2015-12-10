<?php

class Widget
{
    private $widgetHTML = '';
    private $widgetID;
    private $options = [];
    private $realTime = false;
    private $realTimeSource = '';
    private $title = '';
    private $bodyClass = '';
    private $titleIcon = '';
    private $widgetContentHTML = '';
    private $widgetActions=array();

    public function __construct()
    {
        $this->widgetID=$this->generateID();

        $this->options = array(
            'color'=>'true',
            'toggle'=>'false',
            'edit'=>'false',
            'delete'=>'false',
            'fullscreen'=>'false',
            'collapsed'=>'false',
            'sortable'=>'true',
            'hidden'=>'false',
            'custom'=>'false'
        );

        $this->bodyClass = 'no-padding';
    }

    public function setTitle($title,$icon='')
    {
        $this->title = $title;
        $this->titleIcon=$icon;
    }

    public function setBodyClass($class)
    {
        //options are nothing, no-padding or well
        $this->bodyClass = $class;
    }

    public function setRealTime($url)
    {
        $this->realTime = true;
        $this->realTimeSource = $url;
        $this->setOption('load',$url);
        $this->setOption('refresh',15);
    }

    public function setActions($action)
    {
        /*
         * Action array format is
         *      $action = array('label'=>'Users','url'=>'/pages/user/users.php','class'=>'primary');
         *
         * or for a subaction
         *      $action = array('label'=>'Users','class'=>'primary','subitems'=>array('label'=>'Users','url'=>'/pages/user/users.php','class'=>'primary'))
         */
        $this->widgetActions[]=$action;
    }

    public function setOption($type,$value='true')
    {
        $this->options[$type] = $value;
    }

    public function setOptions($options)
    {

        $this->options = array_merge($this->options,$options);
    }

    public function addTable($headers,$rows)
    {
        $tableHTML = "<div class=\"table-responsive\"><table class='table table-striped table-bordered table-condensed table-hover'>\n";
        $tableHTML.="<thead><tr>";
        if(count($headers)>0)
        {
            foreach($headers as $header)
            {
                $tableHTML.="<th>$header</th>";
            }
        }
        $tableHTML.="</tr></thead>\n";
        $tableHTML.="<tbody>";
        if(count($rows)>0)
        {
            foreach($rows as $row)
            {
                $tableHTML.="<tr>";
                foreach($row as $cell)
                {
                    $tableHTML.="<td>$cell</td>";
                }
                $tableHTML.="</tr>";
            }
        }
        $tableHTML.="</tbody></table></div>\n";

        $this->widgetContentHTML.= $tableHTML;
    }

    public function addContent($content)
    {
        $this->widgetContentHTML.=$content;
    }

    private function getOptions()
    {
        $optionHTML='';
        if(count($this->options)>0)
        {
            foreach($this->options as $type => $value) {
                if($value!='true') {
                    switch ($type) {
                        case 'color';
                            $optionHTML .= " data-widget-colorbutton=\"false\"";
                            break;

                        case 'edit';
                            $optionHTML .= " data-widget-editbutton=\"false\"";
                            break;

                        case 'load';
                            $optionHTML .= " data-widget-load=\"$value\"";
                            break;

                        case 'refresh';
                            $optionHTML .= " data-widget-refresh=\"$value\"";
                            break;

                        case 'toggle';
                            $optionHTML .= " data-widget-togglebutton=\"false\"";
                            break;

                        case 'delete';
                            $optionHTML .= " data-widget-deletebutton=\"false\"";
                            break;

                        case 'fullscreen';
                            $optionHTML .= " data-widget-fullscreenbutton=\"false\"";
                            break;

                        case 'hidden';
                            $optionHTML .= " data-widget-collapsed=\"false\"";
                            break;

                        case 'collapsed';
                            $optionHTML .= " data-widget-collapsed=\"false\"";
                            break;

                        case 'sortable';
                            $optionHTML .= " data-widget-sortable=\"false\"";
                            break;

                        case 'custom';
                            $optionHTML .= " data-widget-custombutton=\"false\"";
                            break;
                    }
                }
            }
        }
        return $optionHTML;
    }

    private function getActions()
    {
        print "<div class=\"widget-toolbar\">
            <div class=\"btn-group btn-group-xs \" role=\"group\">";
        foreach($this->widgetActions as $action)
        {
            if(!isset($action['class'])){$class='bg-color-blueDark txt-color-white';}else{$class="btn-".$action['class'];}
            if(!isset($action['subitems']) || count($action['subitems'])==0)
            {
                print "<a href=\"$action[url]\" class=\"btn $class btn-xs\">$action[label]</a>";
            } else {
                print "<button class=\"btn dropdown-toggle btn-xs $class\" data-toggle=\"dropdown\">$action[label] <i class=\"fa fa-caret-down\"></i></button>
                 <ul class=\"dropdown-menu pull-right\">";
                foreach($action['subitems'] as $subaction)
                {
                    if(!isset($subaction['class'])){$class='btn-default';}else{$class="btn-".$subaction['class'];}
                    print "<li><a href=\"$subaction[url]\">$subaction[label]</a></li>";
                }
                print "</ul>\n";
            }
        }
        print "</div></div>\n";
    }

    private function editBox()
    {
        ?>
        <!-- widget edit box -->
        <div class="jarviswidget-editbox">
            <div>
                <label>Title:</label>
                <input type="text" />
            </div>
        </div>
        <!-- end widget edit box -->
        <?php
    }
    public function render()
    {


        ?>

        <!-- new widget -->
        <div class="jarviswidget" id="<?php echo $this->widgetID ?>"<?php echo $this->getOptions() ?>>


                <header>
                    <?php if ($this->titleIcon != ''): ?>
                    <span class="widget-icon"> <i class="<?php echo $this->titleIcon ?>"></i> </span>
                    <?php endif ;?>
                    <h2><?php echo $this->title ?></h2>
                    <?php if ($this->realTime) : ?>
                    <div class="widget-toolbar hidden-mobile">
                    <i class="fa fa-location-arrow"></i> Realtime
                    </div>
                    <?php endif; ?>
                    <?php if(count($this->widgetActions)>0)
                    {
                        $this->getActions();
                    } ?>
                </header>

                <!-- widget div-->
                <div>
                    <?php $this->editBox() ?>

                    <div class="widget-body <?php echo $this->bodyClass ?>">
                        <!-- content goes here -->
                        <?php
                        echo $this->widgetContentHTML;
                        ?>

                        <!-- end content -->

                    </div>
                </div>

        </div>
        <!-- end widget div -->
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

        return 'widget_'.$randstr;
    }


}