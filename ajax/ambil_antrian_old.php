<?php
header('Content-Type: application/json');

// Include koneksi database
require_once '../includes/db.php';

// Ambil nomor antrian terakhir hari ini
$tanggal_hari_ini = date('Y-m-d');
$stmt = $conn->prepare("SELECT MAX(nomor) as max_nomor FROM tb_antrian WHERE DATE(waktu) = ?");
$stmt->bind_param("s", $tanggal_hari_ini);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

$nomor_terakhir = $data['max_nomor'] ?? 0;
$nomor_baru = $nomor_terakhir + 1;

// Simpan nomor baru ke database
$stmt = $conn->prepare("INSERT INTO tb_antrian (nomor, status) VALUES (?, 'menunggu')");
$stmt->bind_param("i", $nomor_baru);
$stmt->execute();

// Jika ingin print otomatis, kirim ke printer server di sini
// Contoh: kirim request ke Raspberry Pi print server (opsional)
// file_get_contents("http://printer.local/print.php?nomor=$nomor_baru");

echo json_encode([
  "success" => true,
  "nomor" => $nomor_baru
]);
