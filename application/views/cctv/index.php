<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
	    <h1 class="h3 mb-0 text-gray-800 mb-3"><?= $title;  ?></h1>
	    <a href="<?= base_url('cctv/add'); ?>" class="btn btn-sm btn-primary shadow-sm" >
	        <i class="fas fa-fw fa-plus fa-sm text-white-50"></i>
	        <span class="text">Tambah</span>
	    </a>
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
	              <h6 class="m-0 font-weight-bold text-primary">Tabel Data User</h6>
	            </div>
				<div class="card-body">
					<div class="table-responsive">
				  		<table class="table table-user-management table-striped table-bordered table-sm" id="tabel-data">
						  <thead>
						    <tr>
						      <th scope="col">#</th>
						      <th scope="col">Status</th>
						      <th scope="col">Nama CCTV</th>
						      <th scope="col">Group</th>
						      <th scope="col">Link RTSP</th>
						      <th scope="col">Link M3U8</th>
						      <th scope="col">Latitude</th>
						      <th scope="col">Longitude</th>
						      <th scope="col">Tanggal</th>
						      <th scope="col">Action</th>
						    </tr>
						  </thead>
						  <tbody>
						  	<?php $i = 1; ?>
				  			<?php foreach ($dt_all as $data) : ?>
						    <tr>
						      <th scope="row"><?= $i++; ?></th>
						      <td>
						      	<?php if($data['stts'] == 1) { ?>
						      	<span class="badge badge-success">Aktif</span>
						      <?php } else { ?>
						      	<span class="badge badge-danger">Non-Aktif</span>
						      <?php } ?>
						      </td>
						      <td><?= $data['nm_cctv']; ?></td>
						      <td><?= $data['nm']; ?></td>
						      <td><?= $data['url_rtsp']; ?></td>
						      <td><?= $data['url_directory']; ?></td>
						      <td><?= $data['latitude']; ?></td>
						      <td><?= $data['longitude']; ?></td>
						      <td width="150px"><?= date('d F Y', $data['date_created']); ?></td>
						      <td class="text-center" width="140px">
						      		<a href="<?= base_url(); ?>cctv/edit/<?= $data['id_cctv']; ?>" class="badge badge-primary">
						      			<span class="icon text-white-50">
										  	<i class="fas fa-fw fa-edit"></i>
										</span>
										<span class="text">Edit</span>
									</a>
						      		<a href="<?= base_url(); ?>cctv/delete/<?= $data['id_cctv']; ?>" class="badge badge-danger" onclick="return confirm('yakin?');">
						      			<span class="icon text-white-50">
										  	<i class="fas fa-fw fa-trash"></i>
										</span>
										<span class="text">Delete</span>
						      		</a>
						      </td>
						    </tr>
						    <?php endforeach; ?>
						  </tbody>
						</table>
					</div>
					
				</div>
			</div>
	  	</div>
	</div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->