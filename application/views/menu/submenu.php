<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
	    <h1 class="h3 mb-0 text-gray-800 mb-3"><?= $title;  ?></h1>
	    <?php if (is_admin()) : ?>
		    <a href="" class="btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#tambahMenu">
		        <i class="fas fa-fw fa-plus fa-sm text-white-50"></i>
		        <span class="text">Tambah</span>
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
	              <h6 class="m-0 font-weight-bold text-primary">Tabel <?= $title;  ?> (Menu <?= $dt_menu['nama'];  ?>)</h6>
	            </div>
				<div class="card-body">
					<div class="table-responsive"> 
				  		<table class="table table-dataAkun table-striped table-bordered table-sm" id="tabel-data">
						  <thead class="text-center">
						  	<tr>
						      <th scope="col">#</th>
						      <th scope="col">Nama Menu</th>
						      <th scope="col">Url</th>
						      <?php if (is_admin()) : ?>
							      <th scope="col" rowspan="2">Action</th>
							  <?php endif; ?>
						  	</tr>
						  </thead>
						  <tbody>
						  	<?php $i = 1; ?>
				  			<?php foreach ($dt_all as $row) : ?>
						    <tr>
						      <th width="5%" scope="row"><?= $i++; ?></th>
						      <td width="40%"><?= $row['nama']; ?></td>
						      <td width="40%"><?= $row['url']; ?></td>
						      <?php if (is_admin()) : ?>
							      <td class="text-center" width="20%">
							      		<a href="" class="badge badge-primary updateSubMenu" data-toggle="modal" data-target="#updateSubMenu"
							      			data-id_sub_menu="<?= $row['id_sub_menu'] ?>"
							      			data-id_menu="<?= $row['id_menu'] ?>"
							      			data-nama="<?= $row['nama'] ?>"
							      			data-url="<?= $row['url'] ?>"
							      			>
							      			<span class="icon text-white-50">
											  	<i class="fas fa-fw fa-edit"></i>
											</span>
											<span class="text">Edit</span>
										</a>
							      		<a href="<?= base_url(); ?>menu/delete/<?= $row['id_menu']; ?>" class="badge badge-danger" onclick="return confirm('yakin?');">
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
<div class="modal fade" id="tambahMenu" tabindex="-1" role="dialog" aria-labelledby="tambahMenuLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahMenuLabel">Tambah Menu</h5>
      </div>
      <form action="<?= base_url('menu/add_sub_menu'); ?>" method="post">
      	<div class="modal-body">
      		<div class="form-group row">
                <label for="nama" class="col-sm-5 col-form-label">Nama</label>
                <div class="col-sm-7">
                	<input type="hidden" id="id_menu" name="id_menu" class="form-control" value="<?= $id_menu; ?>" required="">
                	<input type="text" id="nama" name="nama" class="form-control" placeholder="Masukkan Nama" required="">
                </div>
            </div>
      		<div class="form-group row">
                <label for="url" class="col-sm-5 col-form-label">Url</label>
                <div class="col-sm-7">
                	<input type="text" id="url" name="url" class="form-control" placeholder="Masukkan url" required="">
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
<div class="modal fade" id="updateSubMenu" tabindex="-1" role="dialog" aria-labelledby="updateSubMenuLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateSubMenuLabel">Ubah Menu</h5>
      </div>
      <form action="<?= base_url('menu/sub_menu_update'); ?>" method="post">
      	<div class="modal-body">
      		<div class="form-group row">
                <label for="bln" class="col-sm-5 col-form-label">Nama Menu</label>
                <div class="col-sm-7">
                	<input type="hidden" id="update_id_menu" name="id_menu" class="form-control" required="">
                	<input type="hidden" id="update_id_sub_menu" name="id_sub_menu" class="form-control" required="">
                	<input type="text" id="update_nama" name="nama" class="form-control" placeholder="Masukkan Nama Menu" required="">
                </div>
            </div>
      		<div class="form-group row">
                <label for="url" class="col-sm-5 col-form-label">Url</label>
                <div class="col-sm-7">
                	<input type="text" id="update_url" name="url" class="form-control" placeholder="Masukkan url" required="">
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
<div class="modal fade" id="updateSubMenu" tabindex="-1" role="dialog" aria-labelledby="updateSubMenuLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateSubMenuLabel">Ubah Menu</h5>
      </div>
      <form action="<?= base_url('menu/sub_menu_update'); ?>" method="post">
      	<div class="modal-body">
        	<input type="hidden" id="update_id_menu" name="id_menu" class="form-control" required="">
        	<input type="hidden" id="update_id_sub_menu" name="id_sub_menu" class="form-control" required="">

        	
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
       </div>
    </div>
  </form>
  </div>
</div>


<script type="text/javascript">
	$(".updateSubMenu").click(function(){
		let id_sub_menu = $(this).data('id_sub_menu');
		let id_menu = $(this).data('id_menu');
		let nama = $(this).data('nama');
		let url_nm = $(this).data('url');

		$('#update_id_sub_menu').val(id_sub_menu);
		$('#update_id_menu').val(id_menu);
		$('#update_nama').val(nama);
		$('#update_url').val(url_nm);
	});
</script>