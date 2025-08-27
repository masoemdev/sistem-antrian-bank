<style>
.my-profile {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 4;
    background: linear-gradient(#020, #002);
}

.container-my-profile {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
}

.box-my-profile {
    max-width: 500px;
    margin: 10px;
    padding: 20px 15px;
    border-radius: 10px;
    background: linear-gradient(#efe, #ccf);
}
</style>
<?php
$error_ubah_password = null;
if (isset($_POST['btn_ubah_password'])) {
  if (isset($_POST['password_lama'])) {
    $s = "SELECT 1 FROM tb_user WHERE password=md5('$_POST[password_lama]') AND username='$username'";
    $q = mysqli_query($cn, $s) or die(mysqli_error($cn));
    if (!mysqli_num_rows($q)) {
      $error_ubah_password = 'Password lama Anda tidak sesuai.';
    } else {
      $sql_password_lama = "password = md5('$_POST[password_lama]')";
    }
  } else {
    $sql_password_lama = '1';
  }
  if (!$error_ubah_password) {
    $s = "UPDATE tb_user SET password = md5('$_POST[password_baru]') WHERE username='$username' AND $sql_password_lama";
    $q = mysqli_query($cn, $s) or die(mysqli_error($cn));
    unset($_SESSION['antrian_username']);
    unset($_SESSION['antrian_kode_role']);
    echo "<script>alert(`Password Anda berhasil diubah, mohon diingat baik-baik.\n\nSilahkan relogin dengan password baru Anda.`)</script>";
    jsurl();
  }
}
if ($user['password']) {
  $info_password = $error_ubah_password ? "<div class='alert alert-danger'>$error_ubah_password</div>" : '';
  $input_password_lama = "<input required type='password' name='password_lama' class='form-control mb-2' placeholder='Password Lama Anda' autocomplete=off minlength=3 maxlength=20>";
} else {
  $info_password = "<div class='alert alert-danger'>Perhatian! Password Anda masih sama dengan username. Segera Anda ganti password Anda!</div>";
  $input_password_lama = '';
  echo '<style>.my-profile {display: block;}</style>';
}
echo "
  <div class='my-profile'>
    <div class=container-my-profile>
      <div class=box-my-profile>
        <h3 class='tengah mb-3'>My Profile</h3>
        <table class=table>
          <tr><td class='abu miring'>Username</td><td>$username</td></tr>
          <tr><td class='abu miring'>Role</td><td>$user[jenis_role]</td></tr>
          <tr><td class='abu miring'>Nama</td>
            <td>
              <div class='bg-editable form-control' id='tb_user--nama--username--$username'>$user[nama]</div>
              <div class='mb-4 f12 abu miring'>Silahkan Anda boleh mengubah nama Anda sesuai KTP.</div>
            </td>
          </tr>
        </table>
        <hr>
        <form method=post>
          <h3 class='tengah mb-3'>Ubah Password</h3>
          $info_password
          $input_password_lama
          <input required type='password' name='password_baru' id='password_baru' class='input-password form-control mb-2' placeholder='Password Baru...' autocomplete=off minlength=3 maxlength=20>
          <input required type='password' name='confirm_password' id='confirm_password' class='input-password form-control mb-2' placeholder='Confirm Password...' autocomplete=off minlength=3 maxlength=20>
          <button class='btn btn-primary w-100 mt-2' name=btn_ubah_password id=btn_ubah_password>Ubah Password</button>
        </form>
        <hr>
        <span class='btn btn-secondary w-100 mt-2' id=btn_close>Close</span>
      </div>
    </div>
  </div>
";
?>
<script src="js/editable.js"></script>
<script>
$(function() {
    $('.input-password').keyup(function() {
        if ($('#password_baru').val() == $('#confirm_password').val()) {
            $('#btn_ubah_password').prop('disabled', 0);
        } else {
            $('#btn_ubah_password').prop('disabled', 1);
        }
    });
    $('#btn_close').click(function() {
        let username = $('#username').text();
        $('.my-profile').slideUp();
        $('.nama-user').text($('#tb_user--nama--username--' + username).text())
    });
    $('.nama-user').click(function() {
        $('.my-profile').slideDown();
    });
})
</script>