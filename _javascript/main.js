$(document).ready(function() {

	// $Spelling.SpellCheckAsYouType('all');

	/* 



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
		$('.meals_per_day').val(0);
	});

	$('.create_and_edit_menu .server').click(function(event) {
		var image_path = $('option:selected', this).attr('data-server-image-path');
		if(image_path == undefined) {
			$('.server_image').css('background-image', 'url(../_images/ui/default_server.jpg)');
		} else {
			$('.server_image').css('background-image', 'url(../'+image_path+')');
		}
	});

	$('.create_and_edit_menu .meal_type').click(function(event) {
		var currentSelection = $('option:selected', this)[0].text;
		if (currentSelection == 'Bites') {
			$('.bites_form').addClass('bites_mode');
			$('.non_bites_form').addClass('bites_mode');
			$('.add_dish').hide();
		} else {
			$('.bites_form').removeClass('bites_mode');
			$('.non_bites_form').removeClass('bites_mode');
			$('.add_dish').show();
		}
	});

	var fieldset_id = 0;
	var active_fieldset;
	$('.create_and_edit_menu .add_dish').click(function(event) {
		fieldset_id++;
		active_fieldset = $('.create_menu_form').find("[data-fieldset-id='"+fieldset_id+"']");
		if(fieldset_id <= $('.meals_per_day').length) {
			active_fieldset.removeClass('hidden');	
		}
		if (fieldset_id == $('.meals_per_day').length-1) {
			$('.create_and_edit_menu .add_dish').fadeOut();
		}
		$('html, body').animate({
			scrollTop: active_fieldset.offset().top
		}, 1000);
	});

	$('.create_and_edit_menu .add_blank_dish').click(function(event) {
		event.preventDefault();
		$('form.add_blank_dish').submit();
	});


	$('.create_and_edit_menu .bites_form .bite_container .quantity').click(function(event) {
		var quantityContainer = $(this).parent().find('.bite_quantity');
		var currentQuantity = $(this).parent().find('.bite_quantity').val();
		if ($(this).hasClass('plus_button')) {
			currentQuantity++;
		} else if ($(this).hasClass('minus_button')) {
			currentQuantity--;
		}
		if(currentQuantity < 0){
			currentQuantity = 0;
		}
		quantityContainer.val(currentQuantity);
		// fieldset_id++;
		// active_fieldset = $('.create_menu_form').find("[data-fieldset-id='"+fieldset_id+"']");
		// if(fieldset_id <= $('.meals_per_day').length) {
		// 	active_fieldset.removeClass('hidden');	
		// }
		// if (fieldset_id == $('.meals_per_day').length-1) {
		// 	$('.create_and_edit_menu .add_dish').fadeOut();
		// }
		// $('html, body').animate({
		// 	scrollTop: active_fieldset.offset().top
		// }, 1000);
	});

	$('.create_menu_page .cancel_button').click(function(event){
		event.preventDefault();
		window.history.back();
	});

	/* 

	Daily Menu Page 

	*/

	$('.daily_menu_page .quantity_button').click(function(event){
		var target = $(this);
		handle_quantity_button_click(target);
	});

	$('.client .like-heart').click(function(event) {
		if($(this).hasClass('liked')) {
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
				this_item.addClass('liked');
			}
		});
	});

	$('.daily_menu_page .meal-types').change(function(event){
		var client_id = $(this).attr('data-client-id');
		var service_date = $(this).attr('data-service-date');
		var admin_or_client = $(this).attr('data-admin-or-client');
		//var meal_id = $(this).attr('data-meal-id'); //$(this).val();
		var meal_id = $(this).val();
		document.location = '../'+admin_or_client+'/daily-menu.php?client-id='+client_id+'&service-date='+service_date+'&meal-id='+meal_id;
	});


	$('.edit_menu_page .meal-types').change(function(event){
		var client_id = $(this).attr('data-client-id');
		var service_date = $(this).attr('data-service-date');
		var admin_or_client = $(this).attr('data-admin-or-client');
		var meal_id = $(this).val();
		document.location = '../'+admin_or_client+'/edit-daily-menu.php?client-id='+client_id+'&service-date='+service_date+'&meal-id='+meal_id;
	});

	/* Weekly Menu Page */ 

	$('.weekly_menu_page .meal_type').change(function(event){
		var client_id = $(this).attr('data-client-id');
		var start_date = $(this).attr('data-start-date');
		var admin_or_client = $(this).attr('data-admin-or-client');
		var meal_id = $(this).val();
		document.location = '../'+admin_or_client+'/weekly-menu.php?client-id='+client_id+'&start-date='+start_date+'&meal-id='+meal_id;
	});

	/* Weekly Menu - Print Placards Page */ 

	// $('.weekly_menu_print_placards_page').on('click','.plus_minus_container a', {} ,function(e){
	addNinthClass();
	$('.print_placards_page').on('click','.plus_minus_container a', {} ,function(e){
		if($(event.target).hasClass('plus')) {
			var meal_container_clone = $(this).closest('.meal_container').clone();
			$(this).closest('.meal_container').after(meal_container_clone);
		} else {
			$(this).closest('.meal_container').remove();
		}
		addNinthClass();		
	});

	function addNinthClass(){
		$('.print_placards_page .meal_container').removeClass('ninth');
		$('.print_placards_page .meal_container').each(function(i){
			if(i%9 == 8) {
				$($('.print_placards_page .meal_container').get(i)).addClass('ninth');
			}
		});
	}

	$('.weekly_menu_print_placards_page').on('click','.meal_container .editable', {} ,function(e){
		$('.weekly_menu_print_placards_page .meal_container.blank').removeClass('unedited');
	});

	/* 

	Yearly Menu Page 

	*/

	$('.yearly_menu_page .week_meal_container.grid_view').click(function(event){
		document.location = $(this).attr('data_view_link');
	});

	
	/* 

	Add Bite 

	*/

	
	$('.edit_bites_page .add_bite').click(function(event){
		var bite_group_id = $(this).attr('data-bite-group-id');
		$.ajax({
			url: '../admin/add-bite-modal.php?bite-group-id='+bite_group_id,
			method: 'GET'
		}).done(function(html) {
			load_modal(html);
		});
	});


	/* 

	Edit Bites Page 

	*/


	$('.edit_bites_page .edit_bite').click(function(event){
		var bite_id = $(this).attr('data-bite-id');
		$.ajax({
			url: '../admin/edit-bite-modal.php?bite-id='+bite_id, 
			method: 'GET'
		}).done(function(html) {
			load_modal(html);
		});
	});

	$('.edit_bites_page .edit_bites_done').click(function(event){
		window.history.back();
	});	



});


function load_modal(html){
	$('.edit_bites_page').append(html);
	$('.edit_bites_page').addClass('no_scroll');
	$('.edit_bites_page .add_edit_bite_modal_content .close_button, .edit_bites_page .add_edit_bite_modal_content .cancel_button').click(function(event){
		$('.add_edit_bite_modal').remove();
		$('.edit_bites_page').removeClass('no_scroll');
	});
	// $('.edit_bite_form').submit(function(event){
		// event.preventDefault();
		// console.log("Form Submit");
		// var bite_name = $('.bite_name').val();
		// console.log(bite_name);
	// });
}


/* Shared Functions */


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
		var total_cost_for_item = (order_count_for_item*price_per_order).toFixed(2);
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
	$('.total_cost_for_menu').html("$"+total_cost_for_menu.toFixed(2));

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
}