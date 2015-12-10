<?php
function template_init()
{
    document_open();
    page_header();
    nav();
    page();
    page_footer();
    document_close();
}

function document_open()
{
    ?>

    <!DOCTYPE html>
    <html lang="en-us" id="extr-page">
    <?php
    include $_SERVER['DOCUMENT_ROOT']."/templates/partials/head.php";
}

function page_header()
{
    ?>
    <body class="fixed-header fixed-navigation fixed-ribbon fixed-page-footer">
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . "/templates/partials/header.php";
}

function nav()
{
    include $_SERVER['DOCUMENT_ROOT'] . "/templates/partials/navigation.php";
    ?>
            <!-- MAIN PANEL -->
        <div id="main" role="main">

            <!-- RIBBON -->
            <div id="ribbon">

                    <span class="ribbon-button-alignment">
                        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
                            <i class="fa fa-refresh"></i>
                        </span>
                    </span>

                <!-- breadcrumb -->
                <ol class="breadcrumb">
                    <?php echo $GLOBALS['breadcrumb']; ?>
                </ol>
                <!-- end breadcrumb -->

                <!-- You can also add more buttons to the
                ribbon for further usability

                Example below:

                <span class="ribbon-button-alignment pull-right">
                <span id="search" class="btn btn-ribbon hidden-xs" data-title="search"><i class="fa-grid"></i> Change Grid</span>
                <span id="add" class="btn btn-ribbon hidden-xs" data-title="add"><i class="fa-plus"></i> Add</span>
                <span id="search" class="btn btn-ribbon" data-title="search"><i class="fa-search"></i> <span class="hidden-mobile">Search</span></span>
                </span> -->

            </div>
            <!-- END RIBBON -->

            <!-- MAIN CONTENT -->
            <div id="content">
    <?php
}

function page_footer()
{
    page_cleanup();
    print "
        </div> <!-- END MAIN CONTENT -->
    </div> <!-- END MAIN PANEL-->
    <!-- including footer partial -->\n";

    include $_SERVER['DOCUMENT_ROOT']."/templates/partials/footer-bar.php";
    include $_SERVER['DOCUMENT_ROOT']."/templates/partials/footer.php";
}

function document_close()
{
    ?>

    </body>
</html>
    <?php
}