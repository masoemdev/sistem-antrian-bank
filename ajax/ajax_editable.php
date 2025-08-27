<?php
include '../cn.php';
include '../includes/alert.php';

$tb = $_GET['tb'] ?? kosong('tb');
$field = $_GET['field'] ?? kosong('field');
$where_id = $_GET['where_id'] ?? kosong('where_id');
$where_value = $_GET['where_value'] ?? kosong('where_value');

# ============================================================
# NEW VALUE HANDLER
# ============================================================
$new_value = $_GET['new_value'] ?? null;
$new_value = str_replace('\'', '`', $new_value);
$new_value = str_replace(';', '', $new_value);

if ($field == 'username') {
  $new_value = preg_replace('/[^a-z0-9]/i', '', strtolower($new_value));
} elseif ($field == 'nama') {
  $new_value = strtoupper($new_value);
}


$may_null = $_GET['may_null'] ?? null; // default tidak boleh ada NULL
if ($may_null) {
  $new_value = $new_value ? "'$new_value'" : 'NULL';
} else {
  $new_value = $new_value ?? kosong('new_value'); // tidak boleh ada nilai null
  $new_value = "'$new_value'";
}



$s = "UPDATE $tb SET $field = $new_value WHERE $where_id = '$where_value'";
// die('OK');
// die($s);
$q = mysqli_query($cn, $s) or die(mysqli_error($cn));
die('OK');
