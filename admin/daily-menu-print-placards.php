<?php
	$page_class = 'daily_menu_print_placards_page';
	$page_title_detail = 'Daily Menu - Placards';
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
		$html = "";
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
		for ($i=0; $i < count($menu_items); $i++) { 
            if($i%9 == 8) {
                $class = 'ninth';
            } else {
                $class = '';
            }
			$checkboxes = "";
			$html .= "<div class='placard_container $class'>";
            $html .= "<div class='like-heart'><img src='../_images/ui/favorite_off.png' /></div>";
			$html .= "<h3>".$menu_items[$i]['menu_item_name']."</h3>";
			// Josh R. edit
			$html .= "<p>".$menu_items[$i]['ingredients']."</p>";
			// Josh R. edit end	
            $first_allergy_alert = true;		
			for($j=0; $j<count($item_attributes_array); $j++) {
                if($menu_items[$i][$item_attributes_array[$j]] == 1) {
                    if(strrpos(ALLERGY_ALERT_ARRAY, $item_attributes_array[$j]) > -1) {
                        if($first_allergy_alert) {
                            $prepend_allery_list = "Contains";
                            $first_allergy_alert = false;
                        } else {
                            $prepend_allery_list = "";
                        }
                        $checkboxes .= "<span class='allergy-alert'>".$prepend_allery_list.str_replace("contains", "", $item_attributes_array[$j]). "</span>, ";
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
		echo $html;
	?>
</div>


<?php require_once(SERVER_ROOT . "/_includes/print-footer.php"); ?>