<?php
$rdata = [];
$rkode_jenis = [];
$categories = []; // axis horizontal

$s = "SELECT 
kode, singkatan 
FROM tb_jenis_antrian 
WHERE status = 1 -- hanya yang diaktifkan saja
";
$q = mysqli_query($cn, $s) or die(mysqli_error($cn));
while ($d = mysqli_fetch_assoc($q)) {
  $rkode_jenis[$d['kode']] = $d['singkatan'];
}



$i = 0;
foreach ($rkode_jenis as $kode_jenis => $jenis) {
  $JENIS = strtoupper($jenis);
  $i++;
  for ($j = 7; $j > 0; $j--) {
    $tgl_ke = date('Y-m-d', strtotime("-$j day", strtotime('today')));
    if ($i == 1) array_push($categories, date('d-M', strtotime($tgl_ke)));
    $s = "SELECT COUNT(1) as count 
    FROM tb_antrian 
    WHERE waktu >= '$tgl_ke' 
    AND waktu <= '$tgl_ke 23:59:59' 
    AND status = 2 -- sudah dilayani 
    AND kode_jenis = '$kode_jenis'
    ";
    $q = mysqli_query($cn, $s) or die(mysqli_error($cn));
    $d = mysqli_fetch_assoc($q);
    $rdata[$JENIS][$tgl_ke] = $d['count'];
  }
  $str = join(',', $rdata[$JENIS]);
  echo "<div class=hideit id=$JENIS>$str</div>";
}




$str_categories = join(',', $categories);
echo "<div class=hideit id=categories>$str_categories</div>";
?>
<div class="card">

  <div class="card-body">
    <h5 class="card-title">Grafik Nasabah Terlayani (7 hari terakhir)</h5>

    <!-- Line Chart -->
    <div id="grafik_nasabah_harian"></div>

    <script>
      document.addEventListener("DOMContentLoaded", () => {
        let categories = document.getElementById('categories').innerHTML.split(',');
        let TELLER = document.getElementById('TELLER').innerHTML.split(',');
        let CS = document.getElementById('CS').innerHTML.split(',');
        let RAHN = document.getElementById('RAHN').innerHTML.split(',');
        new ApexCharts(document.querySelector("#grafik_nasabah_harian"), {
          series: [{
            name: 'Teller',
            data: TELLER,
          }, {
            name: 'CS',
            data: CS
          }, {
            name: 'Rahn',
            data: RAHN
          }],
          chart: {
            height: 350,
            type: 'area',
            toolbar: {
              show: false
            },
          },
          markers: {
            size: 4
          },
          colors: ['#4154f1', '#2eca6a', '#ff771d'],
          fill: {
            type: "gradient",
            gradient: {
              shadeIntensity: 1,
              opacityFrom: 0.3,
              opacityTo: 0.4,
              stops: [0, 90, 100]
            }
          },
          dataLabels: {
            enabled: false
          },
          stroke: {
            curve: 'smooth',
            width: 2
          },
          xaxis: {
            type: 'date',
            categories: categories
          },
          tooltip: {
            x: {
              format: 'dd/MM/yy HH:mm'
            },
          }
        }).render();
      });
    </script>
    <!-- End Line Chart -->

    <div class="tengah">
      <a href="?export_csv" class="btn btn-success btn-sm mt-3">Export Data Antrian</a>

    </div>

  </div>

</div>