<?php
    UnloqUtil::register_style('admin');
    UnloqUtil::register_js('admin');
?>

<div class="wrap">
    <h2>UNLOQ Settings</h2>
    <div class="card unloq-card">
        <form id="unloq-form" method="post" action="<?php echo UnloqUtil::pluginUrl(); ?>">
            <?php wp_nonce_field('unloq_settings'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th class="option-key" scope="row">
                        <label for="unloqLogin">Login type</label>
                    </th>
                    <td valign="top">
                        <select name="login_type" id="unloqLoginType">
                            <option value="UNLOQ" <?php if (UnloqConfig::get('login_type') == "UNLOQ") { ?>selected="selected"<?php } ?>>UNLOQ-only</option>
                            <option value="UNLOQ_PASS" <?php if (UnloqConfig::get('login_type') == "UNLOQ_PASS") { ?>selected="selected"<?php } ?>>UNLOQ or passwords</option>
                        </select>
                    </td>
                </tr>
                <tr valign="top">
                    <th class="option-key" scope="row">
                        <label for="unloqTheme">Plugin theme</label>
                    </th>
                    <td valign="top" style="vertical-align: top; width: 200px;">
                        <select name="theme" id="unloqTheme">
                            <option value="light" <?php if (UnloqConfig::get('theme') == "light") { ?>selected="selected"<?php } ?>>Light</option>
                            <option value="dark" <?php if (UnloqConfig::get('theme') == "dark") { ?>selected="selected"<?php } ?>>Dark</option>
                        </select>
                    </td>
                    <td valign="top" style="text-align: right;">
                        <img class="login-theme login-dark" src="<?php echo UnloqUtil::image('login-dark.png') ?>" alt="Dark login theme"/>
                        <img class="login-theme login-light" src="<?php echo UnloqUtil::image('login-light.png') ?>" alt="Light login theme"/>
                    </td>
                </tr>
            </table>
            <p class="submit">
                <?php submit_button("Save changes", "primary", null, false); ?>
                <a href="<?php echo UnloqUtil::pluginUrl(array('setup' => 'true')) ?>" class="button">Enter setup</a>
            </p>

            <br/>
            <p class="helper">
                You can find out more about the UNLOQ Login plugin <a href="http://unloq.readme.io/v1/docs/integration" target="_blank">here</a>.
            </p>
        </form>
    </div>
</div>
