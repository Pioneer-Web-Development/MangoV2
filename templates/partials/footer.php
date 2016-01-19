
<!--================================================== -->
<script src="/public/js/all.js"></script>
<script>
    $(document).ready(function() {
        pageSetUp();

        $.ajaxSetup({
            headers: {
                'X-Csrf-Token': "<?php echo $GLOBALS['session']->csrf_token ?>"
            }
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
            return show

        });

        //for form toggle button field
        $('.btn-toggle').click(function() {
            $(this).find('.btn').toggleClass('active');

            if ($(this).find('.btn-primary').size()>0) {
                $(this).find('.btn').toggleClass('btn-primary');
            }
            if ($(this).find('.btn-danger').size()>0) {
                $(this).find('.btn').toggleClass('btn-danger');
            }
            if ($(this).find('.btn-success').size()>0) {
                $(this).find('.btn').toggleClass('btn-success');
            }
            if ($(this).find('.btn-info').size()>0) {
                $(this).find('.btn').toggleClass('btn-info');
            }

            $(this).find('.btn').toggleClass('btn-default');

        });
        $('.colorpicker').colorpicker();

        /*
        $('.summernote').each(function(i, obj) {
            console.log(obj);
            $(obj).summernote({
                callbacks: {
                    onBlur: function(e) {
                        console.log('Copying from summer to textarea');
                        var id = $(obj).attr('id').replace("_editor","");
                        console.log('Working with '+id);
                        //drop "_editor" from the id and that'll be the textarea to copy the contents of the summernote instance to
                        $('#'+id).val($(obj).code());
                    }
                }
            });
        });
        */
    });
</script>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/templates/partials/flash-messaging.php';
includeScripts();
