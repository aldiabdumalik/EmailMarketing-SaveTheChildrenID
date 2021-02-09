<div class="row">
	<div class="col-4">
		<div class="card-box">
			<form id="sendmail-form" class="form-horizontal">
				<div class="form-group">
					<label for="send-subject">subject</label>
					<input type="text" name="send-subject" id="send-subject" class="form-control" autocomplete="off" required>
				</div>
				<!-- <div class="form-group">
					<label for="send-page">pilih page</label>
					<select name="send-page" id="send-page" class="form-control" required>
						<?php for($i=0; $i < $page; $i++): ?>
						<option value="<?= $i ?>"><?= $i+1 ?></option>
						<?php endfor; ?>
					</select>
					<span style="font-size:10px;font-weight:bold;">Catatan: setiap page berisi 20 kontak email</span>
				</div> -->
				<div class="form-group">
					<button type="submit" class="btn btn-outline-success btn-block">Send Email</button>
				</div>
			</form>
		</div>
	</div>
	<div class="col-8">
		<div class="card-box">
			<table id="contact-tbl" class="table table-bordered dt-responsive nowrap my-table">
				<thead>
					<tr>
						<th>ID Kontak</th>
						<th>Nama</th>
						<th>Email</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>