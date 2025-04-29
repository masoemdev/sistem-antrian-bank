<?php
$today = date('Y-m-d');
$rjenis_antrian = [];
$s = "SELECT a.*,
(
  SELECT p.nomor FROM tb_antrian p 
  WHERE p.waktu >= '$today' 
  AND p.kode_jenis = a.kode
  AND (status = 1 OR status = 2) -- sedang dilayani | sudah dilayani
  ORDER BY p.waktu DESC LIMIT 1
  ) posisi_antrian 
FROM tb_jenis_antrian a 
-- WHERE a.status=1 -- hanya yang diaktifkan
ORDER BY a.kode";
$q = mysqli_query($cn, $s) or die(mysqli_error($cn));
while ($d = mysqli_fetch_assoc($q)) {
  $rjenis_antrian[$d['kode']] = $d;
}
