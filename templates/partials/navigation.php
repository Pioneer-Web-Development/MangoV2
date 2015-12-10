<!-- Left panel : Navigation area -->
<!-- Note: This width of the aside area can be adjusted through LESS variables -->
<aside id="left-panel">

    <!-- User info -->
    <div class="login-info">
				<span> <!-- User image size is adjusted inside CSS, it should stay as it -->

					<a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
                        <?php if ($user->avatar!='') { ?>
                        <img src="/images/avatars/<?php  $user->avatar ?>" alt="me" class="online" />
						<?php } ?>
                        <span>
							<?php echo $user->first_name ?>
						</span>
                        <i class="fa fa-angle-down"></i>
                    </a>

				</span>
    </div>
    <!-- end user info -->

    <!-- NAVIGATION : This navigation is also responsive-->
    <nav>
        <ul>
            <?php
            $menu=array(
                    array("url"=>"/dashboard","title"=>"Dashboard","icon"=>"home","restricted"=>false,"sub"=>array()),
                    array("url"=>'#',
                      'icon'=>'cog',
                      'title'=>'Admin',
                      'restricted'=>true,
                      'sub'=>array(
                            array("url"=>"config/users","title"=>"Users","icon"=>"users","restricted"=>false,"sub"=>array()),
                            array("url"=>"admin/roles","title"=>"Roles","icon"=>"graduation-cap","restricted"=>false,"sub"=>array()),
                            array("url"=>"admin/permissions","title"=>"Permissions","icon"=>"key","restricted"=>false,"sub"=>array()),
                            array("url"=>"admin/preferences","title"=>"Preferences","icon"=>"gears","restricted"=>true,"sub"=>array()),
                            array("url"=>"admin/sites","title"=>"Sites","icon"=>"cubes","restricted"=>true,"sub"=>array())
                      )
                    ),
                    array("url"=>'#',
                            'icon'=>'calendar',
                            'title'=>'Calendars',
                            'restricted'=>false,
                            'sub'=>array(
                                    array("url"=>"press/calendar","title"=>"Press","icon"=>"calendar","restricted"=>false,"sub"=>array()),
                                    array("url"=>"packaging/calendar","title"=>"Packaging","icon"=>"calendar","restricted"=>false,"sub"=>array()),
                                    array("url"=>"bindery/calendar","title"=>"Bindery","icon"=>"calendar","restricted"=>false,"sub"=>array()),
                                    array("url"=>"labelling/calendar","title"=>"Labelling","icon"=>"calendar","restricted"=>false,"sub"=>array()),
                                    array("url"=>"delivery/calendar","title"=>"Delivery","icon"=>"calendar","restricted"=>false,"sub"=>array()),
                                    array("url"=>"advertising/calendar","title"=>"Special Sections","icon"=>"calendar","restricted"=>false,"sub"=>array()),
                                    array("url"=>"projects/calendar","title"=>"Projects","icon"=>"calendar","restricted"=>false,"sub"=>array())
                            )
                    ),
                    array("url"=>'#',
                            'icon'=>'print',
                            'title'=>'Press',
                            'restricted'=>false,
                            'sub'=>array(
                                    array("url"=>"press/calendar","title"=>"Calendar","icon"=>"calendar","restricted"=>false,"sub"=>array()),
                                    array("url"=>"press/jobs/create","title"=>"Create New Job","icon"=>"","restricted"=>false,"sub"=>array()),
                                    array("url"=>"press/jobs","title"=>"Manage Jobs","icon"=>"","restricted"=>false,"sub"=>array()),
                                    array("url"=>"monitor/press","title"=>"Press Monitor","icon"=>"","restricted"=>false,"sub"=>array()),
                                    array("url"=>"monitor/pagination","title"=>"Pagination Monitor","icon"=>"","restricted"=>false,"sub"=>array()),
                                    array("url"=>"monitor/plateroom","title"=>"Plateroom Monitor","icon"=>"","restricted"=>false,"sub"=>array()),
                                    array("url"=>"press/jobs/move","title"=>"Move Jobs","icon"=>"","restricted"=>false,"sub"=>array()),
                                    array("url"=>"press/jobs/recurring","title"=>"Recurring Jobs","icon"=>"","restricted"=>false,"sub"=>array())
                            )
                    ),
                    array("url"=>'#',
                            'icon'=>'print',
                            'title'=>'Circulation',
                            'restricted'=>false,
                            'sub'=>array(
                                    array("url"=>"/circulation/draw","title"=>"Set daily draw","icon"=>"","restricted"=>false,"sub"=>array()),
                                    array("url"=>"#","title"=>"Racks","icon"=>"","restricted"=>false,'sub'=>array(
                                            array("url"=>"circulation/racks/","title"=>"Racks","icon"=>"","restricted"=>false,"sub"=>array()),
                                            array("url"=>"circulation/racks/maintenance","title"=>"Maintenance","icon"=>"","restricted"=>false,"sub"=>array()),
                                            array("url"=>"circulation/racks/location","title"=>"Locations","icon"=>"","restricted"=>false,"sub"=>array())
                                         )
                                    )
                            )
                    ),
                    array("url"=>'#',
                            'icon'=>'print',
                            'title'=>'Advertising',
                            'restricted'=>false,
                            'sub'=>array(
                                    array("url"=>"advertising/dashboard","title"=>"Dashboard","icon"=>"","restricted"=>false,"sub"=>array()),
                                    array("url"=>"advertising/special_sections","title"=>"Special Sections","icon"=>"","restricted"=>false,"sub"=>array()),
                                    array("url"=>"advertising/proofs","title"=>"Ad Proofs","icon"=>"","restricted"=>false,"sub"=>array()),
                                    array("url"=>"advertising/outbound","title"=>"Outbound Call Generator","icon"=>"","restricted"=>false,"sub"=>array())
                            )

                    ),
                    array("url"=>'#',
                            'icon'=>'print',
                            'title'=>'Finance',
                            'restricted'=>false,
                            'sub'=>array(
                                    array("url"=>"circulation/draw","title"=>"Set daily draw","icon"=>"","restricted"=>false,"sub"=>array()),
                                    array("url"=>"circulation/routes","title"=>"Route Creator","icon"=>"","restricted"=>false,"sub"=>array()),
                                    array("url"=>"#","title"=>"Racks","icon"=>"","restricted"=>false,'sub'=>array(
                                            array("url"=>"circulation/racks/","title"=>"Racks","icon"=>"","restricted"=>false,"sub"=>array()),
                                            array("url"=>"circulation/racks/maintenance","title"=>"Maintenance","icon"=>"","restricted"=>false,"sub"=>array()),
                                            array("url"=>"circulation/racks/location","title"=>"Locations","icon"=>"","restricted"=>false,"sub"=>array())
                                            )
                                    )
                            )
                    ),
                    array("url"=>'#',
                            'icon'=>'print',
                            'title'=>'Packaging',
                            'restricted'=>false,
                            'sub'=>array(
                                    array("url"=>"packaging/calendar/","title"=>"Packaging Calendar","icon"=>"calendar","restricted"=>false,"sub"=>array()),
                                    array("url"=>"inserts/receive/","title"=>"Receive Insert","icon"=>"","restricted"=>false,"sub"=>array()),
                                    array("url"=>"inserts","title"=>"Manage Inserts","icon"=>"","restricted"=>false,"sub"=>array()),
                                    array("url"=>"packaging/plan/","title"=>"Plans","icon"=>"","restricted"=>false,"sub"=>array()),
                                    array("url"=>"packaging/package/","title"=>"Packages","icon"=>"","restricted"=>false,"sub"=>array()),
                                    array("url"=>"monitor/packaging/","title"=>"Packaging Monitor","icon"=>"","restricted"=>false,"sub"=>array())
                            )
                    ),
                    array("url"=>'#',
                            'icon'=>'print',
                            'title'=>'Bindery & Labelling',
                            'restricted'=>false,
                            'sub'=>array(
                                    array("url"=>"bindery/calendar/","title"=>"Bindery Calendar","icon"=>"calendar","restricted"=>false,"sub"=>array()),
                                    array("url"=>"bindery/job/","title"=>"Bindery Jobs","icon"=>"","restricted"=>false,"sub"=>array()),
                                    array("url"=>"labelling/calendar/","title"=>"Labelling Calendar","icon"=>"calendar","restricted"=>false,"sub"=>array()),
                                    array("url"=>"labelling/job/","title"=>"Labelling Jobs","icon"=>"","restricted"=>false,"sub"=>array())
                            )
                    ),
                    array("url"=>'#',
                            'icon'=>'print',
                            'title'=>'Maintenance',
                            'restricted'=>false,
                            'sub'=>array(
                                    array("url"=>"maintenance/","title"=>"Overview","icon"=>"wrench","restricted"=>false,"sub"=>array()),
                                    array("url"=>"maintenance/press/","title"=>"Press","icon"=>"wrench","restricted"=>false,"sub"=>array()),
                                    array("url"=>"maintenance/inserter/","title"=>"Inserter","icon"=>"wrench","restricted"=>false,"sub"=>array()),
                                    array("url"=>"maintenance/stitcher/","title"=>"Stitcher","icon"=>"wrench","restricted"=>false,"sub"=>array()),
                                    array("url"=>"maintenance/building/","title"=>"Building","icon"=>"wrench","restricted"=>false,"sub"=>array()),
                                    array("url"=>"maintenance/misc/","title"=>"Miscellaneous","icon"=>"wrench","restricted"=>false,"sub"=>array()),
                                    array("url"=>"maintenance/scheduled/","title"=>"Scheduled","icon"=>"wrench","restricted"=>false,"sub"=>array()),
                                    array("url"=>"maintenance/tickets/","title"=>"Tickets","icon"=>"wrench","restricted"=>false,"sub"=>array()),
                                    array("url"=>"maintenance/wiki/","title"=>"Wiki","icon"=>"wrench","restricted"=>false,"sub"=>array()),
                                    array("url"=>"maintenance/parts/","title"=>"Part Management","icon"=>"wrench","restricted"=>false,"sub"=>array()),
                                    array("url"=>"maintenance/pm/","title"=>"PM Management","icon"=>"wrench","restricted"=>false,"sub"=>array()),
                                    array("url"=>"#","title"=>"IT Management","icon"=>"floppy-o","restricted"=>false,"sub"=>array(
                                            array("url"=>"/maintenance/it/hardware/","title"=>"Hardware","icon"=>"wrench","restricted"=>false,"sub"=>array()),
                                            array("url"=>"/maintenance/it/software/","title"=>"Software","icon"=>"wrench","restricted"=>false,"sub"=>array())
                                    ))
                            )
                    ),
                    array("url"=>'#',
                            'icon'=>'print',
                            'title'=>'Newsprint',
                            'restricted'=>false,
                            'sub'=>array(
                                    array("url"=>"newsprint/","title"=>"Overview","icon"=>"","restricted"=>false,"sub"=>array()),
                                    array("url"=>"newsprint/order","title"=>"Orders","icon"=>"","restricted"=>false,"sub"=>array()),
                                    array("url"=>"newsprint/receive","title"=>"Receive Order","icon"=>"","restricted"=>false,"sub"=>array()),
                                    array("url"=>"newsprint/processing/","title"=>"Daily Batches","icon"=>"","restricted"=>false,"sub"=>array()),
                                    array("url"=>"newsprint/trueup/","title"=>"True-up","icon"=>"","restricted"=>false,"sub"=>array())
                            )
                    ),
                    array("url"=>'#',
                            'icon'=>'print',
                            'title'=>'Inventory',
                            'restricted'=>false,
                            'sub'=>array(
                                    array("url"=>"inventory/","title"=>"Overview","icon"=>"","restricted"=>false,"sub"=>array()),
                                    array("url"=>"inventory/parts/","title"=>"Parts","icon"=>"","restricted"=>false,"sub"=>array()),
                                    array("url"=>"newsprint/","title"=>"Newsprint","icon"=>"","restricted"=>false,"sub"=>array()),
                                    array("url"=>"inventory/po/","title"=>"Purchase Orders","icon"=>"","restricted"=>false,"sub"=>array()),
                                    array("url"=>"inventory/monthly/","title"=>"Monthly Rolling","icon"=>"","restricted"=>false,"sub"=>array())
                            )
                    ),
                    array("url"=>'#',
                            'icon'=>'print',
                            'title'=>'Miscellaneous',
                            'restricted'=>false,
                            'sub'=>array(
                                    array("url"=>"misc/address","title"=>"Address Fixer","icon"=>"","restricted"=>false,"sub"=>array()),
                                    array("url"=>"misc/templabor/","title"=>"Temp Labor","icon"=>"","restricted"=>false,"sub"=>array())
                            )
                    ),
                    array("url"=>'#',
                            'icon'=>'gear',
                            'title'=>'Configuration',
                            'restricted'=>false,
                            'sub'=>array(
                                    array("url"=>"config/accounts","title"=>"Accounts","icon"=>"","restricted"=>false,"sub"=>array()),
                                    array("url"=>"config/publications","title"=>"Publications","icon"=>"","restricted"=>false,"sub"=>array()),
                                    array("url"=>"config/products","title"=>"Products","icon"=>"","restricted"=>false,"sub"=>array()),
                                    array("url"=>"config/preferences","title"=>"Preferences","icon"=>"","restricted"=>false,"sub"=>array()),
                                    array("url"=>"#","title"=>"Newsprint","icon"=>"","restricted"=>false,"sub"=>array(
                                            array("url"=>"config/newsprint/types","title"=>"Newsprint Types","icon"=>"","restricted"=>false,"sub"=>array()),
                                            array("url"=>"config/newsprint/sizes","title"=>"Roll Sizes","icon"=>"","restricted"=>false,"sub"=>array()),
                                            array("url"=>"misc/templabor/","title"=>"Temp Labor","icon"=>"","restricted"=>false,"sub"=>array())
                                        )
                                    ),
                                    array("url"=>"#","title"=>"Inventory","icon"=>"","restricted"=>false,"sub"=>array(
                                            array("url"=>"config/inventory/rollingitems","title"=>"Monthly Items","icon"=>"","restricted"=>false,"sub"=>array()),
                                            array("url"=>"config/inventory/locations","title"=>"Storage Locations","icon"=>"","restricted"=>false,"sub"=>array())
                                        )
                                    ),
                                    array("url"=>"#","title"=>"Email","icon"=>"","restricted"=>false,"sub"=>array(
                                            array("url"=>"config/email/groups","title"=>"Groups","icon"=>"","restricted"=>false,"sub"=>array()),
                                            array("url"=>"config/email/reports","title"=>"Reports","icon"=>"","restricted"=>false,"sub"=>array())
                                        )
                                    ),
                                    array("url"=>"#","title"=>"Press","icon"=>"","restricted"=>false,"sub"=>array(
                                            array("url"=>"config/press/setup","title"=>"Setup","icon"=>"","restricted"=>false,"sub"=>array()),
                                            array("url"=>"config/press/layouts","title"=>"Layouts","icon"=>"","restricted"=>false,"sub"=>array()),
                                            array("url"=>"config/press/benchmarks","title"=>"Benchmarks","icon"=>"","restricted"=>false,"sub"=>array()),
                                            array("url"=>"config/press/codes","title"=>"Stop Codes","icon"=>"","restricted"=>false,"sub"=>array()),
                                            array("url"=>"config/press/checklist","title"=>"Checklist","icon"=>"","restricted"=>false,"sub"=>array())
                                        )
                                    ),
                                    array("url"=>"#","title"=>"Bindery & Packaging","icon"=>"","restricted"=>false,"sub"=>array(
                                            array("url"=>"config/inserter/setup","title"=>"Inserter Setup","icon"=>"","restricted"=>false,"sub"=>array()),
                                            array("url"=>"config/stitcher/setup","title"=>"Stitcher Setup","icon"=>"","restricted"=>false,"sub"=>array())
                                        )
                                    ),
                                    array("url"=>"#","title"=>"System","icon"=>"","restricted"=>false,"sub"=>array(
                                            array("url"=>"config/system/filemonitor","title"=>"File Monitors","icon"=>"","restricted"=>false,"sub"=>array()),
                                            array("url"=>"config/system/misc","title"=>"Miscellaneous","icon"=>"","restricted"=>false,"sub"=>array())
                                        )
                                    ),
                                    array("url"=>"#","title"=>"General","icon"=>"","restricted"=>false,"sub"=>array(
                                            array("url"=>"config/general/floorplans","title"=>"Floorplans","icon"=>"","restricted"=>false,"sub"=>array()),
                                            array("url"=>"config/general/chatrooms","title"=>"Chat rooms","icon"=>"","restricted"=>false,"sub"=>array()),
                                            array("url"=>"config/general/budget","title"=>"Budgetary","icon"=>"","restricted"=>false,"sub"=>array())
                                        )
                                    ),
                                    array("url"=>"#","title"=>"Permissions","icon"=>"","restricted"=>false,"sub"=>array(
                                            array("url"=>"permissions/permissions","title"=>"Permissions","icon"=>"","restricted"=>false,"sub"=>array()),
                                            array("url"=>"permissions/groups","title"=>"Permission Groups","icon"=>"","restricted"=>false,"sub"=>array())
                                        )
                                    ),
                                    array("url"=>"#","title"=>"Users","icon"=>"","restricted"=>false,"sub"=>array(
                                            array("url"=>"user/users","title"=>"Users","icon"=>"users","restricted"=>false,"sub"=>array()),
                                            array("url"=>"user/groups","title"=>"Groups","icon"=>"","restricted"=>false,"sub"=>array()),
                                            array("url"=>"user/positions","title"=>"Positions","icon"=>"","restricted"=>false,"sub"=>array())
                                        )
                                    ),

                            )
                    )
            );
            foreach($menu as $item) {
                if(($user->isAdmin && $item['restricted']) || !($item['restricted'])){ ?>
                <li><a href="<?php page_link($item['url']) ?>" title="<?php echo $item['title'] ?>"><?php if($item['icon']!='') { ?><i class="fa fa-lg fa-fw fa-<?php echo $item['icon'] ?>"> </i><?php };if(count($item['sub'])>0) { ?><span class="menu-item-parent"><?php }echo $item['title'];if(count($item['sub'])>0) { ?></span><?php } ?></a>
                    <?php if(count($item['sub'])>0) { ?><ul>
                    <?php foreach($item['sub'] as $second) {
                    if(($user->isAdmin && $second['restricted']) || !($second['restricted'])) { ?>
                    <li><a href="<?php page_link($second['url']) ?>" title="<?php echo $second['title'] ?>"><?php if($second['icon']!='') { ?><i class="fa fa-lg fa-fw fa-<?php echo $second['icon'] ?>"> </i><?php } ?><?php if(count($second['sub'])>0) { ?><span class="menu-item-parent"><?php } echo $second['title']; if(count($second['sub'])>0) { ?></span><?php } ?></a>
                    <?php if(count($second['sub'])>0) {  ?>
                        <ul>
                        <?php foreach($second['sub'] as $third) {
                            if(($user->isAdmin && $third['restricted']) || !($third['restricted'])) { ?>
                            <li><a href="<?php page_link($third['url']) ?>" title="<?php echo $third['title'] ?>"><?php if($third['icon']!='') { ?><i class="fa fa-lg fa-fw fa-<?php echo $third['icon'] ?>"> </i><?php } ?><?php if(count($third['sub'])>0) { ?><span class="menu-item-parent"><?php } echo $third['title']; if(count($third['sub'])>0) { ?></span><?php } ?></a>
                                <?php if(count($third['sub'])>0) { ?>
                                    <ul>
                                        <?php foreach($third['sub'] as $fourth) {
                                            if(($user->isAdmin && $fourth['restricted']) || !($fourth['restricted']))  { ?>
                                                <li><a href="<?php page_link($fourth['url']) ?>" title="<?php echo $fourth['title'] ?>"><?php if($fourth['icon']!='')  { ?><i class="fa fa-lg fa-fw fa-<?php echo $fourth['icon'] ?>"> </i><?php } ?><?php if(count($fourth['sub'])>0)  { ?><span class="menu-item-parent"><?php }; echo $fourth['title']; if(count($fourth['sub'])>0)  { ?></span><?php } ?></a></li>
                                        <?php } ?>
                                        <?php } ?>
                                    </ul>
                                <?php } ?></li>
                        <?php } ?>
                        <?php } ?>
                        </ul>
                    <?php } ?>
                    </li>
                    <?php } ?>
                    <?php } ?></ul>
                    <?php } ?>
                </li>
            <?php } ?>
            <?php } ?>
            <!--
        <li>
            <a href="#"><i class="fa fa-lg fa-fw fa-calendar"> </i> <span class="menu-item-parent">Calendar</span></a>
            <ul>
                <li>
                    <a href="/calendar/press">Press</a>
                </li>
                <li>
                    <a href="/calendar/packaging">Packaging</a>
                </li>
                <li>
                    <a href="/calendar/bindery">Bindery</a>
                </li>
                <li>
                    <a href="/calendar/specialsections">Special Sections</a>
                </li>
                <li>
                    <a href="/calendar/delivery">Delivery</a>
                </li>
                <li>
                    <a href="/calendar/projects">Projects</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#"><i class="fa fa-lg fa-fw fa-newspaper-o"></i> <span class="menu-item-parent">Circulation</span></a>
            <ul>
                <li>
                    <a href="/circulation/dailydraw"><i class="fa fa-lg fa-fw fa-pencil"></i> Daily Draw</a>
                </li>
                <li>
                    <a href="/circulation/rackmaintenance"><i class="fa fa-lg fa-fw fa-wrench"></i> Rack Maintenance</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#"><i class="fa fa-lg fa-fw fa-pencil-square-o"></i> <span class="menu-item-parent">Forms</span></a>
            <ul>
                <li>
                    <a href="form-elements.html">Smart Form Elements</a>
                </li>
                <li>
                    <a href="form-templates.html">Smart Form Layouts</a>
                </li>
                <li>
                    <a href="validation.html">Smart Form Validation</a>
                </li>
                <li>
                    <a href="bootstrap-forms.html">Bootstrap Form Elements</a>
                </li>
                <li>
                    <a href="bootstrap-validator.html">Bootstrap Form Validation</a>
                </li>
                <li>
                    <a href="plugins.html">Form Plugins</a>
                </li>
                <li>
                    <a href="wizard.html">Wizards</a>
                </li>
                <li>
                    <a href="other-editors.html">Bootstrap Editors</a>
                </li>
                <li>
                    <a href="dropzone.html">Dropzone </a>
                </li>
                <li>
                    <a href="image-editor.html">Image Cropping <span class="badge pull-right inbox-badge bg-color-yellow">new</span></a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#"><i class="fa fa-lg fa-fw fa-desktop"></i> <span class="menu-item-parent">UI Elements</span></a>
            <ul>
                <li>
                    <a href="general-elements.html">General Elements</a>
                </li>
                <li>
                    <a href="buttons.html">Buttons</a>
                </li>
                <li>
                    <a href="#">Icons</a>
                    <ul>
                        <li>
                            <a href="fa.html"><i class="fa fa-plane"></i> Font Awesome</a>
                        </li>
                        <li>
                            <a href="glyph.html"><i class="glyphicon glyphicon-plane"></i> Glyph Icons</a>
                        </li>
                        <li>
                            <a href="flags.html"><i class="fa fa-flag"></i> Flags</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="grid.html">Grid</a>
                </li>
                <li>
                    <a href="treeview.html">Tree View</a>
                </li>
                <li>
                    <a href="nestable-list.html">Nestable Lists</a>
                </li>
                <li>
                    <a href="jqui.html">JQuery UI</a>
                </li>
                <li>
                    <a href="typography.html">Typography</a>
                </li>
                <li>
                    <a href="#">Six Level Menu</a>
                    <ul>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-folder-open"></i> Item #2</a>
                            <ul>
                                <li>
                                    <a href="#"><i class="fa fa-fw fa-folder-open"></i> Sub #2.1 </a>
                                    <ul>
                                        <li>
                                            <a href="#"><i class="fa fa-fw fa-file-text"></i> Item #2.1.1</a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="fa fa-fw fa-plus"></i> Expand</a>
                                            <ul>
                                                <li>
                                                    <a href="#"><i class="fa fa-fw fa-file-text"></i> File</a>
                                                </li>
                                                <li>
                                                    <a href="#"><i class="fa fa-fw fa-trash-o"></i> Delete</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-folder-open"></i> Item #3</a>

                            <ul>
                                <li>
                                    <a href="#"><i class="fa fa-fw fa-folder-open"></i> 3ed Level </a>
                                    <ul>
                                        <li>
                                            <a href="#"><i class="fa fa-fw fa-file-text"></i> File</a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="fa fa-fw fa-file-text"></i> File</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>

                        </li>
                    </ul>
                </li>
            </ul>
        </li>

        <li>
            <a href="calendar.html"><i class="fa fa-lg fa-fw fa-calendar"><em>3</em></i> <span class="menu-item-parent">Calendar</span></a>
        </li>
        <li>
            <a href="widgets.html"><i class="fa fa-lg fa-fw fa-list-alt"></i> <span class="menu-item-parent">Widgets</span></a>
        </li>
        <li>
            <a href="#"><i class="fa fa-lg fa-fw fa-puzzle-piece"></i> <span class="menu-item-parent">App Views</span></a>
            <ul>
                <li>
                    <a href="projects.html"><i class="fa fa-file-text-o"></i> Projects</a>
                </li>
                <li>
                    <a href="blog.html"><i class="fa fa-paragraph"></i> Blog</a>
                </li>
                <li>
                    <a href="gallery.html"><i class="fa fa-picture-o"></i> Gallery</a>
                </li>

                <li>
                    <a href="#"><i class="fa fa-comments"></i> Forum Layout</a>
                    <ul>
                        <li><a href="forum.html">General View</a></li>
                        <li><a href="forum-topic.html">Topic View</a></li>
                        <li><a href="forum-post.html">Post View</a></li>
                    </ul>
                </li>
                <li>
                    <a href="profile.html"><i class="fa fa-group"></i> Profile</a>
                </li>
                <li>
                    <a href="timeline.html"><i class="fa fa-clock-o"></i> Timeline</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="gmap-xml.html"><i class="fa fa-lg fa-fw fa-map-marker"></i> <span class="menu-item-parent">GMap Skins</span><span class="badge bg-color-greenLight pull-right inbox-badge">9</span></a>
        </li>
        <li>
            <a href="#"><i class="fa fa-lg fa-fw fa-windows"></i> <span class="menu-item-parent">Miscellaneous</span></a>
            <ul>
                <li>
                    <a href="http://bootstraphunter.com/smartadmin-landing/" target="_blank">Landing Page <i class="fa fa-external-link"></i></a>
                </li>
                <li>
                    <a href="pricing-table.html">Pricing Tables</a>
                </li>
                <li>
                    <a href="invoice.html">Invoice</a>
                </li>
                <li>
                    <a href="login.html" target="_top">Login</a>
                </li>
                <li>
                    <a href="register.html" target="_top">Register</a>
                </li>
                <li>
                    <a href="lock.html" target="_top">Locked Screen</a>
                </li>
                <li>
                    <a href="error404.html">Error 404</a>
                </li>
                <li>
                    <a href="error500.html">Error 500</a>
                </li>
                <li>
                    <a href="blank_.html">Blank Page</a>
                </li>
                <li>
                    <a href="email-template.html">Email Template</a>
                </li>
                <li>
                    <a href="search.html">Search Page</a>
                </li>
                <li>
                    <a href="ckeditor.html">CK Editor</a>
                </li>
            </ul>
        </li>
        -->
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/partials/chat_menu.php'; ?>
        </ul>
    </nav>
    <span class="minifyme" data-action="minifyMenu">
        <i class="fa fa-arrow-circle-left hit"></i>
    </span>

</aside>
<!-- END NAVIGATION -->