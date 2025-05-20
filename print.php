<style>
  body {
    background: black;
  }

  .kertas-thermal {
    text-align: center;
    font-family: consolas, "Courier New", Courier, monospace;
    font-size: 12px;
    background: white;
    color: black;
    width: 57.5mm;
    height: 65mm;
  }

  .nomor-antrian-print-label {
    margin-top: 10px;
    font-size: 20px;
  }

  .nomor-antrian-print {
    font-size: 60px;
    transform: translateY(-13px);
  }

  .antrian-saat-ini {
    font-size: 20px;
  }

  .estimasi {
    font-size: 15px;
  }

  .slogan {
    margin-top: 10px;
    font-size: 15px;
  }
</style>

<?php
# ============================================================
# TOTAL ANTRIAN
# ============================================================
include 'cn.php';
include 'total_antrian.php';
echo "<span style=display:none id=total_antrian>$total_antrian</span>";

# ============================================================
# LAST ANTRIAN
# ============================================================
$s = "SELECT * FROM tb_antrian ORDER BY waktu DESC LIMIT 1";
$q = mysqli_query($cn, $s) or die(mysqli_error($cn));
$last_antrian = mysqli_fetch_assoc($q);

$last_antrian_show = $last_antrian['kode_jenis'] . sprintf('%03d', $last_antrian['nomor']);


# ============================================================
# ANTRIAN SAAT INI
# ============================================================
$s = "SELECT 
a.id, 
a.nomor,
b.durasi_layanan  
FROM tb_antrian a 
JOIN tb_jenis_antrian b ON a.kode_jenis=b.kode 
WHERE a.waktu >= '$today' 
AND a.kode_jenis = '$last_antrian[kode_jenis]'
AND (a.status = 1 OR a.status = 2 OR a.status = -1) -- sedang | sudah | skipped dilayani
ORDER BY a.waktu DESC LIMIT 1 ";
$q = mysqli_query($cn, $s) or die(mysqli_error($cn));
$antrian_sedang = mysqli_fetch_assoc($q);
$antrian_sedang_show = $last_antrian['kode_jenis'] . sprintf('%03d', $antrian_sedang['nomor']);

$estimasi = ($last_antrian['nomor'] - $antrian_sedang['nomor']) * $antrian_sedang['durasi_layanan'];

?>

<div class="kertas-thermal">
  <h1 class="nomor-antrian-print-label">Antrian Anda</h1>
  <div class="nomor-antrian-print"><?= $last_antrian_show ?></div>
  <div class="antrian-saat-ini">antrian skg:
    <?= $antrian_sedang_show ?>
  </div>
  <div class="estimasi">est. <?= $estimasi ?> menit menunggu</div>
  <div class="slogan">
    BPRS Al-Ma'soem <br />Meraih Sukses Bersama <br />Kemaslahatan Ummat
  </div>
</div>

<script>
  window.onload = () => {
    // Tunggu sebentar untuk pastikan halaman benar-benar siap
    setTimeout(() => {
      window.print();
    }, 500); // 0.5 detik delay supaya teks termuat dulu
  };
</script>

<!-- <script src="../assets/vendor/jquery/jquery-3.7.1.min.js"></script> -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="js/update_counts.js"></script>