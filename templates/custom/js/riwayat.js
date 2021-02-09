$(document).ready(function () {
	const getUrl = window.location;
	// const base_url = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
	const base_url = $('.base-url').data('baseurl');
	const xhr = new XMLHttpRequest();
	const tbl = $('#tb-riwayat').DataTable({
		"processing": true, 
        "serverSide": true, 
        "order": [], 
        "ajax": {
            "url": base_url + '/datatable-riwayat?id=' + window.localStorage.getItem('myId'),
            "type": "POST",
        },
        "columnDefs": [{ 
            "targets": [ 0 ], 
            "orderable": false, 
       	}],
	});
	$(document).on('click', '.btn-detail', function () {
		const tbl2 = $('#tb-detail').DataTable({
			"destroy": true,
			"processing": true, 
	        "serverSide": false, 
	        "order": [], 
	        "ajax": {
	            "url": base_url + '/api/detail-get?id=' + $(this).data('id'),
	            "type": "GET",
	        },
	        "columns": [
	        	{ "data":"no" },
	        	{ "data":"jenis_biaya" },
	        	{ "data":"nominal" },
	        ],
		});

	});
});