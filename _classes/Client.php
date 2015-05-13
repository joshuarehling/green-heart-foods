<?php 

class Client {

	private $database_connection = null;

	public function __construct() {
		require_once("../_classes/Database.php");
        require_once("../_classes/Messages.php");
        require_once("../_classes/User.php");
        require_once("../_classes/Image.php");
        $this->image = new Image();
		$database = new Database();
		$this->database_connection = $database->connect();
	}

    public function get_client($client_id) {
        $arguments = [$client_id];
        $query = $this->database_connection->prepare("SELECT * FROM clients LEFT JOIN users ON clients.admin_user_id = users.user_id WHERE clients.client_id = ?");
        $query->execute($arguments);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        if(count($result) > 0) {
            return $result;
        } else {
            Messages::add("Sorry, there was an error. The client you requested was not found.");
            header('Location: '.WEB_ROOT.'/admin/clients.php');
        }
    }

    public function get_all_clients(){
        $query = $this->database_connection->prepare("SELECT * FROM clients");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        if(count($result) > 0) {
            return $result;
        } else {
            Messages::add("Sorry, there was an error. No clients were found.");
            header('Location: '.WEB_ROOT.'/admin/create-client.php');
        }
    }

    public function update_client() {
        $client_id = $_POST['client_id'];
        $arguments = [
            $_POST['admin_email'],
            $_POST['admin_password'],
            $client_id,
            2
        ];
        $query = $this->database_connection->prepare("UPDATE users SET user_name = ?, password = ? WHERE client_id = ? AND user_type_id = ?");
        $result = $query->execute($arguments);

        $arguments = [
            $_POST['general_username'],
            $_POST['general_password'],
            $client_id,
            3
        ];
        $query = $this->database_connection->prepare("UPDATE users SET user_name = ?, password = ? WHERE client_id = ? AND user_type_id = ?");
        $result = $query->execute($arguments);

        if(!isset($_POST['has_breakfast'])) $_POST['has_breakfast'] = 0;
        if(!isset($_POST['has_lunch'])) $_POST['has_lunch'] = 0;
        if(!isset($_POST['has_dinner'])) $_POST['has_dinner'] = 0;
        if(!isset($_POST['has_snack'])) $_POST['has_snack'] = 0;
        if(!isset($_POST['is_active'])) $_POST['is_active']= 0;

        if($_FILES['company_logo_large']['name'] != "") {
            $company_logo_large = $this->image->upload_image($_FILES, "company_logo_large");
        } else {
            $company_logo_large = $_POST['company_logo_large_original'];
        }

        if($_FILES['company_logo_small']['name'] != "") {
            $company_logo_small = $this->image->upload_image($_FILES, "company_logo_small");
        } else {
            $company_logo_small = $_POST['company_logo_small_original'];
        }

        $arguments = [
            $_POST['company_name'],
            $_POST['admin_name'],
            $_POST['meals_per_day'],
            $_POST['has_breakfast'],
            $_POST['has_lunch'],
            $_POST['has_dinner'],
            $_POST['has_snack'],
            $company_logo_large,
            $company_logo_small,
            $_POST['is_active'],
            $client_id
        ];
        $query = $this->database_connection->prepare("UPDATE clients SET company_name = ?, admin_name = ?, meals_per_day = ?, has_breakfast = ?, has_lunch = ?, has_dinner = ?, has_snack = ?, company_logo_large = ?, company_logo_small = ?, is_active = ? WHERE client_id = ?");
        $result = $query->execute($arguments);
        if($query->rowCount() === 1){
            Messages::add($_POST['company_name'].' has been updated.');
            header('Location: ../admin/clients.php');
            exit();
        }
    }

    
    /* Create Client */
	
