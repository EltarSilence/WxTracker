<?php
/**
* METAR CLASS
*/
class METAR {

  // private $time;
  // private $vis;
  // private $fen = array();
  // private $cld = array();
  // private $airtemp;
  // private $dewpoint;
  // private $qnh;
  // private $rmk;

  // function __construct($time, $vis, $fen, $cld, $temp, $qnh, $rmk) {
  //   $this->time = $time;
  //   $this->vis = $vis;
  //   $this->fen = $fen;
  //   $this->cld = $cld;
  //   $this->airtemp = explode('/', $temp)[0];
  //   $this->dewpoint = explode('/', $temp)[1];
  //   $this->qnh = $qnh;
  //   $this->rmk = $rmk;
  // }

  private static function convertKtoC($value){
    return $value<15?floor($value-273.15):ceil($value-273.15);
  }

  private static function convertMPStoKT($value){
    return ceil(1.944*$value);
  }

  private static function calculateDewpoint($temp, $hum){
    $dew = floor(pow($hum/100, 1/8) * (112+($temp*0.9)) + $temp*0.1 - 112);
    return $dew>$temp?$temp:$dew;
  }

  private static function convertVisUnit($vis, $from, $to) {
    switch ($from) {
      case 'meters':
      switch ($to) {
        case 'kilometers':
        $vis/=1000;
        break;
        default:
        $vis = null;
        break;
      }
      break;
      case 'kilometers':
      switch ($to) {
        case 'meters':
        $vis*=1000;
        break;
        default:
        $vis = null;
        break;
      }
      default:
      $vis = null;
      break;
    }
    return $vis;
  }

  public static function createTimeGroup($round = false){
    $day = gmdate("d");
    $hour = gmdate("H");
    $minutes = gmdate("i");
    if ($round){
      (abs(50-$minutes) > abs($minutes-20))?$minutes=20:$minutes=50;
    }
    return $day.$hour.$minutes.'Z';
  }

  public static function createWindGroup($deg, $speed){
    if (is_null($deg)){
      $wind_dir = "///";
    }
    else {
      $wind_dir = sprintf("%03d", $deg);
    }

    $wind_spd = sprintf("%02d", METAR::convertMPStoKT($speed));
    $wind_dir=="0"?$wind_dir="360":false;
    return $wind_dir.$wind_spd.'KT';
  }

  public static function getVisibility($vis){
    if (!isset($vis)) return '////';
    else return METAR::outputVisibility($vis);
  }

  public static function createQNHGroup($press){
    return 'Q'.$press;
  }

  public static function createTempGroup($airtemp, $hum){
    $temp = sprintf("%02d", METAR::convertKtoC($airtemp));
    $dewpoint = sprintf("%02d", METAR::calculateDewpoint($temp, $hum));
    if ($temp<0) $temp = 'M'.sprintf("%02d", abs($temp));
    if ($dewpoint<0) $dewpoint = 'M'.sprintf("%02d", abs($dewpoint));
    return $temp.'/'.$dewpoint;
  }

  private static function getRainAmount($rain){
    if (!isset($rain)){
      return 0;
    }
    else {
      return $rain;
    }
  }

