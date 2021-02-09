import * as init from './init.js';
$(document).ready(function () {
	const base_url = $('.base-url').data('baseurl');
	const xhr = new XMLHttpRequest();
	$('#login-form').submit(function () {
		init.loading_start();
		const data = JSON.stringify({
			email:$('#login-id').val(),
			password:$('#login-password').val(),
		});
		xhr.onloadstart = function () {};
		xhr.onloadend = function () {
			const response = JSON.parse(this.responseText);
			init.loading_stop();
			if (response.status == true) {
				init.toast({
					'status':'success',
					'message': response.message,
					'url':'dashboard.html'
				});
			}else{
				init.toast({
					'status':'error',
					'message': response.message
				});
			}
		}
		xhr.open("POST", init.myurl('act/login.json'), true);
		xhr.send(data);
		return false;
	});
});