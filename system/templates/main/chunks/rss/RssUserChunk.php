<?php
global $_USER;
?>
<div class="row user-rss-list-wrap">
    <?php foreach ($urls as $key => $value) { ?>
        <div class="col-md-12">
            <div class="rss-wrapper alert  alert-info" id="rss<?php echo $key; ?>" role="alert">
                <?php echo $value ?>
                <div
                    onclick="DeleteRss(<?php echo $_USER->getProperty('id'); ?>, '<?php echo $value; ?>', 'rss<?php echo $key; ?>');"
                    class="delete" data-url="<?php echo $value; ?>"><i class="glyphicon glyphicon-remove"></i></div>
            </div>
        </div>
    <? } ?>
</div>
