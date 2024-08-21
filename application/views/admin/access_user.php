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
		<div class="col-sm-6">
	  		<div class="card border-bottom-primary shadow mb-4">
	            <div class="card-header py-3">
	            	<div class="row">
		              <div class="col-sm-6">
			              <h6 class="m-0 font-weight-bold text-primary">Tabel Access User</h6>
		              </div>
		              <div class="col-sm-6 text-right">
		              	<input type="checkbox" id="checkAll" > Check All
		              	<!-- <span class="btn btn-sm btn-primary" id="checkAll">Check All</span> -->
		              </div>
	              </div>
	            </div>

	            <?= form_open_multipart(''); ?>

                <input type="hidden" class="form-control" id="id_role" name="id_role" value="<?= $id_role; ?>" readonly>
				<div class="card-body">

	                <div class="row">
	                  <div class="col-sm">
							<div class="table-responsive">
						  		<table class="table table-user-management table-striped table-bordered table-sm" id="tabel-data">
								  <thead>
								    <tr>
								      <th scope="col">#</th>
								      <th scope="col">Nama</th>
								      <th scope="col">Url</th>
								      <th scope="col">Pilih</th>
								    </tr>
								  </thead>
								  <tbody>
								  	<?php $i = 1; ?>
						  			<?php foreach ($dt_all_menu as $data) : ?>
								    <tr>
								      <th scope="row"><?= $i++; ?></th>
								      <td colspan="3"><?= $data['nama']; ?></td>
						  			<?php foreach ($data['dt_sub_menu'] as $row) : 
						  				$checked = ($row['stts_access'] == 1) ? "checked" : "";
						  				?>
								    <tr>
								      <th scope="row"></th>
								      <td><?= $row['nama']; ?></td>
								      <td><?= $row['url']; ?></td>
								      <td>
								      	<div class="input-group">
										  <div class="input-group-prepend">
										    <div class="input-group-text">
										      <input type="checkbox" value="<?= $row['id_sub_menu']; ?>" name="id_sub_menu[]" aria-label="Checkbox for following text input" <?= $checked; ?>>
										    </div>
										  </div>
										</div>
								      </td>
								    </tr>

								    <?php endforeach; ?>
								    <?php endforeach; ?>
								  </tbody>
								</table>
							</div>
						</div>
					</div>

	                <hr class="mb-3 mt-3">
	                <div class="row">
	                  <div class="col-sm text-right">
	                      <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
	                  </div>
	                </div>
				</div>

	            </form>
			</div>
		</div>
	</div>
	

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<script>
	$(document).ready(function(){
		$("#checkAll").click(function(){
		    $('input:checkbox').not(this).prop('checked', this.checked);
		});
	});
</script>