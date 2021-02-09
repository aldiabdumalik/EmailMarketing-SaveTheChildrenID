import * as init from './init.js';
Dropzone.autoDiscover = false;
$(document).ready(function () {
	const base_url = $('.base-url').data('baseurl');
	const xhr = new XMLHttpRequest();

	var video_upload = new Dropzone("form#testDrop",{
		url: init.myurl('kosongan/kosong/test_upload'),
		maxFiles: 5,
		maxFilesize: 10,
		method:"post",
		acceptedFiles:".mp4",
		paramName:"userfile",
		autoProcessQueue : true,
		dictInvalidFileType:"Type file ini tidak dizinkan"
	});
	video_upload.on("success", function(file, response) {
		console.log(response);
	});
	video_upload.on("complete", function(file) {
		setTimeout(function () {
			video_upload.removeFile(file);
		}, 3000);
	});
});