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
    <link href="<?= base_url('assets/'); ?>css/css-display.css" rel="stylesheet">

	<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1MgLuZuyqR_OGY3ob3M52N46TDBRI_9k" async defer></script>
	<script type="text/javascript">
	    var map;
	    var infoWindow;
	    var markers = [];
	    var currentHls = null;

	    function initMap() {
	        var center = new google.maps.LatLng(-7.6325217, 111.3339423);
	        var mapOptions = {
	            zoom: 16,
	            center: center,
	            mapTypeId: google.maps.MapTypeId.ROADMAP
	        };
	        map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
	        infoWindow = new google.maps.InfoWindow({ disableAutoPan: false });

	        // Load CCTV locations
	        loadCCTVLocations(<?= $dt_AllCCTVInit; ?>);
	    }

	    function loadCCTVLocations(locations) {
	        locations.forEach(function(location, i) {
	            var marker = new google.maps.Marker({
	                position: new google.maps.LatLng(location[0], location[1]),
	                map: map,
	                title: location[2]
	            });

	            marker.addListener('click', function() {
	                showCCTV(location, i);
	            });

	            markers.push(marker);
	        });
	    }
	    
	    function smoothPanTo(targetPosition, zoomLevel) {
            var currentPosition = map.getCenter();
            var steps = 10; // Number of steps for the animation
            var stepLat = (targetPosition.lat() - currentPosition.lat()) / steps;
            var stepLng = (targetPosition.lng() - currentPosition.lng()) / steps;
            var stepZoom = (zoomLevel - map.getZoom()) / steps;
            var currentStep = 0;
        
            function animate() {
                if (currentStep < steps) {
                    currentStep++;
                    map.setCenter({
                        lat: currentPosition.lat() + stepLat * currentStep,
                        lng: currentPosition.lng() + stepLng * currentStep
                    });
                    map.setZoom(map.getZoom() + stepZoom);
                    requestAnimationFrame(animate); // Request next frame for smooth animation
                }
            }
            animate();
        }


	    function showCCTV(location, index) {
	        var videoId = 'video_' + index;
	        var contentString = `
	            <div style="width: 100%; height: 100%; border: 5px solid #4e73df;">
	                <video id="${videoId}" autoplay="true" controls="controls" muted style="width: 100%; height: 100%;" type='application/x-mpegURL'></video>
	            </div>
	        `;

	        infoWindow.setContent(contentString);
	        infoWindow.open(map, markers[index]);

	        google.maps.event.addListenerOnce(infoWindow, 'domready', function() {
	            var closeButton = document.querySelector('.gm-ui-hover-effect');
	            if (closeButton) {
	                closeButton.style.transform = 'scale(0.7)';
	            }

	            if (Hls.isSupported()) {
	                var videoElement = document.getElementById(videoId);
	                currentHls = new Hls();
	                currentHls.attachMedia(videoElement);
	                currentHls.on(Hls.Events.MEDIA_ATTACHED, function () {
	                    currentHls.loadSource(location[3]);
	                });
	            } else {
	                console.error('HLS.js is not supported in this browser.');
	            }
	        });

	        // Get the target position
            var targetPosition = new google.maps.LatLng(
                markers[index].getPosition().lat(),
                markers[index].getPosition().lng()
            );
        
            // Smoothly pan and zoom to the target position
            smoothPanTo(targetPosition, 22); // 18 is the desired zoom level

	        google.maps.event.addListener(infoWindow, 'closeclick', function() {
	            if (currentHls) {
	                currentHls.destroy();
	                currentHls = null;
	            }
	        });
	    }

	    // Event listener for CCTV list
	    function setupCCTVLinks() {

		    document.querySelectorAll('.cctv-link').forEach(function(link) {
		        link.addEventListener('click', function(event) {

		            // event.preventDefault(); // Prevent the default anchor click behavior
		            var latitude = this.getAttribute('data-latitude');
		            var longitude = this.getAttribute('data-longitude');
		            var name = this.getAttribute('data-name');
		            var url = this.getAttribute('data-url');

		            console.log(latitude+','+longitude);

		            // // Call the function to update the map
		            // Find the correct marker index based on the latitude and longitude
		            var markerIndex = markers.findIndex(marker => 
		                marker.getPosition().lat() === parseFloat(latitude) && 
		                marker.getPosition().lng() === parseFloat(longitude)
		            );

		            if (markerIndex !== -1) {
		                showCCTV([latitude, longitude, name, url], markerIndex);
		            } else {
		                console.error('Marker not found for the provided location');
		            }
		        });
		    });
	    }

	    window.onload = function() {
	        initMap();
	        setupCCTVLinks(); // Setup event listeners for dynamic CCTV links
	    };
	</script>

