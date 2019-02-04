<?php require 'METAR.php'; ?>
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
        <title>Inserisci | WX Tracker</title>
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
                      <br>
                      <?php
                        $t = METAR::createTimeGroup(true);
                      ?>

                          <table>
                            <thead>
                              <th>Data e Ora</th>
                              <th>Valido da / a</th>
                              <th>Fen. Generali</th>
                              <th>Fen. Specifici</th>
                              <th>Remarks</th>
                              <th>Note</th>
                            </thead>
                            <tbody>
                              <tr>
                                <form action="index.php" method="post">
                                  <td><input style="width: 135px;" class="form-control" value="<?php echo $t; ?>" name="pvTime"></td>
                                  <td><input style="width: 135px;" class="form-control" name="pvValid" value="<?php echo date('d').date('H').'/'.sprintf("%02d", date('d')+1).'24'; ?>"></td>
                                  <td><input style="width: 300px;" class="form-control" name="pvGeneral"></td>
                                  <td><textarea style="width: 300px; height: 100px;" class="form-control" name="pvSpecific"></textarea></td>
                                  <td><input style="width: 135px;" class="form-control" name="pvRmk"></td>
                                  <td><input style="width: 135px;" class="form-control" name="pvNote"></td>
                                  <td><input type="submit" name="pvNew"></td>
                                </form>
                              </tr>
                            </tbody>
                          </table>
                          <table>
                            <tr>
                              <td>
                                <iframe width="650" height="450" src="https://embed.windy.com/embed2.html?lat=45.466&lon=10.703&zoom=9&level=surface&overlay=wind&menu=&message=&marker=&calendar=24&pressure=true&type=map&location=coordinates&detail=true&detailLat=45.672&detailLon=10.638&metricWind=kt&metricTemp=%C2%B0C&radarRange=-1" frameborder="0"></iframe>
                              </td>
                              <td>
                                <img alt="MeteoSat" src="http://www.meteosatonline.it/riduce/anim-ita.php" width="640" height="480">
                              </td>
                            </tr>
                        </table>
                      <br>
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
