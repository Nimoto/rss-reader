<?php
if ($error) {
    foreach ($error as $message) {
        ?>
        <div class="alert alert-danger" role="alert"><?php echo $message; ?></div><?php
    }
}
if ($success) {
    ?>
    <div class="alert alert-success" role="alert"><?php echo $success; ?></div><?php
}
echo $form_header;
foreach ($fields as $field) {
    ?>
    <div class="form-group"><?php
    echo $field;
    ?></div><?php
}
foreach ($buttons as $button) {
    ?>
    <div class="form-group"><?php
    echo $button;
    ?></div><?php
}
echo $form_footer;
?>