    public function create_client() {
        foreach ($_POST as $key => $value) {
            if ($value === '') {
				Messages::add("Please be sure all fields are complete and try again.");
                header('Location: '.WEB_ROOT.'/admin/create-client.php');
                exit();
            }
        }
        $company_logo_large = $this->image->upload_image($_FILES, "company_logo_large");
        $company_logo_small = $this->image->upload_image($_FILES, "company_logo_small"); 
	    if ($company_logo_small && $company_logo_large) {
            if(!isset($_POST['has_breakfast'])) $_POST['has_breakfast'] = 0;
            if(!isset($_POST['has_lunch'])) $_POST['has_lunch'] = 0;
            if(!isset($_POST['has_dinner'])) $_POST['has_dinner'] = 0;
            if(!isset($_POST['has_snack'])) $_POST['has_snack'] = 0;
            if(!isset($_POST['is_active'])) $_POST['is_active']= 0;
            $arguments = array(
                $_POST['company_name'],
                $company_logo_large,
                $company_logo_small,
                $_POST['admin_name'],
                $_POST['meals_per_day'],
                $_POST['has_breakfast'],
                $_POST['has_lunch'],
                $_POST['has_dinner'],
                $_POST['has_snack'],
                $_POST['is_active']
            );
            $query = $this->database_connection->prepare("INSERT INTO clients (company_name, company_logo_large, company_logo_small, admin_name, meals_per_day, has_breakfast, has_lunch, has_dinner, has_snack, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $query->execute($arguments);
            $client_id = $this->database_connection->lastInsertId();
            
            if($query->rowCount() === 1){

                // Admin user arguments and query

                $arguments = [
                    $client_id,
                    2,
                    $_POST['admin_email'],
                    $_POST['admin_password'],
                ];
                $query = $this->database_connection->prepare("INSERT INTO users (client_id, user_type_id, user_name, password) VALUES (?, ?, ?, ?)");
                $admin_user_result = $query->execute($arguments);

                // General user arguments and query

                $arguments = [
                    $client_id,
                    3,
                    $_POST['general_username'],
                    $_POST['general_password'],
                ];
                $query = $this->database_connection->prepare("INSERT INTO users (client_id, user_type_id, user_name, password) VALUES (?, ?, ?, ?)");
                $general_user_result = $query->execute($arguments);

                if($admin_user_result && $general_user_result) {
                    Messages::add($_POST['company_name'].' has been added.');
                    header('Location: ../admin/clients.php');
                    exit();
                } else {
                    Messages::add('Error, there was a problem adding either the client admin or general user');
                    header('Location: ../admin/clients.php');
                    exit();
                }
            }
        } else {
            Messages::add('Sorry, there was a problem uploading the images. The client has not been created');
            header('Location: ../admin/clients.php');
            exit();
        }
    }


    /* 
    
    get_client_form()
    returns the html for the client form
    Putting it here allows us to use the same HTML for both create and edit

    */


    public function get_client_form($client_id = null) {

        // If client_id is null, the form is used for creating. 
        // Otherwise, it's for editing. 
        // WEB_ROOT constant set as variable for easy use in heredoc (<<<) below.

        $web_root = WEB_ROOT;
        if ($client_id !== null) {
            $user = new User();
            $client = $this->get_client($client_id);
            $client_users = $user->get_client_users($client_id);
            for($i=0; $i<count($client_users); $i++) {
                switch ($client_users[$i]['user_type_id']) {
                    case '2':
                        $admin_email = $client_users[$i]['user_name'];
                        $admin_password = $client_users[$i]['password'];
                        break;
                    case '3':
                        $general_username = $client_users[$i]['user_name'];
                        $general_password = $client_users[$i]['password'];
                        break;
                }
            }
            $company_logo_large = $client[0]['company_logo_large'];
            $company_logo_small = $client[0]['company_logo_small'];
            $company_name = $client[0]['company_name'];
            $admin_name = $client[0]['admin_name'];
            $admin_email = $admin_email;
            $admin_password = $admin_password;
            $general_username = $general_username;
            $general_password = $general_password;
            $meals_per_day = $client[0]['meals_per_day'];
            $has_breakfast = $client[0]['has_breakfast'];
            $has_lunch = $client[0]['has_lunch'];
            $has_dinner = $client[0]['has_dinner'];
            $has_snack = $client[0]['has_snack'];
            $is_active = $client[0]['is_active'];
            $client[0]['has_breakfast'] == 1 ? $has_breakfast_checked = "checked" : $has_breakfast_checked = "";
            $client[0]['has_lunch'] == 1 ? $has_lunch_checked = "checked" : $has_lunch_checked = "";
            $client[0]['has_dinner'] == 1 ? $has_dinner_checked = "checked" : $has_dinner_checked = "";
            $client[0]['has_snack'] == 1 ? $has_snack_checked = "checked" : $has_snack_checked = "";
            $client[0]['is_active'] == 1 ? $is_active_checked = "checked" : $is_active_checked = "";
            $form_action = '../_actions/update-client.php';
            $current_company_logo_large = "<img src='".WEB_ROOT."/_uploads/".$company_logo_large."' />";
            $current_company_logo_small = "<img src='".WEB_ROOT."/_uploads/".$company_logo_small."' />";
        } else {
            $company_logo_large = "null";
            $company_logo_small = "null";
            $company_name = "";
            $admin_name = "";
            $admin_email = "";
            $admin_password = "";
            $general_username = "";
            $general_password = "";
            $meals_per_day = "";
            $has_breakfast = "";
            $has_lunch = "";
            $has_dinner = "";
            $has_snack = "";
            $is_active = "";
            $has_breakfast_checked = "";
            $has_lunch_checked = "";
            $has_dinner_checked = "";
            $has_snack_checked = "";
            $is_active_checked = "";
            $form_action = '../_actions/create-client.php';
            $current_company_logo_large = "";
            $current_company_logo_small = "";
            $client_id = 0;
        }

        return <<<HTML

        <form method="post" action="$form_action" enctype="multipart/form-data">
            <fieldset class="header_logo">
                <label>$current_company_logo_large</label>
                <input name='company_logo_large' type='file' value='$company_logo_large' />
            </fieldset>
            
            <fieldset class="grid_logo">
                <label>$current_company_logo_small</label>
                <input name='company_logo_small' type='file' value='$company_logo_small' />
            </fieldset>

            <fieldset>
                <label>Client Name</label>
                <input name="company_name" type='text' value="$company_name" placeholder="Enter Name" />
            </fieldset>

            <fieldset>
                <label>Admin Info</label>
                
                <label class="secondary_label">Admin Name</label>
                <input name='admin_name' type='text' value='$admin_name' placeholder=""/>
                
                <label class="secondary_label">Admin Email</label>
                <input name='admin_email' type='text' value='$admin_email' placeholder=""/>
                
                <label class="secondary_label">Password</label>
                <input name='admin_password' type='text' value='$admin_password' placeholder=""/>
            </fieldset>

            <fieldset>
                <label>General Info</label>
                
                <label class="secondary_label">Login Name</label>
                <input name='general_username' type='text' value='$general_username' placeholder=""/>
                
                <label class="secondary_label">Log In Password</label>
                <input name='general_password' type='text' value='$general_password' placeholder=""/>
            </fieldset>

            <fieldset>
                <label>Number of Items Per Meal</label>
                <input name='meals_per_day' type='text' value='$meals_per_day' placeholder="Enter Number"/>
            </fieldset>

            <fieldset class="checkbox_container">
				<label>Meals</label>
				<ul>
					<li><span class="move_box"><input class="styled" name='has_breakfast' type='checkbox' $has_breakfast_checked value="1" /></span><label class="box_label">Breakfast</label></li>
					<li><span class="move_box"><input class="styled" name='has_lunch' type='checkbox' $has_lunch_checked value="1" /></span><label class="box_label">Lunch</label></li>
					<li><span class="move_box"><input class="styled" name='has_dinner' type='checkbox' $has_dinner_checked value="1" /></span><label class="box_label">Dinner</label></li>
					<li><span class="move_box"><input class="styled" name='has_snack' type='checkbox' $has_snack_checked value="1" /></span><label class="box_label">Snacks</label></li>
				</ul>
			</fieldset>

            <fieldset class="checkbox_container no_rule">
                <ul>
					<li class='active_client'><span class="move_box"><input class="styled" name='is_active' type='checkbox' $is_active_checked value="1" /></span><label class="box_label">Active Client</label></li>
				</ul>
            </fieldset>

			<div class="button_container">
            <input type="hidden" name="company_logo_large_original" value="$company_logo_large" />
            <input type="hidden" name="company_logo_small_original" value="$company_logo_small" />
            <input type="hidden" name="client_id" value="$client_id" />
            <a href="$web_root/admin/clients.php" class="page_button">Cancel</a>
            <input  class="page_button" type='submit' value='Submit'>
			</div>

        </form>
HTML;
    }

    // TODO - Figure out unique id/system for weeks / week date ranges.

    public function get_weekly_menu($client_id) {
        $arguments = array(
            $client_id
        );
        $query = $this->database_connection->prepare("SELECT * FROM menu_items WHERE client_id = ?");
        $query->execute($arguments);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        if(count($result) > 0) {
            return $result;
        } else {
            echo "Sorry, no menu for this week."; //TODO - Send as error.
        }
    }

    /* Get number of meals by client_id */

    public function get_meals_per_day($client_id) {
        $arguments = array(
            $client_id
        );
        $query = $this->database_connection->prepare("SELECT meals_per_day FROM clients WHERE client_id = ?");
        $query->execute($arguments);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        if(count($result) > 0) {
            return $result;
        } else {
            echo "Sorry, there was an error. No meals found."; //TODO - Send as error.
        }
    }
}