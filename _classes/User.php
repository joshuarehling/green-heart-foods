<?php

class User {
    
    private $database_connection = null;
    public $errors = array();
    public $messages = array();
    public function __construct() {
        require_once("../_classes/Database.php");
    }
    
    /* Login for Clients TODO - Combine the login functions */

    public function login() {

        $redirect_path = WEB_ROOT.'/login/';
        // switch ($_POST['context']) {
        //     case 'green_heart_foods':
        //         $redirect_path = WEB_ROOT.'/login/';
        //         break;
        //     case 'client':
        //         $redirect_path = WEB_ROOT.'/login/';
        //         break;
        // } 
        if (!empty($_POST['user_name']) && !empty($_POST['password'])) {
            $database = new Database();
            $database_connection = $database->connect();
            if ($database_connection) {
                $arguments = array(
                    $_POST['user_name'],
                    $_POST['password']
                );
                $query = $database_connection->prepare("SELECT * FROM users LEFT JOIN user_types ON users.user_type_id=user_types.user_type_id WHERE user_name = ? AND password = ?");
                $query->execute($arguments);
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                if(count($result) === 1) {
                    $client_id = $result[0]['client_id'];
                    $_SESSION['user_id'] = $result[0]['user_id'];
                    $_SESSION['user_name'] = $result[0]['user_name'];
                    $_SESSION['user_type_id'] = $result[0]['user_type_id'];
                    $_SESSION['user_display_name'] = $result[0]['user_display_name'];
                    switch($result[0]['user_type_id']) {
                        case 1:
                            $_SESSION['green_heart_foods_logged_in'] = 1;
                            $forward_url = "../admin/clients.php";
                            break;
                        case 2:
                            $_SESSION['client_admin_logged_in'] = 1;
                            $forward_url = "../clients/yearly-menu.php?client-id=$client_id";
                            break;
                        case 3:
                            $_SESSION['client_general_logged_in'] = 1;
                            $forward_url = "../clients/yearly-menu.php?client-id=$client_id";
                            break;
                    }
                    if($_POST['forward_url'] !== "") {
                        $forward_url = $_POST['forward_url'];
                    }
                    header("Location: $forward_url");
                    Messages::add('Logged In');
                } else {
                    Messages::add('Sorry, there was an error with that user name/password combination.');
                    header('Location: '.$redirect_path);
                    exit();
                }
            } else {
                Messages::add('Sorry, the was an error connecting to the database.'); 
                header('Location: '.$redirect_path);
                exit();
            }
        } else {
            Messages::add('Either the user name or password is missing, please try again.'); 
            header('Location: '.$redirect_path);
            exit();
        }
    }


    // Get users associated with client 


    public function get_client_users($client_id) {
        $database = new Database();
        $database_connection = $database->connect();
        if ($database_connection) {
            $arguments = array(
                $client_id
            );
            $query = $database_connection->prepare("SELECT * FROM users WHERE client_id = ?");
            $query->execute($arguments);
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if(count($result) > 1) {
                return $result;
            } else {
                Messages::add('Sorry, the was an error connecting to the database.'); 
                // header('Location: '.$redirect_path); TODO - Where should these go?
            }
        } else {
            Messages::add('Error, there was a problem connection to the database.'); 
            // header('Location: '.$redirect_path); TODO - Where should these go?
        }
    }

