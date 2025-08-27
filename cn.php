<?php
# ============================================================
# DATABASE CONNECTION
# ============================================================
date_default_timezone_set("Asia/Jakarta");
$is_live = $_SERVER['SERVER_NAME'] == '10.10.10.31' ? 0 : 1;

$db_server = '10.10.10.31';
if ($is_live) {
  $db_user = "admin";
  $db_pass = "noway123!";
  $db_name = "sistem_antrian";
} else {
  $db_user = 'root';
  $db_pass = '';
  $db_name = 'sistem_antrian';
}

$conn = new mysqli($db_server, $db_user, $db_pass, $db_name);
$cn = $conn;
if ($conn->connect_errno) {
  echo "Error Konfigurasi# Tidak dapat terhubung ke MySQL Server :: $db_name";
  exit();
}
