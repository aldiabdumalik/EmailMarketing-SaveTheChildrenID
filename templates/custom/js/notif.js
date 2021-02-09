$(document).ready(function () {
	const getUrl = window.location;
	// const base_url = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
	const base_url = $('.base-url').data('baseurl');
	const xhr = new XMLHttpRequest();
	const tbl = $('#tb-notif').DataTable({
		"processing": true, 
        "serverSide": true, 
        "order": [], 
        "ajax": {
            "url": base_url + '/datatable-notifikasi?id=' + window.localStorage.getItem('myId'),
            "type": "POST",
        },
        "columnDefs": [{ 
            "targets": [ 0 ], 
            "orderable": false, 
       	}],
	});

	$(document).on('click', '.btn-read', function () {
		const data = {
			'id': window.localStorage.getItem('myId'),
			'notif': $(this).data('id')
		};
		xhr.onloadstart = function () {};
		xhr.onloadend = function () {
			const response = JSON.parse(this.responseText);
			tbl.ajax.reload();
		}
		xhr.open("POST", base_url + '/api/read-notif-post', true);
		xhr.send(JSON.stringify(data));
	});
});