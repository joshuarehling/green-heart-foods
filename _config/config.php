<?php 

date_default_timezone_set('America/Los_Angeles');

// Turns off Magic Quotes on older version of PHP.

if (get_magic_quotes_gpc()) {
    $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
    while (list($key, $val) = each($process)) {
        foreach ($val as $k => $v) {
            unset($process[$key][$k]);
            if (is_array($v)) {
                $process[$key][stripslashes($k)] = $v;
                $process[] = &$process[$key][stripslashes($k)];
            } else {
                $process[$key][stripslashes($k)] = stripslashes($v);
            }
        }
    }
    unset($process);
}

switch ($_SERVER['HTTP_HOST']) {
    case 'localhost':
    case 'localhost:8888':
        define('SERVER_ROOT', $_SERVER['DOCUMENT_ROOT'].'/menu-manager');
        define('WEB_ROOT', '/menu-manager');
        break;
    case 'clients.greenheartfoods.com':
        // define('SERVER_ROOT', $_SERVER['DOCUMENT_ROOT']."/clients");
        define('SERVER_ROOT', $_SERVER['DOCUMENT_ROOT']);
        define('WEB_ROOT', '');
        break;
    case 'www.previewmywebsitenow.com':
    case 'previewmywebsitenow.com':
        define('SERVER_ROOT', $_SERVER['DOCUMENT_ROOT']."/clients");
        define('WEB_ROOT', '');
        break;
    default:
        die("Server path error.");
        break;
}

define('GREEN_HEART_FOODS_ADMIN_EMAIL', 'orders@greenheartfoods.com');
//define('GREEN_HEART_FOODS_ADMIN_EMAIL', 'admin@greenheartfoods.com');
// define('GREEN_HEART_FOODS_ADMIN_EMAIL', 'josh@seven-seventeen.com');
define('ALLERGY_ALERT_ARRAY', 'contains_nuts, contains_soy, contains_shellfish, contains_nightshades, contains_alcohol, contains_eggs, contains_gluten, contains_dairy');