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
  else {
    return $v;
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

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );

    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'ora';
}

function getBadges($vento, $vis, $fen, $temp){
  $badges = array();

  if (substr($vento, 0, 2) >= 15){
    array_push($badges, '<span class="badge badge-primary">Ventoso</span>');
  }

  if (substr($vis, 0, 4) >= 5000){
    array_push($badges, '<span class="badge badge-success">VMC</span>');
  }
  else {
    array_push($badges, '<span class="badge badge-danger">IMC</span>');
  }

  $fen = explode(' ', $fen);
  if (in_array('BR', $fen)){
    array_push($badges, '<span class="badge badge-secondary">Foschia</span>');
  }
  if (in_array('RA', $fen) || in_array('DZ', $fen) || in_array('RADZ', $fen) || in_array('-RA', $fen) || in_array('+RA', $fen) || in_array('-DZ', $fen)){
    array_push($badges, '<span class="badge badge-warning">Pioggia</span>');
  }
  if (in_array('TSRA', $fen) || in_array('+TSRA', $fen) || in_array('-TSRA', $fen)){
    array_push($badges, '<span class="badge badge-danger">Temporale</span>');
  }
  if (in_array('SN', $fen) || in_array('-SN', $fen) || in_array('+SN', $fen)){
    array_push($badges, '<span class="badge badge-danger">Neve</span>');
  }
  if (in_array('RASN', $fen)){
    array_push($badges, '<span class="badge badge-warning">Nevischio</span>');
  }
  if (similar_text('M', $temp) >= 1){
    array_push($badges, '<span class="badge badge-info">Sottozero</span>');
  }

  return implode(' ', $badges);
}


?>
