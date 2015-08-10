<?php

/*
 Holds the UNLOQ configuration array, serializing it to the db and back.
 */
class UnloqConfig {
    private static $fields = array('api_key', 'api_secret', 'theme', 'login_type', 'is_setup', 'app_linking');
    private static $instance = null;
    private $config;
    private $loaded = false;
    private $active = null;

    protected function __construct() {
        // We only load the configuration on-demand.
        $this->config = array();
    }

    private static function query() {
        $settings = get_option(UNLOQ_NS);
        if(is_string($settings) && trim($settings) != "") {
            $settings = unserialize($settings);
        }
        if(!is_array($settings)) {
            $settings = array();
        }
        self::$instance->config = $settings;
        self::$instance->loaded = true;
    }

    public static function isActive() {
        if(self::$instance->active == null) {
            $tmp = get_option("UNLOQ_ACTIVE");
            self::$instance->active = ($tmp == "true");
        }
        return self::$instance->active;


    }

    public static function isSetup() {
        return (self::get("is_setup") == "true");
    }

    public static function get($key, $default = null) {
        if(!self::$instance->loaded) {
            self::$instance->query();
        }
        if(isset(self::$instance->config[$key])) {
            return self::$instance->config[$key];
        }
        return $default;
    }

    public static function set($key, $val = null) {
        if(!self::$instance->loaded) {
            self::$instance->query();
        }
        if(is_array($key)) {
            $errs = array();
            foreach($key as $k => $v) {
                if(in_array($k, self::$fields)) {
                    $res = self::set($k, $v);
                    if($res) {
                        array_push($errs, $res);
                    }
                }
            }
            if(sizeof($errs) == 0) return null;
            return $errs;
        }
        $err = null;
        switch($key) {
            case "api_key":
                $err = self::$instance->validate_key($val);
                break;
            case "api_secret":
                $err = self::$instance->validate_secret($val);
                break;
            case "login_type":
                $err = self::$instance->validate_login($val);
                break;
            case "app_linking":
                break;
        }
        if($err) {
            return $err;
        }
        self::$instance->config[$key] = $val;
        return false;
    }

    private function validate_key($val) {
        if(!isset($val) || $val == "") {
            return new UnloqError("Please enter the API key", "api_key");
        }
        if(strlen($val) != 64) {
            return new UnloqError("The API key must be exactly 64 characters long", "api_key");
        }
        return null;
    }

    private function validate_secret($val) {
        if(!isset($val) || $val == "") {
            return new UnloqError("Please enter the API secret", "api_secret");
        }
        if(strlen($val) != 32) {
            return new UnloqError("The API secret must be exactly 32 characters long", "api_secret");
        }
        return null;
    }

    private function validate_login($val) {
        if($val === "UNLOQ" || $val === "UNLOQ_PASS") return null;
        return new UnloqError("The login type is not valid.", "login_type");
    }

    public static function save() {
        $serial = serialize(self::$instance->config);
        update_option(UNLOQ_NS, $serial);
    }

    public static function load() {
        if (!isset(self::$instance) || self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}

?>