  private static function generateCloudLayers($r, $hum, $pctg) {
    $rain = METAR::getRainAmount($r);

    $cldLayers = "";
    $lh = array('030///', '035///', '040///');
    $mh = array('045///', '050///', '060///', '070///');
    $hh = array('080///', '090///');
    $pctg/=100;
    $p = rand(1, 100);
    $q = rand(1, 100);

    if ($pctg <=1/8) return "NCD";
    if ($pctg > 1/8 && $pctg < 2/8) {
      $state = "FEW";
    }
    if ($pctg >= 2/8 && $pctg <1/2) {
      $state = "SCT";
    }
    if ($pctg >= 1/2 && $pctg <7/8) {
      $state = "BKN";
    }
    if ($pctg >= 7/8 && $pctg <1) {
      $state = "OVC";
    }

    switch ($state) {
      case 'FEW':
        if ($p <= 65) {
          //65% chance
          $ly_nmb = 1;
          $index = array_rand($mh);
          $h = $mh[$index];
          $cldLayers = "FEW".$h;
          if ($q <= 15) {
            //15% chance
            do {
              $new_index = array_rand($hh);
              $h2 = $hh[$new_index];
              $cldLayers = $cldLayers.' SCT'.$h2;
              $ly_nmb++;
            }
            while ($ly_nmb>2);
          }
        }
        else {
          //35% chance
          $cldLayers = "NCD";
        }
        break;
      case 'SCT':
        $ly_nmb = 1;
        $index = array_rand($mh);
        $h = $mh[$index];
        $cldLayers = "SCT".$h;
        if ($q <= 35) {
          //35% chance
          do {
            $new_index = array_rand($hh);
            $h2 = $hh[$new_index];
            $cldLayers = $cldLayers.' BKN'.$h2;
            $ly_nmb++;
          }
          while ($ly_nmb>2);
        }
        break;
      case 'BKN':
        $ly_nmb = 1;
        $index = array_rand($mh);
        $h = $mh[$index];
        $cldLayers = "BKN".$h;
        if ($q <= 10) {
          //15% chance
          do {
            $new_index = array_rand($hh);
            $h2 = $hh[$new_index];
            $cldLayers = $cldLayers.' BKN'.$h2;
            $ly_nmb++;
          }
          while ($ly_nmb>2);
        }
        break;
      case 'OVC':
        $ly_nmb = 1;
        if ($rain>0 && $p<=75){
          //if in the last 3h rained + 75%
          $index = array_rand($lh);
          $h = $lh[$index];
          $cldLayers = "OVC".$h;
        }
        else {
          //if in the last 3h rained + 25%
          $index = array_rand($mh);
          $h = $mh[$index];
          $cldLayers = "OVC".$h;
        }
        if ($rain<=0 && $p<=60){
          //chance 60% (no rain)
          $index = array_rand($mh);
          $h = $mh[$index];
          $cldLayers = "OVC".$h;
        }
        else if ($rain<=0 && $p>=60){
          //chance 40% (no rain)
          $index = array_rand($hh);
          $h = $hh[$index];
          $cldLayers = "OVC".$h;
        }
        break;
      default:
        $cldLayers = null;
      break;
    }
    return $cldLayers;
  }

  private static function convertToMETAR($phen){
    switch ($phen) {
      //TEMPORALI
      case 'thunderstorm with light rain':
        return "-TSRA";
        break;
      case 'thunderstorm with rain':
        return "TSRA";
        break;
      case 'thunderstorm with heavy rain':
        return "+TSRA";
        break;
      case 'thunderstorm':
      case 'ragged thunderstorm':
      case 'light thunderstorm':
      case 'heavy thunderstorm':
      case 'thunderstorm with light drizzle':
      case 'thunderstorm with drizzle':
      case 'thunderstorm with heavy drizzle':
        return "TS";
        break;

      case 'light intensity drizzle':
        return "-DZ";
        break;
      case 'heavy intensity drizzle':
      case 'shower drizzle':
      case 'heavy intensity drizzle rain':
        return "+DZ";
        break;
      case 'drizzle':
        return "DZ";
        break;
      case 'drizzle rain':
        return "RADZ";
        break;
      case 'light intensity drizzle rain':
        return "-RADZ";
        break;

      case 'light rain':
        return "-RA";
        break;
      case 'moderate rain':
        return "RA";
        break;
      case 'heavy intensity rain':
      case 'very heavy rain':
      case 'extreme rain':
        return "+RA";
        break;

      case 'light intensity shower rain':
        return "-SHRA";
        break;
      case 'shower rain':
      case 'shower rain and drizzle':
      case 'heavy rain and drizzle':
      case 'ragged shower rain':
        return "SHRA";
        break;
      case 'heavy intensity shower rain':
        return "+SHRA";
        break;
      case 'freezing rain':
        return "FZRA";
        break;
      /*
        da fare
        Group 6xx: Snow
        ID	Meaning	Icon
        600	light snow	 13d
        601	snow	 13d
        602	heavy snow	 13d
        611	sleet	 13d
        612	shower sleet	 13d
        615	light rain and snow	 13d
        616	rain and snow	 13d
        620	light shower snow	 13d
        621	shower snow	 13d
        622	heavy shower snow	 13d
      */
      case 'mist':
        return "BR";
        break;
      case 'haze':
        return "HZ";
        break;
      case 'fog':
        return "FG";
        break;
      case 'squalls':
        return "SQ";
        break;
      case 'tornado':
        return "FC";
        break;

      default:
        return '';
        break;
    }
  }

