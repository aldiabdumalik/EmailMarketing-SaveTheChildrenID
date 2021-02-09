$(document).ready(function () {
	const getUrl = window.location;
	const base_url = $('.base-url').data('baseurl');
	const xhr = new XMLHttpRequest();

	$('#btn-masuk').click(function () {
		const data = {
			'id': $('#login-id').val(),
			'password': $('#login-password').val()
		};
		if (is_valid(data) == true) {
			xhr.onloadstart = function () {};
			xhr.onloadend = function () {
				const response = JSON.parse(this.responseText);
				if (response.status == true) {
					window.localStorage.setItem('myId', response.data.myId);
					// window.localStorage.setItem('myKelas', $('#daftar-kelas').val());
					$.toast({
						// heading: 'Well done!',
						text: response.message,
						position: 'top-right',
						loaderBg: '#5ba035',
						icon: 'success',
						hideAfter: 3000,
						stack: 1
					});
					window.location.href = base_url + 'dashboard.html';
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
			xhr.open("POST", base_url + 'api/login-submit-post', true);
			xhr.send(JSON.stringify(data));
		}else{
			$.toast({
				// heading: 'Maaf form tidak lengkap!',
				text: 'Silahkan isi id & password terlebih dahulu',
				position: 'top-right',
				loaderBg: '#da8609',
				icon: 'warning',
				hideAfter: 3000,
				stack: 1
			});
		}
	});

	$('#btn-lupa').click(function () {
		$(this).prop('disabled', true);
		$(this).html('<i class="fa fa-circle-o-notch fa-spin"></i> Loading');
		const data = {
			'id': $('#lupa-id').val(),
			'email': $('#lupa-email').val()
		};
		if (is_valid(data) == true) {
			xhr.onloadstart = function () {};
			xhr.onloadend = function () {
				const response = JSON.parse(this.responseText);
				console.log(response);
				if (response.status == true) {
					$.toast({
						text: response.message,
						position: 'top-right',
						loaderBg: '#5ba035',
						icon: 'success',
						hideAfter: 3000,
						stack: 1
					});
					$('#login-modal').modal('hide');
					// window.location.href = base_url + '/dashboard.html';
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
			xhr.open("POST", base_url + 'api/kirim-email-post', true);
			xhr.send(JSON.stringify(data));
		}else{
			$.toast({
				text: 'Silahkan isi id & email terlebih dahulu',
				position: 'top-right',
				loaderBg: '#da8609',
				icon: 'warning',
				hideAfter: 3000,
				stack: 1
			});
		}
	});

	function is_valid(data) {
		var result = true;
		$.each(data, function (i, data) {
			if (data == "") {
				result = false;
			}
		});
		return result;
	}
});