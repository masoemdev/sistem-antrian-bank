<?php
$kode_jenis = $_GET['kode'];
if (!$kode_jenis) stop('GET kode_jenis undefined.');

$s = "SELECT (MAX(nomor)+1) as nomor_baru 
FROM tb_antrian 
WHERE waktu >= '$today' 
AND kode_jenis = '$kode_jenis'
";
$q = mysqli_query($cn, $s) or die(mysqli_error($cn));
$d = mysqli_fetch_assoc($q);
$nomor_baru = $d['nomor_baru'] ?? 1;

if (!$nomor_baru) stop("Nomor baru nol [$nomor_baru]");

$s = "INSERT INTO tb_antrian (nomor,kode_jenis) VALUES ('$nomor_baru','$kode_jenis')";
// echo '<pre>';
// var_dump($s);
// echo '<b style=color:red>Developer SEDANG DEBUGING: exit(true)</b></pre>';
// exit;
$q = mysqli_query($cn, $s) or die(mysqli_error($cn));
?>
<style>
.blok-sedang-print {
    font-size: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    /* gap: 50px;*/
    height: 100vh;
}

.blok-mohon {
    transform: translateY(-5vh);
}

.sedang-mencetak {
    margin: 20px 0 20px 0;
}

.kembali {
    display: none;
    position: absolute;
    bottom: 50px;
    left: 0;
    right: 0;

}
</style>
<div class="blok-sedang-print text-center">
    <div class="blok-mohon">
        <div class="perintah">Mohon Tunggu</div>
        <div class="sedang-mencetak">
            Sedang Mencetak Antrian Anda.
        </div>
        <div>
	<img src="img/loading.gif" alt="loading">
        </div>
    </div>
    <div class="kembali">
        <a href="/">Kembali</a>
    </div>
</div>
<script>
setTimeout(() => $('.kembali').fadeIn(3000), 3000);
setTimeout(() => location.replace('/'), 4000);
</script>
