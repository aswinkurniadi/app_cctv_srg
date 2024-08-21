<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title;  ?></h1>

  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card border-bottom-primary shadow mb-4">
         <div class="card-header py-3">
          <div class="row">
            <div class="col-sm">
              <h6 class="m-0 font-weight-bold text-primary mt-2">Form <?= $title;  ?></h6>
            </div>
          </div>
        </div>
        <div class="card-body">

          <div class="col-lg">
            <?= form_open_multipart(''); ?>
                <div class="form-group">
                  <input type="hidden" class="form-control" id="id" name="id" value="<?= $profile['id_profile']; ?>" readonly>
                </div>
                <div class="form-group row">
                  <label for="name" class="col-sm-2 col-form-label">Nama Perusahaan</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="name" value="<?= $profile['name']; ?>" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="almt" class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="almt" name="almt" value="<?= $profile['almt']; ?>" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="no_telp" class="col-sm-2 col-form-label">No Telp</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?= $profile['no_telp']; ?>" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="email" class="col-sm-2 col-form-label">Email Perusahaan</label>
                    <div class="col-sm-10">
                    <input type="email" class="form-control" id="email" name="email" value="<?= $profile['email']; ?>" required>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-2">Logo Perusahaan</div>
                  <div class="col-sm-10">
                    <div class="row">
                      <div class="col-sm-3">
                        <img src="<?= base_url('assets/img/profile_perusahaan/') . $profile['logo'];  ?>" class="img-thumbnail">
                      </div>
                      <div class="col-sm-9">
                        <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" name="image">
                        <label class="custom-file-label" for="image">Choose file</label>
                        <small>*(perhatian : nama file harus "logo.png")</small>
                      </div>
                      </div>
                    </div>
                  </div>
               </div>
                <div class="form-group row">
                  <label for="content" class="col-sm-2 col-form-label">Deskripsi Perusahaan</label>
                    <div class="col-sm-10">
                    <textarea class="form-control" name="content" id="content" required><?= $profile['deskripsi']; ?></textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="time_zone" class="col-sm-2 col-form-label">Set TIME ZONE</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="time_zone" name="time_zone" value="<?= $profile['time_zone']; ?>" placeholder="date_default_timezone_set" required>
                  </div>
                </div>
                <hr class="mb-3 mt-3">
                <div class="row">
                  <div class="col-sm text-right">
                      <button type="submit" class="btn btn-primary btn-sm">Update Profile</button>
                  </div>
                </div>
            </form>
            </div>
          </div>

        </div>
      </div>
    </div>
    
  </div>
  
</div>
<!-- /.container-fluid -->