    // public function login_client() {
    //     if (!empty($_POST['user_name']) && !empty($_POST['password'])) {
    //         $database = new Database();
    //         $database_connection = $database->connect();
    //         if ($database_connection) {
    //             $arguments = array(
    //                 $_POST['user_name'],
    //                 $_POST['password'],
    //                 2,
    //                 3
    //             );
    //             $query = $database_connection->prepare("SELECT * FROM users WHERE user_name = ? AND password = ? AND (user_type_id = ? OR user_type_id = ?)");
    //             $query->execute($arguments);
    //             $result = $query->fetchAll(PDO::FETCH_ASSOC);
    //             if(count($result) === 1) {
    //                 $_SESSION['user_id'] = $result[0]['user_id'];
    //                 $_SESSION['user_name'] = $result[0]['user_name'];
    //                 $_SESSION['client_logged_in'] = 1;
    //                 Messages::add('Logged In');
    //                 header('Location: ../admin/clients.php');
    //             } else {
    //                 Messages::add('Sorry, there was an error with that user name/password combination.');
    //                 header('Location: ../clients/login.php');
    //             }
    //         } else {
    //             Messages::add('Sorry, the was an error connecting to the database.'); 
    //             header('Location: ../admin/login.php');
    //         }
    //     } else {
    //         Messages::add('Either the user name or password is missing, please try again.'); 
    //         header('Location: ../admin/login.php');
    //     }
    // }

    
    /* Login Green Heart Food Users */

    
    // public function login_green_heart_foods() {
    //     if (!empty($_POST['user_name']) && !empty($_POST['password'])) {
    //         $database = new Database();
    //         $database_connection = $database->connect();
    //         if ($database_connection) {
    //             $user_name = $_POST['user_name'];
    //             $password = $_POST['password'];
    //             $arguments = array(
    //                 $user_name,
    //                 $password,
    //                 1
    //             );
    //             $query = $database_connection->prepare("SELECT * FROM users WHERE user_name = ? AND password = ? AND user_type_id = ?");
    //             $query->execute($arguments);
    //             $result = $query->fetchAll(PDO::FETCH_ASSOC);
    //             if(count($result) === 1) {
    //                 $_SESSION['user_id'] = $result[0]['user_id'];
    //                 $_SESSION['user_name'] = $result[0]['user_name'];
    //                 $_SESSION['green_heart_foods_logged_in'] = 1;
    //                 Messages::add('Logged In');
    //                 header('Location: ../admin/clients.php');
    //             } else {
    //                 Messages::add('Sorry, there was an error with that user name/password combination.');
    //                 header('Location: ../admin/login.php');
    //             }
    //         } else {
    //             Messages::add('Sorry, the was an error connecting to the database.'); 
    //             header('Location: ../admin/login.php');
    //         }
    //     } else {
    //         Messages::add('Either the user name or password is missing, please try again.'); 
    //         header('Location: ../admin/login.php');
    //     }
    // }
    
    
    /* Log out */

    
    public function logout() {
        $_SESSION = array();
        session_destroy();
        Messages::add('You have been logged out.'); 
        header('Location: '.WEB_ROOT.'/login/');
    } 

    /* Check for Green Heart Food logged in status */
    
    public function get_green_heart_foods_access_level() {
        if (isset($_SESSION['green_heart_foods_logged_in']) AND $_SESSION['green_heart_foods_logged_in'] == 1) {
            return 'green_heart_foods_admin';
        } else {
            header('Location: '.WEB_ROOT.'/login/');
        }
    }

    /* Check for client logged in status */
    
    public function get_client_access_level ($forward_url) {
        if (isset($_SESSION['client_admin_logged_in']) AND $_SESSION['client_admin_logged_in'] == 1) {
            return 'client_admin';
        } else if (isset($_SESSION['client_general_logged_in']) AND $_SESSION['client_general_logged_in'] == 1) {
            return 'client_general';
        } else {
            if($forward_url !== "") {
                header("Location: ".WEB_ROOT."/login/index.php?forward-url=$forward_url");
            } else {
                header("Location: ".WEB_ROOT."/login/");
            }
            
        }
    }

    // public function get_user_display_name() {
    //     if (isset($_SESSION['user_display_name'])) {
    //         return $_SESSION['user_display_name'];
    //     } else {
    //         return null;
    //     }
    // }

    /* Get Login Form */

    public function get_login_form($context, $forward_url) {
        return <<<HTML
            <h1>Log in to View Menus</h1>
            <form method="post" action="../_actions/login.php">
                <input id="login_input_username" class="login_input" type="text" name="user_name" value="" placeholder="username" required />
                <input id="login_input_password" class="login_input" type="password" name="password" autocomplete="off" value="" placeholder="password" required />
                <input type="hidden" name="context" value="$context" />
                <input type="hidden" name="forward_url" value="$forward_url" />
                <input class="login_button" type="submit"  name="login" value="Log in" />
            </form>
            <p class="login_note">
                Having trouble? <br />Please contact your us at <a href="tel:+4158008910">415-800-8910</a><br />or <a href="mailto:info@greenheartfoods.com">info@greenheartfoods.com</a>
            </p>
HTML;
    }
}