<div class="row">
	<div class="col-12 col-xl-4">
		<div class="card-box">
			<form id="users-form" class="form-horizontal">
				<input type="hidden" name="users-id" id="users-id" class="form-control" readonly>
				<input type="hidden" name="users-fromfield" id="users-fromfield" class="form-control" readonly>
				<div class="form-group">
					<label for="users-nama">Nama</label>
					<input type="text" name="users-nama" id="users-nama" class="form-control" autocomplete="off" required>
				</div>
				<div class="form-group">
					<label for="users-email">Email</label>
					<input type="email" name="users-email" id="users-email" class="form-control" autocomplete="off" required>
				</div>
				<div class="form-group">
					<label for="users-password">password</label>
					<input type="password" name="users-password" id="users-password" class="form-control" autocomplete="off" required>
				</div>
				<div class="form-group">
					<label for="users-level">Level</label>
					<select name="users-level" id="users-level" class="form-control" required>
						<option value="">Pilih level</option>
						<option value="1">Admin</option>
						<option value="2">User</option>
					</select>
				</div>
				<div class="form-group">
					<button type="submit" id="users-simpan" class="btn btn-custom btn-block">Save</button>
				</div>
				<div class="form-group">
					<button type="button" id="users-batal" class="btn btn-default btn-block">Cancel</button>
				</div>
			</form>
		</div>
	</div>
	<div class="col-12 col-xl-8">
		<div class="card-box">
			<table id="users-tbl" class="table table-bordered dt-responsive nowrap my-table">
				<thead>
					<tr>
						<th>No.</th>
						<th>ID</th>
						<th>Nama</th>
						<th>Email</th>
						<th>Level</th>
						<th>Option</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>