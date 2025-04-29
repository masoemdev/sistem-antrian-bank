<?php
$rket = [

  'display' => [
    'title' => 'Manage Display Antrian',
    'ket' => '
      Display Antrian adalah informasi posisi antrian saat ini pada dinding lobby nasabah. Untuk mengubah tulisan yang tampil pada display yaitu dengan cara:
      <ul>
        <li>Pada tabel, klik pada kolom Display</li>
        <li>Ubah Nama Display Antrian, klik OK</li>
        <li>Maka pada Display pun akan berubah</li>
      </ul>
    ',
  ],
  'status' => [
    'title' => 'Manage Status Jenis Antrian',
    'ket' => '
      Status Jenis Antrian yaitu:
      <ul>
        <li><b class=text-success>Aktif</b>: dipakai dan terlihat pada display</li>
        <li><b class=text-danger>Non-Aktif</b>: tidak dipakai dan tidak terlihat pada display</li>
      </ul>
    ',
  ],
  'reset_antrian' => [
    'title' => 'Reset Antrian Manual',
    'ket' => 'Untuk melakukan Reset Antrian Manual pada hari ini ke antrian 001. Perhatian! Semua data Antrian pada hari ini akan di set ke Status Null (belum dilayani). Pada tabel, klik tombol Reset pada tiap Jenis Antrian.',
  ],
  'durasi_layanan' => [
    'title' => 'Estimasi Durasi Pelayanan',
    'ket' => '
      Rata-rata waktu yang dibutuhkan untuk melayani satu orang Nasabah
      <ul>
        <li>Klik pada kolom Durasi Layanan</li>
        <li>Masukan angka antara 0 s.d 20 (satuan menit)</li>
        <li>Jika Anda mengisi 0, maka tidak ada bagian info estimasi menunggu pada Struk Antrian</li>
        <li>
          Jika Anda mengisi antara 1 s.d 20, maka system melakukan perhitungan estimasi menunggu dan tampil pada Struk Antrian. 
          <div class="consolas darkblue p3">
            [Estimasi menunggu] = [durasi layanan] x [sisa antrian]
          </div>
        </li>
      </ul>
    ',
  ],
];

$panduan = '';
foreach ($rket as $key => $arr) {
  $panduan .= "
    <div class='mb-3 row-panduan'>
      <h3>$arr[title]</h3> 
      <p>$arr[ket]</p>
    </div> 
  ";
}

$tr = '';
$i = 0;
foreach ($rjenis_antrian as $kode => $d) {
  $i++;
  $posisi_antrian = 0;
  $status = $d['status'] ? $aktif : $non_aktif;
  if ($d['status']) {
    $tr_class = '';
    $btn_status = "
      <button name=btn_set_status_jenis_antrian value='$d[kode]--0' class='btn btn-success btn-sm' onclick='return confirm(`Non Aktifkan Jenis Antrian ini?`)'>Aktif</button>
    ";

    if ($d['posisi_antrian']) {
      $posisi_antrian = $d['posisi_antrian'];
      $btn_reset = "
        <button name=btn_reset_antrian value=$d[kode] class='btn btn-danger btn-sm' onclick='return confirm(`Reset Antrian ini?\n\nPerhatian! Semua antrian $d[jenis] pada hari ini akan hilang.`)'>Reset</button>
      ";
    } else {
      $btn_reset = "
        <span class='btn btn-secondary btn-sm' onclick='alert(`Antrian ini sedang berada di awal antrian.`)'>Reset</span>
      ";
    }

    $td_display = "<td class='bg-editable' id=tb_jenis_antrian--singkatan--kode--$d[kode]>$d[singkatan]</td>";

    $td_reset = "
      <td>
        <div class='d-flex gap-2'>
          <div class='kanan' style='min-width:30px'>$posisi_antrian</div>
          <div>$btn_reset</div>
        </div>
      </td>
    ";

    $td_durasi = "<td class='bg-editable' id=tb_jenis_antrian--durasi_layanan--kode--$d[kode]>$d[durasi_layanan]</td>";
  } else {
    $tr_class = 'text-disabled';
    $btn_status = "
      <button name=btn_set_status_jenis_antrian value='$d[kode]--1' class='btn btn-secondary btn-sm' onclick='return confirm(`Aktifkan Kembali Jenis Antrian ini?`)'>Non-Aktif</button>
    ";
    $btn_reset = '-';
    $td_display = '<td>-</td>';
    $td_reset = '<td>-</td>';
    $td_durasi = '<td>-</td>';
  }

  # ============================================================
  # FINAL LOOP TR
  # ============================================================
  $tr .= "
    <tr id=tr__$d[kode] class='$tr_class'>
      <td>
        <span class=hover $onclick_ondev >$img_delete_disabled</span>
      </td>

      <td>$d[kode]</td>
      <td>$d[jenis]</td>
      <td>$btn_status</td>
      $td_display
      $td_reset
      $td_durasi
    </tr>
  ";
}


?>
<table class="table table-hover">
  <thead>
    <th>#</th>
    <th>Kode</th>
    <th>Jenis Antrian</th>
    <th>Status</th>
    <th>Display</th>
    <th>Antrian</th>
    <th>Durasi Layanan</th>
  </thead>
  <?= $tr ?>
</table>
<!-- <button class='btn btn-success btn-sm' onclick='return confirm(`Tambah Jenis Antrian?`)'>Tambah Jenis Antrian</button> -->
<span class='btn btn-secondary btn-sm' <?= $onclick_ondev ?>>Tambah Jenis Antrian</span>

<span class="btn btn-info btn-sm btn-aksi" id="panduan--toggle">Tampilkan Panduan <?= img_icon('help') ?></span>
<script src="js/btn-aksi-click.js"></script>
<div class="my-4">
</div>
<div class="card my-2 hideit  " id="panduan">
  <div class="card-header bg-info text-white text-center">Panduan Manage Jenis Antrian</div>
  <div class="card-body gradasi-toska">
    <?= $panduan ?>
  </div>
</div>