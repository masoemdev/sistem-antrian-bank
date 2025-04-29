<?php
$get_tb = $_GET['tb'] ?? kosong('tb');
$get_id = $_GET['id'] ?? kosong('id');

// include 'detail-process.php';
$where_fields = [];
$where_fields['user'] = 'username';
$where_fields['jenis_antrian'] = 'kode';

$where_field = $where_fields[$get_tb] ?? stop("where_field [$get_tb] undefined. ");

# ============================================================
# DESCRIBE
# ============================================================
$s = "DESCRIBE tb_$get_tb";
$q = mysqli_query($cn, $s) or die(mysqli_error($cn));
$desctb = [];
while ($d = mysqli_fetch_assoc($q)) {
  $desctb[$d['Field']] = $d;
}

# ============================================================
# MAIN SELECT
# ============================================================
$s = "SELECT a.* 
FROM tb_$get_tb a WHERE $where_field='$get_id'";
$q = mysqli_query($cn, $s) or die(mysqli_error($cn));
$tr = '';
$nama = '';
if (mysqli_num_rows($q)) {
  $i = 0;
  $d = mysqli_fetch_assoc($q);
  $nama = $d['nama'] ?? '';
  foreach ($d as $key => $value) {
    if (
      $key == 'password'
      || $key == 'date_created'
      || $key == 'created_at'
    ) continue;

    // $editable = ($editables[$get_tb][$key] ?? null) ? 'td_editable' : null;
    $editable = '';
    $kolom = strtoupper(key2kolom($key));
    $tr .= "
      <tr>
        <td class='miring f14 darkabu'>$kolom</td>
        <td class='$editable'>$value</td>
        <td class='consolas purple'>" . $desctb[$key]['Type'] . "</td>
        <td class='consolas purple'>" . ($desctb[$key]['Null'] == 'NO' ? 'Required' : '-') . "</td>
      </tr>
    ";
  }
} else {
  die("Data tabel [$get_tb] tidak ditemukan.");
}

$tb = $tr ? "
  <div class='wadah gradasi-hijau'>
    <table class='table table-striped'>
      $tr
    </table>
  </div>
" : alert("Data [$get_tb] dengan id [$get_id] tidak ditemukan.");

# ============================================================
# FINAL ECHO HEADER
# ============================================================
echo "
  <div>
    <span onclick='history.go(-1)' class='inline-block mr2'>
      $img_prev
    </span>
    <i class=abu>detail of</i> <span class='upper darkblue f30 inline-block ml2'>$get_tb $nama</span>
  </div>
  <hr>
";

# ============================================================
# FITUR TAMBAHAN / SPESIAL  
# ============================================================
$file = "pages/detail-$get_tb.php";
if (file_exists($file)) {
  include $file;
  $hideit = 'hideit';
  $toggle = "<div><hr><span class='btn_aksi pointer' id=blok_tb_detail__toggle>Lihat more details $img_detail</span></div>";
} else {
  $hideit = '';
  $toggle = '';
  alert("Maaf, Belum ada fitur tambahan untuk Detail Page tabel [ $get_tb ]");
}

# ============================================================
# FINAL ECHO
# ============================================================
echo "
  $toggle
  <div class='$hideit mt2' id=blok_tb_detail>
    $tb
  </div>
";
