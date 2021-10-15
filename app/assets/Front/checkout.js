import $ from 'jquery';
const total = $('#checkout-button').data('total') * 100;

var stripe = Stripe(
	'pk_test_51IrUFOIPqsC3XcMt1SFLXLTFuKXY9X3VvpLU0XIvcOPUVc36FpvWt2u7cwbk8JiM6sq8CpYAX9bLaMYxliOoLhUU00DhG9vQtY'
);
var checkoutButton = document.getElementById('checkout-button');

checkoutButton.addEventListener('click', function() {
	fetch(`/panier/validation/create-checkout-session`, {
		method: 'POST'
	})
	.then(function(response) {
		return response.json();
	})
	.then(function(session) {
		return stripe.redirectToCheckout({ sessionId: session.id });
	})
	.then(function(result) {
		// If redirectToCheckout fails due to a browser or network
		// error, you should display the localized error message to your
		// customer using error.message.
		if (result.error) {
			alert(result.error.message);
		}
	})
	.catch(function(error) {
		console.error('Error:', error.message);
	});
});
