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
</head>
<body class="bg-gradient-white">

	<!-- Content Wrapper -->
	<div id="content-wrapper">

	    <!-- Main Content -->
	    <div id="content">

        	<img src="<?= base_url('assets/img/profile_perusahaan/') . $profile['logo']; ?>" class="d-none d-sm-inline-block col-sm-1" width="90vh" style="float: left; position: absolute; z-index: 99; margin-left: 3vh; margin-top: 4vh; ">

	        <div style="height: 92vh; " class="row">
	        	<div class="col-sm" id="player"></div>
	        </div>

	        
	        <div style="height: 8vh;" class="row shadow bg-white justify-content-center">
	        	<div class="col-sm-2 bg-primary text-center">
	        		<span class="font-weight-bold text-white" style="font-size: 3vh; line-height: 8vh;" id="waktu_sekarang"></span>
	        	</div>
	        	<div class="col-sm-10 bg-white text-center">
	        		<marquee class="h5 mb-0 font-weight-bold text-gray-800 mt-2"style="font-size: 4vh; line-height: 6vh;"><?= $text_active; ?></marquee>
	        	</div>
	        </div>

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
	  var videoIDs = []; // Array videoIDs kosong untuk awalnya
	  var player, currentVideoId = 0;
	  var videoEnded = true; // Menandakan bahwa video sebelumnya telah selesai diputar

	  // Function untuk mengatur waktu dan permintaan AJAX
	  function time() {
	    // Mendapatkan elemen dengan ID "waktu_sekarang"
	    const waktuElem = $('#waktu_sekarang');

	    // Array nama bulan
	    const arrbulan = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];

	    // Fungsi untuk mengubah nilai menjadi 2 digit angka
	    function twoDigits(val) {
	      return val < 10 ? '0' + val : val;
	    }

	    // Memperbarui tampilan waktu setiap detik
	    function updateClock() {
	      const date = new Date();
	      const detik = twoDigits(date.getSeconds());
	      const menit = twoDigits(date.getMinutes());
	      const jam = twoDigits(date.getHours());

	      waktuElem.html(jam + " : " + menit + " : " + detik);
	      jikaWaktu(jam);
	    }

	    // Memanggil fungsi updateClock() setiap detik menggunakan setInterval
	    setInterval(updateClock, 1000);
	  }

	  // Function untuk mendapatkan data video melalui permintaan AJAX dengan Promise
	  function list_video(stts) {
	    return new Promise(function(resolve, reject) {
	      $.ajax({
	        url: "<?= base_url('display/getLinkByGroup'); ?>",
	        method: "POST",
	        data: { id: stts },
	        dataType: 'json',
	        success: function(data) {
	          resolve(data);
	        },
	        error: function(xhr, status, error) {
	          reject(error);
	        }
	      });
	    });
	  }

	  // Function untuk memulai pemutaran video berdasarkan video ID
	  function playVideoById(videoId) {
	    if (player && typeof player.loadVideoById === 'function') {
	      player.loadVideoById(videoIDs[videoId]);
	    }
	  }

	  // Function untuk mengatur pemutaran video berdasarkan waktu dan rentangJam
	  function jikaWaktu(jam) {
	    getRentangJam()
	      .then(function(rentangJam) {
	        let stts_grup = 0;
	        // Logika waktu untuk mengatur stts_grup berdasarkan data rentangJam
	        for (let i = 0; i < rentangJam.length; i++) {

	          if (jam >= rentangJam[i].jam_awal && jam < rentangJam[i].jam_akhir) {
	            stts_grup = rentangJam[i].id_group;            
	            break;
	          }
	        }

	        if (stts_grup > 0) {
	          list_video(stts_grup)
	            .then(function(data) {
	              // Ubah videoIDs berdasarkan data yang diterima dari server
	              videoIDs = data;
	              // Panggil onYouTubeIframeAPIReady() jika belum terjadi
	              if (!player) {
	                onYouTubeIframeAPIReady();
	              } else {
	                // Mulai pemutaran video jika video sebelumnya telah selesai diputar
	                if (videoEnded) {
	                  playVideoById(currentVideoId);
	                  videoEnded = false;
	                }
	              }
	            })
	            .catch(function(error) {
	              console.error(error);
	            });
	        }
	      })
	      .catch(function(error) {
	        console.error(error);
	      });
	  }

	  // Function untuk inisialisasi YouTube Iframe API
	  function onYouTubeIframeAPIReady() {
	    player = new YT.Player('player', {
	      height: '100%',
	      width: '100%',
	      playerVars: {
	        autoplay: 1,
	        showinfo: 0,
	        autohide: 1,
	        controls: 1,
	        modestbranding: 0,
	        vq: 'highres'
	      },
	      events: {
	        'onReady': onPlayerReady,
	        'onStateChange': onPlayerStateChange
	      }
	    });
	  }

	  // Function yang akan dipanggil ketika pemutar video siap
	  function onPlayerReady(event) {
	    event.target.loadVideoById(videoIDs[currentVideoId]);
	    player.mute();
	  }

	  // Function yang akan dipanggil ketika status pemutar video berubah
	  function onPlayerStateChange(event) {
	    if (event.data == YT.PlayerState.ENDED) {
	      // Video selesai diputar, tandai videoEnded sebagai true untuk dapat memutar video berikutnya
	      videoEnded = true;

	      if (currentVideoId == (videoIDs.length - 1)) {
	        currentVideoId = 0;
	      } else {
	        currentVideoId++;
	      }
	    }
	  }

	  // Function untuk mendapatkan data rentangJam melalui permintaan AJAX dengan Promise
	  function getRentangJam() {

	    return new Promise(function(resolve, reject) {
	      $.ajax({
	        url: "<?= base_url('display/getRentangJam'); ?>",
	        method: "GET",
	        dataType: 'json',
	        success: function(data) {
	          resolve(data);
	        },
	        error: function(xhr, status, error) {
	          reject(error);
	        }
	      });
	    });
	  }

	  // Panggil fungsi time() untuk memulai pengaturan waktu
	  time();
	</script>



</body>
</html>