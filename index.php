<?php require_once 'config.php'; ?>

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
        <link href="css/style.css" rel="stylesheet">
        <link href="vendors/pace-progress/css/pace.min.css" rel="stylesheet">
        <!-- Global site tag (gtag.js) - Google Analytics-->
        <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>
        <script>
          window.dataLayer = window.dataLayer || [];

          function gtag() {
            dataLayer.push(arguments);
          }
          gtag('js', new Date());
          // Shared ID
          gtag('config', 'UA-118965717-3');
          // Bootstrap ID
          gtag('config', 'UA-118965717-5');
        </script>
      </head>
      <body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
        <header class="app-header navbar">
          <a class="navbar-brand" href="#">
            <img class="navbar-brand-full" src="img/brand/logo.svg" width="89" height="25" alt="CoreUI Logo">
            <img class="navbar-brand-minimized" src="img/brand/sygnet.svg" width="30" height="30" alt="CoreUI Logo">
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
                      <div class="card-header">Riporti Meteorologici</div>
                        <br>
                        <?php

                          if (isset($_POST['wxNew'])) {
                            $t = $_POST['wxTime'];
                            $dV = $_POST['wxDirV'];
                            $vV = validateWSpeed($_POST['wxVelV']);
                            $vis = validateVisibility($_POST['wxVis']);
                            $fen = $_POST['wxFen'];
                            $nuv = $_POST['wxNuv'];
                            $temp1 = validateTemp($_POST['wxTA']);
                            $temp2 = validateTemp($_POST['wxTR']);
                            $press = convertQFEToQNH($_POST['wxPress']);
                            $rmk = $_POST['wxRmk'];

                            $METAR = preg_replace('/\s+/', ' ', "METAR LIDQ $t $dV$vV"."KT $vis $fen $nuv $temp1/$temp2 Q$press");

                            $sql = "INSERT INTO wxdata (wxDirV, wxVelV, wxVisib, wxFen, wxNuv, wxTempA, wxTempR, wxPress, remarks, raw)
                            VALUES ('$dV', '$vV', '$vis', '$fen', '$nuv', '$temp1', '$temp2', '$press', '$rmk', '$METAR')";

                            $result = mysqli_query($conn, $sql);

                          }


                        ?>
                        <!-- INIZIO TAB METAR -->
                        <table class="table table-responsive-sm table-hover table-outline mb-0">
                          <thead class="thead-light">
                            <tr>
                              <th class="text-center">
                                <i class="icon-people"></i>
                              </th>
                              <th>Data e Ora</th>
                              <th>Badges</th>
                              <th>RAW METAR</th>
                            </tr>
                          </thead>
                          <tbody>
                        <?php
                          $sql = "SELECT * FROM wxdata";
                          $result = mysqli_query($conn, $sql);
                          while ($row = mysqli_fetch_assoc($result)){
                            ?>
                            <tr>
                              <td><?php echo time_elapsed_string($row['wxTime']); ?></td>
                              <td>
                                <div><?php echo $row['wxTime']; ?></div>
                                <div class="small text-muted">
                                  VERA ORA DI EMISSIONE</div>
                              </td>
                              <td>
                                <?php
                                echo getBadges($row['wxVelV'], $row['wxVisib'], $row['wxFen'], $row['wxTempA']);
                              ?>
                            </td>
                              <td>
                              <strong>
                               <?php echo $row['raw']; ?>
                             </strong>
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
        <script src="js/main.js"></script>
      </body>
    </html>
