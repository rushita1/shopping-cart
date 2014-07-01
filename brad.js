$(function() {

	// Model
	var cart = {};

	var catTemplate = Handlebars.compile($('#catalog').html());
	$('.masterCat').append(catTemplate(default_products));

	// Click Add
	$('.addItem').on('click', function() {
		
		// Get our class name resource
		var className = $(this).parent().attr('class');

		// Update our Model
		if (cart[className]) {
			cart[className]++;
		} else {
		 	cart[className] = 1;
		}
			// $('#cart_data').val(JSON.stringify(cart));

		renderView();

	});

	// Click Remove One
	// If your target is not going to exist until after the page is loaded,
	// Then you have to write all of your events slightly differently. The
	// way that its different, is that now the second argument is the target
	$('body').on('click', '.cart button', function() {
		var className = $(this).parent().attr('class');
		
		if (cart[className] > 1) {
			cart[className]--;
		} else {
			delete cart[className];
		}

		renderView();
	});

	// Remove All
	$('.removeAll').on('click', function() {

		// loop and delete all contents
		// for (i in cart) {
		// 	delete cart[i];
		// }
		cart = {};

		renderView();
	});



	// Render the View
	var renderView = function() {

		// Wipe out whatever DOM is currently in the cart
		$('.cart').html('');

		// Loop the entire cart, and build the whole thing
		for (i in cart) {



			$('<li>')
				
				.append(i + ': ' + cart[i])
				.append('<button>Remove</button>')
				.addClass(i)
				.appendTo('.cart');
			

		}

	}

	// As soon as the page loads, we render the whole thing
	renderView();

});