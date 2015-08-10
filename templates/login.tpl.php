<?php
$unloq_script = '<script type="text/javascript" src="' . UnloqApi::PLUGIN_LOGIN . '" data-unloq-theme="' . $unloq_theme . '" data-unloq-key="' . $unloq_api_key . '"></script>';
?>
<?php
// Login with UNLOQ only
if($unloq_type == "UNLOQ") { ?>
    <div class="unloq-login-box">
        <?php echo $unloq_script; ?>
    </div>
<?php } ?>

<?php
// Login with UNLOQ or passwords
if ($unloq_type == "UNLOQ_PASS") {
    UnloqUtil::register_js('login', array('jquery'));
?>
    <div id="btnInitUnloq" class="unloq-init" data-script="<?php echo UnloqApi::PLUGIN_LOGIN; ?>" data-theme="<?php echo $unloq_theme; ?>" data-key="<?php echo $unloq_api_key; ?>"></div>

<?php } ?>