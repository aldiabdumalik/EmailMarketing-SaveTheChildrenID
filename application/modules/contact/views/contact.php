<div class="row">
	<div class="col-4">
		<div class="card-box">
			<form id="contact-form" class="form-horizontal">
				<div class="form-group">
					<a href="<?= base_url('contact/Contact/download_template') ?>" target="_blank" class="btn btn-outline-warning btn-block">Download Kontak Template</a>
				</div>
				<div class="form-group">
					<button type="button" class="btn btn-outline-success btn-block" data-target="#contact-modal" data-toggle="modal">Import Kontak</button>
				</div>
			</form>
		</div>
	</div>
	<div class="col-8">
		<div class="card-box">
			<table id="contact-tbl" class="table table-bordered dt-responsive nowrap my-table">
				<thead>
					<tr>
						<th>No.</th>
						<th>Nama</th>
						<th>Email</th>
						<th>Option</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>
<div id="contact-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
				<form method="post" enctype="multipart/form-data" action="<?= base_url() ?>contact/Contact/import_contact">
					<div class="form-group">
						<label for="exampleInputFile">File Upload</label>
						<input type="file" name="berkas_excel" class="form-control" id="exampleInputFile">
					</div>
					<button type="submit" class="btn btn-primary">Import</button>
				</form>
            </div>
        </div>
    </div>
</div>