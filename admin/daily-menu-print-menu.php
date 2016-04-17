<?php
	$page_class = 'daily_menu_print_menu_page';
	$page_title_detail = 'Daily Menu - Print';
	require_once("../_config/config.php");
    require_once(SERVER_ROOT . "/_includes/restrict-access-green-heart-foods.php");
    require_once(SERVER_ROOT . "/_includes/print-header.php");
    require_once(SERVER_ROOT . "/_classes/Client.php");
    require_once(SERVER_ROOT . "/_classes/Messages.php");
	require_once(SERVER_ROOT . "/_classes/Menu.php");
	$menu = new Menu();
	$context = $green_heart_foods_access_level;
	$meal_id = $_GET['meal-id'];
	$client_id = $_GET['client-id'];
	$service_date = $_GET['service-date'];
	$menu_items = $menu->get_daily_menu($client_id, $service_date, $meal_id);
?>

<div class="menu">

	<?php 
	
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
		$html .= "<h1 class='date'>".date('F d, Y', strtotime($menu_items[0]['service_date']))."</h1>";
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
			$html .= "<p>".$menu_items[$i]['ingredients']."</p>";
			$first_allergy_alert = true;
			for($j=0; $j<count($item_attributes_array); $j++) {
                if($menu_items[$i][$item_attributes_array[$j]] == 1) {
                    if(strrpos(ALLERGY_ALERT_ARRAY, $item_attributes_array[$j]) > -1) {
                    	if($first_allergy_alert) {
                    	   // $prepend_allery_list = "Contains";
                    	    $prepend_allery_list = "";
                    	    $first_allergy_alert = false;
                    	} else {
                    	    $first_allergy_alert = "";
                    	}
                    	$checkboxes .= "<span class='allergy-alert'>".$first_allergy_alert.str_replace("contains", "", $item_attributes_array[$j]). "</span>, ";
                        // $checkboxes .= "<span class='allergy-alert'>".$item_attributes_array[$j]. "</span>, ";
                    } else {
                        $checkboxes .= $item_attributes_array[$j]. ", ";	
                    }
                }
            }
            $checkboxes = str_replace('is_', '', $checkboxes);
            $checkboxes = str_replace('_', ' ', $checkboxes);
            $checkboxes = substr($checkboxes, 0, -2);
            $html .= "<p class='labels'>".ucwords($checkboxes)."</p>";
			$html .= "</div>";
		}

		$html .= 	"<div class='address_bar'><span class='green_heart_foods_url'><img src='../_images/ui/ghf_print_footer.png'> greenheartfoods.com</span> 415-729-1089 &nbsp; info@greenheartfoods.com &nbsp; 1069 Pennsylvania Ave San Francisco, CA 94107</div>";

		echo $html;
	?>
</div>

<?php require_once(SERVER_ROOT . "/_includes/print-footer.php"); ?>