<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = mysqli_connect($servername, $username, $password, 'wxtracker');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function convertQFEToQNH($qfe){
  $qnh = $qfe + 668/27;
  return floor($qnh);
}

function validateWSpeed($s){
  if (similar_text($s, 'G') < 1){
    return sprintf("%02d", $s);
  }
  return $s;
}

function validateVisibility($v){
  if (strlen($v) == 4){
    return sprintf("%04d", $v);
  }
}

function validateTemp($t){
  if ($t<0){
    return "M".sprintf("%02d", abs($t));
  }
  else {
    return sprintf("%02d", abs($t));
  }
}

?>
