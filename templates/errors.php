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
<body id='extra-page' class="animated fadeInDown">
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . "/templates/partials/head.php";
}

function nav()
{
    include $_SERVER['DOCUMENT_ROOT'] . "/templates/partials/navigation.php";
}

function page_footer()
{
    include $_SERVER['DOCUMENT_ROOT']."/templates/partials/footer.php";
}

function document_close()
{
    ?>
    </body>
    </html>
    <?php
}