$(document).ready(function () {
	const getUrl = window.location;
	// const base_url = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
	const base_url = $('.base-url').data('baseurl');
	const xhr = new XMLHttpRequest();
	$('#daftar-tl').datepicker({
		format: 'yyyy-mm-dd'
	});
	getProvinsi();
	function getProvinsi() {
		xhr.onloadstart = function () {
			$('#daftar-kabupaten').html('<option value="">Silahkan pilih kabupaten</option>');
			$('#daftar-kecamatan').html('<option value="">Silahkan pilih kecamatan</option>');
		};
		xhr.onloadend = function () {
			const response = JSON.parse(this.responseText);
			if (response.status == true) {
				$.each(response.data, function (i, data) {
					$('#daftar-provinsi').append($("<option></option>")
	                    .attr({"value": data.id, "data-val": data.id})
	                    .text(data.nama_provinsi)); 
				});
				$('#daftar-provinsi').change(function () {
					changeKabupaten($(this).val());
				});
			}
			keyupEmail();
		};
		xhr.open("GET", base_url + '/api/pendaftaran-provinsi-get', true);
		xhr.send();
	}
	function changeKabupaten($id) {
		xhr.onloadstart = function () {
			$('#daftar-kabupaten').html('<option value="">Silahkan pilih kabupaten</option>');
			$('#daftar-kecamatan').html('<option value="">Silahkan pilih kecamatan</option>');
		};
		xhr.onloadend = function () {
			const response = JSON.parse(this.responseText);
			if (response.status == true) {
				$.each(response.data, function (i, data) {
					$('#daftar-kabupaten').append($("<option></option>")
	                    .attr({"value": data.id, "data-val": data.id})
	                    .text(data.nama_kabupaten));
				});
				$('#daftar-kabupaten').change(function () {
					changeKecamatan($(this).val());
				});
			}
		};
		xhr.open("GET", base_url + '/api/pendaftaran-kabupaten-get?id=' + $id, true);
		xhr.send();
	}
	function changeKecamatan($id) {
		xhr.onloadstart = function () {
			$('#daftar-kecamatan').html('<option value="">Silahkan pilih kecamatan</option>');
		};
		xhr.onloadend = function () {
			const response = JSON.parse(this.responseText);
			if (response.status == true) {
				$.each(response.data, function (i, data) {
					$('#daftar-kecamatan').append($("<option></option>")
	                    .attr({"value": data.id, "data-val": data.id})
	                    .text(data.nama_kecamatan));
				});
			}
		};
		xhr.open("GET", base_url + '/api/pendaftaran-kecamatan-get?id=' + $id, true);
		xhr.send();
	}
	function keyupEmail() {
		$('#daftar-email').keyup(function () {
			xhr.onloadstart = function () {};
			xhr.onloadend = function () {
				const response = JSON.parse(this.responseText);
				if (response.status == true) {
					$.toast({
						// heading: 'Maaf!',
						text: 'Maaf email sudah terdaftar, silahkan menggunakan email yang lain',
						position: 'top-right',
						loaderBg: '#bf441d',
						icon: 'error',
						hideAfter: 3000,
						stack: 1
					})
					$('#daftar-email').val("");
				}
			};
			xhr.open("GET", base_url + '/api/pendaftaran-email-get?email=' + $(this).val(), true);
			xhr.send();
		});
	}

	$('#btn-daftar').click(function () {
		const data = {
			'nama': $('#daftar-nama').val(),
			'tempat': $('#daftar-tempat').val(),
			'tl': $('#daftar-tl').val(),
			'jenkel': $('#daftar-jenkel').val(),
			'provinsi': $('#daftar-provinsi').val(),
			'kabupaten': $('#daftar-kabupaten').val(),
			'kecamatan': $('#daftar-kecamatan').val(),
			'alamat': $('#daftar-alamat').val(),
			'telepon': $('#daftar-telepon').val(),
			'email': $('#daftar-email').val(),
			'password': $('#daftar-password').val(),
			'kelas':  $('#daftar-kelas').val()
		};
		if (is_valid(data) == true) {
			if (data.password == $('#daftar-ulangi-password').val()) {
				swal({
					title: 'Apakah yakin data yang Anda masukan sudah benar?',
					// text: "Apakah yakin data yang Anda masukan sudah benar?",
					type: 'warning',
					showCancelButton: true,
					confirmButtonClass: 'btn btn-confirm mt-2',
					cancelButtonClass: 'btn btn-cancel ml-2 mt-2',
					confirmButtonText: 'Yakin!'
				}).then(function () {
					xhr.onloadstart = function () {};
					xhr.onloadend = function () {
						const response = JSON.parse(this.responseText);
						if (response.status == true) {
							window.localStorage.setItem('myId', response.data.id);
							window.localStorage.setItem('myKelas', $('#daftar-kelas').val());
							swal({
								title: 'Berhasil!',
								text: response.message,
								type: 'success',
								confirmButtonClass: 'btn btn-confirm mt-2'
							}).then(function () {
								window.location.href = base_url + '/lengkapi-pendaftaran.html';
							});
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
					xhr.open("POST", base_url + '/api/pendaftaran-submit-post', true);
					xhr.send(JSON.stringify(data));
				})
			}else{
				$.toast({
					heading: 'Password tidak sama!',
					// text: 'Change a few things up and try submitting again.',
					position: 'top-right',
					loaderBg: '#bf441d',
					icon: 'error',
					hideAfter: 3000,
					stack: 1
				});
			}
		}else{
			$.toast({
				heading: 'Maaf form tidak lengkap!',
				text: 'Harap melengkapi semua data terlebih dahulu',
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