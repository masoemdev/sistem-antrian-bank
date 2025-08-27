<?php
if (!isset($jenis_antrian)) {
  $jenis_antrian = 'total';
}

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

$today = date('Y-m-d');
$s = "SELECT 1 FROM tb_antrian a 
WHERE waktu >= '$today' 
AND $sql_where
";
$q = mysqli_query($cn, $s) or die(mysqli_error($cn));
$total_antrian = mysqli_num_rows($q);
