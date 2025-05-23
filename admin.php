<?php
include 'includes/img_icon.php';
include 'admin-process.php';
?>
<link rel="stylesheet" href="css/admin.css">
<form method=post class="admin">
  <div class="admin-header text-center pt-2 mb-4">
    <img src="img/logo.png" alt="logo" class="logo" />
    <h1 class=text-danger>Panel Admin</h1>
    <div class="info text-primary">Digunakan untuk Konfigurasi System, hati-hati dalam melakukan perubahan!</div>

  </div>
  <div class="container">
    <div class="row">
      <div class="col-xl-12">
        <div class="card mb-4">
          <div class="card-header bg-primary text-white">Jenis Antrian</div>
          <div class="card-body">
            <?php include 'admin-jenis_antrian.php'; ?>
          </div>
        </div>
      </div>
      <div class="col-xl-8">
        <div class="card mb-4">
          <div class="card-header bg-primary text-white">Manage Petugas</div>
          <div class="card-body">
            <?php include 'admin-manage_petugas.php'; ?>
          </div>
        </div>
      </div>

      <div class="col-xl-4">
        <div class="card mb-4">
          <div class="card-header bg-primary text-white">Auto Reset</div>
          <div class="card-body">
            <label class="d-flex gap-2 mb-3" onclick="alert(`Rule ini sudah fixed. \n\nHubungi developer jika ingin Customisasi.`)">
              <div class="">
                <input type="checkbox" name="" id="" checked disabled>
              </div>
              <div>
                Otomatis Reset Antrian untuk Esok Hari
              </div>
            </label>
            <p>Saat App dijalankan pada tanggal berbeda (esok hari), maka secara otomatis sistem melakukan Reset Antrian untuk semua Jenis Antrian.</p>
          </div>
        </div>
      </div>

      <div class="col-xl-12 mb-4">
        <script src="js/apexcharts.min.js"></script>
        <?php include 'grafik_nasabah_harian.php'; ?>


      </div>


    </div>
  </div>
</form>

<script src="js/editable.js"></script>