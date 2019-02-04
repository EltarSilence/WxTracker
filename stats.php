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
        <link href="css/style.min.css" rel="stylesheet">
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
                      <div class="card-header">Elenco completo dei riporti e delle previsioni meteorologiche <a class="nav-link" href="index.php">Aggiorna</a></div>
                        <br>
                        <?php
                          //INTERROGAZ.
                        ?>
                        <!-- INIZIO TAB -->
                        <table class="table table-responsive-sm table-hover table-outline mb-0">
                          <thead class="thead-light">
                            <tr>
                              <th class="text-center">
                                <i class="icon-people">Titolo</i>
                              </th>
                              <th>Valore rilevato</th>
                            </tr>
                          </thead>
                          <tbody>
                        <?php
                          $sql = "SELECT COUNT(id) AS n_riporti FROM wxdata";
                          $result = mysqli_query($conn, $sql);
                          while ($output = mysqli_fetch_assoc($result)){ $tot = $output['n_riporti']; }

                          $sql = "SELECT MAX(wxTempA) AS maxtemp FROM wxdata";
                          $result = mysqli_query($conn, $sql);
                          while ($output = mysqli_fetch_assoc($result)){ $maxtemp = $output['maxtemp']; }

                          $sql = "SELECT MIN(wxTempA) AS mintemp FROM wxdata";
                          $result = mysqli_query($conn, $sql);
                          while ($output = mysqli_fetch_assoc($result)){ $mintemp = $output['mintemp']; }

                          $sql = 'SELECT COUNT(wxVisib) AS quantiCAVOK FROM wxdata WHERE wxVisib = "CAVOK" ';
                          $result = mysqli_query($conn, $sql);
                          while ($output = mysqli_fetch_assoc($result)){ $countCAVOK = $output['quantiCAVOK']; }

                          $sql = 'SELECT COUNT(wxFen) AS q_foschia FROM wxdata WHERE wxFen LIKE "%BR%" ';
                          $result = mysqli_query($conn, $sql);
                          while ($output = mysqli_fetch_assoc($result)){ $countBR = $output['q_foschia']; }

                          $sql = 'SELECT COUNT(wxFen) AS q_pioggia FROM wxdata WHERE wxFen LIKE "%RA%" ';
                          $result = mysqli_query($conn, $sql);
                          while ($output = mysqli_fetch_assoc($result)){ $countRA = $output['q_pioggia']; }

                          $sql = 'SELECT COUNT(wxVelV) AS q_gust FROM wxdata WHERE wxVelV LIKE "%G%" ';
                          $result = mysqli_query($conn, $sql);
                          while ($output = mysqli_fetch_assoc($result)){ $countGust = $output['q_gust']; }
                        ?>
                            <tr>
                              <td>
                                Numero di METAR emessi
                              </td>
                              <td>
                                <?php echo $tot; ?>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                Massime di temperatura
                              </td>
                              <td>
                                <?php echo 'MAX: '. $maxtemp.' C / MIN: '.$mintemp. ' C'; ?>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                Numero di CAVOK
                              </td>
                              <td>
                                <?php echo $countCAVOK.' ('.round(($countCAVOK/$tot*100), 1).'% dei riporti)'; ?>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                Riporti contenenti foschia
                              </td>
                              <td>
                                <?php echo $countBR.' ('.round(($countBR/$tot*100), 1).'% dei riporti)'; ?>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                Riporti contenenti pioggia
                              </td>
                              <td>
                                <?php echo $countRA.' ('.round(($countRA/$tot*100), 1).'% dei riporti)'; ?>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                Riporti con raffiche di vento (gusts)
                              </td>
                              <td>
                                <?php echo $countGust.' ('.round(($countGust/$tot*100), 1).'% dei riporti)'; ?>
                              </td>
                            </tr>
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
