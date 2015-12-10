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
    include "/templates/partials/head.php";
}

function page_header()
{
?>
    <body id='extra-page' class="animated fadeInDown">
<?php
}

function nav()
{
    /* no nav on login page */
}

function page_footer()
{
    global $messenger;
    include "/templates/partials/footer.php";
}

function document_close()
{
    ?>
    </body>
</html>
<?php
}