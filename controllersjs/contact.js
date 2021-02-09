import * as init from './init.js';
$(document).ready(function () {
	const base_url = $('.base-url').data('baseurl');
	const xhr = new XMLHttpRequest();
	const tbl = $('#contact-tbl').DataTable({
		"processing": true, 
		"serverSide": true, 
		"order": [], 
		"ajax": {
			"url": init.myurl('contact/Contact/DataTables'),
			"type": "POST",
		},
		"columnDefs": [{ 
			"targets": [ 0 ],
			"orderable": false,
		}],
	});

	$(document).on('click','.contact-delete', function () {
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
					'url': 'contact.html'
				});
			}else{
				init.toast({
					'status':'error',
					'message': 'Gagal menghapus contact...'
				});
			}
		}
		xhr.open("POST", init.myurl('act/delete-contact.json'), true);
		xhr.send(data);
		return false;
	});
});