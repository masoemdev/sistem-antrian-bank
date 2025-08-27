<style>
  * {
    margin: 0;
    padding: 0;
  }

  body {
    text-align: center;
    font-family: consolas, "Courier New", Courier, monospace;
    font-size: 30px;
  }

  .nomor-antrian-label {
    margin-top: 20px;
    font-size: 40px;
  }

  .nomor-antrian {
    font-size: 160px;
  }

  .antrian-saat-ini {
    font-size: 30px;
  }

  .estimasi {
    font-size: 25px;
  }

  .slogan {
    margin-top: 20px;
    font-size: 25px;
  }
</style>
<h1 class="nomor-antrian-label">Antrian Anda</h1>
<div class="nomor-antrian">0034</div>
<div class="antrian-saat-ini">Antrian saat ini: 0025</div>
<div class="estimasi">Estimasi 12 menit menunggu</div>
<div class="slogan">
  BPRS AlMasoem <br />Meraih Sukses Bersama <br />Kemaslahatan Ummat
</div>
<button id="zzz">zzz</button>
<script>
  window.onload = () => {
    // Tunggu sebentar untuk pastikan halaman benar-benar siap
    setTimeout(() => {
      window.print();
    }, 500); // 0.5 detik delay supaya teks termuat dulu
  };
</script>

<script src="../assets/vendor/jquery/jquery-3.7.1.min.js"></script>
<script>
  function loadAntrian() {
    console.log("load");

    $.ajax({
      url: "api/ambil_antrian.php",
      success: function(a) {
        console.log(a);
        $("#nomor-antrian").text(a);
      },
    });
  }

  $(function() {
    $("#zzz").click(function() {
      alert("zzz");
      $.ajax({
        url: "api/ambil_antrian.php",
        success: function(a) {
          alert(a);
          console.log(a);
          $("#nomor-antrian").text(a);
        },
        error: function(xhr, status, error) {
          alert("Terjadi kesalahan saat mengambil data antrian: " + error);
          console.error("Status:", status);
          console.error("Error detail:", xhr.responseText);
          $("#nomor-antrian").text("Gagal mengambil nomor antrian");
        },
      });
    });
    // setInterval(loadAntrian, 2000);
    // loadAntrian(); // awal load
  });
</script>