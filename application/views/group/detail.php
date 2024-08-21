<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
	    <h1 class="h3 mb-0 text-gray-800 mb-3"><?= $title;  ?></h1>
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
						      <th scope="col">Status</th>
						      <th scope="col">Nama CCTV</th>
						      <th scope="col">Group</th>
						      <th scope="col">Link RTSP</th>
						      <th scope="col">Link M3U8</th>
						      <th scope="col">Latitude</th>
						      <th scope="col">Longitude</th>
						      <th scope="col">Tanggal</th>
						  	</tr>
						  </thead>
						  <tbody>
						  	<?php $i = 1; ?>
				  			<?php foreach ($dt_allRes as $data) : ?>
						    <tr>
						      <th scope="row"><?= $i++; ?></th>
						      <td>
						      	<?php if($data['stts'] == 1) { ?>
						      	<span class="badge badge-success">Aktif</span>
						      <?php } else { ?>
						      	<span class="badge badge-danger">Non-Aktif</span>
						      <?php } ?>

						      		<a href="" class="badge badge-primary updateGrup" data-toggle="modal" data-target="#updateGrup"
						      			data-id_cctv="<?= $data['id_cctv'] ?>"
						      			data-id_group="<?= $data['id_group'] ?>"
						      		>
						      			<span class="icon text-white-50">
										  	<i class="fas fa-fw fa-edit"></i>
										</span>
										<span class="text">Ubah Group</span>
									</a>
						      </td>
						      <td><?= $data['nm_cctv']; ?></td>
						      <td><?= $data['nm']; ?></td>
						      <td><?= $data['url_rtsp']; ?></td>
						      <td><?= $data['url_directory']; ?></td>
						      <td><?= $data['latitude']; ?></td>
						      <td><?= $data['longitude']; ?></td>
						      <td width="150px"><?= date('d F Y', $data['date_created']); ?></td>
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
<div class="modal fade" id="updateGrup" tabindex="-1" role="dialog" aria-labelledby="updateGrupLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateGrupLabel">Ubah Grup</h5>
      </div>
      <form action="<?= base_url('group/update_group'); ?>" method="post">
      	<div class="modal-body">
        	<input type="hidden" id="update_id_cctv" name="id_cctv" class="form-control" required="">
        	<input type="hidden" id="update_id_group_lm" name="id_group_lm" class="form-control" required="">

      		<div class="form-group row">
                <label for="bln" class="col-sm-5 col-form-label">Nama Grup</label>
                <div class="col-sm-7">
                    <select name="id_group" id="update_id_group" class="form-control bootstrap-select" title="Pilih Group" required="">
                      <?php foreach ($dt_group as $row) : ?>
                        <option value="<?= $row['id_group']; ?>" ><?= $row['nm']; ?></option>
                      <?php endforeach; ?>
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
	$(".updateGrup").click(function(){
		let id_cctv = $(this).data('id_cctv');
		let id_group = $(this).data('id_group');

		$('#update_id_cctv').val(id_cctv);
		$('#update_id_group_lm').val(id_group);
		$('#update_id_group').val(id_group).prop("selected", true).change();
	});
</script>