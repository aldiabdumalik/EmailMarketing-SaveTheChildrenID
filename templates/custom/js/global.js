$(document).ready(function () {
	const getUrl = window.location;
	// const base_url = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
	const base_url = $('.base-url').data('baseurl');
	const xhr = new XMLHttpRequest();
	// if (window.localStorage.getItem('myId') != null && window.localStorage.getItem('myId') != undefined) {
	// 	getNotif(window.localStorage.getItem('myId'));
	// }
	// function getNotif($id) {
	// 	xhr.onloadstart = function () {};
	// 	xhr.onloadend = function () {
	// 		const response = JSON.parse(this.responseText);
	// 		if (response.status == true) {
	// 			$('#count-notif').html(response.jml);
	// 			$.each(response.data, function (i, data) {
	// 				$('#isi-notif').append(`
	// 					<a href="javascript:void(0);" class="dropdown-item notify-item">
 //                            <div class="notify-icon bg-success"><i class="mdi mdi-comment-account-outline"></i></div>
 //                            <p class="notify-details">${data.subjek_notif}<small class="text-muted">${data.waktu}</small></p>
 //                        </a>
	// 				`);
	// 			});
	// 		}
	// 	};
	// 	xhr.open("GET", base_url + '/api/system-notif-get?id=' + $id, true);
	// 	xhr.send();
	// }

	$('#btn-logout').click(function () {
		window.localStorage.clear();
		window.location.href = base_url + '/logout.html';
	});

	// var loading_start = new (function () {
	// 	$('body').loading({
	// 		theme: 'dark'
	// 	});
	// })();
	// var loading_stop = function () {
	// 	$('body').loading('stop');
	// }
});