<div class="panel panel-default">
    <?php if (count($GLOBALS['errors']) > 0): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($GLOBALS['errors'] as $error ): ?>
                    <li><?php echo  $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
        <div class="panel-heading"><?php echo $title ?></div>
        <div class="panel-body">
        <?php echo $description; ?>
        </div>
</div>
