<?php
include("/system/prolog.php");
include (TEMPLATE_PATH."header.php");
$_ROUTER->route($_ADDRESS);
include (TEMPLATE_PATH."footer.php");
?>