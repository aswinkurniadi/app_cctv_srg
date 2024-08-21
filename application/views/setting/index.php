<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
	    <h1 class="h3 mb-0 text-gray-800 mb-3"><?= $title;  ?></h1>
	</div>

  	<div class="row clearfix">
	  	<div class="col-lg-12">
			
			<?= $this->session->flashdata('message'); ?>
			
		</div>
	</div>


	<div class="row">
		<div class="col-sm-12">
	  		<div class="card border-bottom-primary shadow mb-4">
	            <div class="card-header py-3">
	              <h6 class="m-0 font-weight-bold text-primary">Tabel <?= $title;  ?></h6>
	            </div>
				<div class="card-body">
						<form action="<?= base_url('setting/save_domain'); ?>" method="post">
							<div class="form-group row">
				                <label for="domain" class="col-sm-3 col-form-label">Domain</label>
				                <div class="col-sm-7">
				                	<input type="text" id="domain" name="domain" class="form-control" value="<?= $dtByid['domain']; ?>" placeholder="Masukkan Domain" required="">
				                </div>
				                <div class="col-sm-2">
				                	<button type="submit" class="btn btn-primary">
				                		<i class="fa-solid fa-floppy-disk"></i>
				                	</button>
				                </div>
				            </div>
						</form>
						<form action="<?= base_url('setting/save_url_xampp'); ?>" method="post">
							<div class="form-group row">
				                <label for="url_xampp" class="col-sm-3 col-form-label">Directory Xampp</label>
				                <div class="col-sm-7">
				                	<input type="text" id="url_xampp" name="url_xampp" class="form-control" value="<?= $dtByid['url_xampp']; ?>" placeholder="Masukkan Url Xampp" required="">
				                </div>
				                <div class="col-sm-2">
				                	<button type="submit" class="btn btn-primary">
				                		<i class="fa-solid fa-floppy-disk"></i>
				                	</button>
				                </div>
				            </div>
						</form>
				</div>
			</div>
	  	</div>
	</div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