</head>
<body class="bg-gradient-white">

	<!-- Content Wrapper -->
	<div id="content-wrapper">

	    <!-- Main Content -->
	    <div id="content">

	    	<!-- Search Icon -->
			<div id="search-icon">
			    <i class="fas fa-search" style="font-size: 2rem; line-height: 60px; margin-left: 15px;"></i>
			</div>

	        <!-- Search Box and List Container -->
			<div class="pencarian">
				<button class="close-btn" aria-label="Close">&times;</button>

			    <div style="display: flex; flex-direction: column; align-items: left;">
			        <!-- Logo -->

			        <div style="display: flex; align-items: center; margin-bottom: 2vh;">
					    <!-- Logo -->
					    <img src="<?= base_url('assets/img/profile_perusahaan/') . $profile['logo']; ?>" style="width: auto; height: 10vh; margin-right: 2vh;">

					    <!-- Text Container -->
					    <div style="display: flex; flex-direction: column;">
					        <h5 class="font-weight-bold text-primary text-left nm-perusahaan">SARANGAN VISION</h5>
					        <p class="text-left ket-perusahaan">Layanan Internet dan TV Digital</p>
					    </div>
					</div>
			        <!-- Title -->
			        <h5 class="font-weight-bold text-primary text-left jml-cctv">(10 CCTV Online)</h5>
			    </div>

			    <!-- Search Box and Button -->
			    <!-- <h5 class="font-weight-bold text-primary text-center mb-3" style="margin-top: 5vh;">10 CCTV Online</h5> -->
			    <div class="input-group">
			        <input type="text" class="form-control" placeholder="Pencarian CCTV..." id="search-box" style="font-size: 2vh; padding: 1vh;">
			        <!-- div class="input-group-append">
			            <button class="btn btn-primary" type="button" id="search-button" style="font-size: 2vh;">Cari</button>
			        </div> -->
			    </div>
			    <small class="text-primary">*berdasarkan nama cctv</small>

			    <!-- CCTV List -->
			    <div style="max-height: 35vh; overflow-y: auto;">
			        <ul id="cctv-list" class="mt-2 list-group">
			            <?php foreach($dt_allCCTV as $row) { ?>
			                <a href="#" class="cctv-link" style="text-decoration: none;"
			                   data-latitude="<?= $row['latitude']; ?>"
			                   data-longitude="<?= $row['longitude']; ?>"
			                   data-name="<?= $row['nm_cctv']; ?>"
			                   data-url="<?= $dt_setting['domain'].$row['url_directory'] ?>">
			                    <li class="list-group-item"><?= $row['nm_cctv']; ?></li>
			                </a>
			            <?php } ?>
			            <li class="no-results">CCTV tidak ditemukan</li>
			        </ul>
			    </div>
			</div>
			
			<style>
                /* Masukkan CSS di sini atau dalam file eksternal */
                .map_canvas {
                    width: 100%;
                    /* Default untuk desktop */
                    height: 82vh; /* atau nilai yang Anda inginkan */
                }
                /* Default - Desktop */
                .tanggal_hari_ini {
                    width: 16.66%; /* 2 dari 12 kolom */
                }
                .berita {
                    width: 83.33%; /* 10 dari 12 kolom */
                }
        
                /* Tablet */
                @media (max-width: 992px) {
                    .map_canvas {
                        height: 70vh; /* atau nilai yang sesuai */
                    }
                    .tanggal_hari_ini {
                        width: 25%; /* 3 dari 12 kolom */
                    }
                    .berita {
                        width: 75%; /* 9 dari 12 kolom */
                    }
                }
        
                /* Mobile */
                @media (max-width: 768px) {
                    .map_canvas {
                        height: 70vh; /* atau nilai yang lebih kecil */
                    }
                    .tanggal_hari_ini {
                        width: 33.33%; /* 4 dari 12 kolom */
                    }
                    .berita {
                        width: 66.66%; /* 8 dari 12 kolom */
                    }
                }
                
                

            </style>
        
	        <div class="row" style="height: auto; position: relative;">
	        	<div id="map_canvas" class="map_canvas" style="width: 100%; "></div>
	        </div>

	        
	        <div style="height: auto; position: relative;" class="row shadow bg-white justify-content-center">
			    <div class="bg-secondary text-center tanggal_hari_ini">
			        <span class="h5 mb-0 font-weight-bold text-white mt-2 tgl-hari-ini"><?= $now; ?></span>
			    </div>
			    <div class="bg-white text-center berita">
			        <marquee class="h5 mb-0 font-weight-bold text-gray-800 mt-2 text-berjalan">CCTV ONLINE MAGETAN PT SARANGAN SUKSES PERKASA</marquee>
			    </div>
			</div>

	        <!-- Footer -->
			<footer class="footer bg-primary text-white pt-4">
			     <div class="container-fluid">
			        <div class="row">
			            <div class="col-sm-4 text-center">
			                <span class="font-weight-bold nm-perusahaan-footer">PT. SARANGAN SUKSES PERKASA</span>
			            </div>
			            <div class="col-sm-4 text-center">
			                <span class="font-weight-bold mb-3" style="font-size: 16px;">Support by :</span>
			            </div>
			            <div class="col-sm-4 text-center">
			                <span class="font-weight-bold mb-3" style="font-size: 16px;">Sosial Media</span>
			                <div class="mt-2">
			                    <a href="#" class="text-white mx-2">
			                        <i class="fab fa-instagram" style="font-size: 2.5vh;"></i>
			                    </a>
			                    <a href="#" class="text-white mx-2">
			                        <i class="fab fa-facebook" style="font-size: 2.5vh;"></i>
			                    </a>
			                </div>
			            </div>
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

		document.addEventListener('DOMContentLoaded', function() {
		    var closeBtn = document.querySelector('.close-btn');
		    var pencarianDiv = document.querySelector('.pencarian');
		    var searchIcon = document.getElementById('search-icon');

		    // Show the search box and hide the search icon
		    searchIcon.addEventListener('click', function() {
		        pencarianDiv.style.display = 'block';
		        searchIcon.style.display = 'none'; // Hide the search icon
		    });

		    // Hide the search box and show the search icon
		    closeBtn.addEventListener('click', function() {
		        pencarianDiv.style.display = 'none';
		        searchIcon.style.display = 'block'; // Show the search icon
		    });
		});

		document.getElementById('search-box').addEventListener('input', function() {
		    const searchBox = document.getElementById('search-box');
            const filter = searchBox.value.toLowerCase();
            const listItems = document.querySelectorAll('#cctv-list .list-group-item');
            let found = false;

            listItems.forEach(function(item) {
                if (item.textContent.toLowerCase().indexOf(filter) > -1) {
                    item.style.display = '';
                    found = true;
                } else if (!item.classList.contains('no-results')) {
                    item.style.display = 'none';
                }
            });

            // Tampilkan atau sembunyikan pesan tidak ditemukan
            document.querySelector('.no-results').style.display = found ? 'none' : 'block';
		});
	</script>



</body>
</html>