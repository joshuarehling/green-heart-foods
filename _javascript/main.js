$(document).ready(function() {

	/* 

	Create Menu Page 

	*/

	$('body.create_and_edit_menu').ready(function(event) {
		set_days_in_month();
	});
	
	$('.create_and_edit_menu select.month').change(function(event){
		set_days_in_month();
	});

	$('.create_and_edit_menu .price_per_order_input').keyup(function(event){
		var current_class = get_current_menu_item_class($(this));
		update_item_summary(current_class);
	});

	$('.create_and_edit_menu .servings_per_order_input').keyup(function(event){
		var current_class = get_current_menu_item_class($(this));
		// var input_value = $(this).val();
		// if(Math.floor(input_value) == input_value && $.isNumeric(input_value)) {
		// 	$(current_class+' .serves-output').html(input_value);
		// } else if (input_value === "") {
		// 	$(current_class+' .serves-output').html(0);
		// }
		update_item_summary(current_class);
	});

	$('.create_and_edit_menu .quantity_button').click(function(event){
		var target = $(this);
		handle_quantity_button_click(target);
	});

	$('.create_and_edit_menu .preview_menu_button').click(function(event){
		$('.create_menu_form').submit();
	});

	$('.create_and_edit_menu select.server').change(function(event) {
		var image_path = $('option:selected', this).attr('data-server-image-path');
		if(image_path == undefined) {
			$('.server_image').css('background-image', 'url(../_images/ui/default_server.jpg)');
		} else {
			$('.server_image').css('background-image', 'url(../'+image_path+')');
		}
	});

	/* 

	Daily Menu Page 

	*/

	$('.daily_menu_page .quantity_button').click(function(event){
		var target = $(this);
		handle_quantity_button_click(target);
	});

	$('.client .like-heart').click(function(event) {
		if($(this).hasClass('disabled')) {
			return;
		};
		var this_item = $(this);
		var menu_item_id = this_item.attr('data-menu-item-id');
		var increment_id = this_item.parent().attr('data-increment-id');
		$.post('../_actions/like-menu-item.php', { 
			menu_item_id: menu_item_id
		}).done(function(data){
			console.log(data);
			if(data == 1) {
				var current_count_span = $('.menu-item-'+increment_id+' .like_count');
				var current_count = Number(current_count_span.html());
				current_count++;
				current_count_span.html(current_count);
				this_item.addClass('liked disabled');
			}
		});
	});

	$('select.meal-types').change(function(event){
		var client_id = $(this).attr('data-client-id');
		var service_date = $(this).attr('data-service-date');
		var meal_id = $(this).val();
		document.location = '../admin/daily-menu.php?client-id='+client_id+'&service-date='+service_date+'&meal-id='+meal_id;
	});
});


function handle_quantity_button_click(target) {
	console.log("click");
	var current_class = get_current_menu_item_class(target);
	var total_orders_for_item = $(current_class+' .total_orders_for_item').html();
	if(target.hasClass('add')) {
		total_orders_for_item++;
	} else {
		total_orders_for_item--;
	}
	if(total_orders_for_item < 0) total_orders_for_item = 0;
	$(current_class+' .total_orders_for_item').html(total_orders_for_item);
	$(current_class+' .total_orders_for_item_hidden').val(total_orders_for_item);
	update_item_summary(current_class);
}

function get_current_menu_item_class(element) {
	var increment_id = element.closest('.menu-item').attr('data-increment-id');
	var current_class = '.menu-item-'+increment_id;
	return current_class;
}

function update_item_summary(current_class) {
	var order_count_for_item = Number($(current_class+' .total_orders_for_item').html());
	var price_per_order_input = $(current_class+' .price_per_order_input').val();
	var price_per_order = Number(price_per_order_input.replace("$", ""));
	var servings_per_order = Number($(current_class+' .servings_per_order_input').val());
	var total_orders_for_menu = 0;
	var total_served_for_menu = 0;
	var total_cost_for_menu = 0;
	if(isNaN(order_count_for_item) || isNaN(price_per_order)) {
		return;
	} else {
		var total_cost_for_item = order_count_for_item*price_per_order;
		var servings_count_for_item = order_count_for_item*servings_per_order;
		$(current_class+' .total_cost_for_item').html(total_cost_for_item);
		$(current_class+' .total_served_for_item').html(servings_count_for_item);
	}
	$('.total_orders_for_item').each(function(event){
		total_orders_for_menu += Number($(this).html());
	});
	$('.total_served_for_item').each(function(event){
		total_served_for_menu += Number($(this).html());
	});
	$('.total_cost_for_item').each(function(event){
		total_cost_for_menu += Number($(this).html());
	});
	$('.total_orders_for_menu').html(total_orders_for_menu);
	$('.total_served_for_menu').html(total_served_for_menu);
	$('.total_cost_for_menu').html("$"+total_cost_for_menu);

}

/* Function for setting the number of days in the selected month */

function set_days_in_month() {
	var month_number = $('select.month').val();
	var year = $('select.year').val();
	var days_in_month = new Date(year, month_number, 0).getDate();
	var html = "";
	var selected = "";
	var tomorrow = new Date();
	var leadingZeroDay = "";
	tomorrow.setDate(tomorrow.getDate() + 1);
	for (var i=1; i < days_in_month+1; i++) {
		if(i < 10) {
			leadingZeroDay = '0'+i;
		} else {
			leadingZeroDay = i;
		}
		if($('.current_day_edit_mode').val() == 0) {
			if(i === tomorrow.getDate()) {
				selected = "selected='selected'";
			} else {
				selected = "";
			}	
		} else {
			if($('.current_day_edit_mode').val() == i) {
				selected = "selected='selected'";
			} else {
				selected = "";
			}
		}
		
		html += "<option "+selected+" value='"+leadingZeroDay+"'>"+i+"</option>";
	};
	$('select.day').html(html);

	/* There must be a better way of doing this. */

	 [].slice.call( document.querySelectorAll( 'select.day' ) ).forEach( function(el) {	
	 	new SelectFx(el);
	 });

	 [].slice.call( document.querySelectorAll( 'select.year' ) ).forEach( function(el) {	
	 	new SelectFx(el);
	 });

	 [].slice.call( document.querySelectorAll( 'select.meal_type' ) ).forEach( function(el) {	
	 	new SelectFx(el);
	 });
	 
	 [].slice.call( document.querySelectorAll( 'select.server' ) ).forEach( function(el) {	
	 	new SelectFx(el);
	 });
}