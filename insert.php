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
        <link href="css/kstyle.css" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <!-- Global site tag (gtag.js) - Google Analytics-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script>
          $(document).ready(function(){
            $('#hid').hide();

            $('.add').on('click', function(){
              if ($('#ic').hasClass('fa fa-plus-circle')) {
                $('#ic').removeClass('fa fa-plus-circle');
                $('#ic').addClass('fa fa-minus-circle');
              }
              else {
                $('#ic').removeClass('fa fa-minus-circle');
                $('#ic').addClass('fa fa-plus-circle');
              }
              $('#hid').slideToggle();

            })

          })
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
                          <th>Campo</th>
                          <th>Valore</th>
                        </thead>
                        <tbody>
                          <form action="index.php" method="post">
                          <tr>
                            <td>Data e Ora</td>
                            <td><input class="form-control" value="<?php echo $t; ?>" name="wxTime"></td>
                          </tr>

                          <tr>
                            <td>Direzione Vento</td>
                            <td><input class="form-control" name="wxDirV"></td>
                          </tr>

                          <tr>
                            <td>Vel. Vento</td>
                            <td><input class="form-control" name="wxVelV"></td>
                          </tr>

                          <tr>
                            <td>Visibilita</td>
                            <td><input class="form-control" name="wxVis" placeholder="<CAVOK>"></td>
                          </tr>

                          <tr>
                            <td>Fenomeni</td>
                            <td><input class="form-control" name="wxFen"></td>
                          </tr>

                          <tr>
                            <td>Cop. Nuvolosa<br />
                            <div class="add">
                              <i>Tipo Nubi</i>
                              <i id="ic" class="fa fa-plus-circle"></i>
                            </div>
                            </td>
                            <td><input class="form-control" name="wxNuv">
                              <div id="hid">
                                <select class="form-control" name="wx1stNuv">
                                  <option value="">Non specificata</option>
                                  <?php
                                    $sql = "SELECT id, nube FROM cldtypes";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_assoc($result)){
                                      echo '<option value="'.$row['id'].'">'.$row['nube'].'</option>';
                                    }
                                  ?>
                                </select>
                                <select class="form-control" name="wx2ndNuv">
                                  <option value="">Non specificata</option>
                                  <?php
                                    $sql = "SELECT id, nube FROM cldtypes";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_assoc($result)){
                                      echo '<option value="'.$row['id'].'">'.$row['nube'].'</option>';
                                    }
                                  ?>
                                </select>
                              </div>

                            </td>
                          </tr>

                          <tr>
                            <td>Temperatura</td>
                            <td><input type="number" class="form-control" name="wxTA"></td>
                          </tr>

                          <tr>
                            <td>P. di rugiada</td>
                            <td><input type="number" class="form-control" name="wxTR"></td>
                          </tr>

                          <tr>
                            <td>Pressione</td>
                            <td><input class="form-control" name="wxPress"></td>
                          </tr>

                          <tr>
                            <td>Trend</td>
                            <td><input class="form-control" name="wxTrend"></td>
                          </tr>

                          <tr>
                            <td>Note</td>
                            <td><input class="form-control" name="wxRmk"></td>
                          </tr>

                          <tr>
                            <td colspan="2"><input type="submit" name="wxNew"></td>
                          </tr>
                          </form>
                        </tbody>

                      </table>

                      <br>
                      </div>
                      <img src="http://www.marinadibogliaco.com/meteo/bogliaco.jpg?n=1678601804" width="50%">
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
