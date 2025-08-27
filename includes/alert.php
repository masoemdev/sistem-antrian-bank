<?php
function alert($pesan, $class = 'danger', $style = '', $is_echo = true)
{
  $string = "<div class='alert alert-$class' style='$style'>$pesan</div>";
  if ($is_echo) {
    echo "
      <style>
        .alert{
          margin: 20px 10px;
          padding: 20px;
          color: white;
          background: gray;
          border-radius: 5px;
        }
        .alert-success, 
        .alert-1 {
          background: #cfc;
          color: green;
        }
        .alert-danger, 
        .alert-0 {
          background: yellow;
          color: red;
        }
      </style>
      $string
    ";
    return '';
  }
  return $string;
}

function sukses($pesan, $class = 'success', $style = null)
{
  alert($pesan, $class, $style);
}

function stop($pesan, $exit = true)
{
  alert($pesan);
  if ($exit) exit;
}

# ===============================
# MATIKAN PROSES
# ===============================
function mati($field, $pesan = 'undefined.', $style = 'color:red; font-weight:bold')
{
  echo "<div style='$style'>field [ $field ] $pesan</div>";
  exit;
}

function kosong($field, $pesan = ' tidak boleh dikosongkan.')
{
  mati($field, $pesan);
}