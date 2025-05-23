<?php
if (isset($_POST) and $_POST) {
  if (isset($_POST['btn_set_status_jenis_antrian'])) {
    $t = explode('--', $_POST['btn_set_status_jenis_antrian']);
    $kode = $t[0] ?? kosong('kode');
    $status = $t[1] ?? kosong('status');

    $s = "UPDATE tb_jenis_antrian SET status = $status WHERE kode = '$kode'";
    $q = mysqli_query($cn, $s) or die(mysqli_error($cn));
    jsurl();
  } elseif (isset($_POST['btn_set_status_petugas'])) {
    $t = explode('--', $_POST['btn_set_status_petugas']);
    $cusername = $t[0] ?? kosong('cusername');
    $cstatus = $t[1] ?? kosong('cstatus');

    $s = "UPDATE tb_user SET status = $cstatus WHERE username = '$cusername'";
    $q = mysqli_query($cn, $s) or die(mysqli_error($cn));
    jsurl();
  } elseif (isset($_POST['btn_reset_antrian'])) {
    $s = "DELETE FROM tb_antrian WHERE waktu >= '$today' AND waktu < '$now'";
    $q = mysqli_query($cn, $s) or die(mysqli_error($cn));
    jsurl();
  } elseif (isset($_POST['btn_tambah_petugas'])) {
    $t = explode('--', $_POST['btn_tambah_petugas']);
    $kode = $t[0] ?? kosong('kode');
    $singkatan = $t[1] ?? kosong('singkatan');

    $s = "SELECT 1 FROM tb_user WHERE kode_role = '$kode'";
    $q = mysqli_query($cn, $s) or die(mysqli_error($cn));
    $new_no = mysqli_num_rows($q) + 1;
    $new_user = strtolower("$singkatan$new_no");
    $new_nama = strtolower("$singkatan-baru-$new_no");

    $s = "INSERT INTO tb_user (
      username,
      nama,
      kode_role,
      created_by
    ) VALUES (
      '$new_user',
      '$new_nama',
      '$_POST[btn_tambah_petugas]',
      '$username'
    ) ON DUPLICATE KEY UPDATE 
      username = username
    ";
    $q = mysqli_query($cn, $s) or die(mysqli_error($cn));
    jsurl();
  } elseif (isset($_POST['btn_delete_petugas'])) {
    $s = "DELETE FROM tb_user WHERE username='$_POST[btn_delete_petugas]'";
    $q = mysqli_query($cn, $s) or die(mysqli_error($cn));
    jsurl();
  } elseif (isset($_POST['btn_logout'])) {
    // do nothing
  } elseif (isset($_POST['btn_ubah_password'])) {
    // sudah ada handler
  } elseif (isset($_POST['btn_reset_password'])) {
    $s = "UPDATE tb_user SET password=null WHERE username='$_POST[btn_reset_password]'";
    $q = mysqli_query($cn, $s) or die(mysqli_error($cn));
    jsurl();
  } else {

    echo '<pre>';
    var_dump($_POST);
    echo '<b style=color:red>Belum ada handler untuk Data POST diatas. Exit(true)</b></pre>';
    exit;
  }
}
