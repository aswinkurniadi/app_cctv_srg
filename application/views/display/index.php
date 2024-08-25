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

	    /* Gaya dasar untuk item daftar */
	    .list-group-item {
	        transition: background-color 0.3s, color 0.3s; /* Transisi halus untuk perubahan warna */
            cursor: pointer;
	    }

	    /* Gaya saat kursor berada di atas item daftar */
	    .list-group-item:hover {
	        background-color: #4e73df; /* Warna latar belakang biru (primary) */
	        color: #ffffff; /* Warna teks putih */
	    }

	    /* Gaya untuk link di dalam item daftar agar tetap terlihat seperti item daftar */
	    .list-group-item a {
	        color: inherit; /* Menggunakan warna teks item daftar */
	        text-decoration: none; /* Menghapus garis bawah dari link */
	    }

        .no-results {
            display: none; /* Sembunyikan pesan tidak ditemukan secara default */
            color: red;
            font-size: 1em;
            text-align: center;
            padding: 10px;
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
	      mapTypeId: google.maps.MapTypeId.SATELLITE
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
		    (function(i) {
		        var marker = new google.maps.Marker({
		            position: new google.maps.LatLng(locations[i][0], locations[i][1]),
		            map: map,
		            title: locations[i][2],
		        });

		        marker.addListener('click', function() {
		            var videoId = 'video_' + i;
		            var videoIdB = 'videoB_' + i;
		            var currentHls = 'videoC_' + i;

		            var contentString = `
		                <div style="width: 100%; height: 100%; border: 5px solid #4e73df;">
		                    <video id="${videoId}" autoplay="true" controls="controls" muted style="width: 100%; height: 100%;" type='application/x-mpegURL'></video>
		                </div>
		            `;

		            infoWindow.setContent(contentString);
		            infoWindow.open(map, marker);

		            google.maps.event.addListenerOnce(infoWindow, 'domready', function() {
		            	var closeButton = document.querySelector('.gm-ui-hover-effect');
				        if (closeButton) {
				            closeButton.style.transform = 'scale(0.7)'; // Mengurangi ukuran tombol "X"
				            // closeButton.style.width = '20px'; // Sesuaikan lebar tombol "X"
				            // closeButton.style.height = '20px'; // Sesuaikan tinggi tombol "X"
				            // closeButton.style.top = '20px'; // Posisikan tepat di atas
				            // closeButton.style.right = '0px'; // Posisikan tepat di kanan
				            // closeButton.style.position = 'absolute'; // Pastikan posisi absolut
				            // closeButton.style.padding = '5px'; // Tambahkan padding untuk jarak yang lebih baik
				        }

		                if (Hls.isSupported()) {
		                    var videoElement = document.getElementById(videoId);
		                    currentHls = new Hls();
		                    currentHls.attachMedia(videoElement);
		                    currentHls.on(Hls.Events.MEDIA_ATTACHED, function () {
		                        currentHls.loadSource(locations[i][3]);
		                    });
		                } else {
		                    console.error('HLS.js is not supported in this browser.');
		                }
		            });


			        // Center the map on the CCTV location
			        map.panTo(position);
			        map.setZoom(18);


				    // Menghapus instance HLS saat infoWindow ditutup
				    google.maps.event.addListener(infoWindow, 'closeclick', function() {
				        if (currentHls) {
				            currentHls.destroy();
				            currentHls = null;
				        }
				    });
		        });

		        markers.push(marker);
		    })(i);
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

	    	<style type="text/css">
		    	/* Style umum untuk semua perangkat */
				.footer {
				    background-color: #007bff; /* Warna biru */
				    color: #ffffff; /* Warna putih */
				    padding: 1rem;
				    text-align: center;
				    position: relative; /* Pastikan footer tetap berada di posisi relatifnya */
				    overflow: hidden; /* Mencegah konten keluar dari batas footer */
				}

				.nm-perusahaan-footer {
				    display: inline-block;
				    margin: auto;
				}

				.tgl-hari-ini {
				    font-size: 3vh;
				    line-height: 6vh;
				}

				.text-berjalan {
				    font-size: 3vh;
				    line-height: 6vh;
				    overflow: hidden;
				}

	    		/*<!-- tampilan hp -->*/
	    		@media (max-width: 450px) {
	    			.pencarian {
	    				position: absolute; 
	    				top: 3vh; 
	    				left: 20vh; 
	    				transform: translateX(-50%); 
	    				z-index: 10; 
	    				width: 35vh; 
	    				background-color: white; 
	    				padding: 2vh; 
	    				border-radius: 8px; 
	    				box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
	    			}

	    			.pencarian .nm-perusahaan {
	    				font-size: 2vh;
	    			}

	    			.pencarian .ket-perusahaan {
	    				font-size: 1.5vh;
	    				margin: 0;
	    			}

	    			.pencarian .jml-cctv {
	    				font-size: 2vh;
	    			}

	    			.pencarian #cctv-list .list-group-item {
	    				font-size: 2vh;    				
	    			}

	    			.pencarian #cctv-list .no-results {
	    				font-size: 2vh;    				
	    			}

					#search-icon {
					    position: absolute;
					    top: 8vh; /* Jarak dari atas */
					    left: 20px; /* Jarak dari kiri */
					    background-color: #4e73df; /* Warna biru */
					    color: white; /* Warna ikon */
					    border-radius: 50%; /* Membuat lingkaran */
					    width: 60px; /* Lebar */
					    height: 60px; /* Tinggi */
					    display: none;
					    align-items: center;
					    justify-content: center;
					    cursor: pointer;
					    z-index: 1000; /* Pastikan di atas elemen lain */
					    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Efek bayangan */
					}

	    			.close-btn {
					    position: absolute;
					    top: 10px; /* Adjust as needed */
					    right: 10px; /* Adjust as needed */
					    background: none;
					    border: none;
					    font-size: 2rem;
					    color: #000; /* Adjust color as needed */
					    cursor: pointer;
					    z-index: 10; /* Ensure it's on top of other content */
					}

					.close-btn:hover {
					    color: #f00; /* Optional: change color on hover */
					}



				    /* Gaya untuk perangkat mobile */
				    .nm-perusahaan-footer {
				        font-size: 14px;
				    }

				    .fab {
				        font-size: 2vh;
				    }

				    .tgl-hari-ini, .text-berjalan {
				        font-size: 2.5vh; /* Mengurangi ukuran font untuk layar kecil */
				        line-height: 4vh; /* Menyesuaikan line-height */
				        margin-top: 0.5rem;
				    }
	    		}

	    		/*<!-- tampilan hp -->*/
	    		@media (min-width: 450px) and (max-width: 768px) {
	    			.pencarian {
	    				position: absolute; 
	    				top: 5vh; 
	    				left: 20vh; 
	    				transform: translateX(-50%); 
	    				z-index: 10; 
	    				width: 35vh; 
	    				background-color: white; 
	    				padding: 2vh; 
	    				border-radius: 8px; 
	    				box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
	    			}

	    			.pencarian .nm-perusahaan {
	    				font-size: 2.5vh;
	    			}

	    			.pencarian .ket-perusahaan {
	    				font-size: 1.7vh;
	    				margin: 0;
	    			}

	    			.pencarian .jml-cctv {
	    				font-size: 2vh;
	    			}

	    			.pencarian #cctv-list .list-group-item {
	    				font-size: 2vh;    				
	    			}

	    			.pencarian #cctv-list .no-results {
	    				font-size: 2vh;    				
	    			}

					#search-icon {
					    position: absolute;
					    top: 8vh; /* Jarak dari atas */
					    left: 20px; /* Jarak dari kiri */
					    background-color: #4e73df; /* Warna biru */
					    color: white; /* Warna ikon */
					    border-radius: 50%; /* Membuat lingkaran */
					    width: 60px; /* Lebar */
					    height: 60px; /* Tinggi */
					    display: none;
					    align-items: center;
					    justify-content: center;
					    cursor: pointer;
					    z-index: 1000; /* Pastikan di atas elemen lain */
					    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Efek bayangan */
					}

	    			.close-btn {
					    position: absolute;
					    top: 10px; /* Adjust as needed */
					    right: 10px; /* Adjust as needed */
					    background: none;
					    border: none;
					    font-size: 2rem;
					    color: #000; /* Adjust color as needed */
					    cursor: pointer;
					    z-index: 10; /* Ensure it's on top of other content */
					}

					.close-btn:hover {
					    color: #f00; /* Optional: change color on hover */
					}

				    /* Gaya untuk tablet kecil dan smartphone lebih besar */
				    .nm-perusahaan-footer {
				        font-size: 16px;
				    }

				    .fab {
				        font-size: 2.5vh;
				    }

				    .tgl-hari-ini, .text-berjalan {
				        font-size: 3vh; /* Mengurangi ukuran font untuk layar kecil */
				        line-height: 5vh; /* Menyesuaikan line-height */
				        margin-top: 0.75rem;
				    }
	    		}


	    		/*<!-- tampilan laptop / komputer -->*/
	    		@media (min-width: 768px) {
	    			.pencarian {
	    				position: absolute; 
	    				top: 8vh; 
	    				left: 25vh; 
	    				transform: translateX(-50%); 
	    				z-index: 10; 
	    				width: 40vh; 
	    				background-color: white; 
	    				padding: 2vh; 
	    				border-radius: 8px; 
	    				box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
	    			}

					#search-icon {
					    position: absolute;
					    top: 8vh; /* Jarak dari atas */
					    left: 20px; /* Jarak dari kiri */
					    background-color: #4e73df; /* Warna biru */
					    color: white; /* Warna ikon */
					    border-radius: 50%; /* Membuat lingkaran */
					    width: 60px; /* Lebar */
					    height: 60px; /* Tinggi */
					    display: none;
					    align-items: center;
					    justify-content: center;
					    cursor: pointer;
					    z-index: 1000; /* Pastikan di atas elemen lain */
					    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Efek bayangan */
					}

	    			.close-btn {
					    position: absolute;
					    top: 10px; /* Adjust as needed */
					    right: 10px; /* Adjust as needed */
					    background: none;
					    border: none;
					    font-size: 2rem;
					    color: #000; /* Adjust color as needed */
					    cursor: pointer;
					    z-index: 10; /* Ensure it's on top of other content */
					}

					.close-btn:hover {
					    color: #f00; /* Optional: change color on hover */
					}

				    /* Gaya untuk desktop dan tablet besar */
				    .nm-perusahaan-footer {
				        font-size: 18px;
				    }

				    .fab {
				        font-size: 3vh;
				    }

				    .tgl-hari-ini, .text-berjalan {
				        font-size: 3vh; /* Mengurangi ukuran font untuk layar kecil */
				        line-height: 6vh; /* Menyesuaikan line-height */
				        margin-top: 1rem;
				    }

	    		}


	    	</style>

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

	        <div style="height: 82vh; " class="row">
	        	<div id="map_canvas" style="width: 100%;"></div>
	        </div>

	        
	        <div style="height: auto; position: relative;" class="row shadow bg-white justify-content-center">
	        	 <div class="container-fluid">
			        <div class="row">
					    <div class="col-sm-2 bg-secondary text-center tanggal">
					        <span class="h5 mb-0 font-weight-bold text-white mt-2 tgl-hari-ini" style="font-size: 3vh; line-height: 6vh;"><?= $now; ?></span>
					    </div>
					    <div class="col-sm-10 bg-white text-center berita">
					        <marquee class="h5 mb-0 font-weight-bold text-gray-800 mt-2 text-berjalan" style="font-size: 3vh; line-height: 6vh;">CCTV ONLINE MAGETAN PT SARANGAN SUKSES PERKASA</marquee>
					    </div>
				    </div>
			    </div>
			</div>

	        <!-- Footer -->
			<footer class="footer bg-primary py-6 text-white pt-4">
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
	                <div style="width: 100%; height: 100%;  border: 5px solid #4e73df;">
		                <video id="video" autoplay="true" controls="controls" muted style="width: 100%; height: 100%;" type='application/x-mpegURL'></video>
		            </div>
		        `;

		        // Open the info window with the CCTV name
		        infoWindow.setContent(contentString);
		        infoWindow.open(map, currentMarker);

		        // After the info window is opened, initialize HLS.js
		        google.maps.event.addListenerOnce(infoWindow, 'domready', function() {
	            	var closeButton = document.querySelector('.gm-ui-hover-effect');
			        if (closeButton) {
			            closeButton.style.transform = 'scale(0.7)'; // Mengurangi ukuran tombol "X"
			            // closeButton.style.width = '20px'; // Sesuaikan lebar tombol "X"
			            // closeButton.style.height = '20px'; // Sesuaikan tinggi tombol "X"
			            // closeButton.style.top = '20px'; // Posisikan tepat di atas
			            // closeButton.style.right = '0px'; // Posisikan tepat di kanan
			            // closeButton.style.position = 'absolute'; // Pastikan posisi absolut
			            // closeButton.style.padding = '5px'; // Tambahkan padding untuk jarak yang lebih baik
			        }

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

		            
			    // Menghapus instance HLS saat infoWindow ditutup
			    google.maps.event.addListener(infoWindow, 'closeclick', function() {
			        if (currentHls) {
			            currentHls.destroy();
			            currentHls = null;
			        }
			    });
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