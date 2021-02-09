$(document).ready(function () {
	const getUrl = window.location;
	const base_url = $('.base-url').data('baseurl');
	const xhr = new XMLHttpRequest();
	$('.dropify').dropify();
	$('#modal-loading').modal({
        backdrop: 'static',
        keyboard: true, 
        show: false
    });
    $('#ubah-tanggal').datepicker({
		format: 'yyyy-mm-dd'
	});

	function initProvinsi(prov, kab, kec) {
		xhr.onloadend = function () {
			const response = JSON.parse(this.responseText);
			if (response.status == true) {
				$.each(response.data, function (i, data) {
					$('#ubah-provinsi').append($("<option></option>")
	                    .attr({"value": data.id, "data-val": data.id})
	                    .text(data.nama_provinsi)); 
				});
				$('#ubah-provinsi').val(prov);
				initKabupaten(kab, kec);
			}
		};
		xhr.open("GET", base_url + '/api/pendaftaran-provinsi-get', true);
		xhr.send();
	}
	function initKabupaten(kab, kec) {
		xhr.onloadend = function () {
			const response = JSON.parse(this.responseText);
			if (response.status == true) {
				$.each(response.data, function (i, data) {
					$('#ubah-kabupaten').append($("<option></option>")
	                    .attr({"value": data.id, "data-val": data.id})
	                    .text(data.nama_kabupaten));
				});
				$('#ubah-kabupaten').val(kab);
				initKecamatan(kec)
			}
		};
		xhr.open("GET", base_url + '/api/pendaftaran-kabupaten-get?id=' + $('#ubah-provinsi').val(), true);
		xhr.send();
	}
	function initKecamatan(kec) {
		xhr.onloadend = function () {
			const response = JSON.parse(this.responseText);
			if (response.status == true) {
				$.each(response.data, function (i, data) {
					$('#ubah-kecamatan').append($("<option></option>")
	                    .attr({"value": data.id, "data-val": data.id})
	                    .text(data.nama_kecamatan));
				});
				$('#ubah-kecamatan').val(kec);
			}
		};
		xhr.open("GET", base_url + '/api/pendaftaran-kecamatan-get?id=' + $('#ubah-kabupaten').val(), true);
		xhr.send();
	}

	function init() {
		xhr.onloadstart = function () {};
		xhr.onloadend = function () {
			const response = JSON.parse(this.responseText);
			const data = response.data;
			initProvinsi(data.provinsi_mhs, data.kabupaten_mhs, data.kecamatan_mhs);
			$('#ubah-nama').val(data.nama_mhs);
			$('#ubah-tempat').val(data.tempat_mhs);
			$('#ubah-tanggal').val(data.tl_mhs);
			$('#ubah-jenkel').val(data.jenkel_mhs);
			$('#ubah-telepon').val(data.telepon_mhs);
			$('#ubah-email').val(data.email_mhs);
			$('#ubah-alamat').val(data.alamat_mhs);
		}
		xhr.open("GET", base_url + 'api/Api_mhs/mhs?id=' + window.localStorage.getItem('myId'), true);
		xhr.send();
	}

	init()

	$('#ubah-form').submit(function () {
		const formData = new FormData();
		formData.append("id", window.localStorage.getItem('myId'))
		if ($('#ubah-foto')[0].files.length != 0) {
			formData.append("is_upload", 'yes');
			formData.append("foto", $('#ubah-foto')[0].files[0]);
		}else{
			formData.append("is_upload", null);
		}
		formData.append("nama", $('#ubah-nama').val())
		formData.append("tempat", $('#ubah-tempat').val())
		formData.append("tanggal", $('#ubah-tanggal').val())
		formData.append("jenkel", $('#ubah-jenkel').val())
		formData.append("telepon", $('#ubah-telepon').val())
		formData.append("email", $('#ubah-email').val())
		formData.append("alamat", $('#ubah-alamat').val())
		formData.append("provinsi", $('#ubah-provinsi').val())
		formData.append("kabupaten", $('#ubah-kabupaten').val())
		formData.append("kecamatan", $('#ubah-kecamatan').val())
		xhr.onloadstart = function () {
		    $('#modal-loading').modal('show');
		};
		xhr.onloadend = function () {
			const response = JSON.parse(this.responseText);
			hideModal();
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
					window.location.href = base_url + 'dashboard.html';
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
				setTimeout(function () {
					window.location.href = base_url + 'dashboard.html';
				}, 3100);
			}
		}
		xhr.open("POST", base_url + 'api/Api_mhs/ubah', true);
		xhr.send(formData);
		return false;
	});

	function hideModal(){
        $("#modal-loading").removeClass("in");
        $(".modal-backdrop").remove();
        $("#modal-loading").hide();
    }
});