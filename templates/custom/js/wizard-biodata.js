$(document).ready(function () {
	const getUrl = window.location;
	const base_url = $('.base-url').data('baseurl');
	const xhr = new XMLHttpRequest();
	$('#lengkapi-ttl-tanggal').datepicker({
		format: 'yyyy-mm-dd'
	});
	$("#wizard-vertical-test").steps({
		headerTag: "h3",
		bodyTag: "section",
		transitionEffect: "slideLeft",
		stepsOrientation: "vertical",
		onFinished: function (event, currentIndex) {
			const data = {
				'id': window.localStorage.getItem('myId'),
				'kelas':  $('#lengkapi-type').val(),
				'program': $('#lengkapi-program').val(),
				'prodi': $('#lengkapi-program-studi').val(),
				'jurusan': $('#lengkapi-program-jurusan').val().toString(),
				'nama': $('#lengkapi-nama').val(),
				'tempat': $('#lengkapi-ttl-tempat').val(),
				'tl': $('#lengkapi-ttl-tanggal').val(),
				'jenkel': $('#lengkapi-jenkel').val(),
				'provinsi': $('#lengkapi-provinsi').val(),
				'kabupaten': $('#lengkapi-kabupaten').val(),
				'kecamatan': $('#lengkapi-kecamatan').val(),
				'alamat': $('#lengkapi-alamat').val(),
				'telepon': $('#lengkapi-nohp').val(),
				'email': $('#lengkapi-email').val(),
				'ibu': $('#lengkapi-ibu').val(),
				'survey': $('#lengkapi-survey').val()
			};
			const reguler = {
				'asal':  $('#lengkapi-sekolah').val(),
				'almt':  $('#lengkapi-alamat-sekolah').val(),
				'lulus':  $('#lengkapi-tahun-lulus').val(),
			};
			const karyawan = {
				'pendidikan': $('#lengkapi-pendidikan').val(),
				'asal': $('#lengkapi-sekolah').val(),
				'almt': $('#lengkapi-alamat-sekolah').val(),
				'perusahaan': $('#lengkapi-perusahaan').val(),
				'jabatan': $('#lengkapi-jabatan').val(),
				'pengalaman': $('#lengkapi-lama-kerja').val(),
			};
			const newData = ($('#lengkapi-type').val() == 'reguler' ? forreguler(data, reguler) : forkaryawan(data, karyawan));
			if (is_valid(newData) == true) {
				xhr.onloadstart = function () {};
				xhr.onloadend = function () {
					const response = JSON.parse(this.responseText);
					if (response.status == true) {
						swal({
							title: 'Berhasil!',
							text: response.message,
							type: 'success',
							confirmButtonClass: 'btn btn-confirm mt-2'
						}).then(function () {
							window.location.href = base_url + 'dashboard.html';
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
				xhr.open("POST", base_url + 'api/lengkapi-post', true);
				xhr.send(JSON.stringify(newData));
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
		}
	});
	function forkaryawan(data, karyawan) {
		var fix={};
		for(var _obj in data) fix[_obj ]=data[_obj];
		for(var _obj in karyawan) fix[_obj ]=karyawan[_obj];
		return fix;
	}
	function forreguler(data, reguler) {
		var fix={};
		for(var _obj in data) fix[_obj ]=data[_obj];
		for(var _obj in reguler) fix[_obj ]=reguler[_obj];
		return fix;
	}
    $("#lengkapi-program-jurusan").select2();
	$("#lengkapi-survey").select2();
	getProdi();
	function getMHS() {
		xhr.onloadstart = function () {};
		xhr.onloadend = function () {
			const response = JSON.parse(this.responseText);
			if (response.status == true) {
				const data = response.data;
				$('#lengkapi-nama').val(data.nama_mhs);
				$('#lengkapi-ttl-tempat').val(data.tempat_mhs);
				$('#lengkapi-ttl-tanggal').val(data.tl_mhs);
				$('#lengkapi-jenkel').val(data.jenkel_mhs);
				$('#lengkapi-alamat').val(data.alamat_mhs);
				$('#lengkapi-nohp').val(data.telepon_mhs);
				$('#lengkapi-email').val(data.email_mhs);
				getProvinsi(data.provinsi_mhs, data.kabupaten_mhs, data.kecamatan_mhs);
			}
		};
		xhr.open("GET", base_url + 'api/pendaftaran-mhs-get?id=' + window.localStorage.getItem('myId'), true);
		xhr.send();
	}
	function getProdi() {
		xhr.onloadstart = function () {};
		xhr.onloadend = function () {
			const response = JSON.parse(this.responseText);
			if (response.status == true) {
				$.each(response.data, function (i, data) {
					$('#lengkapi-program-studi').append($("<option></option>")
	                    .attr({"value": data.id, "data-val": data.code_pstudi})
	                    .text(data.nama_pstudi)); 
				});
				$('#lengkapi-program-studi').change(function () {
					changeProdi($(this).val());
				});
			}
			getMHS();
		};
		xhr.open("GET", base_url + 'api/pendaftaran-prodi-get', true);
		xhr.send();
	}
	function changeProdi($id) {
		xhr.onloadstart = function () {
			$('#lengkapi-program-jurusan').empty();
		};
		xhr.onloadend = function () {
			const response = JSON.parse(this.responseText);
			if (response.status == true) {
				$.each(response.data, function (i, data) {
					$('#lengkapi-program-jurusan').append($("<option></option>")
	                    .attr({"value": data.id, "data-val": data.code_jurusan})
	                    .text(data.nama_jurusan));
				});
			}
		};
		xhr.open("GET", base_url + 'api/pendaftaran-jurusan-get?id=' + $id, true);
		xhr.send();
	}
	function getProvinsi($id=null, $kab=null, $kec=null) {
		xhr.onloadstart = function () {
			$('#lengkapi-kabupaten').html('<option value="">Silahkan pilih kabupaten</option>');
			$('#lengkapi-kecamatan').html('<option value="">Silahkan pilih kecamatan</option>');
		};
		xhr.onloadend = function () {
			const response = JSON.parse(this.responseText);
			if (response.status == true) {
				$.each(response.data, function (i, data) {
					$('#lengkapi-provinsi').append($("<option></option>")
	                    .attr({"value": data.id, "data-val": data.id})
	                    .text(data.nama_provinsi)); 
				});
				$('#lengkapi-provinsi').change(function () {
					changeKabupaten($(this).val());
				});
				if ($id!=null) {
					$('#lengkapi-provinsi').val($id);
					changeKabupaten($id, $kab, $kec);
				}
			}
		};
		xhr.open("GET", base_url + 'api/pendaftaran-provinsi-get', true);
		xhr.send();
	}
	function changeKabupaten($id, $kab=null, $kec=null) {
		xhr.onloadstart = function () {
			$('#lengkapi-kabupaten').html('<option value="">Silahkan pilih kabupaten</option>');
			$('#lengkapi-kecamatan').html('<option value="">Silahkan pilih kecamatan</option>');
		};
		xhr.onloadend = function () {
			const response = JSON.parse(this.responseText);
			if (response.status == true) {
				$.each(response.data, function (i, data) {
					$('#lengkapi-kabupaten').append($("<option></option>")
	                    .attr({"value": data.id, "data-val": data.id})
	                    .text(data.nama_kabupaten));
				});
				$('#lengkapi-kabupaten').change(function () {
					changeKecamatan($(this).val());
				});
				if ($kab!=null) {
					$('#lengkapi-kabupaten').val($kab);
					changeKecamatan($kab, $kec);
				}
			}
		};
		xhr.open("GET", base_url + 'api/pendaftaran-kabupaten-get?id=' + $id, true);
		xhr.send();
	}
	function changeKecamatan($id, $kec=null) {
		xhr.onloadstart = function () {
			$('#lengkapi-kecamatan').html('<option value="">Silahkan pilih kecamatan</option>');
		};
		xhr.onloadend = function () {
			const response = JSON.parse(this.responseText);
			if (response.status == true) {
				$.each(response.data, function (i, data) {
					$('#lengkapi-kecamatan').append($("<option></option>")
	                    .attr({"value": data.id, "data-val": data.id})
	                    .text(data.nama_kecamatan));
				});
				if ($kec!=null) {
					$('#lengkapi-kecamatan').val($kec);
				}
			}
		};
		xhr.open("GET", base_url + 'api/pendaftaran-kecamatan-get?id=' + $id, true);
		xhr.send();
	}

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