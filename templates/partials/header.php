<?php
  //bring in some global variables for this partial

global $sites, $user;

?>
<!-- HEADER -->
<header id="header">
    <div id="logo-group">

        <span id="logo"> <img src="/public/img/logo.png" alt="Mango"> </span>

        <!-- Note: The activity badge color changes when clicked and resets the number to 0
        Suggestion: You may want to set a flag when this happens to tick off all checked messages / notifications -->
        <span id="activity" class="activity-dropdown"> <i class="fa fa-envelope"></i>
            <?php if(isset($user) && $user->messageCount>0) { ?>
                <b class="badge"> <?php  echo  $user->messageCount ?> </b>
            <?php } ?>
        </span>
    </div>

    <!-- projects dropdown -->
    <div class="project-context hidden-xs">

        <span class="label">Projects:</span>
        <span class="project-selector dropdown-toggle" data-toggle="dropdown">Tasks &amp; Jobs <i class="fa fa-angle-down"></i></span>

        <ul class="dropdown-menu">
            <?php if(count($user->projects)>0) {
                foreach ($user->projects as $link => $name) { ?>
                    <li>
                        <a href="<?php  echo  $link ?>"> <?php  echo  $name ?></a>
                    </li>
                <?php }
            } ?>
        </ul>
        <!-- end dropdown-menu-->

    </div>
    <!-- end projects dropdown -->

    <!-- pulled right: nav area -->
    <div class="pull-right">

        <!-- collapse menu button -->
        <div id="hide-menu" class="btn-header pull-right">
            <span> <a href="javascript:void(0);" data-action="toggleMenu" title="Collapse Menu"><i class="fa fa-reorder"></i></a> </span>
        </div>
        <!-- end collapse menu -->

        <!-- logout button -->
        <div id="logout" class="btn-header transparent pull-right">
            <span> <a href="/pages/user/logout.php" title="Sign Out" data-action="userLogout" data-logout-msg="You can improve your security further after logging out by closing this opened browser"><i class="fa fa-sign-out"></i></a> </span>
        </div>
        <!-- end logout button -->

         <!-- fullscreen button -->
        <div id="fullscreen" class="btn-header transparent pull-right">
            <span> <a href="javascript:void(0);" data-action="launchFullscreen" title="Full Screen"><i class="fa fa-arrows-alt"></i></a> </span>
        </div>
        <!-- end fullscreen button -->


        <ul class="header-dropdown-list hidden-xs">
            <li>
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <span> Active site is: <?php  echo $sites[$session->current_site] ?></span> <i class="fa fa-angle-down"></i> </a>
                <ul class="dropdown-menu pull-right">
                    <?php
                    foreach($user->sites as $site){
                        if($site->id==0) { ?>
                    <li>
                        <a href="/setsite/<?php  echo  $site->id  ?>"> <?php  echo  $site->name ?></a>
                    </li>
                    <?php //foreach($user->allSites() as $site) {
                        if($site->id!=1) { ?>
                    <li>
                        <a href="/setsite/<?php  echo  $site->id  ?>"> <?php  echo  $site->name ?></a>
                    </li>
                    <?php }
                    }
                        break;
                    //} else { ?>
                    <li>
                        <a href="/setsite/<?php  echo  $site->id  ?>"> <?php  echo  $site->name ?></a>
                    </li>
                    <?php }
                    //}
                    ?>
                </ul>
            </li>
        </ul>
        <!-- end multiple lang -->

    </div>
    <!-- end pulled right: nav area -->

</header>
<!-- END HEADER -->
