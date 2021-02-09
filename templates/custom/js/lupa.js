$(document).ready(function () {
	const getUrl = window.location;
	// const base_url = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
	const base_url = $('.base-url').data('baseurl');
	const xhr = new XMLHttpRequest();

	$('#btn-lupa').click(function () {
		if ($('#lupa-password').val() != $('#lupa-password-ulangi').val()) {
			$.toast({
				heading: 'Gagal!',
				text: 'Maaf password tidak sama',
				position: 'top-right',
				loaderBg: '#bf441d',
				icon: 'error',
				hideAfter: 3000,
				stack: 1
			});
		}else{
			if ($('#lupa-password').val() != "" && $('#lupa-password-ulangi').val() != "") {
				const data = {
					'token': $('#lupa-token').val(),
					'password': $('#lupa-password').val()
				};
				xhr.onloadstart = function () {};
				xhr.onloadend = function () {
					const response = JSON.parse(this.responseText);
					if (response.status == true) {
						$.toast({
							text: response.message,
							position: 'top-right',
							loaderBg: '#5ba035',
							icon: 'success',
							hideAfter: 3000,
							stack: 1
						});
						setTimeout(function () {
							window.location.href = base_url + '/login.html';
						}, 3100);
					}else{
						$.toast({
							heading: 'Gagal!',
							text: response.message,
							position: 'top-right',
							loaderBg: '#bf441d',
							icon: 'error',
							hideAfter: 3000,
							stack: 1
						});
					}
				};
				xhr.open("POST", base_url + '/api/lupa-submit-post', true);
				xhr.send(JSON.stringify(data));
			}
		}
	});
});