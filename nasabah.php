<?php
$antrian = 32;


$cols = '';
$antrian = [];
$jenis_antrian_aktif_count = 0;
foreach ($rjenis_antrian as $kode => $d) {
  if ($d['status'] == 1) $jenis_antrian_aktif_count++;
}
foreach ($rjenis_antrian as $kode => $d) {
  if ($d['status'] != 1) continue;

  $nama_jenis = ucwords(strtolower($d['jenis']));

  $s = "SELECT a.nomor FROM tb_antrian a 
  WHERE waktu >= '$today' 
  AND kode_jenis = '$kode'
  ORDER BY waktu DESC LIMIT 1 ";
  $q = mysqli_query($cn, $s) or die(mysqli_error($cn));
  $antrian = mysqli_fetch_assoc($q);
  if (!$antrian) {
    # ============================================================
    # AUTO INSERT ANTRIAN 1
    # ============================================================
    $s = "INSERT INTO tb_antrian (
      nomor,
      kode_jenis
    ) VALUES (
      1,
      '$kode'
    )";
    $q = mysqli_query($cn, $s) or die(mysqli_error($cn));

    $antrian['nomor'] = 1;
  }
  $antrian_show = sprintf('%03d', $antrian['nomor']);

  $col_size = intval(12 / $jenis_antrian_aktif_count);

  $cols .= "
    <div class='col-$col_size h-100'>
      <div class='card h-100'>
        <div class='card-header bg-primary text-white'>$nama_jenis</div>
        <div class='card-body gradasi-$d[gradasi]'>
          <div class='d-flex flex-column justify-content-between h-100'>
            <div class='nomor-antrian-nasabah d-flex justify-content-center align-items-center bg-debuga h-100'>
              <div class='antrian-show bg-dangera'>
                $kode$antrian_show
              </div>
            </div>
            <div>
              <a href='?p=ambil_antrian&kode=$kode' class='btn btn-primary w-100 btn-ambil-antrian'>
                Ambil Antrian
                <img src='img/hand-white.png' alt='hand-icon' class='btn-img-hand' />
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>    
  ";
}

?>
<style>
  .nomor-antrian-label {
    position: absolute;
    top: 10vh;
    left: 0;
    right: 0;
    font-size: 4rem;
    color: #007bff;
    padding: 2rem;
  }

  .blok-nomor-antrian {
    position: absolute;
    top: 30vh;
    height: 65vh;
    left: 0;
    right: 0;
  }

  .card-header {
    font-size: 30px;
  }

  .antrian-show {
    font-size: 95px;
    height: 170px;
  }

  .btn-ambil-antrian {
    font-size: 40px
  }

  .btn-img-hand {
    width: 80px;
  }

  .bg-debug {
    background: yellow !important;
  }
</style>
<div class="blok-nasabah text-center">
  <img src="img/logo.png" alt="logo" class="logo" />
  <h1 class="selamat-datang">Selamat Datang Nasabah!</h1>
  <div class="nomor-antrian-label">Silahkan Ambil Antrian!</div>
  <div class="blok-nomor-antrian">
    <div class="px-4 h-100">
      <div class="row h-100">
        <?= $cols ?>
      </div>
    </div>
  </div>
</div>