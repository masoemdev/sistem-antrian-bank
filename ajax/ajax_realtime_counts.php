<?php
include '../cn.php';
$today = date('Y-m-d');
$jenis_antrian = $_GET['p'] ?? 'total';

if ($jenis_antrian == 'total') {
  $sql_where = 1;
} elseif ($jenis_antrian == 'terlayani') {
  $sql_where = "(status = 1 OR status = 2 OR status = -1)";
} elseif ($jenis_antrian == 'skipped') {
  $sql_where = "status = -1 ";
} elseif ($jenis_antrian == 'antrian_baru') {
  $sql_where = "status = -1 ";
} else {
  die("invalid parameter [$jenis_antrian] pada AJAX realtime counts.");
}

# ============================================================
# REALTIME COUNTS
# ============================================================
$s = "SELECT 1 FROM tb_antrian a 
  WHERE waktu >= '$today' 
  AND $sql_where
  ";
$q = mysqli_query($cn, $s) or die(mysqli_error($cn));
$realtime_counts = mysqli_num_rows($q);

die("$realtime_counts");
