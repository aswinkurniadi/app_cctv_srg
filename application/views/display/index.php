<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>
        <?= $title; ?>
    </title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/'); ?>css/sb-admin-2.min.css" rel="stylesheet">
        <style>
        .bg-login-image {
            background-image: url("<?= base_url('assets/img/ktp-dark_.png'); ?>");
        }

        body {
        	overflow: hidden;
        }
    </style>

	<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1MgLuZuyqR_OGY3ob3M52N46TDBRI_9k&callback=getLocation" async defer></script>
	<script type="text/javascript">

    	var map;
    	var infoWindow;
	    var markers = [];
	    var currentHls = null;

	  function getLocation() {
	    if (navigator.geolocation) {
	        var location_timeout = setTimeout("geolocFail()", 10000);

	        navigator.geolocation.getCurrentPosition(function(position) {
	            clearTimeout(location_timeout);

	            geocodeLatLng(-7.6325217, 111.3339423);

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

	  function geocodeLatLng(lat , lng)
	  {
	    var center = new google.maps.LatLng(lat,lng);

	    var mapOptions = {
	      zoom : 16,
	      center : center,
	      mapTypeId: google.maps.MapTypeId.ROADMAP
	    }

	    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions)


	    // Initialize the info window
	    infoWindow = new google.maps.InfoWindow({
            disableAutoPan: false // Allow auto pan to adjust map view
        });

        // Data for all CCTV locations (latitude, longitude, name, and URL)
        var locations =  <?= $dt_AllCCTVInit; ?>; 

        // Add markers for each CCTV location
        for (var i = 0; i < locations.length; i++) {  
            // var position = { lat: cctvData[i][1], lng: cctvData[i][2] };

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][0], locations[i][1]),
                map: map,
                title: locations[i][2],
            });

            marker.addListener('click', function() {
                // Create a unique ID for each video element
                var videoId = 'video_' + i;
                var videoIdB = 'videoB_' + i;
                var currentHls = 'videoC_' + i;

                var contentString = `
                    <div style="width: 300px; height: 200px;">
                        <video id="${videoId}" autoplay="true" controls="controls" muted style="width: 100%; height: 100%;" type='application/x-mpegURL'></video>
                    </div>
                `;

                infoWindow.setContent(contentString);
                infoWindow.open(map, marker);

                google.maps.event.addListenerOnce(infoWindow, 'domready', function() {

                    // Create a new HLS instance
                    if (Hls.isSupported()) {
                        var videoIdB = document.getElementById(videoId);
                        currentHls = new Hls();
                        currentHls.attachMedia(videoIdB);
                        currentHls.on(Hls.Events.MEDIA_ATTACHED, function () {
                            currentHls.loadSource(locations[i][3]);
                            currentHls.on(Hls.Events.MANIFEST_PARSED, function () {
                                // Handle parsed manifest if needed
                            });
                        });
                    } else {
                        console.error('HLS.js is not supported in this browser.');
                    }
                });

            });

            markers.push(marker);

        };
	  }

	  function failWorking($message){
	    alert($message);
	  }

	  window.onload = getLocation;

	</script>
