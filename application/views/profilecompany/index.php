<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
	    <h1 class="h3 mb-0 text-gray-800"><?= $title;  ?></h1>
	</div>
  	
  	<div class="row clearfix">
	  	<div class="col-lg-12">
			
			<?= form_error('dataakun', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

			<?= $this->session->flashdata('message'); ?>
			
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
	  		<div class="card border-bottom-success shadow mb-4">
	            <div class="card-header py-3">
	            	<div class="row">
				  		<div class="col-sm-12 text-right">
				  			<?php if (is_admin()) : ?>
					  			<a href="<?= base_url('profilecompany/edit_profile_perusahaan/'); ?><?= $profile['id_profile']; ?>" class="btn btn-sm btn-success">
					  				<i class="fas fa-fw fa-print fa-sm text-white-50"></i>
		        					<span class="text">Update Profile</span>
					  			</a>
				  			<?php endif; ?>
				  		</div>
				  	</div>
	            </div>
				<div class="card-body">
					<div class="row justify-content-center">
						<div class="col-md-4">
			                <img src="<?= base_url('assets/img/profile_perusahaan/') . $profile['logo']; ?>" class="card-img">
			            </div>
		            </div>
		            <div class="row">
						<div class="col-md-12 text-center">
							<h2 class="mb-4"><?= $profile['name']; ?></h2>
							<p class=""><?= $profile['almt']; ?> <br><?= $profile['no_telp']; ?> | <?= $profile['email']; ?></p>
						</div>
						<div class="col-md-12 text-center">
							<p class=""><?= $profile['deskripsi']; ?></p>
						</div>
					</div>
				</div>
			</div>
	  	</div>
	</div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
