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
				<div class="card-body">
					
			      <form action="" method="post">
					<div class="form-group row">
		                <label for="domain" class="col-sm-3 col-form-label">Group</label>
		                <div class="col-sm-7">
		                    <select name="id_group" id="update_id_group" class="form-control bootstrap-select" title="Pilih Group" required="">
		                      <?php foreach ($dt_group as $row) : ?>		                      	
		                        <?php $selected = ($dt_LiveById['id_group'] == $row['id_group']) ? 'selected' : null; ?>
		                        <option value="<?= $row['id_group']; ?>" <?= $selected; ?> ><?= $row['nm']; ?></option>
		                      <?php endforeach; ?>
		                    </select>
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

	<div class="row">
		<div class="col-sm-12">
	  		<div class="card border-bottom-primary shadow mb-4">
	            <div class="card-header py-3">
	              <h6 class="m-0 font-weight-bold text-primary">Live CCTV (Group : <?= $dt_LiveById['nm']; ?>)</h6>
	            </div>
				<div class="card-body">

					<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
					<div class="row">
					<?php 
						$i = 1;
						foreach($dt_allCCTVLive as $row) {
						?>
						<style type="text/css">
							.col-sm-3 video {
							    width: 100%;
							    height: auto;
							    object-fit: cover; /* Menjaga proporsi video */
							}
						</style>
						<div class="col-sm-3">
						    <video id="video<?= $i; ?>" autoplay="true" controls="controls" muted type='application/x-mpegURL'></video>

						    <script>
						      if (Hls.isSupported()) {
						        var video<?= $i; ?> = document.getElementById('video<?= $i; ?>');
						        var hls<?= $i; ?> = new Hls();
						        hls<?= $i; ?>.attachMedia(video<?= $i; ?>);
						        hls<?= $i; ?>.on(Hls.Events.MEDIA_ATTACHED, function () {
						          console.log("video<?= $i; ?> dan hls.js sekarang terhubung!");
						          hls<?= $i; ?>.loadSource("<?= $dt_setting['domain'].$row['url_directory'] ?>");
						          hls<?= $i; ?>.on(Hls.Events.MANIFEST_PARSED, function (event, data) {
						            // Anda bisa menambahkan kode di sini jika perlu
						          });
						        });
						      }
						    </script>
						</div>

					<?php 
					$i++;
					} 
					?>
					</div>

				</div>
			</div>
	  	</div>
	</div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->