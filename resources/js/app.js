require('./bootstrap');

$(() => {
	setTimeout(() => {
	  $('.alert-success').fadeOut(1000);
	  $('.alert-info').fadeOut(1000);
	}, 1500);
});
