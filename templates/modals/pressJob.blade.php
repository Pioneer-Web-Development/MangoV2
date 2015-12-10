<div id="jobEditor" class="modal fade" tabindex="-1" data-width="850" style="display: none;">
    <div id="presswizard">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Job Editor <span id="jobID"></span></h4>
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="container">
                        <ul>
                            <li><a href="#basic" data-index="1" data-toggle="tab">Basic</a></li>
                            <li><a href="#paper" data-index="2" data-toggle="tab">Paper</a></li>
                            <li><a href="#draw" data-index="3" data-toggle="tab">Draw</a></li>
                            <li><a href="#sections" data-index="4" data-toggle="tab">Sections</a></li>
                            <li><a href="#layout" data-index="5" data-toggle="tab">Layout</a></li>
                            <li><a href="#color" data-index="6" data-toggle="tab">Color</a></li>
                            <li><a href="#bindery" data-index="7" data-toggle="tab">Bindery</a></li>
                            <li><a href="#delivery" data-index="8" data-toggle="tab">Delivery</a></li>
                            <li><a href="#stats" data-index="9" data-toggle="tab">Statistics</a></li>
                            <li><a href="#notes" data-index="10" data-toggle="tab">Notes/Messages</a></li>
                            <li><a href="#duplicate" data-index="11" data-toggle="tab">Duplicate/Tools</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="bar" class="progress progress-striped active">
                <div class="bar"></div>
            </div>
        </div>
        <div class="modal-body">
        @if(count($presses)>1)
            {!!   Form::select('press_id',1,$presses)  !!}
        @else
            <input type="text" id="press_id" name="press_id" value="{{  $presses[0]->id }}" />
        @endif

            <div class="tab-content">
                <div class="tab-pane" id="basic">
                    <div class="row">
                        <div class="col-sm-12">
                            {!!  Form::open(array('url'=>'/pressjobs/{id}/basic','method'=>'POST', "class"=>"form form-horizontal"))  !!}
                            @include('forms.pressJob.basics')
                            {!!  Form::close() !!}
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="paper">
                    <div class="row">
                        <div class="col-sm-12">
                            {!!  Form::open(array('url'=>'/pressjobs/{id}/paper','method'=>'POST', "class"=>"form form-horizontal"))  !!}
                            @include('forms.pressJob.paper')
                            {!!  Form::close() !!}
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="draw">
                    <div class="row">
                        <div class="col-sm-12">
                            {!!  Form::open(array('url'=>'/pressjobs/{id}/draw','method'=>'POST', "class"=>"form form-horizontal"))  !!}
                            @include('forms.pressJob.draw')
                            {!!  Form::close() !!}
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="sections">
                    <div class="row">
                        <div class="col-sm-12">
                            {!!  Form::open(array('url'=>'/pressjobs/{id}/sections','method'=>'POST', "class"=>"form form-horizontal"))  !!}
                            @include('forms.pressJob.sections')
                            {!!  Form::close() !!}
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="layout">
                    <div class="row">
                        <div class="col-sm-12">
                            {!!  Form::open(array('url'=>'/pressjobs/{id}/layout','method'=>'POST', "class"=>"form form-horizontal"))  !!}
                            @include('forms.pressJob.layout')
                            {!!  Form::close() !!}
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="color">
                    <div class="row">
                        <div class="col-sm-12">
                            {!!  Form::open(array('url'=>'/pressjobs/{id}/color','method'=>'POST', "class"=>"form form-horizontal"))  !!}
                            @include('forms.pressJob.color')
                            {!!  Form::close() !!}
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="bindery">
                    <div class="row">
                        <div class="col-sm-12">
                            {!!  Form::open(array('url'=>'/pressjobs/{id}/bindery','method'=>'POST', "class"=>"form form-horizontal"))  !!}
                            @include('forms.pressJob.bindery')
                            {!!  Form::close() !!}
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="delivery">
                    <div class="row">
                        <div class="col-sm-12">
                            {!!  Form::open(array('url'=>'/pressjobs/{id}/delivery','method'=>'POST', "class"=>"form form-horizontal"))  !!}
                            @include('forms.pressJob.delivery')
                            {!!  Form::close() !!}
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="stats">
                    <div class="row">
                        <div class="col-sm-12">
                            {!!  Form::open(array('url'=>'/pressjobs/{id}/stats','method'=>'POST', "class"=>"form form-horizontal"))  !!}
                            @include('forms.pressJob.stats')
                            {!!  Form::close() !!}
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="notes">
                    <div class="row">
                        <div class="col-sm-12">
                            {!!  Form::open(array('url'=>'/pressjobs/{id}/notes','method'=>'POST', "class"=>"form form-horizontal"))  !!}
                            @include('forms.pressJob.notes')
                            {!!  Form::close() !!}
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="duplicate">
                    <div class="row">
                        <div class="col-sm-12">
                            {!!  Form::open(array('url'=>'/pressjobs/{id}/duplicate','method'=>'POST', "class"=>"form form-horizontal"))  !!}
                            @include('forms.pressJob.duplicate')
                            {!!  Form::close() !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <ul class="pager wizard">
                        <li class="previous first"><a href="javascript:;">First</a></li>
                        <li class="previous"><a href="javascript:;">Previous</a></li>
                        <li class="next last"><a href="javascript:;">Last</a></li>
                        <li class="next"><a href="javascript:;">Next</a></li>
                        <li class="next finish" style="display:none;"><a href="javascript:;">Finish</a></li>
                    </ul>
                </div>
            </div>
        </div>


    </div>
</div>

