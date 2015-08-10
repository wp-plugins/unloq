<?php

class UnloqSetup {
    public static function start() {
        UnloqSetup::register_hooks();
    }

    public static function activate_plugin() {
        // We add unloq_id and unloq_secret to the users table
        global $wpdb;
        $userTable = $wpdb->prefix . "users";
        try {
            $wpdb->suppress_errors = true;
            $wpdb->query("ALTER TABLE $userTable ADD unloq_id INT NULL DEFAULT NULL , ADD unloq_secret VARCHAR( 100 ) NULL DEFAULT NULL");
        } catch(Exception $e) {
            // we've already altered it.
        }
        $wpdb->suppress_errors = false;
        if(get_option("UNLOQ_ACTIVE") !== false) {
            update_option('UNLOQ_ACTIVE', 'true', true);
        } else {
            add_option('UNLOQ_ACTIVE', "true", null, true);
        }
        $old = get_option(UNLOQ_NS);
        if($old !== false) {
            if(substr($old, -1) == " ") {
                $old = substr($old, 0, strlen($old)-1);
            } else {
                $old .= " ";
            }
            update_option(UNLOQ_NS, $old, true);
        } else {
            add_option(UNLOQ_NS, "", null, true);
        }

    }

    public static function deactivate_plugin() {
        update_option('UNLOQ_ACTIVE', "false");
        $old = get_option(UNLOQ_NS);
        if($old !== false) {
            if(substr($old, -1) == " ") {
                $old = substr($old, 0, strlen($old)-1);
            } else {
                $old .= " ";
            }
            update_option(UNLOQ_NS, $old, false);
        } else {
            add_option(UNLOQ_NS, "", false);
        }
    }

    public static function uninstall_plugin() {
        // We drop the unloq_id and unloq_secret from the users table.
        global $wpdb;
        $userTable = $wpdb->prefix . "users";
        $wpdb->query("ALTER TABLE $userTable DROP unloq_id, DROP unloq_secret");
        delete_option(UNLOQ_NS);
        delete_option("UNLOQ_ACTIVE");
    }

    private function register_hooks() {
        register_activation_hook(UNLOQ_PATH . 'unloq.php', array('UnloqSetup', 'activate_plugin'));
        register_deactivation_hook(UNLOQ_PATH . 'unloq.php', array('UnloqSetup', 'deactivate_plugin'));
        register_uninstall_hook(UNLOQ_PATH . 'unloq.php', array('UnloqSetup', 'uninstall_plugin'));
    }
}

?>