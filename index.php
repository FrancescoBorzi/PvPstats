<?php

  require_once("config.php");

  // just for testing
  $alliance_today = 2;
  $alliance_last7 = 8;
  $alliance_month = 32;
  $alliance_overall = 64;
  $horde_today = 1;
  $horde_last7 = 9;
  $horde_month = 26;
  $horde_overall = 64;

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title><?= $server_name ?> PvPstats</title>

    <link href="css/bootstrap-cyborg.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="visible-xs navbar-brand" href="#"><?= $server_name ?> PvPstats</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-center">
            <li class="active"><a href="#">All levels</a></li>
            <li><a href="">80</a></li>
            <li><a href="">70-79</a></li>
            <li><a href="">60-69</a></li>
            <li><a href="">50-59</a></li>
            <li><a href="">40-49</a></li>
            <li><a href="">30-39</a></li>
            <li><a href="">20-29</a></li>
            <li><a href="">10-19</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container main-box">

      <div class="main-title">
        <h1><?= $server_name ?> PvPstats</h1>
        <p class="lead" style="margin-bottom: 5px">See who is winning!</p>
        <p class="small" style="color: white;">The statistics count the amount of victories in all Battlegrounds from <span style="color: orange;"><strong><?= $online_from ?></strong></span></p>
      </div>

      <div class="row">
        <div class="col-md-3 col-sm-6" style="padding: 0 10px;">
          <p class="h3 text-center">Today</p>
          <div class="score-faction-container text-center">
            <img src="img/alliance_min.png" height="100%"> <span style="color: white; font-size: 20px;"><strong>&nbsp;&nbsp;<?= $alliance_today ?>&nbsp;&nbsp;  -&nbsp;&nbsp;<?= $horde_today ?>&nbsp;&nbsp;</strong></span> <img src="img/horde_min.png" height="100%">
          </div>
          <div id="today-score-container" class="score-container">
            <table class="table table-striped text-center">
              <tr>
                <th class="text-center">#</th>
                <th class="text-center">Character</th>
                <th class="text-center">Victories</th>
              </tr>
              <tr>
                <td>1</td>
                <td>Namename</td>
                <td>12</td>
              </tr>
              <tr>
                <td>2</td>
                <td>Namename</td>
                <td>5</td>
              </tr>
              <tr>
                <td>3</td>
                <td>Namename</td>
                <td>1</td>
              </tr>
            </table>
          </div>
        </div>
        <div class="col-md-3 col-sm-6" style="padding: 0 10px;">
          <p class="h3 text-center">Last 7 days</p>
          <div class="score-faction-container text-center">
            <img src="img/alliance_min.png" height="100%"> <span style="color: white; font-size: 20px;"><strong>&nbsp;&nbsp;<?= $alliance_last7 ?>&nbsp;&nbsp;  -&nbsp;&nbsp;<?= $horde_last7 ?>&nbsp;&nbsp;</strong></span> <img src="img/horde_min.png" height="100%">
          </div>
          <div id="last7-score-container" class="score-container">
            <table class="table table-striped text-center">
              <tr>
                <th class="text-center">#</th>
                <th class="text-center">Character</th>
                <th class="text-center">Victories</th>
              </tr>
              <tr>
                <td>1</td>
                <td>Namename</td>
                <td>12</td>
              </tr>
              <tr>
                <td>2</td>
                <td>Namename</td>
                <td>5</td>
              </tr>
              <tr>
                <td>3</td>
                <td>Namename</td>
                <td>1</td>
              </tr>
            </table>
          </div>
        </div>
        <div class="col-md-3 col-sm-6" style="padding: 0 10px;">
          <p class="h3 text-center">This month</p>
          <div class="score-faction-container text-center">
            <img src="img/alliance_min.png" height="100%"> <span style="color: white; font-size: 20px;"><strong>&nbsp;&nbsp;<?= $alliance_month ?>&nbsp;&nbsp;  -&nbsp;&nbsp;<?= $horde_month ?>&nbsp;&nbsp;</strong></span> <img src="img/horde_min.png" height="100%">
          </div>
          <div id="month-score-container" class="score-container">
            <table class="table table-striped text-center">
              <tr>
                <th class="text-center">#</th>
                <th class="text-center">Character</th>
                <th class="text-center">Victories</th>
              </tr>
              <tr>
                <td>1</td>
                <td>Namename</td>
                <td>12</td>
              </tr>
              <tr>
                <td>2</td>
                <td>Namename</td>
                <td>5</td>
              </tr>
              <tr>
                <td>3</td>
                <td>Namename</td>
                <td>1</td>
              </tr>
            </table>
          </div>
        </div>
        <div class="col-md-3 col-sm-6" style="padding: 0 10px;">
          <p class="h3 text-center">Overall</p>
          <div class="score-faction-container text-center">
            <img src="img/alliance_min.png" height="100%"> <span style="color: white; font-size: 20px;"><strong>&nbsp;&nbsp;<?= $alliance_overall ?>&nbsp;&nbsp;  -&nbsp;&nbsp;<?= $horde_overall ?>&nbsp;&nbsp;</strong></span> <img src="img/horde_min.png" height="100%">
          </div>
          <div id="overall-score-container" class="score-container">
            <table class="table table-striped text-center">
              <tr>
                <th class="text-center">#</th>
                <th class="text-center">Character</th>
                <th class="text-center">Victories</th>
              </tr>
              <tr>
                <td>1</td>
                <td>Namename</td>
                <td>12</td>
              </tr>
              <tr>
                <td>2</td>
                <td>Namename</td>
                <td>5</td>
              </tr>
              <tr>
                <td>3</td>
                <td>Namename</td>
                <td>1</td>
              </tr>
            </table>
          </div>
        </div>
      </div>

      <div id="footer">
        <hr>
        <p class="h5 text-center">&#9679;&nbsp;<a target="_blank" href="https://github.com/ShinDarth/PvPstats"><strong>PvPstats</strong></a> for <a  target="_blank" href="<?= $server_url ?>"><?= $server_name ?></a> is free software coded by <a target="_blank" href="http://shinworld.altervista.org/"><strong>ShinDarth</strong></a>&nbsp;&#9679;</p>
      </div>

    </div><!-- /.container -->


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
      $(function () {
        var alliance = "blue";
        var horde = "red";
        var none = "grey";

        if (<?= $alliance_today ?> > <?= $horde_today ?>)
        {
          $('#today-score-container').css("border", "1px solid " + alliance);
        }
        else if (<?= $alliance_today ?> < <?= $horde_today ?>)
        {
          $('#today-score-container').css("border", "1px solid " + horde);
        }
        else
        {
          $('#today-score-container').css("border", "1px solid " + none);
        }

        if (<?= $alliance_last7 ?> > <?= $horde_last7 ?>)
        {
          $('#last7-score-container').css("border", "1px solid " + alliance);
        }
        else if (<?= $alliance_last7 ?> < <?= $horde_last7 ?>)
        {
          $('#last7-score-container').css("border", "1px solid " + horde);
        }
        else
        {
          $('#last7-score-container').css("border", "1px solid " + none);
        }

        if (<?= $alliance_month ?> > <?= $horde_month ?>)
        {
          $('#month-score-container').css("border", "1px solid " + alliance);
        }
        else if (<?= $alliance_month ?> < <?= $horde_month ?>)
        {
          $('#month-score-container').css("border", "1px solid " + horde);
        }
        else
        {
          $('#month-score-container').css("border", "1px solid " + none);
        }

        if (<?= $alliance_overall ?> > <?= $horde_overall ?>)
        {
          $('#overall-score-container').css("border", "1px solid " + alliance);
        }
        else if (<?= $alliance_overall ?> < <?= $horde_overall ?>)
        {
          $('#overall-score-container').css("border", "1px solid " + horde);
        }
        else
        {
          $('#overall-score-container').css("border", "1px solid " + none);
        }


      });

    </script>
  </body>
</html>
