import * as init from './init.js';
$(document).ready(function () {
	const base_url = $('.base-url').data('baseurl');
	const xhr = new XMLHttpRequest();
	const tbl = $('#contact-tbl').DataTable({
		"destroy": true,
		"processing": true, 
        "serverSide": false,
        "lengthChange": false,
        "order": [], 
        "ajax": {
            "url": init.myurl('sendmail/Sendmail/kontak_perpage?page=0'),
            "type": "GET",
        },
        "columns": [
        	{
        		"data": null,
        		render: function ( data, type, row ) {
        			return data.id_contact;
        		}
        	},
        	{ "data":"nama_contact" },
        	{ "data":"email_contact" }
        ],
	});

	$('#send-page').change(function () {
		$('#contact-tbl').DataTable({
			"destroy": true,
			"processing": true, 
	        "serverSide": false,
	        "lengthChange": false,
	        "order": [], 
	        "ajax": {
	            "url": init.myurl('sendmail/Sendmail/kontak_perpage?page=')+$(this).val(),
	            "type": "GET",
	        },
	        "columns": [
	        	{
	        		"data": null,
	        		render: function ( data, type, row ) {
	        			return data.id_contact;
	        		}
	        	},
	        	{ "data":"nama_contact" },
	        	{ "data":"email_contact" }
	        ],
		});
	});

	$('#sendmail-form').submit(function () {
		swal({
			// title: `Apakah Anda yakin akan mengirim email pada kontak bagian ke ${parseInt($('#send-page').val())+1}?`,
			title: 'Apakah Anda yakin akan mengirim email? Pastikan sudah mengupload Video & Thumbnail',
			type: 'warning',
			showCancelButton: true,
			confirmButtonClass: 'btn btn-confirm mt-2',
			cancelButtonClass: 'btn btn-cancel ml-2 mt-2',
			confirmButtonText: 'Ya Saya sudah mengupload video & thumbnail',
			cancelButtonText: 'Tidak, sepertinya belum',
		}).then(function (result) {
			const data = JSON.stringify({
				subject: $('#send-subject').val()
			});
			xhr.onloadstart = function () {
				init.loading_start();
			};
			xhr.onloadend = function () {
				const response = JSON.parse(this.responseText);
				console.log(response);
				init.loading_stop();
				if (response.status == true) {
					init.toast({
						'status':'success',
						'message': response.message
					});
				}else{
					init.toast({
						'status':'error',
						'message': 'Sepertinya belum ada kontact yg di import, silahkan import terlebih dahulu ya...'
					});
				}
			}
			xhr.open("POST", init.myurl('act/sendmail.json'), true);
			xhr.send(data);
			return false;

		}, function(dismiss) {
			if (dismiss === 'cancel' || dismiss === 'close' || dismiss === 'overlay') {
				init.redirect('video-thumb.html');
			} 
		})
		return false;
	});
});