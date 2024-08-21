<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
	    <h1 class="h3 mb-0 text-gray-800 mb-3"><?= $title;  ?></h1>
		    <a href="" class="btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#tambahGroup">
		        <i class="fas fa-fw fa-plus fa-sm text-white-50"></i>
		        <span class="text">Tambah Group</span>
		    </a>
	</div>

  	<div class="row clearfix">
	  	<div class="col-lg-12">
			
			<?= form_error('dataakun', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

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
					<div class="table-responsive"> 
				  		<table class="table table-dataAkun table-striped table-bordered table-sm" id="tabel-data">
						  <thead class="text-center">
						  	<tr>
						      <th scope="col">#</th>
						      <th scope="col">Nama</th>
							      <th scope="col" rowspan="2">Action</th>
						  	</tr>
						  </thead>
						  <tbody>
						  	<?php $i = 1; ?>
				  			<?php foreach ($dt_all as $row) : ?>
						    <tr>
						      <th width="5%" scope="row"><?= $i++; ?></th>
						      <td width="40%"><?= $row['nm']; ?></td>
							      <td class="text-center" width="20%">
							      		<a href="<?= base_url(); ?>group/detail/<?= $row['id_group']; ?>" class="badge badge-success" >
							      			<span class="icon text-white-50">
											  	<i class="fas fa-fw fa-eye"></i>
											</span>
											<span class="text">Detail</span>
							      		</a>
							      		<a href="" class="badge badge-primary updateGrup" data-toggle="modal" data-target="#updateGrup"
							      			data-id_group="<?= $row['id_group'] ?>"
							      			data-nm="<?= $row['nm'] ?>"
							      		>
							      			<span class="icon text-white-50">
											  	<i class="fas fa-fw fa-edit"></i>
											</span>
											<span class="text">Edit</span>
										</a>
							      		<a href="<?= base_url(); ?>group/delete/<?= $row['id_group']; ?>" class="badge badge-danger" onclick="return confirm('yakin?');">
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



<!-- Modal -->
<div class="modal fade" id="tambahGroup" tabindex="-1" role="dialog" aria-labelledby="tambahGroupLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahGroupLabel">Tambah Grup</h5>
      </div>
      <form action="<?= base_url('group/add'); ?>" method="post">
      	<div class="modal-body">
      		<div class="form-group row">
                <label for="nm" class="col-sm-5 col-form-label">Nama Grup</label>
                <div class="col-sm-7">
                	<input type="text" id="nm" name="nm" class="form-control" placeholder="Masukkan Nama" required="">
                </div>
            </div>
    	</div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
       </div>
    </div>
  </form>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="updateGrup" tabindex="-1" role="dialog" aria-labelledby="updateGrupLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateGrupLabel">Ubah Grup</h5>
      </div>
      <form action="<?= base_url('group/update'); ?>" method="post">
      	<div class="modal-body">
      		<div class="form-group row">
                <label for="bln" class="col-sm-5 col-form-label">Nama Grup</label>
                <div class="col-sm-7">
                	<input type="hidden" id="update_id_group" name="id_group" class="form-control" required="">
                	<input type="text" id="update_nm" name="nm" class="form-control" placeholder="Masukkan Nama Grup" required="">
                </div>
            </div>
    	</div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
       </div>
    </div>
  </form>
  </div>
</div>


<script type="text/javascript">
	$(".updateGrup").click(function(){
		let id_group = $(this).data('id_group');
		let nm = $(this).data('nm');

		$('#update_id_group').val(id_group);
		$('#update_nm').val(nm);
	});
</script>