  private static function generatePhen($weather, $vis){
    $n_fen = count($weather);
    $fen = array();
    //var_dump(METAR::convertToMETAR('fog'));
    for ($i=0; $i<$n_fen; $i++) {
      //var_dump($weather[$i]['description']);
      array_push($fen, METAR::convertToMETAR($weather[$i]['description']));
    }

    if (in_array("FG", $fen) && $vis > 1000){
      $indiceNebbia = array_search("FG", $fen);
      unset($fen[$indiceNebbia]);
    }

    if (in_array("BR", $fen) && $vis > 5000){
      $indiceFoschia = array_search("BR", $fen);
      unset($fen[$indiceFoschia]);
    }

    if (in_array("BR") && in_array("FG")){
      $indiceFoschia = array_search("BR", $fen);
      unset($fen[$indiceFoschia]);
    }

    $fenomeni = "";
    //var_dump($fen);
    //var_dump($n_fen);
    $n_fen = count($fen);
    for ($i=0; $i<$n_fen; $i++) {
      $fenomeni = $fenomeni.$fen[$i]." ";
    }
    return substr($fenomeni, 0, strlen($fenomeni)-1);
  }

  private static function outputVisibility($vis){
    if ($vis >= 10000) {
      return $vis = "9999";
    }
    else {
      $vis = sprintf("%04d", $vis);
      return $vis;
    }
  }

  public static function generateAutomaticMETAR(){
    $key = "e0c423f7a8d62edc8cdd81f29f70513a";
    $lat = '45.677449';
    $lon = '10.644381';
    $url = 'https://api.openweathermap.org/data/2.5/weather?lat='.$lat.'&lon='.$lon.'&APPID='.$key;
    $txt = file_get_contents($url);
    $json = json_decode($txt, true);

    $timeF = METAR::createTimeGroup();
    if (!isset($json['wind']['deg'])) {
      $windF = METAR::createWindGroup(null, $json['wind']['speed']);
    }
    else {
      $windF = METAR::createWindGroup($json['wind']['deg'], $json['wind']['speed']);
    }

    $vis = METAR::getVisibility($json['visibility']);
    $fenomeni = METAR::generatePhen($json['weather'], $vis);
    if (!isset($json['rain']['3h'])) {
      $clouds = METAR::generateCloudLayers(0,$json['main']['humidity'],$json['clouds']['all']);
    }
    else {
      $clouds = METAR::generateCloudLayers($json['rain']['3h'],$json['main']['humidity'],$json['clouds']['all']);
    }
    $t = METAR::createTempGroup($json['main']['temp'],$json['main']['humidity']);
    $qnh = METAR::createQNHGroup($json['main']['pressure']);

    return "LIDQ $timeF AUTO $windF $vis $fenomeni $clouds $t $qnh";
  }


  //GETTERS AND SETTERS

  // public function setTime($time) { $this->time = $time; }
  // public function getTime() { return $this->time; }
  // public function setVis($vis) { $this->vis = $vis; }
  // public function getVis() { return $this->vis; }
  // public function setFen($fen) { $this->fen = $fen; }
  // public function getFen() { return $this->fen; }
  // public function setCld($cld) { $this->cld = $cld; }
  // public function getCld() { return $this->cld; }
  // public function setAirtemp($airtemp) { $this->airtemp = $airtemp; }
  // public function getAirtemp() { return $this->airtemp; }
  // public function setDewpoint($dewpoint) { $this->dewpoint = $dewpoint; }
  // public function getDewpoint() { return $this->dewpoint; }
  // public function setQnh($qnh) { $this->qnh = $qnh; }
  // public function getQnh() { return $this->qnh; }
  // public function setRmk($rmk) { $this->rmk = $rmk; }
  // public function getRmk() { return $this->rmk; }

}


?>
