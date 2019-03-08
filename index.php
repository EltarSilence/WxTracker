<?php
  require_once 'config.php';
  date_default_timezone_set('UTC');
?>

    <!DOCTYPE html>
    <!--
    * CoreUI - Free Bootstrap Admin Template
    * @version v2.1.10
    * @link https://coreui.io
    * Copyright (c) 2018 creativeLabs Łukasz Holeczek
    * Licensed under MIT (https://coreui.io/license)
    -->

    <html lang="it">
      <head>
        <base href="./">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
        <meta name="author" content="Łukasz Holeczek">
        <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
        <title>WX Tracker</title>
        <!-- Main styles for this application-->
        <link href="css/style.min.css" rel="stylesheet">
        <!-- Global site tag (gtag.js) - Google Analytics-->
      </head>
      <body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
        <header class="app-header navbar">
          <a class="navbar-brand" href="#">
          </a>
        </header>
        <div class="app-body">
          <?php include 'sidebar.html'; ?>
          <main class="main">
            <div class="container-fluid">
              <div class="animated fadeIn">
                <div class="row">
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-header">Elenco completo dei riporti e delle previsioni meteorologiche <a class="nav-link" href="index.php">Aggiorna</a></div>
                        <br>
                        <?php

                          if (isset($_POST['wxNew'])) {
                            $t = $_POST['wxTime'];
                            if ($_POST['wxDirV']!="VRB"){
                              $dV = sprintf("%03d", $_POST['wxDirV']);
                            }
                            else {
                              $dV = "VRB";
                            }
                            $vV = validateWSpeed($_POST['wxVelV']);
                            $vis = validateVisibility($_POST['wxVis']);
                            $fen = $_POST['wxFen'];
                            $nuv = $_POST['wxNuv'];
                            $nt1 = $_POST['wx1stNuv'];
                            $nt2 = $_POST['wx2ndNuv'];
                            $temp1 = validateTemp($_POST['wxTA']);
                            $temp2 = validateTemp($_POST['wxTR']);
                            $press = sprintf("%04d", convertQFEToQNH($_POST['wxPress']));
                            $trend = $_POST['wxTrend'];
                            $rmk = $_POST['wxRmk'];
                            #$realtemp1 = sprintf("%02d", $_POST['wxTA']);
                            #$realtemp2 = sprintf("%02d", $_POST['wxTR']);
                            $realtemp1 = $_POST['wxTA'];
                            $realtemp2 = $_POST['wxTR'];

                            $METAR = preg_replace('/\s+/', ' ', "METAR LIDQ $t $dV$vV"."KT $vis $fen $nuv $temp1/$temp2 Q$press $trend");

                            $sql = "INSERT INTO wxdata (wxDirV, wxVelV, wxVisib, wxFen, wxNuv, wxNuvType1, wxNuvType2, wxTempA, wxTempR, wxPress, remarks, trend, raw)
                            VALUES ('$dV', '$vV', '$vis', '$fen', '$nuv', '$nt1', '$nt2', '$realtemp1', '$realtemp2', '$press', '$rmk', '$trend', '$METAR')";

                            $result = mysqli_query($conn, $sql);

                          }

                          if (isset($_POST['pvNew'])) {
                            $t = $_POST['pvTime'];
                            $valid = $_POST['pvValid'];
                            $general = $_POST['pvGeneral'];
                            $specific = $_POST['pvSpecific'];
                            $rmk = $_POST['pvRmk'];
                            $note = $_POST['pvNote'];

                            $TAF = "TAF LIDQ $t $valid $general";
                            if ($specific!="") $TAF.=" $specific";
                            if ($rmk!="") $TAF.=" RMK $rmk";

                            $sql = "INSERT INTO prevdata (pvValid, pvGeneral, pvSpecific, pvRmk, pvNote, raw)
                            VALUES ('$valid', '$general', '$specific', '$rmk', '$note', '$TAF')";
                            $result = mysqli_query($conn, $sql);
                          }


                        ?>
                        <!-- INIZIO TAB METAR -->
                        <table class="table table-responsive-sm table-hover table-outline mb-0">
                          <thead class="thead-light">
                            <tr>
                              <th class="text-center">
                                <i class="icon-people">PREVISIONI TAF</i>
                              </th>
                              <th>Data e ora</th>
                              <th>Validit&agrave;</th>
                              <th>RAW TAF</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              $sql = "SELECT * FROM prevdata ORDER BY pvTime DESC LIMIT 1";
                              $result = mysqli_query($conn, $sql);
                              while ($row = mysqli_fetch_assoc($result)){
                                echo "<td>ULTIMA PREVISIONE EMESSA</td>";
                                echo "<td>".$row['pvTime']."</td>";
                                echo "<td>".$row['pvValid']."</td>";
                                echo "<td><b>".$row['raw']."</b></td>";
                              }
                            ?>
                          </tbody>
                          <thead class="thead-light">
                            <tr>
                              <th class="text-center">
                                <i class="icon-people">BOLLETTINI METAR</i>
                              </th>
                              <th>Data e Ora</th>
                              <th>Periodo</th>
                              <th>RAW METAR</th>
                              <th>Badges</th>
                            </tr>
                          </thead>
                          <tbody>
                        <?php
                          $sql = "SELECT * FROM wxdata ORDER BY wxTime DESC";
                          $result = mysqli_query($conn, $sql);
                          while ($row = mysqli_fetch_assoc($result)){
                            $d = substr(explode(' ', $row['raw'])[2], 0, 2);
                            $h = substr(explode(' ', $row['raw'])[2], 2, 2);
                            $m = substr(explode(' ', $row['raw'])[2], 4, 2);

                            $diff = abs($m-explode(':', explode(' ', $row['wxTime'])[1])[1]);
                            ?>
                            <tr>
                              <td><?php echo time_elapsed_string($row['wxTime']); ?></td>
                              <td>
                                <div><?php echo $row['wxTime'];?></div>
                                <div class="small text-muted">
                                  ORA DI EMISSIONE:
                                  <?php
                                  $dt = new DateTime($row['wxTime']);

                                  if ($dt->format('H') == $h+1) {
                                    if ($diff>5) {
                                      echo "Scarto di $diff min";
                                    }
                                    else {
                                      echo "Precisa";
                                    }
                                  }
                                  else {
                                    echo "Differita";
                                  }
                                  ?></div>
                              </td>
                              <td>
                                <?php
                                  echo $dt->format('F Y');
                                ?>
                              </td>
                              <td>
                                <strong>
                                 <?php echo $row['raw']; ?>
                               </strong>

                            </td>
                              <td>
                                <?php
                                echo getBadges($row['wxVelV'], $row['wxVisib'], $row['wxFen'], $row['wxTempA'], $row['wxNuv']);
                              ?>
                             </td>
                            </tr>
                            <?php
                          }
                        ?>
                          </tbody>
                        </table>
                        <!-- FINE TAB METAR -->
                      </div>
                    </div>
                  </div>
                  <!-- /.col-->
                </div>
                <!-- /.row-->
              </div>
            </div>
          </main>

        </div>
        <?php include 'ft.html'; ?>
      </body>
    </html>
