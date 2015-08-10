<?php if (!class_exists('Unloq')) {

class Unloq {
    private static $instance = null;
    private function __construct() {
        $this->set_constants();
        if(UNLOQ_BASE_PLUGIN) {
            require_once(UNLOQ_PATH . '/inc/class.setup.php');
            UnloqSetup::start();
        }
        require_once(UNLOQ_PATH.'inc/class.util.php');
        require_once(UNLOQ_PATH.'inc/class.error.php');
        require_once(UNLOQ_PATH.'inc/class.config.php');
        require_once(UNLOQ_PATH.'inc/class.unloq-api.php');
        UnloqConfig::load();
        if(UnloqConfig::isActive()) {
            require_once(UNLOQ_PATH .'inc/class.uauth.php');
            new UnloqUAuth();
            UnloqUAuth::bind();
        }
    }

    private function set_constants() {
        if(!defined('UNLOQ_BASE_PLUGIN')) define('UNLOQ_BASE_PLUGIN', false);
        define('UNLOQ_VERSION', '1.0');
        define('UNLOQ_PATH', plugin_dir_path(__FILE__));
        define('UNLOQ_URL', plugin_dir_url(__FILE__));
        define('UNLOQ_ASSETS', UNLOQ_URL . 'assets/');
        define('UNLOQ_TEMPLATE_PATH', UNLOQ_PATH . 'templates/');
        define('UNLOQ_NS', 'wpunloq');
    }

    public static function start() {
        if (!isset(self::$instance) || self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }
}

} ?>