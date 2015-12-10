
<!--================================================== -->
<script src="/public/js/all.js"></script>
<script>
    $(document).ready(function() {
        pageSetUp();

        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });
        $('.basicTable').dataTable();

        $('a[data-confirm="true"]').click(function(event) {
            event.preventDefault();
            if($(this).data('confirm_title')!='')
            {
                var title = $(this).data('confirm_title');
            } else {
                var title = "Delete Record!";
            }
            if($(this).data('confirm_message')!='')
            {
                var message = $(this).data('confirm_message');
            } else {
                var message = "Are you sure you want to delete this record?";
            }
            $.SmartMessageBox({
                title : title,
                content : message,
                buttons : '[No][Yes]'
            }, function(ButtonPressed) {
                /*if (ButtonPressed === "Yes") {
                    $(event.currentTarget).parent().submit();
                } */
                return true;
                if (ButtonPressed === "No") {
                    return false;
                }
            });

        })


    });
</script>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/templates/partials/flash-messaging.php';
includeScripts();
