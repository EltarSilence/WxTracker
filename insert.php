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
                      <br>
                      <?php
                        $t = METAR::createTimeGroup(true);
                      ?>

                          <table>
                            <thead>
                              <th>Data e Ora</th>
                              <th>Direzione Vento</th>
                              <th>Velocita Vento</th>
                              <th>Visibilita</th>
                              <th>Fenomeni</th>
                              <th>Cop. Nuvolosa</th>
                              <th>Temperatura</th>
                              <th>Punto di rugiada</th>
                              <th>Pressione</th>
                              <th>Note</th>
                            </thead>
                            <tbody>
                              <tr>
                                <form action="index.php" method="post">
                                  <td><input style="width: 135px;" class="form-control" value="<?php echo $t; ?>" name="wxTime"></td>
                                  <td><input style="width: 135px;" class="form-control" name="wxDirV"></td>
                                  <td><input style="width: 135px;" class="form-control" name="wxVelV"></td>
                                  <td><input style="width: 135px;" class="form-control" name="wxVis"></td>
                                  <td><input style="width: 135px;" class="form-control" name="wxFen"></td>
                                  <td><input style="width: 200px;" class="form-control" name="wxNuv"></td>
                                  <td><input type="number" style="width: 70px;" class="form-control" name="wxTA"></td>
                                  <td><input type="number" style="width: 70px;" class="form-control" name="wxTR"></td>
                                  <td><input style="width: 70px;" class="form-control" name="wxPress"></td>
                                  <td><input style="width: 135px;" class="form-control" name="wxRmk"></td>
                                  <td><input type="submit" name="wxNew"></td>
                                </form>
                              </tr>
                            </tbody>
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
