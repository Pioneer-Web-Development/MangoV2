<?php
include 'functions.php';
page_header() ?>
<?php nav(); ?>

    <!-- Main component for a primary marketing message or call to action -->
    <div class="jumbotron">
        <h1>Migration</h1>
        <p>This document supplies all Mango migration information that needs to happen to move from V1 to V2.</p>

    </div>


<div class="well">
    <h3>Database Changes</h3>
    <ul class="list-unstyled">
        <li>
            <ul class="list-unstyled">
                Users
                <ul>Add Fields
                    <li>Add field: token | varchar(100) | nullable</li>
                    <li>Add field: online | tinyint | 0</li>
                    <li>Add field: last_online | datetime | nullable</li>
                </ul>
                <ul>Change Fields
                    <li>Change field: password | varchar (255) from (60) | nullable</li>
                    <li>Change field: vision_data_sales_id | to sales_id</li>
                    <li>Change field: vision_data_sales_name | to sales_name</li>
                </ul>
                <ul>Remove Fields
                    <li>businesscard_title</li>
                    <li>pims_access</li>
                    <li>intranet_access</li>
                    <li>delete_intranet_news</li>
                    <li>delete_intranet_events</li>
                    <li>delete_intranet_docs</li>
                    <li>edit_intranet_news</li>
                    <li>edit_intranet_events</li>
                    <li>edit_intranet_docs</li>
                    <li>master_key</li>
                    <li>submaster_key</li>
                    <li>mango</li>
                    <li>papaya</li>
                    <li>guava</li>
                    <li>kiwi</li>
                    <li>pineapple</li>
                    <li>phone_punchdown</li>
                    <li>simple_menu</li>
                    <li>extension_id</li>
                    <li>weight</li>
                    <li>simple_tables</li>
                </ul>

            </ul>
            <ul class="list-unstyled">
                Core Permission List
                <ul>Add Fields
                </ul>
                <ul>Change Fields
                </ul>
                <ul>Remove Fields
                    <li>weight</li>
                    <li>name</li>
                    <li>type</li>
                    <li>auto_enable</li>
                </ul>

            </ul>
            <ul class="list-unstyled">
                user_messages
                <ul>Add Fields
                    <li>Add field: id | int | auto-increment | primary</li>
                    <li>Add field: user_id | int | nullable</li>
                    <li>Add field: create_datetime | datetime | nullable</li>
                    <li>Add field: updated_datetime | datetime | nullable</li>
                    <li>Add field: received_datetime | datetime | nullable</li>
                    <li>Add field: read_datetime | datetime | nullable</li>
                    <li>Add field: status | int | default(0)</li>
                    <li>Add field: sender_id | int | default(0)</li>
                    <li>Add field: message_type | varchar(50) | enum vales (message, chat, alert,job_update</li>
                    <li>Add field: message_subject | varchar(255) | </li>
                    <li>Add field: message_body | text | </li>
                    <li>Add field: message_priority | tinyint(1) | default 0</li>

                </ul>
                <ul>Change Fields
                </ul>
                <ul>Remove Fields

                </ul>

            </ul>
        </li>
    </ul>
</div>

<?php page_footer() ?>