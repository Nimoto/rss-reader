<div class="select">
    <?php foreach ($urls as $key => $value) { ?>
        <?php
        if (in_array($key, $_SESSION["sort"]["include_rss"])) {
            $class = "active";
            $action = "var elem = document.getElementById('but" . $key . "');ExcludeRss(elem, " . $key . "); return false;";
        } else {
            $class = "";
            $action = "ChooseRss(" . $key . "); return false;";
        }
        ?>
        <div class="option <?php echo $class; ?>" onclick="<?php echo $action; ?>"
             id="rss<?php echo $key ?>"><?php echo $value ?></div>
    <?php } ?>
</div>
