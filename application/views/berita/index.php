<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
	    <h1 class="h3 mb-0 text-gray-800 mb-3"><?= $title;  ?></h1>
	    <?php if (is_user()) : ?>
		    <a href="" class="btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#tambahBerita">
		        <i class="fas fa-fw fa-plus fa-sm text-white-50"></i>
		        <span class="text">Tambah Berita</span>
		    </a>
	    <?php endif; ?>
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
						      <th scope="col">Berita</th>
						      <th scope="col">Status</th>
						      <?php if (is_user()) : ?>
							      <th scope="col" rowspan="2">Action</th>
							  <?php endif; ?>
						  	</tr>
						  </thead>
						  <tbody>
						  	<?php $i = 1; ?>
				  			<?php foreach ($dt_all as $row) : ?>
						    <tr>
						      <th width="10px" scope="row"><?= $i++; ?></th>
						      <td width=""><?= $row['desk']; ?></td>
						      <td width="20px" class="text-center"><?= ($row['stts'] == 1) ? 'On' : 'Off'; ?></td>
						      <?php if (is_user()) : ?>
							      <td class="text-center" width="15%">
							      		<a href="" class="badge badge-primary updateBerita" data-toggle="modal" data-target="#updateBerita"
							      			data-id_berita="<?= $row['id_berita'] ?>"
							      			data-desk="<?= $row['desk'] ?>"
							      			data-stts="<?= $row['stts'] ?>"
							      		>
							      			<span class="icon text-white-50">
											  	<i class="fas fa-fw fa-edit"></i>
											</span>
											<span class="text">Edit</span>
										</a>
							      		<a href="<?= base_url(); ?>berita/delete/<?= $row['id_berita']; ?>" class="badge badge-danger" onclick="return confirm('yakin?');">
							      			<span class="icon text-white-50">
											  	<i class="fas fa-fw fa-trash"></i>
											</span>
											<span class="text">Delete</span>
							      		</a>
							      </td>
							  <?php endif; ?>
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
<div class="modal fade" id="tambahBerita" tabindex="-1" role="dialog" aria-labelledby="tambahBeritaLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahBeritaLabel">Tambah Berita</h5>
      </div>
      <form action="<?= base_url('berita/add'); ?>" method="post">
      	<div class="modal-body">
      		<div class="form-group row">
                <label for="bln" class="col-sm-5 col-form-label">Deskripsi</label>
                <div class="col-sm-7">
                	<input type="text" id="desk" name="desk" class="form-control" placeholder="Masukkan Deskripsi" required="">
                </div>
            </div>
            <div class="form-group row">
                <label for="tahun" class="col-sm-5 col-form-label">Status</label>
                <div class="col-sm-7">
                	<select id="stts" name="stts" class="form-control" required="">
                		<option value="">Pilih Status</option>
                		<option value="0">Tidak Aktif</option>
                		<option value="1">Aktif</option>
                	</select>
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
<div class="modal fade" id="updateBerita" tabindex="-1" role="dialog" aria-labelledby="updateBeritaLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateBeritaLabel">Ubah Berita</h5>
      </div>
      <form action="<?= base_url('berita/update'); ?>" method="post">
      	<div class="modal-body">
      		<div class="form-group row">
                <label for="bln" class="col-sm-5 col-form-label">Deskripsi</label>
                <div class="col-sm-7">
                	<input type="hidden" id="update_id_berita" name="id_berita" class="form-control" required="">
                	<input type="text" id="update_desk" name="desk" class="form-control" placeholder="Masukkan Deskripsi" required="">
                </div>
            </div>
            <div class="form-group row">
                <label for="tahun" class="col-sm-5 col-form-label">Status</label>
                <div class="col-sm-7">
                	<select id="update_stts" name="stts" class="form-control" required="">
                		<option value="">Pilih Status</option>
                		<option value="0">Tidak Aktif</option>
                		<option value="1">Aktif</option>
                	</select>
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
	$(".updateBerita").click(function(){
		let id_berita = $(this).data('id_berita');
		let desk = $(this).data('desk');
		let stts = $(this).data('stts');

		$('#update_id_berita').val(id_berita);
		$('#update_desk').val(desk);
		$("#update_stts option[value='" + stts + "']").prop("selected", true).trigger('change');
	});
</script>