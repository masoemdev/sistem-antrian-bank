<?php
if (isset($_POST['btn_logout'])) {
  unset($_SESSION['antrian_username']);
  unset($_SESSION['antrian_kode_role']);
  jsurl();
}
?>
<style>
  .logout {
    position: absolute;
    top: 20px;
    right: 20px;
    z-index: 101;
    display: flex;
    gap: 15px;
  }

  .logout button {
    background: none;
    border: none;
    padding: 0;
    margin: 0;
    cursor: pointer;
  }

  .nama-user {
    max-width: 180px;
    font-size: 20px;
    text-align: right;
    /* background: red; */
  }

  @media (max-width:600px) {
    .nama-user {
      max-width: 120px;
      font-size: 16px;
    }


  }
</style>
<form method=post class="logout">
  <div class="nama-user"><?= $user['nama'] ?></div>
  <div>
    <button name="btn_logout" onclick="return confirm(`Logout?`)">
      <img src="img/logout.png" alt="logout">
    </button>

  </div>
</form>