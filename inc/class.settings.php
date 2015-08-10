<?php

/*
 * This is the UNLOQ Settings page. Only rendered when an admin is active.
 * */
class UnloqSettings {

    public static function register_menu() {
        if(!UnloqConfig::isActive() || !is_admin()) return;
        add_menu_page('Settings', 'UNLOQ', 'administrator', UNLOQ_NS, array('UnloqSettings', 'render'), (UNLOQ_ASSETS . 'img/icon.png'));
    }

    public static function render() {
        if (!is_admin()) return;
        $wasSetup = false;

        if (UnloqUtil::isPost()) {
            if (UnloqUtil::verifyNonce('unloq_setup')) {
                $wasSetup = self::setup(UnloqUtil::body());
            }
            if (UnloqUtil::verifyNonce('unloq_settings')) {
                self::update(UnloqUtil::body());
            }
        }
        settings_errors('unloq_settings');
        settings_errors('unloq_setup');
        // If the plugin was not setup, we set it up.
        if (!UnloqConfig::isSetup() || (UnloqUtil::query("setup") == "true" && !$wasSetup)) {
            UnloqUtil::render('setup');
        } else {
            UnloqUtil::render('settings');
        }
    }

    /*
     * Performs the UNLOQ setup, collecting the API key, API Secret and testing the credentials,
     * while updating the login/logout webhook
     * */
    private static function setup($data) {
        // Step one: we verify the new api key/secret
        $errs = UnloqConfig::set(array(
            'api_key' => $data['api_key'],
            'api_secret' => $data['api_secret'],
            'app_linking' => $data['app_linking'] == "1" ? true : false));
        if ($errs) {
            foreach ($errs as $error) {
                add_settings_error("unloq_setup", null, $error->message);
            }
            return false;
        }
        // If we're error free, we check the credentials.
        $api = new UnloqApi();
        // We now capture the login/logout paths
        $res = $api->updateHooks();
        if($res->error) {
            add_settings_error("unloq_setup", null, $res->message);
            return false;
        }
        $link = $api->updateAppLinking();
        if($link->error) {
            add_settings_error("unloq_setup", null, $res->message);
            return false;
        }
        UnloqConfig::set('is_setup', "true");
        UnloqConfig::save();
        add_settings_error('unloq_setup', null, "UNLOQ API tested successfully.", "updated");
        return true;
    }

    private static function update($data) {
        $errs = UnloqConfig::set(array(
            'theme' => $data['theme'],
            'login_type' => $data['login_type']
        ));
        if ($errs) {
            foreach ($errs as $error) {
                add_settings_error("unloq_settings", null, $error->message);
            }
            return false;
        }
        UnloqConfig::save();
        add_settings_error('unloq_settings', null, "UNLOQ settings successfully saved.", "updated");
        return true;
    }
}

?>