</head>
<body class="bg-gradient-white">

	<!-- Content Wrapper -->
	<div id="content-wrapper">

	    <!-- Main Content -->
	    <div id="content">

        	<img src="<?= base_url('assets/img/profile_perusahaan/') . $profile['logo']; ?>" class="d-none d-sm-inline-block col-sm-1" width="50vh" style="float: left; position: absolute; z-index: 99; margin-left: 2vh; margin-top: 4vh; ">


	        <!-- Search Box and List Container -->
	        <div style="position: absolute; top: 20vh; left: 30vh; transform: translateX(-50%); z-index: 10; width: 25%; background-color: white; padding: 2vh; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">
	            <!-- Search Box and Button -->
	            <!-- CCTV Online Title -->
	            <h5 class="font-weight-bold text-primary text-center mb-3">10 CCTV Online</h5>
	            <div class="input-group">
	                <input type="text" class="form-control" placeholder="Cari CCTV..." id="search-box" style="font-size: 2vh; padding: 1vh;">
	                <div class="input-group-append">
	                    <button class="btn btn-primary" type="button" id="search-button" style="font-size: 2vh;">Cari</button>
	                </div>
	            </div>
                <small class="text-primary">*berdasarkan nama cctv</small>
	            
	            <!-- CCTV List -->
	            <div style="max-height: 35vh; overflow-y: auto;">
		            <ul class="mt-3 list-group">
		            	<?php foreach($dt_allCCTV as $row) { ?>
			            	<a href="#" class="cctv-link" style="text-decoration: none;"
			            	data-latitude="<?= $row['latitude']; ?>"
			               	data-longitude="<?= $row['longitude']; ?>"
			               	data-name="<?= $row['nm_cctv']; ?>"
			               	data-url="<?= $dt_setting['domain'].$row['url_directory'] ?>"
			               	>
			                    <li class="list-group-item"><?= $row['nm_cctv']; ?></li>
		                    </a>
		                <?php } ?>
		                <!-- Add more list items as needed -->
		            </ul>
		        </div>
	        </div>

	        <div style="height: 82vh; " class="row">
	        	<div id="map_canvas" style="width: 100%;"></div>
	        </div>

	        
	        <div style="height: 5vh; z-index: 100;" class="row shadow bg-white justify-content-center">
	        	<div class="col-sm-2 bg-secondary text-center">
	        		<span class="h5 mb-0 font-weight-bold text-white mt-2" style="font-size: 3vh; line-height: 6vh;"><?= $now; ?></span>
	        	</div>
	        	<div class="col-sm-10 bg-white text-center">
	        		<marquee class="h5 mb-0 font-weight-bold text-gray-800 mt-2"style="font-size: 3vh; line-height: 4vh;">CCTV ONLINE MAGETAN PT SARANGAN SUKSES PERKASA</marquee>
	        	</div>
	        </div>


	        <!-- Footer -->
	        <footer class="row bg-primary py-3 text-white pt-4" style="height: 13vh; z-index: 100;">
	            <div class="col-sm-3 text-center">
	                <span class="font-weight-bold text-center mb-3" style="font-size: 16px;">PT. SARANGAN SUKSES PERKASA</span>
	            </div>
	            <div class="col-sm-3 text-center" class="d-none d-sm-inline-block">
	                <span class="font-weight-bold text-center mb-3" style="font-size: 16px;">Support by :</span>
	            </div>
	            <div class="col-sm-3 text-center" class="d-none d-sm-inline-block">
	                <span class="font-weight-bold text-center mb-3" style="font-size: 16px;">Sosial Media</span>
	                <div class="mt-2">
			            
			            <a href="#" class="text-white mx-2">
			                <i class="fab fa-instagram" style="font-size: 2.5vh;"></i>
			            </a>
			            <a href="#" class="text-white mx-2">
			                <i class="fab fa-facebook" style="font-size: 2.5vh;"></i>
			            </a>
			        </div>
	            </div>
	        </footer>

		</div>
		<!-- End of Main Content -->

    </div>
    <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->





	<!-- Bootstrap core JavaScript-->
	<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
	<script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

	<!-- Core plugin JavaScript-->
	<script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

	<!-- Custom scripts for all pages-->
	<script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>

	<!-- Load jQuery -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<!-- Load API YouTube Iframe Player -->
	<script src="https://www.youtube.com/iframe_api"></script>

	<!-- Skrip JavaScript -->
	<script>
		$(document).ready(function(){
			var markers = [];
			var currentMarker = null; 

			function showCCTV(latitude, longitude, name, url) {
		        var position = { lat: parseFloat(latitude), lng: parseFloat(longitude) };
		        
		        // Clear existing marker if any
		        if (currentMarker) {
		            currentMarker.setMap(null);
		        }

		        // Add a new marker for the CCTV location
		        currentMarker = new google.maps.Marker({
		            position: position,
		            map: map,
		            title: name
		        });


		        // Info window content with video player
		        var contentString = `
		            <div style="width: 300px; height: 200px;">
		                <video id="video" autoplay="true" controls="controls" muted style="width: 100%; height: 100%;" type='application/x-mpegURL'></video>
		            </div>
		        `;

		        // Open the info window with the CCTV name
		        infoWindow.setContent(contentString);
		        infoWindow.open(map, currentMarker);

		        // After the info window is opened, initialize HLS.js
		        google.maps.event.addListenerOnce(infoWindow, 'domready', function() {
		            if (Hls.isSupported()) {
		                var video = document.getElementById('video');
		                var hls = new Hls();
		                hls.attachMedia(video);
		                hls.on(Hls.Events.MEDIA_ATTACHED, function () {
		                    hls.loadSource(url);
		                    hls.on(Hls.Events.MANIFEST_PARSED, function () {
		                        // Handle parsed manifest if needed
		                    });
		                });
		            } else {
		                console.error('HLS.js is not supported in this browser.');
		            }
		        });


		        // Center the map on the CCTV location
		        map.panTo(position);
		        map.setZoom(18);
		    }

		    // Event listener for all links with class 'cctv-link'
		    document.querySelectorAll('.cctv-link').forEach(function(link) {
		        link.addEventListener('click', function(event) {

		            // event.preventDefault(); // Prevent the default anchor click behavior
		            var latitude = this.getAttribute('data-latitude');
		            var longitude = this.getAttribute('data-longitude');
		            var name = this.getAttribute('data-name');
		            var url = this.getAttribute('data-url');

		        	console.log(url);
		            // // Call the function to update the map
		            showCCTV(latitude, longitude, name, url);
		        });
		    });
	    });
	</script>



</body>
</html>