$(document).ready(function () {
	const getUrl = window.location;
	// const base_url = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
	const base_url = $('.base-url').data('baseurl');
	const xhr = new XMLHttpRequest();
	const tbl = $('#tb-pembayaran').DataTable({
		"processing": true, 
        "serverSide": false, 
        "order": [], 
        "ajax": {
            "url": base_url + '/api/pembayaran-get?id=' + window.localStorage.getItem('myId'),
            "type": "GET",
        },
        "columns": [
        	{ "data":"id" },
        	{ "data":"jenis_biaya" },
        	{
        		"data": null,
        		render: function ( data, type, row ) {
        			return `Rp. ${data.nominal_biaya}`;
        		}
        	},
        	{
        		"data":null,
        		render: function ( data, type, row ) {
        			return `
        				<div class="checkbox checkbox-primary text-center">
                            <input type="checkbox" name="tandai[]" id="${data.id}" class="tandai" value="${data.id}">
                            <label for="${data.id}"></label>
                        </div>
        			`;
        		}
        	},
        ],
        // "columnDefs": [{ 
        //     "targets": [ 0 ], 
        //     "orderable": false, 
       	// }],
	});

	$('#btn-bayar-tandai').click(function (event) {
		var arr = new Array();
		$('form input[name="tandai[]"]:checked').each(function(){
	      arr.push($(this).attr("id"));
	    });
	    if (arr.length === 0) {
	    	$.toast({
				text: 'Silahkan tandai terlebih dahulu yang akan dibayar',
				position: 'top-right',
				loaderBg: '#da8609',
				icon: 'warning',
				hideAfter: 3000,
				stack: 1
			});
	    }else{
	    	event.preventDefault();
	    	const data = {
				'id': window.localStorage.getItem('myId'),
				'id_biaya': arr
			};
			$.ajax({
				url: base_url + '/api/midtrans-token-get.json',
				method: 'POST',
				data: JSON.stringify(data),
				success: function(response) {
					response = response.token;

					function changeResult(type, data){
						if (data.status_code == 201) {
							const post = {
								'id': window.localStorage.getItem('myId'),
								'order_id': data.order_id,
								'pdf': data.pdf_url,
								'total': data.gross_amount,
								'id_biaya': arr
							};
							$.ajax({
								url: base_url + '/api/midtrans-riwayat-post.json',
								method: 'POST',
								data: JSON.stringify(post),
								success: function(response2) {
									if (response2.status == true) {
										$.toast({
											text: response2.message,
											position: 'top-right',
											loaderBg: '#5ba035',
											icon: 'success',
											hideAfter: 3000,
											stack: 1
										});
										setTimeout(function () {
											window.location.href = base_url + '/riwayat-pembayaran.html'
										}, 3000)
									}else{
										$.toast({
											text: response2.message,
											position: 'top-right',
											loaderBg: '#bf441d',
											icon: 'error',
											hideAfter: 3000,
											stack: 1
										});
									}
								}
							})
						}
					}

					snap.pay(response, {
			          onSuccess: function(result){
			            changeResult('success', result);
			            // console.log(result);
			          },
			          onPending: function(result){
			            changeResult('pending', result);
			            // console.log(result.status_message);
			          },
			          onError: function(result){
			            changeResult('error', result);
			            // console.log(result.status_message);
			          }
			        });
				}
			});
	    }
	});

	$(document).on('click', '.btn-bayar', function (event) {
		event.preventDefault();
		const data = {
			'id': $(this).data('id')
		};
		$.ajax({
			url: base_url + '/api/midtrans-token-get.json',
			method: 'POST',
			data: JSON.stringify(data),
			success: function(response) {
				response = response.token;

				function changeResult(type, data){
					console.log(type, data);
				}

				snap.pay(response, {
		          onSuccess: function(result){
		            changeResult('success', result);
		            console.log(result);
		          },
		          onPending: function(result){
		            changeResult('pending', result);
		            console.log(result.status_message);
		          },
		          onError: function(result){
		            changeResult('error', result);
		            console.log(result.status_message);
		          }
		        });
			}
		});
	});
});