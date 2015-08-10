<?php

/*
 * This handles the login form and register page. If UNLOQ is activated, we will capture
 * the login page and fight it.
 * */

class UnloqLogin
{
    private $type;
    private $theme;
    private $isOnLoginForm = false;

    public function __construct() {
        if (!UnloqConfig::isActive()) {
            return;
        }
        $this->type = UnloqConfig::get('login_type', "UNLOQ_PASS");
        $this->theme = UnloqConfig::get('theme', 'light');
    }

    public function init() {
        add_action("login_init", array($this, "requestStart"));
        add_action('login_form', array($this, "initForm"));
        add_action('login_enqueue_scripts', array($this, "initAssets"));
        add_action('login_body_class', array($this, "initClasses"));
    }

    /*
     * Called when the request starts.
     * */
    public function requestStart() {
        // IF only the UNLOQ login way is enabled, we block anything else.
        $action = strtolower(isset($_REQUEST['action']) ? $_REQUEST['action'] : 'login');
        if($action == "login" || $action == "logout") {
            if(isset($_REQUEST['redirect_to'])) {
                // We temporary save the redirect_to to the session.
                UnloqUtil::tempFlash("redirect_to", $_REQUEST["redirect_to"]);
            }
            // we place any errors we've got in the flash in the errors section.
            $flashes = UnloqUtil::flash(false);
            if (count($flashes) > 0) {
                add_filter('wp_login_errors', function ($errors) {
                    $flashes = UnloqUtil::flash();
                    foreach ($flashes as $err) {
                        if($err['type'] == 'error') {
                            $errors->add('unloq_error', $err['message']);
                        }
                    }
                    return $errors;
                });
            }
            return;
        }
        // Only when we're unloq-only, do we block everything
        if($this->type !== 'UNLOQ') return;
        switch ($action) {
            case "postpass":
            case "register":
                UnloqUtil::flash("In order to register to the site, please login with UNLOQ.");
                break;
            case "retrievepassword":
            case "lostpassword":
            case "resetpass":
            case "rp":
                UnloqUtil::flash("Password reset is currently disabled.");
                break;
            default:
                UnloqUtil::flash("This action has been disabled by the administrator", "error");
        }
        wp_redirect(wp_login_url());
        exit;
    }

    public function initAssets() {
        UnloqUtil::register_style('login');
    }

    public function initClasses($classes) {
        // If we're on the login page, we add classes to the body
        if (in_array("login-action-login", $classes)) {
            if ($this->type == "UNLOQ") {    // unloq-only
                array_push($classes, "unloq-only");
            }
            if ($this->type == "UNLOQ_PASS") {
                array_push($classes, "unloq-pass");
            }
        }
        return $classes;
    }

    public function initForm() {
        UnloqUtil::render('login', array('unloq_theme' => $this->theme, 'unloq_type' => $this->type, 'unloq_api_key' => UnloqConfig::get('api_key')));
    }
}

?>