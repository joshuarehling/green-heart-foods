<?php

class Menu {
	
	private $database_connection = null;
	
	public function __construct() {
		require_once("../_classes/Messages.php");
		require_once("../_classes/Client.php");
		require_once("../_classes/Database.php");
		require_once("../_classes/Image.php");
		$database = new Database();
		$this->image = new Image();
		$this->database_connection = $database->connect();
	}

	public function like_menu_item($menu_item_id) {
		$arguments = array(
			$menu_item_id
		);
		$query = $this->database_connection->prepare("UPDATE menu_items SET like_count = like_count+1 WHERE menu_item_id = ?");
		$query->execute($arguments);
		echo $query->rowCount();
	}

	public function get_meal_types() {
		$query = $this->database_connection->prepare("SELECT * FROM meals");
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		if(count($result) > 0) {
			return $result;
		} else {
			echo "Sorry, there was an error. Could not find any meal tyoes."; // TODO - Send as error.
			exit();
		}
	}

	public function get_meal_types_by_id($meal_id) {
		$arguments = array(
			$meal_id
		);
		$query = $this->database_connection->prepare("SELECT meal_name FROM meals WHERE meal_id = ?");
		$query->execute($arguments);
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		if(count($result) > 0) {
			return $result;
		} else {
			echo "Sorry, there was an error. Could not find any meal tyoes."; // TODO - Send as error.
			exit();
		}
	}

	public function get_weekly_menu($client_id, $start_date, $context) {
		$end_date = date('Y-m-d', strtotime($start_date.' +6 days'));
		$arguments = array(
			$client_id,
			$start_date,
			$end_date
		);
		if ($context == 'green_heart_foods_admin') {
			$query = $this->database_connection->prepare("SELECT * FROM menu_items LEFT JOIN meals ON menu_items.meal_id = meals.meal_id LEFT JOIN item_status ON menu_items.item_status_id = item_status.item_status_id WHERE client_id = ? AND (service_date BETWEEN ? AND ?) ORDER BY service_date ASC, meals.meal_id ASC, menu_item_id ASC");
		} else {
			$query = $this->database_connection->prepare("SELECT * FROM menu_items LEFT JOIN meals ON menu_items.meal_id = meals.meal_id LEFT JOIN item_status ON menu_items.item_status_id = item_status.item_status_id WHERE client_id = ? AND (service_date BETWEEN ? AND ?) AND (item_status.item_status_id = 2 OR item_status.item_status_id = 3) ORDER BY service_date ASC, meals.meal_id ASC, menu_item_id ASC");
		}
		$query->execute($arguments);
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		if(count($result) > 0) {
			return $result;
		}
	}

	public function get_all_bites() {
		$query = $this->database_connection->prepare("SELECT * FROM bites LEFT JOIN bite_groups ON bites.bite_group_id = bite_groups.bite_group_id");
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		if(count($result) > 0) {
			return $result;
		}
	}

	public function get_all_bites_and_groups(){
		$query = $this->database_connection->prepare("SELECT * FROM bite_groups");
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		if(count($result) > 0) {
			return $result;
		}
	}

	public function get_all_bites_by_group_id($bite_group_id) {
		$arguments = array(
			$bite_group_id
		);
		$query = $this->database_connection->prepare("SELECT * FROM bites WHERE bites.bite_group_id = ?");
		$query->execute($arguments);
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		if(count($result) > 0) {
			return $result;
		}
	}

	public function get_bite_by_id($bite_id) {
		$arguments = array(
			$bite_id
		);
		$query = $this->database_connection->prepare("SELECT * FROM bites LEFT JOIN bite_groups ON bites.bite_group_id = bite_groups.bite_group_id WHERE bites.bite_id = ?");
		$query->execute($arguments);
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		if(count($result) > 0) {
			return $result;
		}
	}

	public function get_weekly_menu_by_meal($client_id, $start_date, $context, $meal_id) {
		$end_date = date('Y-m-d', strtotime($start_date.' +6 days'));
		$arguments = array(
			$client_id,
			$start_date,
			$end_date, 
			$meal_id
		);
		if ($context == 'green_heart_foods_admin') {
			$query = $this->database_connection->prepare("SELECT * FROM menu_items LEFT JOIN meals ON menu_items.meal_id = meals.meal_id LEFT JOIN item_status ON menu_items.item_status_id = item_status.item_status_id LEFT JOIN servers ON menu_items.server_id = servers.server_id WHERE client_id = ? AND (service_date BETWEEN ? AND ?) AND meals.meal_id = ? ORDER BY service_date ASC, meals.meal_id ASC, menu_item_id ASC");
		} else {
			$query = $this->database_connection->prepare("SELECT * FROM menu_items LEFT JOIN meals ON menu_items.meal_id = meals.meal_id LEFT JOIN item_status ON menu_items.item_status_id = item_status.item_status_id LEFT JOIN servers ON menu_items.server_id = servers.server_id WHERE client_id = ? AND (service_date BETWEEN ? AND ?) AND (item_status.item_status_id = 2 OR item_status.item_status_id = 3) AND meals.meal_id = ? ORDER BY service_date ASC, meals.meal_id ASC, menu_item_id ASC");
		}
		$query->execute($arguments);
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		if(count($result) > 0) {
			return $result;
		}
	}

	public function get_daily_menu($client_id, $service_date, $meal_id) {
		$arguments = array(
			$client_id,
			$service_date,
			$meal_id
		);
		if($meal_id == 5){
			$query = $this->database_connection->prepare("SELECT * FROM menu_items LEFT JOIN servers ON menu_items.server_id = servers.server_id LEFT JOIN meals ON menu_items.meal_id = meals.meal_id LEFT JOIN clients ON menu_items.client_id = clients.client_id LEFT JOIN bites on menu_items.bite_id = bites.bite_id LEFT JOIN bite_groups on bites.bite_group_id = bite_groups.bite_group_id WHERE menu_items.client_id = ? AND menu_items.service_date = ? AND menu_items.meal_id = ? ORDER BY bites.bite_group_id");
		} else {
			$query = $this->database_connection->prepare("SELECT * FROM menu_items LEFT JOIN servers ON menu_items.server_id = servers.server_id LEFT JOIN meals ON menu_items.meal_id = meals.meal_id LEFT JOIN clients ON menu_items.client_id = clients.client_id WHERE menu_items.client_id = ? AND menu_items.service_date = ? AND menu_items.meal_id = ?");	
		}
		
		$query->execute($arguments);
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		if(count($result) > 0) {
			return $result;
		}
	}

	public function get_yearly_menus($client_id, $menu_year, $context) {
		$menu_date_minimum = $menu_year."-01-01";
		$menu_date_maximum = $menu_year."-12-31";
		$arguments = array(
			$client_id,
			$menu_date_minimum,
			$menu_date_maximum
		);
		if ($context == 'green_heart_foods_admin') {
			$query = $this->database_connection->prepare(
				"SELECT * FROM menu_items 
				LEFT JOIN meals ON menu_items.meal_id = meals.meal_id
				LEFT JOIN servers ON menu_items.server_id = servers.server_id
				WHERE menu_items.client_id = ?
				AND menu_items.service_date >= ?
				AND menu_items.service_date <= ?
				ORDER BY menu_items.service_date DESC, menu_items.meal_id ASC"
			);
		} else {
			$query = $this->database_connection->prepare(
				"SELECT * FROM menu_items 
				LEFT JOIN meals ON menu_items.meal_id = meals.meal_id
				LEFT JOIN servers ON menu_items.server_id = servers.server_id
				LEFT JOIN item_status ON menu_items.item_status_id = item_status.item_status_id
				WHERE menu_items.client_id = ?
				AND menu_items.service_date >= ?
				AND menu_items.service_date <= ?
				AND (item_status.item_status_id = 2 OR item_status.item_status_id = 3)
				ORDER BY menu_items.service_date DESC, menu_items.meal_id ASC"
			);
		}
		$query->execute($arguments);
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		if(count($result) > 0) {
			return $result;
		}
	}

	public function add_blank_item_to_menu() {
		$service_date = $_POST['service_date'];
		$meal_id = $_POST['meal_id'];
		$client_id = $_POST['client_id'];
		$arguments = array(
			$service_date,
			$meal_id,
			$client_id,
			$_POST['server_id'],
			$_POST['item_status_id']
		);
		$query = $this->database_connection->prepare("INSERT INTO menu_items (service_date, meal_id, client_id, server_id, item_status_id) VALUES (?, ?, ?, ?, ?)");
		$result = $query->execute($arguments);
		if($query->rowCount() === 1){
			Messages::add('The menu item has been added');
			header("Location: ../admin/edit-daily-menu.php?client-id=$client_id&service-date=$service_date&meal-id=$meal_id");
		} else {
			echo "Sorry, there was a problem.";
		}
	}

