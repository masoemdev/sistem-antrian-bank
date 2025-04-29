<?php
if (!$username) {
  stop('undefined [username] @data-user.');
} elseif (!$role) {
  stop('undefined [role] @data-user.');
}

$sql_kode_role = $role == 'ADMIN' ? "a.kode_role is null" : "a.kode_role = '$role'";

$s = "SELECT a.*,
(
  SELECT singkatan FROM tb_jenis_antrian 
  WHERE kode=a.kode_role) jenis_role  
FROM tb_user a
WHERE $sql_kode_role
AND a.username = '$username' 
";
$q = mysqli_query($cn, $s) or die(mysqli_error($cn));
$user = mysqli_fetch_assoc($q);
if (!$user) {
  unset($_SESSION['antrian_username']);
  unset($_SESSION['antrian_role']);
  stop("User [$username] role [$role] tidak ditemukan.");
}
