import * as init from './init.js';
Dropzone.autoDiscover = false;
$(document).ready(function () {
	const base_url = $('.base-url').data('baseurl');
	const xhr = new XMLHttpRequest();

	var thumb_upload = new Dropzone("form#video-thumbnail",{
		url: init.myurl('video/Video/upload_thumb'),
		maxFiles: 10,
		maxFilesize: 10,
		method:"post",
		acceptedFiles:".jpg",
		paramName:"userfile",
		autoProcessQueue : true,
		dictInvalidFileType:"Type file ini tidak dizinkan",
		dictDefaultMessage: "Klik atau Tarik untuk upload Thumbnail (Max 10 file per-upload)"
	});
	thumb_upload.on("success", function(file, response) {
		response = JSON.parse(response);
		init.toast({
			'status':'success',
			'message': response.message
		});
	});
	
	var video_upload = new Dropzone("form#video-nama",{
		url: init.myurl('video/Video/upload_video'),
		maxFiles: 10,
		maxFilesize: 10,
		method:"post",
		acceptedFiles:".mp4",
		paramName:"userfile",
		autoProcessQueue : true,
		dictInvalidFileType:"Type file ini tidak dizinkan",
		dictDefaultMessage: "Klik atau Tarik untuk upload Video (Max 10 file per-upload)"
	});
	video_upload.on("success", function(file, response) {
		response = JSON.parse(response);
		init.toast({
			'status':'success',
			'message': response.message
		});
	});
	video_upload.on("complete", function(file) {
		setTimeout(function () {
			video_upload.removeFile(file);
		}, 3000);
	});




	// get_video();
	function get_video() {
		xhr.onloadstart = function () {
			init.loading_start();
		};
		xhr.onloadend = function () {
			const response = JSON.parse(this.responseText);
			init.loading_stop();
			if (response.status == true) {
				var imagenUrl = init.myurl('uploads/thumb/') + response.data.thumb_video;
				var drEvent = $('#video-thumbnail').dropify(
				{
					defaultFile: imagenUrl
				});
				drEvent = drEvent.data('dropify');
				drEvent.resetPreview();
				drEvent.clearElement();
				drEvent.settings.defaultFile = imagenUrl;
				drEvent.destroy();
				drEvent.init();

				var videoUrl = init.myurl('uploads/video/') + response.data.nama_video;
				var drEvent2 = $('#video-nama').dropify(
				{
					defaultFile: videoUrl
				});
				drEvent2 = drEvent2.data('dropify');
				drEvent2.resetPreview();
				drEvent2.clearElement();
				drEvent2.settings.defaultFile = videoUrl;
				drEvent2.destroy();
				drEvent2.init();
			}else{
				init.toast({
					'status':'error',
					'message': response.message
				});
			}
		}
		xhr.open("GET", init.myurl('act/call-video.json'), true);
		xhr.send();
		return false;
	}
	$('#video-form').submit(function () {
		const formData = new FormData();
		if ($('#video-thumbnail')[0].files.length != 0) {
			formData.append("upload_thumb", 'yes');
			formData.append("thumbnail", $('#video-thumbnail')[0].files[0]);
		}else{
			formData.append("upload_thumb", null);
		}
		if ($('#video-nama')[0].files.length != 0) {
			formData.append("upload_video", 'yes');
			formData.append("video", $('#video-nama')[0].files[0]);
		}else{
			formData.append("upload_video", null);
		}
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
					'message': response.message,
					'url':'dashboard.html'
				});
			}else{
				init.toast({
					'status':'error',
					'message': response.message
				});
			}
		}
		xhr.open("POST", init.myurl('act/update-video.json'), true);
		xhr.send(formData);
		return false;
	});
});