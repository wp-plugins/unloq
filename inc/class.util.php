<?php

class UnloqUtil
{
    const UNLOQ_FLASH_KEY = "wpunloq_sess";

    /* Temporary store the key/value in the session, for exactly 1 request cycle. */
    public static function tempFlash($key = null, $value = null) {
        if(!isset($_SESSION)) {
            return false;
        }
        $sessKey = self::UNLOQ_FLASH_KEY . "_temp";
        if($value === null) {   // we return the key value.
            if(!isset($_SESSION[$sessKey]) || !isset($_SESSION[$sessKey][$key])) return null;
            $tmp = $_SESSION[$sessKey][$key];
            unset($_SESSION[$sessKey][$key]);
            if(count($_SESSION[$sessKey]) == 0) {
                unset($_SESSION[$sessKey]);
            }
            return $tmp;
        }
        if(!isset($_SESSION[$sessKey])) {
            $_SESSION[$sessKey] = array();
        }
        $_SESSION[$sessKey][$key] = $value;
        return true;
    }

    /* Sets a flash message in the session */
    public static function flash($message = null, $type = 'error') {
        // IF no message, we retrieve all flashes.
        if ($message == null || $message == false) {
            if (!isset($_SESSION) || !isset($_SESSION[self::UNLOQ_FLASH_KEY])) {
                return array();
            }
            $tmp = $_SESSION[self::UNLOQ_FLASH_KEY];
            if ($message !== false) {
                unset($_SESSION[self::UNLOQ_FLASH_KEY]);
            }
            return $tmp;
        }
        if (!isset($_SESSION)) {
            return false;
        }
        $item = array('type' => $type, 'message' => $message);
        if (!isset($_SESSION[self::UNLOQ_FLASH_KEY])) {
            $_SESSION[self::UNLOQ_FLASH_KEY] = array();
        }
        array_push($_SESSION[self::UNLOQ_FLASH_KEY], $item);
        return true;
    }

    public static function isGet() {
        return ($_SERVER['REQUEST_METHOD'] === "GET");
    }

    public static function isPost() {
        return ($_SERVER['REQUEST_METHOD'] === "POST");
    }
    public static function isOptions() {
        return ($_SERVER['REQUEST_METHOD'] === "OPTIONS");
    }

    public static function query($key) {
        return (isset($_GET) && isset($_GET[$key]) ? $_GET[$key] : null);
    }

    public static function body($key = null) {
        if (!isset($key)) {
            return isset($_POST) ? $_POST : null;
        }
        return (isset($_POST) && isset($_POST[$key]) ? $_POST[$key] : null);
    }

    public static function pluginUrl($qs = null) {
        $admin = admin_url("admin.php?page=" . UNLOQ_NS);
        if (is_array($qs)) {
            $qs = http_build_query($qs);
            $admin .= "&" . $qs;
        }
        return $admin;
    }

    /*
     * Helper function, returns the full path of the given URL
     * */
    public static function getUrlPath($url) {
        $parsed = parse_url($url);
        if (!$parsed) {
            return "";
        }
        return $parsed['path'];
    }


    public static function image($name) {
        $url = UNLOQ_ASSETS . 'img/' . $name;
        return $url;
    }

    public static function register_style($name) {
        $url = UNLOQ_ASSETS . 'css/' . $name . '.css';
        $name = 'unloq-' . $name;
        if (!wp_style_is($name, 'registered')) {
            wp_register_style($name, $url, false);
        }
        if (!wp_style_is($name, 'enqueued')) {
            wp_enqueue_style($name);
        }
        return $name;
    }

    public static function register_js($name, $dep = null) {
        $url = UNLOQ_ASSETS . 'js/' . $name . '.js';
        $name = 'unloq-js-' . $name;
        if (!wp_script_is($name, 'registered')) {
            wp_register_script($name, $url, $dep);
        }
        if (!wp_script_is($name, 'enqueued')) {
            wp_enqueue_script($name);
        }
        return $name;
    }

    public static function render($template, $vars = null) {
        if ($vars) {
            extract($vars);
        }
        ob_start();
        require(UNLOQ_TEMPLATE_PATH . $template . '.tpl.php');
        echo ob_get_clean();
    }

    public static function verifyNonce($name) {
        if (!self::isPost()) {
            return false;
        }
        $val = self::body('_wpnonce');
        if (!$val) {
            return false;
        }
        if (!wp_verify_nonce($val, $name)) {
            return false;
        }
        return true;
    }

    /*
     * Generate a random string with the given length
     * */
    public static function generateString($length = 16) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

?>