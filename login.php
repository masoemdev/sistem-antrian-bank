<?php
if (isset($_POST['btn_login'])) {
  if (isset($_POST['username'])) {
    $username = $_POST['username'] ?? stop('POST [username] undefined.');
    $password = $_POST['password'] ?? stop('POST [password] undefined.');
    $username = preg_replace('/[^a-z0-9]/i', '', strtolower($username));

    $s = "SELECT kode_role,status FROM tb_user 
    WHERE 1
    AND username = '$username' 
    AND (password = md5('$password') OR password is null) 
    -- AND status = 1 -- untuk status akan diproses kemudian
    ";
    $q = mysqli_query($cn, $s) or die(mysqli_error($cn));
    if (!mysqli_num_rows($q)) {
      stop("username atau password tidak tepat. | <a href=?login&username=$username>Kembali</a>");
    } else {
      $user = mysqli_fetch_assoc($q);
      if ($user['status']) {
        $role = $user['kode_role'] ?? 'ADMIN';
        # ============================================================
        # SET SESSION LOGIN
        # ============================================================
        $_SESSION['antrian_username'] = $username;
        $_SESSION['antrian_kode_role'] = $role;
      } else {
        stop("status akun Anda sudah tidak aktif. | <a href=?login&username=$username>Kembali</a>");
      }
    }
  } else { // tanpa login
    $_SESSION['antrian_username'] = $_POST['btn_login'];
    $_SESSION['antrian_kode_role'] = $_POST['btn_login'];
  }
  jsurl();
}

$username_value = $_POST['username'] ?? null;
$username_value = $_GET['username'] ?? $username_value;

?>
<style>
  .login {
    display: flex;
    justify-content: center;
    /* flex-direction: column; */
    align-items: center;
    min-height: 100vh;
  }


  .form-login {
    font-size: 30px;
    background: linear-gradient(#efe, #cfc);
    max-width: 800px;
    min-width: 40vw;
    margin: 0 15px;
    padding: 15px 20px;
    border-radius: 10px;
    box-sizing: border-box;
  }

  h1,
  h2 {
    font-size: 30px;
    margin: 30px 0;
    color: darkblue;
  }

  h2 {
    font-size: 20px;
  }

  .info-login {
    color: #555;
    font-size: 16px;
    text-align: left;
  }

  .blok-radio {
    font-size: 20px;
    text-align: left;

  }

  .blok-radio label {
    display: flex;
    gap: 20px;
    /* background: red; */
  }

  .blok-radio label input {
    width: auto;
  }

  .blok-radio label div {
    padding-top: 5px;
  }

  @media (max-width:400px) {
    .form-login {
      min-width: 100%;
    }

    .login {
      padding: 15px;
    }
  }
</style>
<div class="login">
  <div class="text-center">

    <h1>Login App</h1>
    <form method=post class="form-login">
      <h2>Tanpa Login</h2>
      <button class="btn btn-primary w-100" name=btn_login value="nasabah">Antrian Nasabah</button>
      <button class="btn btn-primary w-100" name=btn_login value="display">Display Antrian</button>
    </form>
    <div>&nbsp;</div>
    <form method=post class="form-login login-user">
      <h2>Login User</h2>
      <div class="blok-input">
        <input class="form-control mb-2" required minlength=2 maxlength=20 name=username placeholder="username" value="<?= $username_value ?>">
        <input class="form-control mb-2" required minlength=3 maxlength=20 name=password type=password placeholder="password">
        <button class="btn btn-primary w-100" name=btn_login value="user">Login</button>
      </div>
    </form>
  </div>

</div>