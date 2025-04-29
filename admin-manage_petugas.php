<?php
$s = "SELECT a.*,
(
  SELECT jenis FROM tb_jenis_antrian
  WHERE kode=a.kode_role
  ) nama_role,
(
  SELECT 1 FROM tb_antrian 
  WHERE petugas=a.username LIMIT 1) ada_trx   
FROM tb_user a

ORDER BY a.kode_role, a.nama";
$q = mysqli_query($cn, $s) or die(mysqli_error($cn));
$tr = '';
$i = 0;
while ($d = mysqli_fetch_assoc($q)) {
  $i++;
  $status = $d['status'] ? $aktif : $non_aktif;
  $btn = $d['status'] ? "
    <button name=btn_set_status_petugas value='$d[username]--0' class='btn btn-success btn-sm' onclick='return confirm(`Non Aktifkan Petugas ini?`)'>Aktif</button>
  " : "
    <button name=btn_set_status_petugas value='$d[username]--1' class='btn btn-secondary btn-sm' onclick='return confirm(`Aktifkan Kembali Petugas ini?`)'>Non-Aktif</button>
  ";

  $nama_role = $d['nama_role'] ?? 'Admin System';
  $btn = $d['nama_role'] ? $btn : '-';
  $nama = ucwords(strtolower($d['nama']));
  $nama_role = ucwords(strtolower($nama_role));


  if ($d['ada_trx']) {
    $btn_delete = "
    <i onclick='alert(`Tidak bisa hapus Petugas ini karena sudah pernah melayani nasabah.`)'>$img_delete_disabled</i>
    ";
    $td_username = "<td class='dilarang' onclick='alert(`Tidak bisa mengubah username karena sudah pernah melayani nasabah.`)'>$d[username]</td>";
  } else {
    $td_username = "<td class='bg-editable' id=tb_user--username--username--$d[username]>$d[username]</td>";
    $btn_delete = "
      <button name=btn_delete_petugas value='$d[username]' onclick='return confirm(`Hapus Petugas ini?`)' class='transparan'>$img_delete</button>
    ";
  }

  if (!$d['nama_role']) { // tidak bisa hapus akun admin
    $td_username = "<td class='dilarang' onclick='alert(`Tidak bisa mengubah username admin. Hubungi developer untuk customisasi.`)'>$d[username]</td>";
    $btn_delete = '-';
  }

  $tr .= "
    <tr id=tr__$d[username]>
      <td>
        $btn_delete
      </td>
      <td>
        $i
      </td>
      $td_username
      <td class='bg-editable' id=tb_user--nama--username--$d[username]>$nama</td>
      <td>$nama_role</td>
      <td>$btn</td>
    </tr>
  ";
}


?>
<table class="table table-striped table-hover text-left">
  <thead>
    <th>#</th>
    <th>No</th>
    <th>Username</th>
    <th>Nama</th>
    <th>Role</th>
    <th>Status</th>
  </thead>
  <?= $tr ?>
</table>
<?php
# ============================================================
# TAMBAH PETUGAS SESUAI DENGAN JENIS ANTRIAN
# ============================================================
$s = "SELECT * FROM tb_jenis_antrian WHERE status=1";
$q = mysqli_query($cn, $s) or die(mysqli_error($cn));
$btn_adds = '';
$i = 0;
while ($d = mysqli_fetch_assoc($q)) {
  $i++;
  $btn_adds .= "
    <div>
      <button
        name=btn_tambah_petugas 
        value='$d[kode]--$d[singkatan]' 
        class='btn btn-success btn-sm mb-2' 
        onclick='return confirm(`Tambah Petugas $d[jenis]?`)'
      >
        Tambah Petugas $d[jenis]
      </button>  
    </div>
  ";
}

echo "$btn_adds";