	public function create_menu() {
		$service_date = $_POST['service_year'].'-'.$_POST['service_month'].'-'.$_POST['service_day'];
		$client_id = $_POST['client_id'];
		$meal_id = $_POST['meal_id'];
		$menu_image_path = $this->image->upload_image($_FILES, "menu_image");

		/* Check for duplicate meal/day combination */

		$arguments = array(
			$client_id,
			$service_date,
			$meal_id,
		);
		$query = $this->database_connection->prepare("SELECT * FROM menu_items WHERE client_id = ? AND service_date = ? AND meal_id = ?");
		$query->execute($arguments);
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		if(count($result) > 0) {
			Messages::add('Sorry, it looks like there is already a meal created for this day.');
			header("Location: ../admin/create-menu.php?client-id=$client_id");
			exit();
		}

		/* End check for duplicate meal/day combination */

		if($_POST['meal_id'] == 5) {
			for ($i=0; $i < $_POST['number_of_bites']; $i++) {
				$arguments = array(
					$service_date,
					$_POST['meal_id'],
					$_POST['client_id'],
					$_POST['server_id'],
					1,
					$_POST['bite_id'][$i],
					$_POST['bite_quantity'][$i]
				);
				$query = $this->database_connection->prepare("INSERT INTO menu_items (service_date, meal_id, client_id, server_id, item_status_id, bite_id, total_orders_for_item) VALUES (?, ?, ?, ?, ?, ?, ?)");
				$result = $query->execute($arguments);
			}
		} else {
			for ($i=0; $i <= $_POST['meals_per_day']; $i++) {
				if($_POST['menu_item_name'][$i] != "" ) {
					if(!isset($_POST['is_vegetarian'][$i]))         $_POST['is_vegetarian'][$i] = 0;
					if(!isset($_POST['is_vegan'][$i]))              $_POST['is_vegan'][$i] = 0;
					if(!isset($_POST['is_gluten_free'][$i]))        $_POST['is_gluten_free'][$i] = 0;
					if(!isset($_POST['is_whole_grain'][$i]))        $_POST['is_whole_grain'][$i] = 0;
					if(!isset($_POST['contains_nuts'][$i]))         $_POST['contains_nuts'][$i]= 0;
					if(!isset($_POST['contains_soy'][$i])) 			$_POST['contains_soy'][$i] = 0;
					if(!isset($_POST['contains_shellfish'][$i])) 	$_POST['contains_shellfish'][$i] = 0;
					if(!isset($_POST['contains_nightshades'][$i])) 	$_POST['contains_nightshades'][$i] = 0;
					if(!isset($_POST['contains_alcohol'][$i])) 		$_POST['contains_alcohol'][$i] = 0;
					if(!isset($_POST['contains_eggs'][$i])) 		$_POST['contains_eggs'][$i] = 0;
					if(!isset($_POST['contains_gluten'][$i])) 		$_POST['contains_gluten'][$i] = 0;
					if(!isset($_POST['contains_dairy'][$i])) 		$_POST['contains_dairy'][$i] = 0;
					$arguments = array(
						$service_date,
						$_POST['meal_id'],
						$_POST['client_id'],
						$_POST['server_id'],
						$_POST['item_status_id'],
						$menu_image_path,
						$_POST['meal_description'],
						$_POST['menu_item_name'][$i],
						$_POST['ingredients'][$i],
						$_POST['special_notes'][$i],
						$_POST['is_vegetarian'][$i],
						$_POST['is_vegan'][$i],
						$_POST['is_gluten_free'][$i],
						$_POST['is_whole_grain'][$i],
						$_POST['contains_nuts'][$i],
						$_POST['contains_soy'][$i],
						$_POST['contains_shellfish'][$i],
						$_POST['contains_nightshades'][$i],
						$_POST['contains_alcohol'][$i],
						$_POST['contains_eggs'][$i],
						$_POST['contains_gluten'][$i],
						$_POST['contains_dairy'][$i],
						$_POST['price_per_order'][$i],
						$_POST['servings_per_order'][$i],
						$_POST['total_orders_for_item'][$i],
					);
					$query = $this->database_connection->prepare("INSERT INTO menu_items (service_date, meal_id, client_id, server_id, item_status_id, menu_image_path, meal_description, menu_item_name, ingredients, special_notes, is_vegetarian, is_vegan, is_gluten_free, is_whole_grain, contains_nuts, contains_soy, contains_shellfish, contains_nightshades, contains_alcohol, contains_eggs, contains_gluten, contains_dairy, price_per_order, servings_per_order, total_orders_for_item) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
					$result = $query->execute($arguments);
				}
			}
		}

		
		if($query->rowCount() === 1){
			Messages::add('The menu has been created');
			header("Location: ../admin/daily-menu.php?client-id=$client_id&service-date=$service_date&meal-id=$meal_id");
		} else {
			echo "Sorry, there was a problem.";
		}
	}

	public function add_bite() {
		$bite_group_id = $_POST['bite_group_id'];
		$bite_image_name = $this->image->upload_image($_FILES, "bite_image_name");

		if(!isset($_POST['is_vegetarian'])) 		$_POST['is_vegetarian'] = 0;
		if(!isset($_POST['is_vegan'])) 				$_POST['is_vegan'] = 0;
		if(!isset($_POST['is_gluten_free'])) 		$_POST['is_gluten_free'] = 0;
		if(!isset($_POST['is_whole_grain'])) 		$_POST['is_whole_grain'] = 0;
		if(!isset($_POST['contains_nuts'])) 		$_POST['contains_nuts']= 0;
		if(!isset($_POST['contains_soy'])) 			$_POST['contains_soy'] = 0;
		if(!isset($_POST['contains_shellfish'])) 	$_POST['contains_shellfish'] = 0;
		if(!isset($_POST['contains_nightshades'])) 	$_POST['contains_nightshades'] = 0;
		if(!isset($_POST['contains_alcohol'])) 		$_POST['contains_alcohol'] = 0;
		if(!isset($_POST['contains_eggs'])) 		$_POST['contains_eggs'] = 0;
		if(!isset($_POST['contains_gluten'])) 		$_POST['contains_gluten'] = 0;
		if(!isset($_POST['contains_dairy'])) 		$_POST['contains_dairy'] = 0;
		$arguments = array(
			$bite_group_id,
			$_POST['bite_name'],
			$bite_image_name,
			$_POST['is_vegetarian'],
			$_POST['is_vegan'],
			$_POST['is_gluten_free'],
			$_POST['is_whole_grain'],
			$_POST['contains_nuts'],
			$_POST['contains_soy'],
			$_POST['contains_shellfish'],
			$_POST['contains_nightshades'],
			$_POST['contains_alcohol'],
			$_POST['contains_eggs'],
			$_POST['contains_gluten'],
			$_POST['contains_dairy'],
			$_POST['default_quantity']
		);
		$query = $this->database_connection->prepare("INSERT INTO bites (bite_group_id, bite_name, image_name, is_vegetarian, is_vegan, is_gluten_free, is_whole_grain, contains_nuts, contains_soy, contains_shellfish, contains_nightshades, contains_alcohol, contains_eggs, contains_gluten, contains_dairy, default_quantity) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$result = $query->execute($arguments);
		if($query->rowCount() === 1){
			Messages::add('The bite has been created');
			header("Location: ../admin/edit-bites.php");
		} else {
			echo "Sorry, there was a problem.";
		}
	}

	public function delete_bite($bite_id) {
		$arguments = array(
			$bite_id
		);
		$query = $this->database_connection->prepare("DELETE FROM bites WHERE bite_id = ?");
		$result = $query->execute($arguments);
		if($query->rowCount() === 1){
			Messages::add('The bite has been deleted');
			header("Location: ../admin/edit-bites.php");
		} else {
			echo "Sorry, there was a problem.";
		}
	}

	public function update_menu() {
		$service_date = $_POST['service_year'].'-'.$_POST['service_month'].'-'.$_POST['service_day'];
		$client_id = $_POST['client_id'];
		$meal_id = $_POST['meal_id'];
		$menu_item_id_array = $_POST['menu_item_id_array'];

		// echo "<pre>";
		// print_r($_POST);

		$number_of_menu_items = count($menu_item_id_array);
		for ($i=0; $i < $number_of_menu_items; $i++) { 
			// echo "<br>Loop: ".$i;
			// echo "<p>".$_POST['bite_quantity'][$i]."</p>";

			$menu_item_id = $menu_item_id_array[$i];
			if(!isset($_POST['is_vegetarian'][$i])) $_POST['is_vegetarian'][$i] = 0;
			if(!isset($_POST['is_vegan'][$i])) $_POST['is_vegan'][$i] = 0;
			if(!isset($_POST['is_gluten_free'][$i])) $_POST['is_gluten_free'][$i] = 0;
			if(!isset($_POST['is_whole_grain'][$i])) $_POST['is_whole_grain'][$i] = 0;
			if(!isset($_POST['contains_nuts'][$i])) $_POST['contains_nuts'][$i]= 0;
			if(!isset($_POST['contains_soy'][$i])) $_POST['contains_soy'][$i] = 0;
			if(!isset($_POST['contains_shellfish'][$i])) $_POST['contains_shellfish'][$i] = 0;
			if(!isset($_POST['contains_nightshades'][$i])) $_POST['contains_nightshades'][$i] = 0;
			if(!isset($_POST['contains_alcohol'][$i])) $_POST['contains_alcohol'][$i] = 0;
			if(!isset($_POST['contains_eggs'][$i])) $_POST['contains_eggs'][$i] = 0;
			if(!isset($_POST['contains_gluten'][$i])) $_POST['contains_gluten'][$i] = 0;
			if(!isset($_POST['contains_dairy'][$i])) $_POST['contains_dairy'][$i] = 0;
			if($_FILES['menu_image']['name'] != "") {
				$menu_image_path = $this->image->upload_image($_FILES, 'menu_image');
			} else {
				$menu_image_path = $_POST['menu_image_path_orginal'];
			}
			if($meal_id == 5) {
				$total_orders_for_item = $_POST['bite_quantity'][$i];
			} else {
				$total_orders_for_item = $_POST['total_orders_for_item'][$i];
			}
			$arguments = array(
				$_POST['meal_id'],
				$_POST['client_id'],
				$_POST['server_id'],
				$_POST['item_status_id'],
				$menu_image_path,
				$_POST['meal_description'],
				$_POST['menu_item_name'][$i],
				$service_date,
				$_POST['ingredients'][$i],
				$_POST['special_notes'][$i],
				$_POST['is_vegetarian'][$i],
				$_POST['is_vegan'][$i],
				$_POST['is_gluten_free'][$i],
				$_POST['is_whole_grain'][$i],
				$_POST['contains_nuts'][$i],
				$_POST['contains_soy'][$i],
				$_POST['contains_shellfish'][$i],
				$_POST['contains_nightshades'][$i],
				$_POST['contains_alcohol'][$i],
				$_POST['contains_eggs'][$i],
				$_POST['contains_gluten'][$i],
				$_POST['contains_dairy'][$i],
				$_POST['price_per_order'][$i],
				$_POST['servings_per_order'][$i],
				$total_orders_for_item,
				// $_POST['total_orders_for_item'][$i],
				$menu_item_id
			);
			// echo "<pre>";
			// print_r($arguments);
			$query = $this->database_connection->prepare("UPDATE menu_items SET 
				meal_id = ?, 
				client_id = ?, 
				server_id = ?, 
				item_status_id = ?, 
				menu_image_path = ?,
				meal_description = ?, 
				menu_item_name = ?, 
				service_date = ?, 
				ingredients = ?, 
				special_notes = ?, 
				is_vegetarian = ?, 
				is_vegan = ?, 
				is_gluten_free = ?, 
				is_whole_grain = ?, 
				contains_nuts = ?, 
				contains_soy = ?, 
				contains_shellfish = ?, 
				contains_nightshades = ?,
				contains_alcohol = ?,
				contains_eggs = ?,
				contains_gluten = ?,
				contains_dairy = ?,
				price_per_order = ?, 
				servings_per_order = ?, 
				total_orders_for_item = ?
				WHERE 
				menu_item_id = ?");
			$result = $query->execute($arguments);


			if($_POST['menu_item_name'][$i] == "" && $meal_id != 5) {
				$arguments = array(
					$menu_item_id
				);
				$query = $this->database_connection->prepare("DELETE FROM menu_items WHERE menu_item_id = ?"); 
				$result = $query->execute($arguments);
			}

			if($i == $number_of_menu_items-1) {
				Messages::add('The menu has been updated.');
				header("Location: ../admin/daily-menu.php?client-id=$client_id&service-date=$service_date&meal-id=$meal_id");
				exit();
			}
		}
	}

	public function update_bite() {
		$bite_id = $_POST['bite_id'];
		if(!isset($_POST['is_vegetarian'])) 		$_POST['is_vegetarian'] = 0;
		if(!isset($_POST['is_vegan'])) 				$_POST['is_vegan'] = 0;
		if(!isset($_POST['is_gluten_free'])) 		$_POST['is_gluten_free'] = 0;
		if(!isset($_POST['is_whole_grain'])) 		$_POST['is_whole_grain'] = 0;
		if(!isset($_POST['contains_nuts'])) 		$_POST['contains_nuts']= 0;
		if(!isset($_POST['contains_soy'])) 			$_POST['contains_soy'] = 0;
		if(!isset($_POST['contains_shellfish'])) 	$_POST['contains_shellfish'] = 0;
		if(!isset($_POST['contains_nightshades'])) 	$_POST['contains_nightshades'] = 0;
		if(!isset($_POST['contains_alcohol'])) 		$_POST['contains_alcohol'] = 0;
		if(!isset($_POST['contains_eggs'])) 		$_POST['contains_eggs'] = 0;
		if(!isset($_POST['contains_gluten'])) 		$_POST['contains_gluten'] = 0;
		if(!isset($_POST['contains_dairy'])) 		$_POST['contains_dairy'] = 0;
		if($_FILES['bite_image_name']['name'] != "") {
			$bite_image_name = $this->image->upload_image($_FILES, 'bite_image_name');
		} else {
			$bite_image_name = $_POST['bite_image_name_original'];
		}
		$arguments = array(
			$bite_image_name,
			$_POST['bite_name'],
			$_POST['is_vegetarian'],
			$_POST['is_vegan'],
			$_POST['is_gluten_free'],
			$_POST['is_whole_grain'],
			$_POST['contains_nuts'],
			$_POST['contains_soy'],
			$_POST['contains_shellfish'],
			$_POST['contains_nightshades'],
			$_POST['contains_alcohol'],
			$_POST['contains_eggs'],
			$_POST['contains_gluten'],
			$_POST['contains_dairy'],
			$_POST['default_quantity'],
			$bite_id
		);
		$query = $this->database_connection->prepare("UPDATE bites SET 
			image_name = ?, 
			bite_name = ?, 
			is_vegetarian = ?, 
			is_vegan = ?, 
			is_gluten_free = ?, 
			is_whole_grain = ?, 
			contains_nuts = ?, 
			contains_soy = ?, 
			contains_shellfish = ?, 
			contains_nightshades = ?,
			contains_alcohol = ?,
			contains_eggs = ?,
			contains_gluten = ?,
			contains_dairy = ?,
			default_quantity = ? 
			WHERE 
			bite_id = ?");
		$result = $query->execute($arguments);
		if($result) {
			Messages::add('The bite has been updated');
			header("Location: ../admin/edit-bites.php");
			exit();
		}
	}

	public function get_daily_menu_page($context) {
		$html = "";
		$result = $this->get_meal_types();
		$message = Messages::render();
		$meal_id = $_GET['meal-id'];
		$bites_mode = "non_bites";
		if($meal_id == 5){
			$bites_mode = "bites";
		}
		$html .= "<span class=$bites_mode>";	
		
		$selected = "";
		$client_id = $_GET['client-id'];
		$service_date = $_GET['service-date'];
		$weekday = date('l', strtotime($service_date));
		$web_root = WEB_ROOT;
		$server_image_style = "";
		$menu_image_style = "";
		if($context == 'green_heart_foods_admin') {
			$admin_or_client = 'admin';
		} else {
			$admin_or_client = 'clients';
		}
		if($meal_id == 5) {
			$show_hide = 'hidden';
		} else {
			$show_hide = 'show';
		}
		$html .= "<div class='page_header'>";
		$html .= "<ul>";
		if($context == 'green_heart_foods_admin') {
			$html .= "<li class='left'><a class='menu $show_hide' href='$web_root/admin/daily-menu-print-menu.php?client-id=$client_id&service-date=$service_date&meal-id=$meal_id'>Print Menu</a></li>";
			$html .= "<li><h2>".date('M d', strtotime($service_date))."</h2></li>";
			$html .= "<li class='right'><a class='placard $show_hide' href='$web_root/admin/daily-menu-print-placards.php?client-id=$client_id&service-date=$service_date&meal-id=$meal_id'>Print Placards</a></li>";
		} else {
			$html .= "<li class='left'><a class='menu' href='$web_root/clients/daily-menu-print-menu.php?client-id=$client_id&service-date=$service_date&meal-id=$meal_id'>Print Menu</a></li>";
			$html .= "<li><h2>".date('M d', strtotime($service_date))."</h2></li>";
			$html .= "<li class='right'><a class='placard'>&nbsp;</a></li>";			
		}
		$html .= "</ul>";
		$html .= "</div>";
		
		$html .= "<div class='date_and_meal'>";
		$html .= "<select data-client-id='$client_id' data-meal-id='$meal_id' data-service-date='$service_date' data-admin-or-client='$admin_or_client' class='meal-types'>";
		for($i=0; $i<count($result); $i++) {
			$meal_id_option = $result[$i]['meal_id'];
			if($meal_id === $meal_id_option) {
				$selected = 'selected';
			} else {
				$selected = '';
			}
			$meal_name = $result[$i]['meal_name'];
			$html .= $result[$i]['meal_name']."<br />";
			$html .= "<option $selected value='".$meal_id_option."'>$meal_name</option>";
		}
		$html .= '</select>';

		$result = $this->get_daily_menu($client_id, $service_date, $meal_id);
		$result_count = count($result);
		$menu_item_id_array = array();
		for($i=0; $i<$result_count; $i++) {
			array_push($menu_item_id_array, $result[$i]['menu_item_id']);
		}
		if($result_count > 0) {
			$server_image_path = WEB_ROOT.'/'.$result[0]['server_image_path'];
			$menu_image_path = WEB_ROOT.'/_uploads/'.$result[0]['menu_image_path'];
			$total_orders = 0;
			$total_servings = 0;
			$total_price = 0;
			$html .= '</div>';
			$html .= '<div class="server_and_meal_container">';
			$html .= 	"<p class='meal_description'>".$result[0]['meal_description']."</p>";
			$html .=    '<div class="server_and_meal">';
			$html .=        "<div class='server_information'>";
			$html .=    		"<img class='server_image' src='$server_image_path' />";
			$html .=            "<div class='name'>Hosted By ".$result[0]['server_first_name']."</div>";
			$html .=        "</div>";
			$html .=    "</div>";
			$html .= "</div>";
			$html .= "<form action='".WEB_ROOT."/_actions/approve-menu-from-client.php' method='post' enctype='application/x-www-form-urlencoded'>";
			if($meal_id == 5) {
				$previous_bite_group_id = NULL;
				for($i=0; $i<$result_count; $i++) {
					$current_bite_group_id = $result[$i]['bite_group_id'];
					if($current_bite_group_id != $previous_bite_group_id){
						$html .= "<div class='bite_group_container_outer'>";
						$html .= "<div class='bite_group_container'>";
						$html .= "<h2 class='bite_group_name'>".$result[$i]['bite_group_name']."</h2>";
						for($j=0; $j<$result_count; $j++) {
							if($result[$j]['bite_group_id'] == $result[$i]['bite_group_id']) {
								$bite_quantity = $result[$j]['total_orders_for_item'];
								$html .= "<div class='bite_container'>";
								$html .= "<img src='".WEB_ROOT."/_uploads/".$result[$j]['image_name']."'/>";
								$html .= "<p>".$result[$j]['bite_name']."</p>";
								$html .= $this->get_attributes_and_allergens($result[$i]);
								$html .= "</div>";
							}
						}
						$previous_bite_group_id = $current_bite_group_id;
						$html .= "</div>";
						$html .= "</div>";
					}
				}
			} else {
				for($i=0; $i<$result_count; $i++) {
					$menu_item_id = $result[$i]['menu_item_id'];
					$like_count = $result[$i]['like_count'];
					$order_quantity = $result[$i]['total_orders_for_item'];
					$price_per_order = $result[$i]['price_per_order'];
					$servings_per_order = $result[$i]['servings_per_order'];
					$special_requests = htmlspecialchars($result[$i]['special_requests'], ENT_QUOTES);
					$calculated_number_of_item_servings = $order_quantity*$servings_per_order;
					$total_item_price = $order_quantity*$price_per_order;
					$total_orders = $total_orders+$order_quantity;
					$total_servings = $total_servings+$calculated_number_of_item_servings;
					$total_price = $total_price+$total_item_price;
					if($like_count > 0) {
						$like_heart_class = 'liked';
						$like_heart_image = "<img src='$web_root/_images/ui/favorite_on.png' />";
					} else {
						$like_heart_class = '';
						$like_heart_image = "<img src='$web_root/_images/ui/favorite_off.png' />";
					}
					$html .= "<div data-increment-id='$i' class='menu_item_container menu-item menu-item-$i'>";
					$html .= "<div class='left_and_right_column'>";
					$html .= "<div data-menu-item-id='$menu_item_id' class='like-heart $like_heart_class'><p class='number_of_likes'>LIKE</p></div>";
					$html .= "<div class='right_column'>";
					$html .= "<p class='dish_name'>".$result[$i]['menu_item_name'].'</p>';
					if($result[$i]['ingredients'] != "") {
						$html .= "<p class='ingredients'>".$result[$i]['ingredients'].'</p>';	
					}	
					$html .= $this->get_attributes_and_allergens($result[$i]);
					$html .= "</div>"; // Ends right column
					$html .= "</div>"; // Ends left_and_right_column
					$html .= "</div>"; // Ends menu-item
				}
			}
			if($context != 'client_general') {
				$html .= "<div class='button_container'>";
				$html .=    "<p><span class='total_orders_for_menu'>$total_orders</span> Orders <span class='total_served_for_item_serves'>Serves</span> <span class='total_served_for_menu'>$total_servings</span> <span class='total_served_for_item_serves'>=</span> <span class='total_cost_for_menu'>$$total_price</span></p>";
				if($context == 'client_admin') {
					$html .= "<input type='hidden' name='service_date' value='$service_date' >";
					$html .= "<input type='hidden' name='client_id' value='$client_id' >";
					$html .= "<input type='hidden' name='meal_id' value='$meal_id' >";
					for($i=0; $i<count($menu_item_id_array); $i++) {
						$html .= "<input type='hidden' name='menu_item_id_array[$i]' value='$menu_item_id_array[$i]' >";
					}
					$html .= "<input type='submit' class='place_order_button page_button' value='Place Order'>";
				}
				if($context == 'green_heart_foods_admin') {
					$html .= "<a class='page_button' href='".WEB_ROOT."/admin/edit-daily-menu.php?client-id=$client_id&service-date=$service_date&meal-id=$meal_id'>Edit</a>";
				}
				$html .= "</div>";
			}
		} else {
			$html .= '<p class="no_menus">No menus found</p>';
		}
		$html .= '</form>';
		$html .= '</span>';
		return $html;
	}

	public function get_weekly_menu_page($context) {
		$last_week = date('Y-m-d', strtotime('Monday last week'));
		$this_week = date('Y-m-d', strtotime('Monday this week'));
		$next_week = date('Y-m-d', strtotime('Monday next week'));
		$last_week_formatted = date('M d', strtotime('Monday last week'))."-".date('d', strtotime('Monday last week + 6 days'));
		$this_week_formatted = date('M d', strtotime('Monday this week'))."-".date('d', strtotime('Monday this week + 6 days'));
		$next_week_formatted = date('M d', strtotime('Monday next week'))."-".date('d', strtotime('Monday next week + 6 days'));
		if(isset($_GET['start-date'])) {
			$start_date = $_GET['start-date'];
		} else {
			$start_date = $this_week;
		}
		$start_date_formatted = date('M d', strtotime($start_date))."-".date('d', strtotime($start_date.' + 6 days'));
		if(isset($_GET['meal-id'])) {
			$url_meal_id = $_GET['meal-id'];
		} else {
			$url_meal_id = 1;
		}
		$client_id = $_GET['client-id'];
		$html = "";
		$client = new Client();
		$result = $client->get_client($client_id);
		$web_root = WEB_ROOT;
		if(count($result) == 1) {
			// $html .= "<div class='hero'></div><!--<img src='../_uploads/".$result[0]['company_logo_large']."' />-->";
			// $image_path = $web_root."/_uploads/".$result[0]['company_logo_large'];
			// $html .= "<div class='hero' style='background-image: url($image_path)'></div>";
		}
		$last_week_selected = '';
		$this_week_selected = '';
		$next_week_selected = '';
		switch ($start_date) {
			case $last_week:
				$last_week_selected = 'selected';
				break;
			case $this_week:
				$this_week_selected = 'selected';
				break;
			case $next_week:
				$next_week_selected = 'selected';
				break;
		}
		$result = $this->get_weekly_menu_by_meal($client_id, $start_date, $context, $url_meal_id);
		$result_count = count($result);
		if($url_meal_id == 5) {
			$show_hide = 'hidden';
		} else {
			$show_hide = 'show';
		}
		$html .= "<div class='page_header'>";
		$html .=    "<ul>";
		$html .=        "<li class='left'><a class='print_link $show_hide' href='weekly-menu-print-menu.php?client-id=$client_id&start-date=$start_date&meal-id=$url_meal_id'>Print Menus</a></li>";
		$html .=        "<li><h2>$start_date_formatted</h2></li>";
		$html .=        "<li class='right'><a class='print_link $show_hide placard_link' href='weekly-menu-print-placards.php?client-id=$client_id&start-date=$start_date&meal-id=$url_meal_id'>Print Placards</a></li>";
		$html .=    "</ul>";
		$html .= "</div>";
		$service_date = null;
		$meal_id = null;
		$additional_menu_items = array();
		$group_id = 0;
		$meal_type_select_html = "";
		$meal_types = $this->get_meal_types();
		if($meal_types) {
			if($context == 'green_heart_foods_admin') {
				$admin_or_client = 'admin';
			} else {
				$admin_or_client = 'clients';
			}
			$meal_type_select_html .= "<select data-client-id='$client_id' data-start-date='$start_date' data-admin-or-client='$admin_or_client' class='meal_type'>";
			for ($i=0; $i < count($meal_types); $i++) {
				$meal_option_id = $meal_types[$i]['meal_id'];
				$meal_name = $meal_types[$i]['meal_name'];
				if($meal_option_id == $url_meal_id) {
					$selected = 'selected';
				} else {
					$selected = '';
				}
				$meal_type_select_html .= "<option value='$meal_option_id' $selected>$meal_name</option>";
			}
			$meal_type_select_html .= "<select>";
		}
		if($result_count > 0) {
			$html .= $meal_type_select_html;
			$additional_menu_items[$meal_id] = "";
			$service_date = null;
			$meal_id = null;
			$image_class = ""; //TODO Delete?
			for ($i=0; $i < count($result); $i++) { 
				$first_bite = true;
				if($service_date != $result[$i]['service_date']) {
					if($context != 'client_general') {
						$item_status = "<p class='item_status'>".$result[$i]['item_status']."</p>";
					} else {
						$item_status = "";
					}
					$meal_name = strtolower($result[$i]['meal_name']);
					$html .= "<div class='outside_container'>";
					$html .=    "<div class='meal_container $meal_name'>";
					$html .=        "<div class='meal_details'>";
					$html .=                $item_status;
					$html .=            "<p class='day_of_the_week'>".date('l', strtotime($result[$i]['service_date'])).'</p>';
					$html .=            "<p class='month_and_date'>".date('M d', strtotime($result[$i]['service_date'])).'</p>';
					// if($meal_name == "bites") {
						// $html .=            "<p class='meal_name'>Brite ".$meal_name.'</p>';
					// } else {
						$html .=            "<p class='meal_name'>".$meal_name.'</p>';	
					// }
					$html .=            "<p class='meal_description'>".$result[$i]['meal_description'].'</p>';
					if($result[$i]['meal_id'] != 5){
						$html .=        	"<h4 class='hosted_by'>Hosted By ".$result[$i]['server_first_name']."</h4>";		
					}
					$html .=            "<a class='page_button' href='daily-menu.php?client-id=$client_id&service-date=".$result[$i]['service_date']."&meal-id=".$result[$i]['meal_id']."'>View</a>";
					$html .=        "</div>";
					$html .= 		"<div class='menu_items_container'>";

					for ($j=0; $j < count($result); $j++) {
						if($result[$i]['service_date'] == $result[$j]['service_date']) {
							if($result[$i]['meal_id'] == 5) {
								if($first_bite) {
									$html .= "<div class='bite_message_container'>";
									$html .= "<div class='bite_message_icon'></div>";
									$html .= "<p>Brite Bites delivery service includes Snack Packs, Sandwiches and Beverages.</p>";
									$html .= "</div>";
									$first_bite = false;
								}
							} else {
								$html .= '<p class="menu_item_name">'.$result[$j]['menu_item_name']."</p>";
								$is_list = "";
								$contains_list_prepend = "<span class='allergy-alert'>";
								$contains_list = $contains_list_prepend;
								$result[$j]['is_vegetarian'] == 1 ? 		$is_list .= "Vegetarian, " : 			$is_list .= "";
								$result[$j]['is_vegan'] == 1 ? 				$is_list .= "Vegan, " : 				$is_list .= "";
								$result[$j]['is_gluten_free'] == 1 ? 		$is_list .= "Gluten-Free, " : 			$is_list .= "";
								$result[$j]['is_whole_grain'] == 1 ? 		$is_list .= "Whole Grain, " : 			$is_list .= "";
								$result[$j]['contains_nuts'] == 1 ? 		$contains_list .= "Nuts, " : 			$contains_list .= "";
								$result[$j]['contains_soy'] == 1 ? 			$contains_list .= "Soy, " : 			$contains_list .= "";
								$result[$j]['contains_shellfish'] == 1 ? 	$contains_list .= "Shellfish, " : 		$contains_list .= "";
								$result[$j]['contains_nightshades'] == 1 ? 	$contains_list .= "Nightshades, " : 	$contains_list .= "";
								$result[$j]['contains_alcohol'] == 1 ? 		$contains_list .= "Alcohol, " : 		$contains_list .= "";
								$result[$j]['contains_eggs'] == 1 ? 		$contains_list .= "Eggs, " : 			$contains_list .= "";
								$result[$j]['contains_gluten'] == 1 ? 		$contains_list .= "Gluten, "  :	 		$contains_list .= "";
								$result[$j]['contains_dairy'] == 1 ? 		$contains_list .= "Dairy, " : 			$contains_list .= "";
								if($contains_list === $contains_list_prepend) {
									$is_list = trim($is_list, ", ");
									$contains_list = "";
								}
								$contains_list = trim($contains_list, " ,")."</span>";
								$html .= "<p class='is_and_contains_list'>".$is_list." ".$contains_list."</p>";
							}
						}	
					}
					$html .=    	"</div>";
					$html .=    "</div>";
					$html .= "</div>";
				}
				$service_date = $result[$i]['service_date'];
				$meal_id = $result[$i]['meal_id'];
			}
			$menus = 1;
		} else {
			$html .= $meal_type_select_html;
			$formatted_start_date = date('M d', strtotime($start_date))."-".date('d', strtotime($start_date.' + 6 days'));
			$html .= "<p class='no_menus'>No menus found</p>";
			$menus = 0;
		}
		if($context == 'green_heart_foods_admin') {
			$html .=    "<div class='button_container'>";
			$html .=        '<a class="page_button" href="'.WEB_ROOT.'/admin/create-menu.php?client-id='.$client_id.'&meal-id='.$url_meal_id.'">Create Menu </a>';
			if($menus) {
				$html .=     "<a class='page_button' href='".WEB_ROOT."/_actions/email-client.php?client-id=$client_id&start-date=$start_date&meal-id=$url_meal_id'> Email Client</a><br />";    
			}
			$html .=    "</div>";
		}
		return $html;
	}

	public function get_yearly_menu_page($context) {
		$this_year = date('Y', strtotime('now'));
		if(isset($_GET['menu-year'])) {
			$menu_year = $_GET['menu-year'];
		} else {
			$menu_year = $this_year;
		}
		$previous_year = $menu_year-1;
		$next_year = $menu_year+1;
		$client_id = $_GET['client-id'];
		$html = "";
		$client = new Client();
		$result = $client->get_client($client_id);
		$web_root = WEB_ROOT;
		$html .= "<div class='page_header'>";
		$html .= "<ul>";
		$html .=    "<li><h2>$menu_year</h2><li>";
		$html .= "</ul>";
		$html .= "</div>";
		$result = $this->get_yearly_menus($client_id, $menu_year, $context);
		$previous_start_date = NULL;
		$html .= "<div class='outside_container'>";
		$start_grid_view_container = true;
		if ($result){
			for($i=0; $i<count($result); $i++) {
				$service_date = $result[$i]['service_date'];
				if (date('l', strtotime($service_date)) === 'Monday') {
					$week_start_date = date('M d', strtotime($service_date));
					$week_start_date_with_year = date('Y-m-d', strtotime($service_date));
				} else {
					$week_start_date = date('M d', strtotime('last monday', strtotime($service_date)));
					$week_start_date_with_year = date('Y-m-d', strtotime('last monday', strtotime($service_date)));
				}
				$week_end_date = date('M d', strtotime("$week_start_date + 6 days"));
				$week_end_date_with_year = date('Y-m-d', strtotime("$week_start_date + 6 days"));
				if($week_start_date != $previous_start_date) {
					$thru_dates = $week_start_date."<br> <span class='thru'>THRU</span> <br><span class='thru_end_date'>".$week_end_date."</span>";
					$previous_service_date = NULL;
					$previous_meal_id = NULL;
					$previous_week_start_date = "Rubbish";
					$meal_types_displayed = array();
					for($j=0; $j<count($result); $j++) {
						$current_service_date = $result[$j]['service_date'];
						$current_meal_name = $result[$j]['meal_name'];
						$today = date('Y-m-d', strtotime('now'));
						$last_monday = date('Y-m-d', strtotime('last monday'));
						$next_monday = date('Y-m-d', strtotime('next monday'));
						$current_meal_id = $result[$j]['meal_id'];
						switch ($context) {
							case 'client_general':
							case 'client_admin':
								$view_link = $web_root."/clients/weekly-menu.php?client-id=$client_id&start-date=$week_start_date_with_year&meal-id=$current_meal_id";
								break;
							case 'green_heart_foods_admin':
								$view_link = $web_root."/admin/weekly-menu.php?client-id=$client_id&start-date=$week_start_date_with_year&meal-id=$current_meal_id";
								break;
						}
						if($week_start_date_with_year >= $last_monday) {
							$view_type = 'list_view';
							$grid_view_container = "";
						} else {
							$view_type = 'grid_view';
						}
						if ($result[$j]['service_date'] <= $week_end_date_with_year && $result[$j]['service_date'] >= $week_start_date_with_year && $current_meal_id != $previous_meal_id) {
							if (array_search($result[$j]['meal_id'], $meal_types_displayed) === false) {
								$meal_name_class = strtolower($current_meal_name);
								$grid_view_container = "";
								if($start_grid_view_container == true && $view_type == 'grid_view') {
									$grid_view_container = "<div class='grid_view_container'>";
									$start_grid_view_container = false;
								}
								$html .= $grid_view_container;
								$html .= "<div data_view_link='$view_link' class='week_meal_container $view_type $meal_name_class'>";
								$html .= "<div class='left_and_right_column $view_type'>";
								$html .=    "<div class='left_column'>";
								$html .=        "<h2 class='thru_dates'>".$thru_dates."</h2>";
								if($current_meal_name == "Bites") {
									$html .=        "<h3 class='meal_name'>Brite ".$current_meal_name."</h3>";	
								} else {
									$html .=        "<h3 class='meal_name'>".$current_meal_name."</h3>";
								}
								if($result[$j]['meal_name'])
								if($result[$j]['meal_id'] != 5){
									$html .=        "<h4 class='hosted_by'>Hosted By ".$result[$j]['server_first_name']."</h4>";
								}
								$html .=        "<a href='$view_link' class='view_link'>View</a>";
								$html .=    "</div>";
								$html .=    "<div class='right_column'>";
								$previous_meal_service_date = NULL;
								$weekly_menu = $this->get_weekly_menu_by_meal($client_id, $week_start_date_with_year, $context, $result[$j]['meal_id']);
								if($weekly_menu) {
									$current_meal_service_date = null;
									for ($k=0; $k<count($weekly_menu); $k++) { 
										$first_bite = true;
										$current_meal_service_date = $weekly_menu[$k]['service_date'];
										if($current_meal_service_date != $previous_meal_service_date) {
											$html .= "<p>".date('l, M d', strtotime($weekly_menu[$k]['service_date']))."</p>";
										}
										if($weekly_menu[$k]['meal_id'] == 5) {
											if($first_bite && $current_meal_service_date != $previous_meal_service_date) {
												$html .= "<p class='menu_item_name_bites'>Brite Bites delivery service includes Snack Packs, Sandwiches and Beverages.</p>";
												$first_bite = false;
											}
										} else {
											$html .= "<p class='menu_item_name'>".$weekly_menu[$k]['menu_item_name']."</p>";
										}
										$previous_meal_service_date = $current_meal_service_date;	
									}								
								}
								$html .=    "</div>"; // end right_column
								$html .=    "</div>"; // end left_and_right_column
								$html .= "</div>"; // end week_meal_container
								
								array_push($meal_types_displayed, $result[$j]['meal_id']);
							}
						}


						$previous_service_date = $current_service_date;
						$previous_meal_id = $current_meal_id;
					}

				}


				$previous_start_date = $week_start_date;
			}
		} else {
			$html .= "<div class='no-results-found no_menus'>No menus for $menu_year </div>";
		}

		if($start_grid_view_container == false) {
			$html .= "</div>"; // end grid_view_wrapper	
		}
		

		$html .= "</div>"; // End outside_container

		$html .= "<div class='button_container'>";
		$html .=    "<a href='yearly-menu.php?client-id=$client_id&menu-year=$previous_year' class='page_button'>Prev Year</a>";
		if($context === 'green_heart_foods_admin') {
			$html .=    "<a href='create-menu.php?client-id=$client_id' class='page_button'>Create Menu</a>";
		}
		$html .=    "<a href='yearly-menu.php?client-id=$client_id&menu-year=$next_year' class='page_button'>Next Year</a>";
		$html .= "</div>";
		return $html;
	}

	public function send_menu_for_client_review ($client_id, $start_date, $meal_id) {
		$user = new User();
		$result = $user->get_client_users($client_id);
		for ($i=0; $i < count($result); $i++) { 
			if($result[$i]['user_type_id'] == 2) {
				$client_admin_email = $result[$i]['user_name'];        
			}
		}
		$end_date = date('Y-m-d', strtotime($start_date.' +6 days'));
		$arguments = array(
			2,
			$client_id,
			$start_date,
			$end_date
		);
		$query = $this->database_connection->prepare("UPDATE menu_items SET item_status_id = ? WHERE client_id = ? AND (service_date BETWEEN ? AND ?)");
		$result = $query->execute($arguments);
		if ($result){
			$link = "http://clients.greenheartfoods.com" . WEB_ROOT . "/clients/weekly-menu.php?client-id=$client_id&start-date=$start_date";
			$link_with_forward = $link."&forward-url=$link";
			$to_email  = $client_admin_email; 
			$subject = 'Your Weekly Menu is Ready';
			$image_path = "http://clients.greenheartfoods.com/" . WEB_ROOT . "/_images/ui/email_logo.jpg";
			$message = "
				<html>
					<body>
						<h1><img src='$image_path' /></h1>
						<p>Hello, Food Lover!</p>
						<p>Your weekly menus are ready to review. Please click the link below to review, edit and confirm.</p>
						<p><a class='page_button' href=$link_with_forward>$link_with_forward</a></p>
						<p>Green Heart Foods</p>
					</body>
				</html>";
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: Green Heart Foods <'.GREEN_HEART_FOODS_ADMIN_EMAIL.'>' . "\r\n";
			$sent = mail($to_email, $subject, $message, $headers);
			if($sent) {
				Messages::add('Your email has been sent.');
				header("Location: ". WEB_ROOT . "/admin/weekly-menu.php?client-id=$client_id&start-date=$start_date&meal-id=$meal_id");
				exit();
			} else {
				Messages::add('Sorry, the was an error. Your email has not been sent.');
				header("Location: ". WEB_ROOT . "/admin/weekly-menu.php?client-id=$client_id&start-date=$start_date&meal-id=$meal_id");
				exit();
			}
		} else {
			echo "There was a problem updating menu status.";
		}
	}

	public function approve_menu_from_client() {
		$service_date = $_POST['service_date'];
		$client_id = $_POST['client_id'];
		$meal_id = $_POST['meal_id'];
		$menu_item_id_array = $_POST['menu_item_id_array'];
		$number_of_menu_items = count($menu_item_id_array);
		$client = new Client();
		$result = $client->get_client($client_id);
		if($result) {
			$client_name = $result[0]['company_name'];
		} else {
			$client_name = "Client";
		}
		for ($i=0; $i < $number_of_menu_items; $i++) { 
			$menu_item_id = $menu_item_id_array[$i];
			$arguments = array(
				3,
				$_POST['special_requests'][$i],
				$_POST['total_orders_for_item'][$i],
				$menu_item_id
			);
			$query = $this->database_connection->prepare("UPDATE menu_items SET 
				item_status_id = ?,
				special_requests = ?, 
				total_orders_for_item = ?
				WHERE 
				menu_item_id = ?");
			$result = $query->execute($arguments);
			if($i == $number_of_menu_items-1) {
				$link = "http://clients.greenheartfoods.com/". WEB_ROOT . "/admin/weekly-menu.php?client-id=$client_id&start-date=$service_date";
				$to_email  = GREEN_HEART_FOODS_ADMIN_EMAIL;
				$subject = "A Menu Has Been Approved by $client_name";
				$message = "
					<html>
						<body>
							<p>$client_name has approved a menu - please click below to review.</p>
							<a href=$link>$link</a>
						</body>
					</html>";
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: Green Heart Foods <'.GREEN_HEART_FOODS_ADMIN_EMAIL.'>' . "\r\n";
				$sent = mail($to_email, $subject, $message, $headers);
				if($sent) {
					Messages::add('Thanks! Your order has been updated.');
				} else {
					Messages::add('Sorry, there was an error. Your order has not been updated.');
				}
				$location = "Location: ". WEB_ROOT . "/clients/weekly-menu.php?client-id=$client_id&start-date=$service_date&meal-id=$meal_id";
				header($location);
				exit();
			}
		}
	}

	public function get_menu_form($client_id, $service_date = null, $meal_id = null) {
		$menu = new Menu();
		$servers = new Servers();
		$client = new Client();
		$meal_types = $menu->get_meal_types();
		$server_list = $servers->get_all_servers();
		$meals_result = $client->get_meals_per_day($client_id);
		$meals_per_day = $meals_result[0]['meals_per_day'];
		$form = "";
		$html = "";
		$meal_type_options = "";
		$server_list_options = "";
		$year_options = "";
		$month_options = "";
		$day_options = "";
		$start_month = date('F');
		$start_month_number = date('m');
		$end_month = date('F', strtotime('+1 month'));
		$end_month_number = date('m', strtotime('+1 month'));
		$start_year = date('Y');
		$end_year = date('Y', strtotime('+1 year'));
		$month_options_array = array(
			array($start_month_number, $start_month), 
			array($end_month_number, $end_month)
		);
		$year_options_array = array($start_year, $end_year);
		$server_image_path = '';
		$menu_item_hidden_ids = "";
		$total_orders_for_menu = 0;
		$total_served_for_menu = 0;
		$total_cost_for_menu = 0;
		$menu_image_style = "";
		$server_image_style = "";
		// $all_bites = $this->get_all_bites();
		$bites_mode = '';
		if (isset($_GET['meal-id'])) {
			$meal_id = $_GET['meal-id'];
		}
		if($meal_id == 5) {
			$bites_mode = 'bites_mode';
		}
		if(isset($service_date) && isset($meal_id)) {
			// $all_bites = $this->get_all_bites();
			if($meal_id == 5) {
				$all_bites = $this->get_daily_menu($client_id, $service_date, $meal_id);	
			} else {
				$all_bites = null;
			}
			$mode = 'edit';
			$cancel_url = WEB_ROOT."/admin/daily-menu.php?client-id=$client_id&service-date=$service_date&meal-id=$meal_id";
			$form_action = '../_actions/update-menu.php';
			$arguments = array(
				$client_id,
				$service_date,
				$meal_id,
			);
			$query = $this->database_connection->prepare("SELECT * FROM menu_items LEFT JOIN servers ON menu_items.server_id = servers.server_id WHERE client_id = ? AND service_date = ? AND meal_id = ?");
			$query->execute($arguments);
			$menu_items = $query->fetchAll(PDO::FETCH_ASSOC);
			$number_of_meals = count($menu_items);
			$menu_image_path_orginal = $menu_items[0]['menu_image_path'];
			if($menu_image_path_orginal != ""){
				$menu_image_style = "style='background-image: url(".WEB_ROOT."/_uploads/".$menu_image_path_orginal.")'";
			}
			if($menu_items[0]['server_image_path'] != ""){
				$server_image_style = "style='background-image: url(".WEB_ROOT."/".$menu_items[0]['server_image_path'].")'";
			}
			// $menu_image_html = "";//"<img src='".WEB_ROOT."/_uploads/".$menu_image_path_orginal."' />";
			for ($i=0; $i < count($menu_items); $i++) { 
				$current_month = date('m', strtotime($service_date));
				$current_year = date('Y', strtotime($service_date));
				$current_day = date('d', strtotime($service_date));
				$current_server_id = $menu_items[0]['server_id'];
				$current_meal_id = $menu_items[0]['meal_id'];
				$meal_description = $menu_items[0]['meal_description'];
			}
		} else {
			$all_bites = $this->get_all_bites();
			$mode = 'create';
			$cancel_url = WEB_ROOT."/admin/weekly-menu.php?client-id=$client_id&meal-id=$meal_id";
			$form_action = '../_actions/create-menu.php';
			$current_day = date('d', strtotime('+1 day'));
			$meal_description = "";
			$number_of_meals = $meals_per_day;
			$menu_image_path_orginal = "";
			// $menu_image_path = "<img width='100' src='../_images/menu-image-placeholder.jpg' />";
			//$menu_image_html = "<img class='hidden' width='100' />"; //style='display:hidden'
		}

		// The following for loops were just complex enough to not cosolidate into a function. 
		// They are used to create the options for the select fields, selecting the current option when in edit mode.

		// Year

		for ($i=0; $i < count($year_options_array); $i++) { 
			if(isset($current_year) && ($year_options_array[$i] == $current_year)) {
				$selected = 'selected';
			} else {
				$selected = '';
			}
			$year_options .= "<option $selected value=".$year_options_array[$i].">".$year_options_array[$i]."</option>";
		}

		// Month

		for ($i=0; $i < count($month_options_array); $i++) { 
			if(isset($current_year) && ($month_options_array[$i][0] == $current_month)) {
				$selected = 'selected';
			} else {
				$selected = '';
			}
			$month_options .= "<option $selected value=".$month_options_array[$i][0].">".$month_options_array[$i][1]."</option>";
		}

		// Day Options

		for ($i=1; $i <= 31; $i++) { 
			if(isset($current_day) && ($i == $current_day)) {
				$selected = 'selected';
			} else {
				$selected = '';
			}
			if($i < 10) {
				$leading_zero_formatted = '0'.$i;
			} else {
				$leading_zero_formatted = $i;
			}
			$day_options .= "<option $selected value=".$leading_zero_formatted .">".$leading_zero_formatted ."</option>";
		}        

		// Meal Types
		
		for ($i=0; $i < count($meal_types); $i++) { 
			if(isset($current_meal_id) && ($meal_types[$i]['meal_id'] == $current_meal_id)) {
				$selected = 'selected';
			} else {
				$selected = '';
			}
			$meal_type_options .= "<option $selected value=".$meal_types[$i]['meal_id'].">".$meal_types[$i]['meal_name']."</option>";
		}

		// Server List
		
		for ($i=0; $i < count($server_list); $i++) { 
			if(isset($current_server_id) && ($server_list[$i]['server_id'] == $current_server_id)) {
				$selected = 'selected';
				$server_image_path = '../'.$server_list[$i]['server_image_path'];
			} else {
				$selected = '';
			}
			$server_list_options .= "<option $selected data-server-image-path='".$server_list[$i]['server_image_path']."' value='".$server_list[$i]['server_id']."'>".$server_list[$i]['server_first_name']." ".$server_list[$i]['server_last_name']."</option>";
		}

		$html .= "<form class='create_menu_form' action='$form_action' method='post' enctype='multipart/form-data'>";
		$html .=    "<fieldset>";
		$html .=        "<h3>Date</h3>";
		//$html .=       "<select name='service_month' class='month cs-select cs-skin-border'>";
		$html .=       "<select name='service_month' class='month'>";
		$html .=            $month_options;
		$html .=        "</select>";
		//$html .=        "<select name='service_day' class='day cs-select cs-skin-border'>";
		$html .=        "<select name='service_day' class='day'>";
		$html .=            $day_options;
		$html .=        "</select>";
		//$html .=        "<select name='service_year' class='year cs-select cs-skin-border'>";
		$html .=        "<select name='service_year' class='year'>";
		$html .=            $year_options;
		$html .=        "</select>";
		$html .=    "</fieldset>";
		$html .=    "<fieldset>";
		$html .=        "<h3>Meal Type</h3>";
		//$html .=        "<select class='meal_type cs-select cs-skin-border' name='meal_id'>";
		$html .=        "<select class='meal_type' name='meal_id'>";
		$html .=            $meal_type_options;
		$html .=        "</select>";
		$html .=    "</fieldset>";
		$html .=    "<div class='non_bites_form $bites_mode'>";
		$html .=    "<fieldset>";
		$html .=        "<h3>Meal Description</h3>";
		$html .=        "<input spellcheck='true' name='meal_description' type='text' placeholder='Add Description Here' value='$meal_description' spellcheck='true' />";
		$html .=    "</fieldset>";
		$html .=    "<fieldset>";
		$html .=    "<div class='server_and_meal'>";
		$html .=        "<div class='server_container'>";		
		$html .=            "<div class='server_image' $server_image_style></div>";;
		//$html .=            "<select class='server cs-select cs-skin-border' name='server_id'>";
		$html .=            "<select class='server' name='server_id'>";
		$html .=                "<option value='none'>Select Host</option>";
		$html .=                     $server_list_options;
		$html .=            "</select>";
		$html .=        "</div>";
		$html .=        "<div class='meal_container'>";
		$html .=            "<div class='menu-image meal_image' $menu_image_style></div>";
		$html .=            "<input name='menu_image' type='file' />";
		$html .=        "</div>";
		$html .=    "</div>";
		$html .=    "</fieldset>";
		
		
		for ($i=0; $i < $number_of_meals; $i++) {
			if($mode == 'edit') {
				$server_id = $menu_items[$i]['server_id'];
				$item_status_id = $menu_items[$i]['item_status_id'];
				$item_name = $menu_items[$i]['menu_item_name'];
				$ingredients = $menu_items[$i]['ingredients'];
				$special_notes = $menu_items[$i]['special_notes'];
				$menu_items[$i]['is_vegetarian'] == 1 ? $is_vegetarian_checked = "checked" : $is_vegetarian_checked = "";
				$menu_items[$i]['is_vegan'] == 1 ? $is_vegan_checked = "checked" : $is_vegan_checked = "";
				$menu_items[$i]['is_gluten_free'] == 1 ? $is_gluten_free_checked = "checked" : $is_gluten_free_checked = "";
				$menu_items[$i]['is_whole_grain'] == 1 ? $is_whole_grain_checked = "checked" : $is_whole_grain_checked = "";
				$menu_items[$i]['contains_nuts'] == 1 ? $contains_nuts_checked = "checked" : $contains_nuts_checked = "";
				$menu_items[$i]['contains_soy'] == 1 ? $contains_soy_checked = "checked" : $contains_soy_checked = "";
				$menu_items[$i]['contains_shellfish'] == 1 ? $contains_shellfish_checked = "checked" : $contains_shellfish_checked = "";
				$menu_items[$i]['contains_nightshades'] == 1 ? $contains_nightshades_checked = "checked" : $contains_nightshades_checked = "";
				$menu_items[$i]['contains_alcohol'] == 1 ? $contains_alcohol_checked = "checked" : $contains_alcohol_checked = "";
				$menu_items[$i]['contains_eggs'] == 1 ? $contains_eggs_checked = "checked" : $contains_eggs_checked = "";
				$menu_items[$i]['contains_gluten'] == 1 ? $contains_gluten_checked = "checked" : $contains_gluten_checked = "";
				$menu_items[$i]['contains_dairy'] == 1 ? $contains_dairy_checked = "checked" : $contains_dairy_checked = "";
				$price_per_order = $menu_items[$i]['price_per_order'];
				$servings_per_order = $menu_items[$i]['servings_per_order'];
				$total_orders_for_item = $menu_items[$i]['total_orders_for_item'];
				$total_served_for_item =$total_orders_for_item*$servings_per_order;
				$total_cost_for_item = $total_orders_for_item*$price_per_order;
				$total_orders_for_menu += $total_orders_for_item;
				$total_served_for_menu += $total_served_for_item;
				$total_cost_for_menu += $total_cost_for_item;
				$menu_item_id = $menu_items[$i]['menu_item_id'];
				$menu_item_hidden_ids .= "<input type='hidden' name='menu_item_id_array[]' value='$menu_item_id' />";
			} else {
				$item_name = "";
				$ingredients = "";
				$special_notes = "";
				$is_vegetarian_checked = "";
				$is_vegan_checked = "";
				$is_gluten_free_checked = "";
				$is_whole_grain_checked = "";
				$contains_nuts_checked = "";
				$contains_soy_checked = "";
				$contains_shellfish_checked = "";
				$contains_nightshades_checked = "";
				$contains_alcohol_checked = "";
				$contains_eggs_checked = "";
				$contains_gluten_checked = "";
				$contains_dairy_checked = "";
				$price_per_order = "";
				$servings_per_order = "";
				$order_quantity = 0;
				$total_orders_for_item = 0;
				$total_served_for_item = 0;
				$total_cost_for_item = 0;
			}

			$visibility = 'hidden';
			if($mode == 'create' && $i==0) {
				$visibility = '';
			} elseif ($mode == 'edit') {
				$visibility = '';
			}

			$form .= <<<FORM
			<fieldset class="$mode $visibility" data-fieldset-id="$i">
				<div data-increment-id="$i" class="menu-item menu-item-$i">
					<input type="text" spellcheck='true' name="menu_item_name[$i]" value="$item_name" placeholder="Add Dish Name" />
					<input type="text" spellcheck='true' name="ingredients[$i]" value="$ingredients" placeholder="Add Ingredients" />
					<input type="text" spellcheck='true' name="special_notes[$i]" value="$special_notes" placeholder="Special Notes" />
					<div class="checkbox_container">
						<ul>
							<li><label class="box_label">Vegetarian</label><span class="move_box"><input  class="styled" type="checkbox" value="1" $is_vegetarian_checked name="is_vegetarian[$i]"></span></li>
							<li><label class="box_label">Vegan</label><span class="move_box"><input  class="styled" type="checkbox" value="1" $is_vegan_checked name="is_vegan[$i]"></span></li>
							<li><label class="box_label">Gluten-Free</label><span class="move_box"><input  class="styled" type="checkbox" value="1" $is_gluten_free_checked name="is_gluten_free[$i]"></span></li>
							<li><label class="box_label">Whole Grain</label><span class="move_box"><input  class="styled" type="checkbox" value="1" $is_whole_grain_checked name="is_whole_grain[$i]"></span></li>
							<li><label class="box_label">Contains Nuts</label><span class="move_box"><input  class="styled" type="checkbox" value="1" $contains_nuts_checked name="contains_nuts[$i]"></span></li>
							<li><label class="box_label">Contains Soy</label><span class="move_box"><input  class="styled" type="checkbox" value="1" $contains_soy_checked name="contains_soy[$i]"></span></li>
							<li><label class="box_label">Contains Shellfish</label><span class="move_box"><input  class="styled" type="checkbox" value="1" $contains_shellfish_checked name="contains_shellfish[$i]"></span></li>
							<li><label class="box_label">Contains Nightshades</label><span class="move_box"><input  class="styled" type="checkbox" value="1" $contains_nightshades_checked name="contains_nightshades[$i]"></span></li>
							<li><label class="box_label">Contains Alcohol</label><span class="move_box"><input  class="styled" type="checkbox" value="1" $contains_alcohol_checked name="contains_alcohol[$i]"></span></li>
							<li><label class="box_label">Contains Eggs</label><span class="move_box"><input  class="styled" type="checkbox" value="1" $contains_eggs_checked name="contains_eggs[$i]"></span></li>
							<li><label class="box_label">Contains Gluten</label><span class="move_box"><input  class="styled" type="checkbox" value="1" $contains_gluten_checked name="contains_gluten[$i]"></span></li>
							<li><label class="box_label">Contains Dairy</label><span class="move_box"><input  class="styled" type="checkbox" value="1" $contains_dairy_checked name="contains_dairy[$i]"></span></li>
						</ul>
					</div>
					<div class="price">
						<h3>Set Price per Order</h3>
						<input class="price_per_order_input" name="price_per_order[$i]" type="text" value="$price_per_order" placeholder="$0.00" />
						<input class="servings_per_order_input" name="servings_per_order[$i]" type="hidden" value="15" placeholder="Serves 0" />
						<p class="order_summary">
							<span class="total_orders_for_item">$total_orders_for_item</span> Orders
							<span class="total_served_for_item_serves">Serves </span><span class="total_served_for_item">$total_served_for_item</span><span class="total_served_for_item_serves"> =</span>
							$<span class="total_cost_for_item">$total_cost_for_item</span>
						</p>
						<input type="hidden" name="total_orders_for_item[$i]" class="total_orders_for_item_hidden"  value="$total_orders_for_item" />
						<input type="hidden" class="meals_per_day" name="meals_per_day" value="$i" />
						<input type="hidden" name="client_id" value="$client_id" />
						<input type="hidden" name="item_status_id" value="1" />
						<input type="hidden" name="menu_image_path_orginal" value="$menu_image_path_orginal" />
						<a class="page_button quantity_button subtract">Subtract</a>
						<a class="page_button quantity_button add">Add</a>
					</div>
				</div>
			</fieldset>
FORM;
		}
		$form .= "</div>"; // End non-bites form
		$form .= "<div class='bites_form $bites_mode'>";
		$form .= "<a href='".WEB_ROOT."/admin/edit-bites.php?client-id=$client_id&service-date=$service_date' class='edit_global_bites page_button'>Edit Global</a>";
		$form .= "<div class='fake_hr'></div>";
		//if($meal_id == 5) {
			$form .= $this->build_bites_html($all_bites, $mode);
		//}
		$number_of_bites = count($all_bites);
		// $form .= $this->build_bites_html($all_bites, 'create');
		// $number_of_bites = count($all_bites);
		// for ($i=0; $i < count($all_bites); $i++) { 
		// 	$bite_id = $all_bites[$i]['bite_id'];
		// 	$bite_name = $all_bites[$i]['bite_name'];
		// 	$bite_quantity = $all_bites[$i]['default_quantity'];
		// 	$contains = "";

		// 	if ($all_bites[$i]['is_vegetarian'] == 1) $contains .= "Vegetarian, ";
		// 	if ($all_bites[$i]['is_vegan'] == 1) $contains .= "Vegan, ";
		// 	if ($all_bites[$i]['is_gluten_free'] == 1) $contains .= "Gluten-Free, ";
		// 	if ($all_bites[$i]['is_whole_grain'] == 1) $contains .= "Whole Grain, ";
		// 	if ($all_bites[$i]['contains_nuts'] == 1) $contains .= "Nuts, ";
		// 	if ($all_bites[$i]['contains_soy'] == 1) $contains .= "Soy, ";
		// 	if ($all_bites[$i]['contains_shellfish'] == 1) $contains .= "Shellfish, ";
		// 	if ($all_bites[$i]['contains_nightshades'] == 1) $contains .= "Nightshades, ";
		// 	if ($all_bites[$i]['contains_alcohol'] == 1) $contains .= "Alcohol, ";
		// 	if ($all_bites[$i]['contains_eggs'] == 1) $contains .= "Eggs, ";
		// 	if ($all_bites[$i]['contains_gluten'] == 1) $contains .= "Gluten, ";
		// 	if ($all_bites[$i]['contains_dairy'] == 1) $contains .= "Dairy, ";

		// 	$form .= "<div class='bite_container'>";
		// 	$form .= "<p>$bite_name</p>";
		// 	$form .= "<p>$contains</p>";
		// 	$form .= "<div class='plus_button'>+</div>";
		// 	$form .= "<div class='minus_button'>-</div>";
		// 	$form .= "<input type='text' class='bite_quantity' name='bite_quantity[$i]' value='$bite_quantity' />";
		// 	$form .= "<input type='hidden' name='bite_id[$i]' value='$bite_id' />";
		// 	$form .= "</div>";
			
		// }
		$form .= "<input type='hidden' name='number_of_bites' value='$number_of_bites' />";
		$form .= "</div>";

		$html .= $form;
		$html .= "<input type='hidden' class='current_day_edit_mode' name='current_day' value='$current_day' />";
		$html .= $menu_item_hidden_ids;
		$html .= "</form>";
		if($mode == 'create') {
			$html .= "<div class='add_dish_container'><a class='add_dish page_button'>Add Dish</a></div>";
		} 
		if($mode == 'edit') {
			$html .= "<form class='add_blank_dish' action='../_actions/add-blank-item-to-menu.php' method='post'>";
			$html .= "<input type='hidden' name='service_date' value='$service_date'>";
			$html .= "<input type='hidden' name='meal_id' value='$meal_id'>";
			$html .= "<input type='hidden' name='client_id' value='$client_id'>";
			$html .= "<input type='hidden' name='server_id' value='$server_id'>";
			$html .= "<input type='hidden' name='item_status_id' value='$item_status_id'>";
			$html .= "</form>";
			if($meal_id != 5) {
				$html .= "<div class='add_dish_container'><a class='add_blank_dish page_button'>Add Dish</a></div>";
			}
		}
		$html .= "<div class='button_container'>";
		$html .=    "<p>";
		$html .=        "<span class='total_orders_for_menu'>$total_orders_for_menu</span> Orders ";
		$html .=        "<span class='total_served_for_menu_serves'>Serves </span><span class='total_served_for_menu'>$total_served_for_menu</span></span><span class='total_served_for_menu_serves'> =</span> ";
		$html .=        "<span class='total_cost_for_menu'>$$total_cost_for_menu</span>";
		$html .=    "</p>";
		$html .=    "<a href='$cancel_url' class='cancel_button page_button'>Cancel</a>";
		$html .=    "<button class='preview_menu_button page_button'>Save</button>";
		$html .= "</div>";
		return $html;
	}

	public function get_edit_bites_page() {
		$bites_html = "";
		$client_id = $_GET['client-id'];
		$service_date = $_GET['service-date'];
		$bite_groups = $this->get_all_bites_and_groups();
		for ($i=0; $i<count($bite_groups); $i++) { 
			$bites_html .= "<div class='bite_group_container_outer'>";
			$bites_html .= "<div class='bite_group_container'>";
			$bites_html .= "<h2 class='bite_group_name'>".$bite_groups[$i]['bite_group_name']."</h2>"; 
			$bite_group_id = $bite_groups[$i]['bite_group_id'];
			$bites = $this->get_all_bites_by_group_id($bite_group_id);
			if(count($bites) > 0) {
				for ($j=0; $j<count($bites); $j++) {
					$bite_id = $bites[$j]['bite_id'];
					$bite_name = $bites[$j]['bite_name'];
					$bite_image_name = $bites[$j]['image_name'];
					$contains = "";
					$allergens = "";
					if ($bites[$j]['is_vegetarian'] == 1) 			$contains .= "Vegetarian, ";
					if ($bites[$j]['is_vegan'] == 1) 				$contains .= "Vegan, ";
					if ($bites[$j]['is_gluten_free'] == 1) 			$contains .= "Gluten-Free, ";
					if ($bites[$j]['is_whole_grain'] == 1) 			$contains .= "Whole Grain, ";
					if ($bites[$j]['contains_nuts'] == 1) 			$allergens .= "Nuts, ";
					if ($bites[$j]['contains_soy'] == 1) 			$allergens .= "Soy, ";
					if ($bites[$j]['contains_shellfish'] == 1) 		$allergens .= "Shellfish, ";
					if ($bites[$j]['contains_nightshades'] == 1) 	$allergens .= "Nightshades, ";
					if ($bites[$j]['contains_alcohol'] == 1) 		$allergens .= "Alcohol, ";
					if ($bites[$j]['contains_eggs'] == 1) 			$allergens .= "Eggs, ";
					if ($bites[$j]['contains_gluten'] == 1) 		$allergens .= "Gluten, ";
					if ($bites[$j]['contains_dairy'] == 1) 			$allergens .= "Dairy, ";
					if($allergens != ""){
						$allergens = trim($allergens, ", ");	
					} else {
						$contains = trim($contains, ", ");	
					}
					$bites_html .= "<div class='bite_container'>";
					$bites_html .= "<img src='".WEB_ROOT."/_uploads/".$bite_image_name."' />";
					$bites_html .= "<p>$bite_name</p>";
					$bites_html .= "<p class='attributes_and_allergens'>$contains<span class='allergy-alert'>$allergens</span></p>";
					$bites_html .= "<a data-bite-id='$bite_id' class='edit_bite'>Edit</a>";
					$bites_html .= "</div>"; // End Bite Container
				}	
			}
			$bites_html .= "<a data-bite-group-id='$bite_group_id' class='add_bite page_button'>Add Bite</a>";
			$bites_html .= "</div>"; // End Bites Group Container
			$bites_html .= "</div>"; // End Bites Group Container Outer
		}
		$bites_html .= '<div class="button_container">';
		$bites_html .= "<a href='' class='cancel_button page_button edit_bites_done'>Done</a>";
		$bites_html .= '</div>';
		return $bites_html;
	}

	public function build_bites_html($all_bites, $mode){
		$number_of_bites = count($all_bites);
		$bites_html = "";
		$previous_bite_group_id = null;
		for ($i=0; $i < $number_of_bites; $i++) {
			$current_bite_group_id = $all_bites[$i]['bite_group_id'];
			if($current_bite_group_id != $previous_bite_group_id){
				$bites_html .= "<div class='bite_group_container_outer'>";
				$bites_html .= "<div class='bite_group_container'>";
				$bites_html .= "<h2 class='bite_group_name'>".$all_bites[$i]['bite_group_name']."</h2>"; 
				for ($j=0; $j < $number_of_bites; $j++) {
					if($all_bites[$j]['bite_group_id'] == $all_bites[$i]['bite_group_id']) {
						$bite_id = $all_bites[$j]['bite_id'];
						$bite_name = $all_bites[$j]['bite_name'];
						switch($mode) {
							case 'edit-global-bites':
								$bite_quantity = $all_bites[$j]['default_quantity'];
								break;
							case 'edit':
								$bite_quantity = $all_bites[$j]['total_orders_for_item'];
								break;
							case 'create':
								$bite_quantity = $all_bites[$j]['default_quantity'];
								break;
						}
						// $bite_quantity = $all_bites[$j]['default_quantity'];
						$bite_image_name = $all_bites[$j]['image_name'];
						$contains = "";
						$allergens = "";
						if ($all_bites[$j]['is_vegetarian'] == 1) $contains .= "Vegetarian, ";
						if ($all_bites[$j]['is_vegan'] == 1) $contains .= "Vegan, ";
						if ($all_bites[$j]['is_gluten_free'] == 1) $contains .= "Gluten-Free, ";
						if ($all_bites[$j]['is_whole_grain'] == 1) $contains .= "Whole Grain, ";
						if ($all_bites[$j]['contains_nuts'] == 1) $allergens .= "Nuts, ";
						if ($all_bites[$j]['contains_soy'] == 1) $allergens .= "Soy, ";
						if ($all_bites[$j]['contains_shellfish'] == 1) $allergens .= "Shellfish, ";
						if ($all_bites[$j]['contains_nightshades'] == 1) $allergens .= "Nightshades, ";
						if ($all_bites[$j]['contains_alcohol'] == 1) $allergens .= "Alcohol, ";
						if ($all_bites[$j]['contains_eggs'] == 1) $allergens .= "Eggs, ";
						if ($all_bites[$j]['contains_gluten'] == 1) $allergens .= "Gluten, ";
						if ($all_bites[$j]['contains_dairy'] == 1) $allergens .= "Dairy, ";
						if($allergens != ""){
							$allergens = trim($allergens, ", ");	
						} else {
							$contains = trim($contains, ", ");	
						}
						$bites_html .= "<div class='bite_container'>";
						$bites_html .= "<img src='".WEB_ROOT."/_uploads/".$bite_image_name."' />";
						$bites_html .= "<p>$bite_name</p>";
						$bites_html .= "<p class='attributes_and_allergens'>$contains<span class='allergy-alert'>$allergens</span></p>";
						switch($mode) {
							case 'edit-global-bites':
								$bites_html .= "<a data-bite-id='$bite_id' class='edit_bite'>Edit</a>";
								break;
							case 'edit':
							case 'create':
								$bites_html .= "<div class='quantity_group'>";
								$bites_html .= "<div class='quantity plus_button'>+</div>";
								$bites_html .= "<div class='quantity minus_button'>-</div>";
								$bites_html .= "<input type='text' class='bite_quantity' name='bite_quantity[]' value='$bite_quantity' />";
								// $bites_html .= "<input type='text' class='bite_quantity' name='bite_quantity[$j]' value='$bite_quantity' />";
								break;
						}
						$bites_html .= "<input type='hidden' name='bite_id[$j]' value='$bite_id' />";
						$bites_html .= "</div>";
						$bites_html .= "</div>";
						
					}
				}
				switch($mode) {
					case 'edit-global-bites':
						$bites_html .= "<a data-bite-group-id='$current_bite_group_id' class='add_bite page_button'>Add Bite</a>";
						break;
				}
				$bites_html .= "</div>";
				$bites_html .= "</div>";
			}
			$previous_bite_group_id = $current_bite_group_id;
		}
		return $bites_html;
	}

	public function get_edit_bite_modal($bite_id, $context) {
		$html = "";
		$bite = $this->get_bite_by_id($bite_id);
		$bite[0]['is_vegetarian'] == 1 ? $is_vegetarian_checked = "checked" : $is_vegetarian_checked = "";
		$bite[0]['is_vegan'] == 1 ? $is_vegan_checked = "checked" : $is_vegan_checked = "";
		$bite[0]['is_gluten_free'] == 1 ? $is_gluten_free_checked = "checked" : $is_gluten_free_checked = "";
		$bite[0]['is_whole_grain'] == 1 ? $is_whole_grain_checked = "checked" : $is_whole_grain_checked = "";
		$bite[0]['contains_nuts'] == 1 ? $contains_nuts_checked = "checked" : $contains_nuts_checked = "";
		$bite[0]['contains_soy'] == 1 ? $contains_soy_checked = "checked" : $contains_soy_checked = "";
		$bite[0]['contains_shellfish'] == 1 ? $contains_shellfish_checked = "checked" : $contains_shellfish_checked = "";
		$bite[0]['contains_nightshades'] == 1 ? $contains_nightshades_checked = "checked" : $contains_nightshades_checked = "";
		$bite[0]['contains_alcohol'] == 1 ? $contains_alcohol_checked = "checked" : $contains_alcohol_checked = "";
		$bite[0]['contains_eggs'] == 1 ? $contains_eggs_checked = "checked" : $contains_eggs_checked = "";
		$bite[0]['contains_gluten'] == 1 ? $contains_gluten_checked = "checked" : $contains_gluten_checked = "";
		$bite[0]['contains_dairy'] == 1 ? $contains_dairy_checked = "checked" : $contains_dairy_checked = "";
		$html .= "<div class='add_edit_bite_modal'>";
		$html .= "<div class='add_edit_bite_modal_content'>";
		$html .= "<a class='close_button'></a>";
		$html .= "<a href='../_actions/delete-bite.php?bite-id=$bite_id' class='delete_button'>Delete</a>";
		$html .= "<div class='fake_hr'></div>";
		$html .= "<form class='edit_bite_form' action='../_actions/update-bite.php' method='post' enctype='multipart/form-data'>";
		$html .= "<img src='".WEB_ROOT."/_uploads/".$bite[0]['image_name']."' />";
		$html .= "<input class='bite_image_name' name='bite_image_name' type='file' />";
		$html .= "<input class='bite_name' name='bite_name' type='text' value='".$bite[0]['bite_name']."'/>";
		$html .= "<input class='default_quantity' name='default_quantity' type='text' value='".$bite[0]['default_quantity']."'/>";
		$html .= "<input type='hidden' name='bite_image_name_original' value='".$bite[0]['image_name']."'/>";
		$html .= <<<CHECKBOXES
		<div class="checkbox_container">
			<ul>
				<li><label class="box_label">Vegetarian</label><input type="checkbox" value="1" $is_vegetarian_checked name="is_vegetarian"></li>
				<li><label class="box_label">Vegan</label><input type="checkbox" value="1" $is_vegan_checked name="is_vegan"></li>
				<li><label class="box_label">Gluten-Free</label><input type="checkbox" value="1" $is_gluten_free_checked name="is_gluten_free"></li>
				<li><label class="box_label">Whole Grain</label><input type="checkbox" value="1" $is_whole_grain_checked name="is_whole_grain"></li>
				<li><label class="box_label">Contains Nuts</label><input type="checkbox" value="1" $contains_nuts_checked name="contains_nuts"></li>
				<li><label class="box_label">Contains Soy</label><input type="checkbox" value="1" $contains_soy_checked name="contains_soy"></li>
				<li><label class="box_label">Contains Shellfish</label><input type="checkbox" value="1" $contains_shellfish_checked name="contains_shellfish"></li>
				<li><label class="box_label">Contains Nightshades</label><input type="checkbox" value="1" $contains_nightshades_checked name="contains_nightshades"></li>
				<li><label class="box_label">Contains Alcohol</label><input type="checkbox" value="1" $contains_alcohol_checked name="contains_alcohol"></li>
				<li><label class="box_label">Contains Eggs</label><input type="checkbox" value="1" $contains_eggs_checked name="contains_eggs"></li>
				<li><label class="box_label">Contains Gluten</label><input type="checkbox" value="1" $contains_gluten_checked name="contains_gluten"></li>
				<li><label class="box_label">Contains Dairy</label><input type="checkbox" value="1" $contains_dairy_checked name="contains_dairy"></li>
			</ul>
		</div>
CHECKBOXES;
		$html .= "<a class='cancel_button page_button'>Cancel</a>";
		$html .= "<input type='hidden' name='bite_id' value='$bite_id'>";
		$html .= "<input type='submit' class='save_button page_button' value='Save'>";
		$html .= "</form>";
		$html .= "</div>";
		$html .= "</div>";
		return $html;
	}

	public function get_add_bite_modal($bite_group_id, $context) {
		$html = "";
		$html .= "<div class='add_edit_bite_modal'>";
		$html .= "<div class='add_edit_bite_modal_content'>";
		$html .= "<a class='close_button'></a>";
		$html .= "<form class='add_bite_form' action='../_actions/add-bite.php' method='post' enctype='multipart/form-data'>";
		$html .= "<img class='bite-image' src='' />";
		$html .= "<input class='bite_image_name' name='bite_image_name' type='file' />";
		$html .= "<input class='bite_name' name='bite_name' type='text' value='Add Bite Name'/>";
		$html .= "<input class='default_quantity' name='default_quantity' type='text' value='Enter Default Quantity'/>";
		$html .= <<<CHECKBOXES
		<div class="checkbox_container">
			<ul>
				<li><label class="box_label">Vegetarian</label><input type="checkbox" value="1" name="is_vegetarian"></li>
				<li><label class="box_label">Vegan</label><input type="checkbox" value="1" name="is_vegan"></li>
				<li><label class="box_label">Gluten-Free</label><input type="checkbox" value="1" name="is_gluten_free"></li>
				<li><label class="box_label">Whole Grain</label><input type="checkbox" value="1" name="is_whole_grain"></li>
				<li><label class="box_label">Contains Nuts</label><input type="checkbox" value="1" name="contains_nuts"></li>
				<li><label class="box_label">Contains Soy</label><input type="checkbox" value="1" name="contains_soy"></li>
				<li><label class="box_label">Contains Shellfish</label><input type="checkbox" value="1" name="contains_shellfish"></li>
				<li><label class="box_label">Contains Nightshades</label><input type="checkbox" value="1" name="contains_nightshades"></li>
				<li><label class="box_label">Contains Alcohol</label><input type="checkbox" value="1" name="contains_alcohol"></li>
				<li><label class="box_label">Contains Eggs</label><input type="checkbox" value="1" name="contains_eggs"></li>
				<li><label class="box_label">Contains Gluten</label><input type="checkbox" value="1" name="contains_gluten"></li>
				<li><label class="box_label">Contains Dairy</label><input type="checkbox" value="1" name="contains_dairy"></li>
			</ul>
		</div>
CHECKBOXES;
		$html .= "<a class='cancel_button page_button'>Cancel</a>";
		$html .= "<input type='hidden' name='bite_group_id' value='$bite_group_id'>";
		$html .= "<input type='submit' class='save_button page_button' value='Save'>";
		$html .= "</form>";
		$html .= "</div>";
		$html .= "</div>";
		return $html;
	}

	public function get_daily_print_menu($menu_items) {
		$html = "<div class='print_header'>";
		$html .= "<h1 class='client_name'>".$menu_items[0]['company_name']."</h1>";
		$html .= "";
		$item_attributes_array = array(
			'is_vegetarian', 
			'is_vegan', 
			'is_gluten_free', 
			'is_whole_grain', 
			'contains_nuts', 
			'contains_soy', 
			'contains_shellfish',
			'contains_nightshades',
			'contains_alcohol',
			'contains_eggs',
			'contains_gluten',
			'contains_dairy'
		);
		
		$html .= "<h1 class='meal_name'>".$menu_items[0]['meal_name']." Menu</h1>";
		$html .= "<h1 class='date'>".date('l M d', strtotime($menu_items[0]['service_date']))."</h1>";
		$html .= "<div class='green_heart_foods_logo'></div>";
		$html .= "</div>";

		for ($i=0; $i < count($menu_items); $i++) { 
			$checkboxes = "";
			if($menu_items[$i]['menu_item_name'] == "") {
				$class = "hidden";
			} else {
				$class = "";
			}
			$meal_name = strtolower($menu_items[$i]['meal_name']);
			$html .= "<div class='item_container $class $meal_name'>";
			/*if(count($menu_items) < 7) {
				$html .= "<div class='like-heart'><img src='../_images/ui/favorite_off.png' /></div>";	
			}*/
			$html .= "<h3>".$menu_items[$i]['menu_item_name']."</h3>";
			if($menu_items[$i]['special_notes'] != "") {
				$html .= 		"<span class='special_notes'>".$menu_items[$i]['special_notes']." </span>";
			}
			//$html .= "<p>".$menu_items[$i]['ingredients']."</p>";
			$first_allergy_alert = true;
			for($j=0; $j<count($item_attributes_array); $j++) {
				if($menu_items[$i][$item_attributes_array[$j]] == 1) {
					$item_attribute = $item_attributes_array[$j];
					if(strrpos(ALLERGY_ALERT_ARRAY, $item_attributes_array[$j]) > -1) {
						if($first_allergy_alert) {
						   // $prepend_allery_list = "Contains";
							$prepend_allery_list = "";
							$first_allergy_alert = false;
						} else {
							$first_allergy_alert = "";
						}
						$checkboxes .= "<span class='allergy-alert'>".$first_allergy_alert.str_replace("contains", "", $item_attribute). "</span>, ";
						// $checkboxes .= "<span class='allergy-alert'>".$item_attributes_array[$j]. "</span>, ";
					} else {
						$checkboxes .= $item_attribute. ", ";	
					}
				}
			}
			$checkboxes = str_replace('is_', '', $checkboxes);
			$checkboxes = str_replace('_', ' ', $checkboxes);
			$checkboxes = str_replace('gluten free', 'gluten-Free', $checkboxes);
			$checkboxes = substr($checkboxes, 0, -2);
			$html .= "<p class='labels'>".ucwords($checkboxes)."</p>";
			$html .= "</div>";
		}

		$html .= 	"<div class='address_bar'><span class='green_heart_foods_url'><img src='../_images/ui/ghf_print_footer.png'> greenheartfoods.com</span> 415-729-1089 &nbsp; info@greenheartfoods.com &nbsp; 1069 Pennsylvania Ave San Francisco, CA 94107</div>";
		echo $html;
	}

	public function get_weekly_menu_print_menu($context){
		$html = "";
		$url_meal_id = $_GET['meal-id'];
		$start_date = $_GET['start-date'];
		$client_id = $_GET['client-id'];
		$client = new Client();
		$result = $client->get_client($client_id);
		$client_name = $result[0]['company_name'];
		$web_root = WEB_ROOT;
		$meal_type_query = $this->get_meal_types_by_id($url_meal_id);
		$meal_name = $meal_type_query[0]['meal_name'];
		$start_date_formatted = date('M d', strtotime($start_date));
		$end_date_formatted = date('M d', strtotime($start_date . '+ 6 days'));
		$html .= "<div class='print_header $meal_name'>";
		$html .= 	"<h1 class='client_name'>".$client_name."</h1>";
		$html .= 	"<h1 class='meal_name'>".$meal_name."</h1>";
		$html .= 	"<h1 class='date'>".$start_date_formatted." - ".$end_date_formatted."</h1>";
		$html .= 	"<div class='green_heart_foods_logo'></div>";
		$html .= "</div>";
		$result = $this->get_weekly_menu_by_meal($client_id, $start_date, $context, $url_meal_id);
		$result_count = count($result);
		$service_date = null;
		$meal_id = null;
		$additional_menu_items = array();
		$html .= "<div class='outside_container'>";
		if($result_count > 0) {
			for ($i=0; $i < count($result); $i++) { 
				if($service_date != $result[$i]['service_date']) {
					$meal_name = strtolower($result[$i]['meal_name']) ;
					$html .=    "<div class='meal_container $meal_name'>";
					$html .=    	"<p class='day_of_the_week'>".date('l', strtotime($result[$i]['service_date'])).'</p>';
					$html .= 			"<div class='menu_items_container'>";
					for ($j=0; $j < count($result); $j++) {
						if($result[$i]['service_date'] == $result[$j]['service_date']) {
							$html .= 		"<p>";
							$html .= 		"<span class='menu_item_name'>".$result[$j]['menu_item_name']." </span>";
							if($result[$j]['special_notes'] != "") {
								$html .= 		"<span class='special_notes'>".$result[$j]['special_notes']." </span>";
							}
							$is_list = "";
							$contains_list_prepend = "<span class='allergy-alert'>Contains ";
							$contains_list = $contains_list_prepend;
							$result[$j]['is_vegetarian'] == 1 ? 		$is_list .= "Vegetarian, " : 			$is_list .= "";
							$result[$j]['is_vegan'] == 1 ? 				$is_list .= "Vegan, " : 				$is_list .= "";
							$result[$j]['is_gluten_free'] == 1 ? 		$is_list .= "Gluten-Free, " : 			$is_list .= "";
							$result[$j]['is_whole_grain'] == 1 ? 		$is_list .= "Whole Grain, " : 			$is_list .= "";
							$result[$j]['contains_nuts'] == 1 ? 		$contains_list .= "Nuts, " : 			$contains_list .= "";
							$result[$j]['contains_soy'] == 1 ? 			$contains_list .= "Soy, " : 			$contains_list .= "";
							$result[$j]['contains_shellfish'] == 1 ? 	$contains_list .= "Shellfish, " : 		$contains_list .= "";
							$result[$j]['contains_nightshades'] == 1 ? 	$contains_list .= "Nightshades, " : 	$contains_list .= "";
							$result[$j]['contains_alcohol'] == 1 ? 		$contains_list .= "Alcohol, " : 		$contains_list .= "";
							$result[$j]['contains_eggs'] == 1 ? 		$contains_list .= "Eggs, " : 			$contains_list .= "";
							$result[$j]['contains_gluten'] == 1 ? 		$contains_list .= "Gluten, "  :	 		$contains_list .= "";
							$result[$j]['contains_dairy'] == 1 ? 		$contains_list .= "Dairy, " : 			$contains_list .= "";
							if($contains_list === $contains_list_prepend) {
								$is_list = trim($is_list, ", ");
								$contains_list = "";
							}
							$contains_list = trim($contains_list, " ,")."</span>";
							$html .= "<span class='is_and_contains_list'>".$is_list." ".$contains_list."</span>";
							$html .= "</p>";
						}
					}
					$html .=    	"</div>"; 	// End menu items
					$html .=    "</div>";		// End meal container
					
				}
				$service_date = $result[$i]['service_date'];
				$meal_id = $result[$i]['meal_id'];
			}
		} else {
			$html .= "<p class='no_menus'>No menus found</p>";
		}
		$html .= 	"<div class='address_bar'><span class='green_heart_foods_url'><img src='../_images/ui/ghf_print_footer.png'> greenheartfoods.com</span> 415-729-1089 &nbsp; info@greenheartfoods.com &nbsp; 1069 Pennsylvania Ave San Francisco, CA 94107</div>";
		$html .= "</div>";			// End outside container
		return $html;
	}

	/* 

	This function can/should be updated to use the get_print_placards_page function 
	It should be very easy - less than 5 minutes. 

	*/

	public function get_weekly_menu_print_placrds($context){
		$html = "";
		$start_date = $_GET['start-date'];
		$client_id = $_GET['client-id'];
		$client = new Client();
		$result = $client->get_client($client_id);
		$client_name = $result[0]['company_name'];
		$web_root = WEB_ROOT;
		$start_date_formatted = date('M d', strtotime($start_date));
		$end_date_formatted = date('M d', strtotime($start_date . '+ 6 days'));
		$result = $this->get_weekly_menu($client_id, $start_date, $context);
		$result_count = count($result);
		$service_date = null;
		$meal_id = null;
		$additional_menu_items = array();
		$html .= "<div class='outside_container'>";
		if($result_count > 0) {
			for ($i=0; $i < count($result); $i++) { 
				// if($i%9 == 8) {
				//     $ninth = 'ninth';
				// } else {
				//     $ninth = '';
				// }
				if($result[$i]['meal_id'] != 5) {
					$meal_name = strtolower($result[$i]['meal_name']);
					$html .= "<div class='meal_container $meal_name'>";
					$html .= 	"<div class='green_heart_foods_logo'></div>";
					$html .= 	"<h1 class='menu_item_name'>".$result[$i]['menu_item_name']." </h1>";
					$html .= 	"<h2 class='menu_item_ingredients'>".$result[$i]['ingredients']." </h2>";
					$is_list = "";
					$contains_list_prepend = "<span class='allergy-alert'>";
					$contains_list = $contains_list_prepend;
					$result[$i]['is_vegetarian'] == 1 ? 		$is_list .= "Vegetarian, " : 			$is_list .= "";
					$result[$i]['is_vegan'] == 1 ? 				$is_list .= "Vegan, " : 				$is_list .= "";
					$result[$i]['is_gluten_free'] == 1 ? 		$is_list .= "Gluten-Free, " : 			$is_list .= "";
					$result[$i]['is_whole_grain'] == 1 ? 		$is_list .= "Whole Grain, " : 			$is_list .= "";
					$result[$i]['contains_nuts'] == 1 ? 		$contains_list .= "Nuts, " : 			$contains_list .= "";
					$result[$i]['contains_soy'] == 1 ? 			$contains_list .= "Soy, " : 			$contains_list .= "";
					$result[$i]['contains_shellfish'] == 1 ? 	$contains_list .= "Shellfish, " : 		$contains_list .= "";
					$result[$i]['contains_nightshades'] == 1 ? 	$contains_list .= "Nightshades, " : 	$contains_list .= "";
					$result[$i]['contains_alcohol'] == 1 ? 		$contains_list .= "Alcohol, " : 		$contains_list .= "";
					$result[$i]['contains_eggs'] == 1 ? 		$contains_list .= "Eggs, " : 			$contains_list .= "";
					$result[$i]['contains_gluten'] == 1 ? 		$contains_list .= "Gluten, "  :	 		$contains_list .= "";
					$result[$i]['contains_dairy'] == 1 ? 		$contains_list .= "Dairy, " : 			$contains_list .= "";
					if($contains_list === $contains_list_prepend) {
						$is_list = trim($is_list, ", ");
						$contains_list = "";
					}
					$contains_list = trim($contains_list, " ,")."</span>";
					$html .= "<p class='is_and_contains_list'>".$is_list." ".$contains_list."</p>";
					$html .= "<div class='plus_minus_container'>";
					$html .= 	"<a class='plus'>+</a><a class='minus'>-</a>";
					$html .= "</div>";
					$html .= "</div>"; // End meal container
				}
			}
		} else {
			$html .= "<p class='no_menus'>No menus found</p>";
		}
		$html .= 	"<div class='meal_container blank unedited'>";
		$html .= 		"<div class='green_heart_foods_logo'></div>";
		$html .= 		"<h1 contenteditable='true' class='menu_item_name editable'>[Custom Menu Item]</h1>";
		$html .= 		"<h2 contenteditable='true' class='menu_item_ingredients editable'>[Custom Ingredients]</h2>";
		$html .= 		"<p contenteditable='true' class='is_and_contains_list editable'>[Custom Contains List] <span class='allergy-alert editable'>[Custom Allergens List]</span></p>";
		$html .= 		"<div class='plus_minus_container'>";
		$html .= 			"<a class='plus'>+</a>";
		$html .= 			"<a class='minus'>-</a>";
		$html .= 		"</div>";
		$html .= 	"</div>";
		$html .= "</div>"; // End outside container
		return $html;
	}

	public function get_print_placards_page() {
		$html = "";
		$client_id = $_GET['client-id'];
		$client = new Client();
		$result = $client->get_client($client_id);
		$client_name = $result[0]['company_name'];
		$web_root = WEB_ROOT;
		if (isset($_GET['start-date'])) {
			$start_date = $_GET['start-date'];
			$start_date_formatted = date('M d', strtotime($start_date));
			$end_date_formatted = date('M d', strtotime($start_date . '+ 6 days'));
			$result = $this->get_weekly_menu($client_id, $start_date, $context);
		} else if (isset($_GET['service-date'])) {
			$service_date = $_GET['service-date'];
			$meal_id = $_GET['meal-id'];
			$result = $this->get_daily_menu($client_id, $service_date, $meal_id);
		} else {
			echo "Sorry, there was an error. Either the start-date or service-date are not set.";
		}
		$result_count = count($result);
		$service_date = null;
		$meal_id = null;
		$additional_menu_items = array();
		$html .= "<div class='outside_container'>";
		if($result_count > 0) {
			for ($i=0; $i < count($result); $i++) { 

				// if($i%9 == 8) {
				//     $class = 'ninth';
				// } else {
				//     $class = '';
				// }

				if($result[$i]['meal_id'] != 5) {
					$meal_name = strtolower($result[$i]['meal_name']);
					$html .= "<div class='meal_container $meal_name'>";
					$html .= 	"<div class='green_heart_foods_logo'></div>";
					$html .= 	"<h1 class='menu_item_name'>".$result[$i]['menu_item_name']." </h1>";
					$html .= 	"<h2 class='menu_item_ingredients'>".$result[$i]['ingredients']." </h2>";
					$is_list = "";
					$contains_list_prepend = "<span class='allergy-alert'>";
					$contains_list = $contains_list_prepend;
					$result[$i]['is_vegetarian'] == 1 ? 		$is_list .= "Vegetarian, " : 			$is_list .= "";
					$result[$i]['is_vegan'] == 1 ? 				$is_list .= "Vegan, " : 				$is_list .= "";
					$result[$i]['is_gluten_free'] == 1 ? 		$is_list .= "Gluten-Free, " : 			$is_list .= "";
					$result[$i]['is_whole_grain'] == 1 ? 		$is_list .= "Whole Grain, " : 			$is_list .= "";
					$result[$i]['contains_nuts'] == 1 ? 		$contains_list .= "Nuts, " : 			$contains_list .= "";
					$result[$i]['contains_soy'] == 1 ? 			$contains_list .= "Soy, " : 			$contains_list .= "";
					$result[$i]['contains_shellfish'] == 1 ? 	$contains_list .= "Shellfish, " : 		$contains_list .= "";
					$result[$i]['contains_nightshades'] == 1 ? 	$contains_list .= "Nightshades, " : 	$contains_list .= "";
					$result[$i]['contains_alcohol'] == 1 ? 		$contains_list .= "Alcohol, " : 		$contains_list .= "";
					$result[$i]['contains_eggs'] == 1 ? 		$contains_list .= "Eggs, " : 			$contains_list .= "";
					$result[$i]['contains_gluten'] == 1 ? 		$contains_list .= "Gluten, "  :	 		$contains_list .= "";
					$result[$i]['contains_dairy'] == 1 ? 		$contains_list .= "Dairy, " : 			$contains_list .= "";
					if($contains_list === $contains_list_prepend) {
						$is_list = trim($is_list, ", ");
						$contains_list = "";
					}
					$contains_list = trim($contains_list, " ,")."</span>";
					$html .= "<p class='is_and_contains_list'>".$is_list." ".$contains_list."</p>";
					$html .= "<div class='plus_minus_container'>";
					$html .= 	"<a class='plus'>+</a><a class='minus'>-</a>";
					$html .= "</div>";
					$html .= "</div>"; // End meal container
				}
			}
		} else {
			$html .= "<p class='no_menus'>No menus found</p>";
		}
		$html .= 	"<div class='meal_container blank unedited'>";
		$html .= 		"<div class='green_heart_foods_logo'></div>";
		$html .= 		"<h1 contenteditable='true' class='menu_item_name editable'>[Custom Menu Item]</h1>";
		$html .= 		"<h2 contenteditable='true' class='menu_item_ingredients editable'>[Custom Ingredients]</h2>";
		$html .= 		"<p contenteditable='true' class='is_and_contains_list editable'>[Custom Contains List] <span class='allergy-alert editable'>[Custom Allergens List]</span></p>";
		$html .= 		"<div class='plus_minus_container'>";
		$html .= 			"<a class='plus'>+</a>";
		$html .= 			"<a class='minus'>-</a>";
		$html .= 		"</div>";
		$html .= 	"</div>";
		$html .= "</div>"; // End outside container
		return $html;	
	}

	public function get_attributes_and_allergens($current_result) {
		$html_container = "";
		$attributes_and_allergens = "";
		$item_attributes_array = array(
			'is_vegetarian', 
			'is_vegan', 
			'is_gluten_free', 
			'is_whole_grain', 
			'contains_nuts', 
			'contains_soy', 
			'contains_shellfish',
			'contains_nightshades',
			'contains_alcohol',
			'contains_eggs',
			'contains_gluten',
			'contains_dairy'
		);
		for($j=0; $j<count($item_attributes_array); $j++) {
			if($current_result[$item_attributes_array[$j]] == 1) {
				if(strrpos(ALLERGY_ALERT_ARRAY, $item_attributes_array[$j]) > -1) {
					$prepend_allergy_list = "";
					$attributes_and_allergens .= "<span class='allergy-alert'>".$prepend_allergy_list.str_replace("contains", "", $item_attributes_array[$j])."</span>, ";
				} else {
					$attribute = $item_attributes_array[$j];
					if($attribute === 'is_gluten_free') {
						$attribute = 'is_gluten-Free';
					}
					$attributes_and_allergens .= $attribute. ", ";
				}
			}
		}
		$attributes_and_allergens = str_replace('is_', '', $attributes_and_allergens);
		$attributes_and_allergens = str_replace('_', ' ', $attributes_and_allergens);
		$attributes_and_allergens = substr($attributes_and_allergens, 0, -2);
		$attributes_and_allergens = ucwords($attributes_and_allergens);
		if($attributes_and_allergens != "") {
			$html_container .= "<p class='attributes_and_allergens'>".$attributes_and_allergens."</p>";	
		}
		if($current_result['special_notes'] != "") {
			$html_container .= "<p class='special_notes'>".$current_result['special_notes']."</p>";
		}
		if($current_result['special_requests'] != "") {
			$html_container .= "<p class='special_requests'>".$current_result['special_requests']."</p>";	
		}
		return $html_container;
	}


}