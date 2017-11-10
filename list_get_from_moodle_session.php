<?php
/*
Login as admin in moodle and go to
Site administration/Server/Session handling
[Use database for session information] Must be unchecked.
[Cookie path] Must be default value. [/nls/]
*/
session_start();

function get_app_session_config() {
    $config = new stdClass();
    $config->id = session_id();
    $config->name = session_name();
    $config->handler = session_module_name();
    $config->path = session_save_path();

    return $config;
}

function get_moodle_session_config() {
    $CFG = new stdClass();
    $CFG->dataroot = '/home/nls/moodledata';
    $CFG->cookiename = 'MoodleSession';

    $config = new stdClass();
    $config->id = $_COOKIE[$CFG->cookiename];
    $config->name = $CFG->cookiename;
    $config->handler = 'files';
    $config->path = $CFG->dataroot . '/sessions';

    return $config;
}

function load_session($session_config) {
    session_write_close();
    session_destroy();
    session_id($session_config->id);
    session_name($session_config->name);
    session_module_name($session_config->name);
    session_save_path($session_config->path);
    session_start();
}

function switch_to_moodle_session() {
    global $MOODLE_SESSION_CONFIG;
    load_session($MOODLE_SESSION_CONFIG);
}

function switch_to_app_session() {
    global $APP_SESSION_CONFIG;
    load_session($APP_SESSION_CONFIG);
}

echo "<pre>========= SESSION CONFIG (APP) ==================</pre>\n";
$APP_SESSION_CONFIG = get_app_session_config();
var_dump($APP_SESSION_CONFIG);

echo "<pre>========= SESSION CONFIG (MOODLE) ===============</pre>\n";
$MOODLE_SESSION_CONFIG = get_moodle_session_config();
var_dump($MOODLE_SESSION_CONFIG);

echo "<pre>========= SESSION (APP) ===========================</pre>\n";

$_SESSION['some_variable'] = 'some_value';
$_SESSION['other_variable'] = 'other_value';
var_dump($_SESSION);

echo "<pre>========= SESSION (MOODLE) ===========================</pre>\n";

switch_to_moodle_session();
var_dump($_SESSION);

echo "<pre>========= DATA FROM MOODLE SESSION (USER) ========</pre>\n";

$MOODLE_USER = $_SESSION['USER']->username;
var_dump($MOODLE_USER);

echo "<pre>========= SESSION (APP AGAIN)=========================</pre>\n";

switch_to_app_session();
var_dump($_SESSION);

echo "<pre>========= DATA FROM APP VARIABLE (MOODLE_USER) ========</pre>\n";

$_SESSION['user_name'] = $MOODLE_USER;
var_export($_SESSION);

?>

<!DOCTYPE html>
<html>
<body>

</body>
</html>
