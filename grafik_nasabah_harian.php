<div class="card">

  <div class="card-body">
    <h5 class="card-title">Grafik Nasabah Harian</h5>

    <!-- Line Chart -->
    <div id="grafik_nasabah_harian"></div>

    <script>
      document.addEventListener("DOMContentLoaded", () => {
        new ApexCharts(document.querySelector("#grafik_nasabah_harian"), {
          series: [{
            name: 'Teller',
            data: [131, 140, 128, 151, 0, 0, 156],
          }, {
            name: 'CS',
            data: [11, 32, 45, 32, 0, 0, 41]
          }, {
            name: 'Rahn',
            data: [15, 11, 32, 18, 0, 0, 11]
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
            categories: [
              "2025-04-01",
              "2025-04-02",
              "2025-04-03",
              "2025-04-04",
              "2025-04-05",
              "2025-04-06",
              "2025-04-07",
            ]
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

  </div>

</div>