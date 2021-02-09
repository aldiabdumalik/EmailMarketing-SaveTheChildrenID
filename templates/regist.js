$(document).ready(function() {
	$('#btn-next-1').click(function () {
		$('#form-1').addClass('collapse');
		$('#form-2').removeClass('collapse');
	});
	$('#btn-next-2').click(function () {
		$('#form-2').addClass('collapse');
		$('#form-3').removeClass('collapse');
	});
	$('#btn-back-2').click(function () {
		$('#form-2').addClass('collapse');
		$('#form-1').removeClass('collapse');
	});
});