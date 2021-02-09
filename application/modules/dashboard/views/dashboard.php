<div class="row">
    <div class="col-12">
        <div class="card-box">
            <div class="text-center">
                <div class="row">
                    <div class="col-12 col-xl-4">
                        <div class="card-box widget-flat border-custom bg-custom text-white">
                            <i class="fa fa-external-link"></i>
                            <h3 class="m-b-10"><?= $click ?></h3>
                            <p class="text-uppercase m-b-5 font-13 font-600">Click Link <br/> Bulan Ini</p>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="card-box widget-flat border-custom bg-primary text-white">
                            <i class="fa fa-play"></i>
                            <h3 class="m-b-10"><?= $watching ?></h3>
                            <p class="text-uppercase m-b-5 font-13 font-600">Tonton Video <br/> Bulan Ini</p>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="card-box widget-flat border-custom bg-warning text-white">
                            <i class="fa fa-download"></i>
                            <h3 class="m-b-10"><?= $download ?></h3>
                            <p class="text-uppercase m-b-5 font-13 font-600">Download <br/> Bulan Ini</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-xl-6">
	    <div class="card-box">
	    	<p class="text-center">Download Report Excel</p>
	    	<form action="<?= base_url('report-action.json'); ?>" method="POST" id="report-form" class="form-horizontal">
	    		<?php if ($this->session->mylevel == 1): ?>
	    		<div class="form-group">
	    			<label for="report-user">User</label>
	    			<select name="report-user" id="report-user" class="form-control" required>
	    				<option value="">Pilih User</option>
	    				<?php foreach ($users as $user): ?>
	    				<option value="<?= $user->id ?>"><?= $user->id.' - '.$user->nama ?></option>
	    				<?php endforeach; ?>
	    			</select>
	    		</div>
	    		<?php endif ?>
	    		<div class="form-group">
	    			<label for="report-action">Aksi Report</label>
	    			<select name="report-action" id="report-action" class="form-control" required>
	    				<option value="">Pilih Aksi</option>
	    				<option value="click">Click Link</option>
	    				<option value="watching">Tonton Video</option>
	    				<option value="download">Download Video</option>
	    				<option value="all">Semua Aksi</option>
	    			</select>
	    		</div>
	    		<div class="form-group">
	    			<label for="report-bulan">Bulan</label>
	    			<select name="report-bulan" id="report-bulan" class="form-control" required>
	    				<option value="">Pilih bulan</option>
	    				<option value="1">Januari</option>
	    				<option value="2">Februari</option>
	    				<option value="3">Maret</option>
	    				<option value="4">April</option>
	    				<option value="5">Mei</option>
	    				<option value="6">Juni</option>
	    				<option value="7">Juli</option>
	    				<option value="8">Agustus</option>
	    				<option value="9">September</option>
	    				<option value="10">Oktober</option>
	    				<option value="11">November</option>
	    				<option value="12">Desember</option>
	    				<option value="all">Semua bulan</option>
	    			</select>
	    		</div>
	    		<div class="form-group">
	    			<label for="report-tahun">Tahun</label>
	    			<select name="report-tahun" id="report-tahun" class="form-control" required>
	    				<option value="">Pilih tahun</option>
	    				<?php for ($i=2021; $i <= date('Y'); $i++): ?>
	    				<option value="<?= $i ?>"><?= $i ?></option>
	    				<?php endfor; ?>
	    			</select>
	    		</div>
	    		<div class="form-group">
	    			<button type="submit" class="btn btn-custom btn-block"><i class="fa fa-download"></i> Download</button>
	    		</div>
	    	</form>
	    </div>
    </div>
</div>