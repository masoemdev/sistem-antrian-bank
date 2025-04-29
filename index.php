<?php
session_start();

include 'cn.php';
include 'includes/alert.php';
include 'includes/jsurl.php';
include 'rjenis_antrian.php';

$today = date('Y-m-d');
$now = date('Y-m-d H:i:s');

$aktif = '<span class=text-success>Aktif</span>';
$non_aktif = '<i class=text-danger>non-aktif</i>';
$onclick_ondev = "onclick='alert(`Fitur ini belum diimplementasikan.\n\nInfo lebih lanjut silahkan hubungi Developer.`)'";


$p = $_GET['p'] ?? null;
$username = $_SESSION['antrian_username'] ?? null;
$role = $_SESSION['antrian_kode_role'] ?? null;

if ($username) {
  if (key_exists($role, $rjenis_antrian) == 1 || $role == 'ADMIN') {
    include 'user.php';
    $p = $role;
    if ($role != 'ADMIN') { // kode Petugas A, B, C
      $p = 'petugas';
    }
  } else {
    $user = [];
    $user['nama'] = null;
  }
} else {
  $p = 'login';
}

if ($role == 'nasabah' || $role == 'display') {
  $p = $p ?? $role;
}
$p = $p ?? stop('undefined content of index.');


// 1. jenis antrian
// 2.  disable antrian
// 3. dashboard (report2)
// 4. Branding MU 
// 5. Running Text (nanti sambil jalan)

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Antrian App</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/insho-styles.css">
  <link rel="stylesheet" href="css/antrian.css">
</head>

<body>
  <?php
  $target =  "$p.php";
  if (file_exists($target)) {
    echo '<script src="js/jquery-3.7.1.min.js"></script>';
    include $target;
    if ($username) {
      include 'logout.php';
    }
  } else {
    stop("Fitur [ $p ] belum ada.");
  }
  ?>
</body>

</html>