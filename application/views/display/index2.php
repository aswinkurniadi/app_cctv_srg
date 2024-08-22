<!-- Search Box and List Container -->
<div class="pencarian">

    <div style="display: flex; flex-direction: column; align-items: left;">
        <!-- Logo -->
        <div style="display: flex; align-items: center; margin-bottom: 2vh;">
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
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text search-icon">
                <i class="fas fa-search"></i>
            </span>
        </div>
        <input type="text" class="form-control" placeholder="Pencarian CCTV..." id="search-box" style="font-size: 2vh; padding: 1vh;">
        <div class="input-group-append">
            <span class="input-group-text clear-icon" style="display: none;">
                <i class="fas fa-times"></i>
            </span>
        </div>
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
