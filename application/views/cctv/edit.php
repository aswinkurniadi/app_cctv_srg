<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1MgLuZuyqR_OGY3ob3M52N46TDBRI_9k&callback=getLocation" async defer></script>
<script type="text/javascript">

  function getLocation() {
    if (navigator.geolocation) {
        var location_timeout = setTimeout("geolocFail()", 10000);

        navigator.geolocation.getCurrentPosition(function(position) {
            clearTimeout(location_timeout);

            var lat = <?= $dtById['latitude']; ?>;
            var lng = <?= $dtById['longitude']; ?>;

            geocodeLatLng(lat, lng);
            geocodePosition(lat, lng);
        }, function(error) {
            geolocFail();
        });
    } else {
        // Fallback for no geolocation
        geolocFail();
    }
  }

  function geolocFail(){
    alert('failed, may not be supported');
  }

  function geocodePosition(lat, lng)
  {
    $('#latitude').val(lat);
    $('#longitude').val(lng);
    displayLocation(lat, lng);
  }

  function geocodeLatLng(lat , lng)
  {
    var map;

    var center = new google.maps.LatLng(lat,lng);

    var mapOptions = {
      zoom : 10,
      center : center,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }

    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions)

    var marker = new google.maps.Marker({
      map : map,
      position : center,
      draggable:true,
    });

    google.maps.event.addListener(marker, 'dragend', function(marker) 
    {
      var latLng = marker.latLng; 
          currentLatitude = latLng.lat();
          currentLongitude = latLng.lng();
        geocodePosition(currentLatitude, currentLongitude);
        updateMarkerPosition(currentLatitude, currentLongitude);
    });
  }

  function displayLocation(latitude,longitude){
      var geocoder;
      geocoder = new google.maps.Geocoder();
      var latlng = new google.maps.LatLng(latitude, longitude);

      geocoder.geocode(
          {'latLng': latlng}, 
          function(results, status) {
              if (status == google.maps.GeocoderStatus.OK) {
                  if (results[0]) {
                      var add= results[0].formatted_address ;
                      var  value=add.split(",");

                      count=value.length;
                      country=value[count-1];
                      state=value[count-2];
                      city=value[count-3];
                      $('#almt').val(add);
                  }
                  else  {
                      failWorking("address not found");
                  }
              }
              else {
                  failWorking("Geocoder failed due to: " + status);
              }
          }
      );
  }

  function failWorking($message){
    alert($message);
  }

  window.onload = getLocation;

</script>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title;  ?></h1>

  <div class="row justify-content-center">
    <div class="col-lg-6">
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
                <div class="form-group row">
                  <label for="nama" class="col-sm-3">Nama</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama" value="<?= $dtById['nm_cctv'] ?>" required="">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="id_group" class="col-sm-3">Pilih Group</label>
                  <div class="col-sm-9">
                    <select name="id_group" id="id_group" class="form-control bootstrap-select" title="Pilih Group" required="">
                      <?php foreach ($dt_group as $row) : ?>
                        <?php $selected = ($dtById['id_group'] == $row['id_group']) ? 'selected' : null; ?>
                        <option value="<?= $row['id_group']; ?>" <?= $selected; ?> ><?= $row['nm']; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="url_rtsp" class="col-sm-3">URL RTSP</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="url_rtsp" name="url_rtsp" placeholder="Masukkan url RTSP" value="<?= $dtById['url_rtsp'] ?>" required="">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="url_directory" class="col-sm-3">URL Directory</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="url_directory" name="url_directory" placeholder="Masukkan url Directory" value="<?= $dtById['url_directory'] ?>" required="">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="url_directory" class="col-sm-3">Maps</label>
                  <div class="col-sm-9">

                    <div id="map_canvas" class="mb-2" style="height: 300px; width: 100%;"></div>

                    <input type="hidden" class="form-control mb-2" id="latitude" name="latitude" placeholder="Masukkan latitude" value="<?= $dtById['latitude'] ?>" readonly="" required="">
                    <input type="hidden" class="form-control mb-2" id="longitude" name="longitude" placeholder="Masukkan longitude" value="<?= $dtById['longitude'] ?>" readonly="" required="">
                    <textarea class="form-control mb-2" id="almt" name="almt" rows="3" required readonly=""><?= $dtById['almt'] ?></textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="stts" class="col-sm-3">Status</label>
                  <div class="col-sm-9">
                    <select name="stts" id="stts" class="form-control bootstrap-select" title="Pilih Status" required="">
                        <option value="0" <?= ($dtById['stts'] == 0) ? 'selected' : null; ?>>Tidak Aktif</option>
                        <option value="1" <?= ($dtById['stts'] == 1) ? 'selected' : null; ?>>Aktif</option>
                    </select>
                  </div>
                </div>


                <hr class="mb-3 mt-3">
                <div class="row">
                  <div class="col-sm text-right">
                      <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
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