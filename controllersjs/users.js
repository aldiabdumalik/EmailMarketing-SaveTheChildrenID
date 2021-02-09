import * as init from './init.js';
$(document).ready(function () {
	const base_url = $('.base-url').data('baseurl');
	const xhr = new XMLHttpRequest();
	const tbl = $('#users-tbl').DataTable({
		"processing": true, 
		"serverSide": true, 
		"order": [], 
		"ajax": {
			"url": init.myurl('users/Users/DataTables'),
			"type": "POST",
		},
		"columnDefs": [{ 
			"targets": [ 0 ],
			"orderable": false,
		}],
	});
	$('#users-form').submit(function () {
		const data = JSON.stringify({
			id: $('#users-id').val(),
			nama: $('#users-nama').val(),
			email: $('#users-email').val(),
			password: $('#users-password').val(),
			level: $('#users-level').val()
		});
		xhr.onloadstart = function () {
			init.loading_start();
		};
		xhr.onloadend = function () {
			const response = JSON.parse(this.responseText);
			console.log(response);
			init.loading_stop();
			if (response.status == true) {
				$('#users-form').trigger('reset');
				$('#users-form input:hidden').val('');
				$('#users-simpan').text('Save');
				init.toast({
					'status':'success',
					'message': response.message,
					'url':'users.html'
				});
			}else{
				init.toast({
					'status':'error',
					'message': response.message
				});
			}
		}
		xhr.open("POST", init.myurl('act/create-users.json'), true);
		xhr.send(data);
		return false;
	});
	$(document).on('click','.users-edit', function () {
		const id = $(this).data('id');
		xhr.onloadstart = function () {
			init.loading_start();
		};
		xhr.onloadend = function () {
			const response = JSON.parse(this.responseText);
			init.loading_stop();
			if (response.status == true) {
				const res = response.data[0];
				$('#users-id').val(res.id);
				$('#users-fromfield').val(res.fromfield);
				$('#users-nama').val(res.nama);
				$('#users-email').val(res.email);
				$('#users-password').val(res.password);
				$('#users-level').val(res.level);
				$('#users-simpan').text('Update');
			}else{
				init.toast({
					'status':'error',
					'message': 'User tidak ditemukan...'
				});
			}
		}
		xhr.open("GET", init.myurl('act/call-users.json?id' + id), true);
		xhr.send();
		return false;
	});
	$(document).on('click','.users-delete', function () {
		const id = $(this).data('id');
		const data = JSON.stringify({
			id:id
		});
		xhr.onloadstart = function () {
			init.loading_start();
		};
		xhr.onloadend = function () {
			const response = JSON.parse(this.responseText);
			init.loading_stop();
			if (response.status == true) {
				init.toast({
					'status':'success',
					'message': response.message,
					'url': init.myurl('users.html')
				});
			}else{
				init.toast({
					'status':'error',
					'message': 'Gagal menghapus user...'
				});
			}
		}
		xhr.open("POST", init.myurl('act/delete-users.json'), true);
		xhr.send(data);
		return false;
	});
	$('#users-batal').click(function () {
		$('#users-form').trigger('reset');
		$('#users-form input:hidden').val('');
		$('#users-simpan').text('Save');
	});
});