<div class="row">
	<div class="col-12">
		<div class="card-box">
			<p class="text-center">Upload Thumbnail</p>
			<div class="text-center">
				<p>Upload thumbnail dengan menggunakan nama thumbnail harus sesuai id kontak masing-masing, lihat id kontak pada excel dibawah</p>
				<a href="<?= base_url('video/Video/download_format') ?>" target="_blank" class="btn btn-outline-warning btn-sm">Download Format</a>
			</div>
			<div style="margin-top:10px;"></div>
			<form action="#" class="dropzone" id="video-thumbnail">
				<div class="fallback">
					<input name="file2" type="file" multiple />
				</div>
			</form>
		</div>
	</div>
	<div class="col-12">
		<div class="card-box">
			<p class="text-center">Upload Video</p>
			<div class="text-center">
				<p>Upload video dengan menggunakan nama video harus sesuai id kontak masing-masing, lihat id kontak pada excel dibawah</p>
				<a href="<?= base_url('video/Video/download_format') ?>" target="_blank" class="btn btn-outline-warning btn-sm">Download Format</a>
			</div>
			<div style="margin-top:10px;"></div>
			<form action="#" class="dropzone" id="video-nama">
				<div class="fallback">
					<input name="file" type="file" multiple />
				</div>
			</form>
		</div>
	</div>
</div>
<!-- <form id="video-form" class="form-horizontal">
	<div class="form-group">
		<label for="video-thumbnail">Thumbnail</label>
		<input type="file" name="video-thumbnail" id="video-thumbnail" class="dropify">
	</div>
	<div class="form-group">
		<label for="video-nama">Video</label>
		<input type="file" name="video-nama" id="video-nama" class="dropify">
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-custom btn-block">Save</button>
	</div>
</form> -->