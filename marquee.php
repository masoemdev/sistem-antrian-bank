<div class="marquee-container">
  <div class="marquee">
    <p>Dibuat oleh Unit Kegiatan Mahasiswa (UKM) Computer Club Universitas Ma'soem - Copyright 2025 - BPRS Al-Ma'soem Meraih Sukses Bersama Kemaslahatan Ummat</p>
  </div>
</div>

<style>
  .marquee-container {
    position: fixed;
    bottom: 20px;
    left: 20px;
    right: 20px;
    /* width: 100%; */
    overflow: hidden;
    /* background: white; */
    /* sesuaikan dengan background kamu */
    margin: 0 20px;
  }

  .marquee {
    font-size: 30px;
    text-transform: uppercase;
    white-space: nowrap;
    display: inline-block;
    animation: marquee 20s linear infinite;
    padding-left: 100%;
  }

  .marquee-container::before,
  .marquee-container::after {
    content: "";
    position: absolute;
    top: 0;
    width: 260px;
    height: 100%;
    z-index: 2;
    pointer-events: none;
  }

  .marquee-container::before {
    left: 0;
    background: linear-gradient(to right, white, transparent);
  }

  .marquee-container::after {
    right: 0;
    background: linear-gradient(to left, white, transparent);
  }

  @keyframes marquee {
    0% {
      transform: translateX(0);
    }

    100% {
      transform: translateX(-100%);
    }
  }
</style>