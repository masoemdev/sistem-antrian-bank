<?php
# =======================================================
# CSV FILE HANDLER STARTED
# =======================================================
$date = date('ymd');
$src_csv = "csv/data-antrian-$date.csv";
$file = fopen($src_csv, "w+");
fputcsv($file, ['DATA ANTRIAN ALLTIME']);
fputcsv($file, ['Tanggal Akses: ', date('d-M-Y')]);
fputcsv($file, ['Jam: ', date('H:i')]);
fputcsv($file, [' ']);

$s = "SELECT 
a.id as id_nasabah,
a.nomor as nomor_antrian,
a.waktu as waktu_ambil,
a.kode_jenis as kode,
b.jenis as jenis_antrian,
a.awal_layanan as awal_dilayani,
a.akhir_layanan as akhir_dilayani,
a.status,
(SELECT nama FROM tb_status WHERE status=a.status) as ket_status,
a.petugas as username_petugas,
(SELECT nama FROM tb_user WHERE username=a.petugas) as nama_petugas

FROM tb_antrian a 
JOIN tb_jenis_antrian b ON a.kode_jenis=b.kode 
ORDER BY a.waktu DESC";
$q = mysqli_query($cn, $s) or die(mysqli_error($cn));
$i = 0;
while ($d = mysqli_fetch_assoc($q)) {
  $i++;
  # ============================================================
  # CSV HEADER HANDLER
  # ============================================================
  if ($i == 1) {
    $rheader_csv = [];
    foreach ($d as $nama_kolom => $array_data) {
      array_push($rheader_csv, strtoupper(str_replace('_', ' ', $nama_kolom)));
    }
    fputcsv($file, $rheader_csv);
  }

  # ============================================================
  # CSV KONTEN HANDLER
  # ============================================================
  fputcsv($file, $d);
}


# ============================================================
# CSV CLOSING HANDLER
# ============================================================
fputcsv($file, [
  'DATA FROM: BPR ALMASOEM ANTRIAN APP, PRINTED AT: ' .
    date('F d, Y, H:i:s')
]);
fclose($file);
echo " 
  <div class='container'>
    <div class='d-flex justify-content-center'>
      <div class='mt-5 pt-5'>
        <a href='$src_csv' target=_blank class='btn btn-primary my-3' onclick='redirect()'>Download Data Antrian</a>
      </div>
    </div>
  </div>
";
?>
<script>
  function redirect() {
    setTimeout(() => {
      location.replace("?")
    }, 3000);
  }
  $(function() {
    $('title').text('Export CSV');
  })
</script>