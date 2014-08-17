<?php

  require_once("config.php");
  require_once("variables.php");
  require_once("functions.php");
  require_once("factionScores.php");

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
            <li id="link-all"><a href="index.php">All levels</a></li>
            <?php

            switch ($expansion)
            {
              case 0: // Classic only
                ?>

            <li id="link-6"><a href="index.php?level=6">60</a></li>

                <?php
                break;

              case 1: // TBC only
                ?>
            <li id="link-7"><a href="index.php?level=7">70</a></li>
            <li id="link-6"><a href="index.php?level=6">60-69</a></li>
                <?php
                break;

              case 2: // WOTLK only
                ?>
            <li id="link-8"><a href="index.php?level=8">80</a></li>
            <li id="link-7"><a href="index.php?level=7">70-79</a></li>
            <li id="link-6"><a href="index.php?level=6">60-69</a></li>
                <?php
                break;
            }

            ?>

            <li id="link-5"><a href="index.php?level=5">50-59</a></li>
            <li id="link-4"><a href="index.php?level=4">40-49</a></li>
            <li id="link-3"><a href="index.php?level=3">30-39</a></li>
            <li id="link-2"><a href="index.php?level=2">20-29</a></li>
            <li id="link-1"><a href="index.php?level=1">10-19</a></li>
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

      <div class="row text-center">
        <div class="col-lg-3 col-md-6" style="padding: 0 10px;">
          <p class="h3">Today</p>
          <div class="score-faction-container">
            <img src="img/alliance_min.png" height="100%"> <span style="color: white; font-size: 20px;"><strong>&nbsp;&nbsp;<?= $alliance_today ?>&nbsp;&nbsp;  -&nbsp;&nbsp;<?= $horde_today ?>&nbsp;&nbsp;</strong></span> <img src="img/horde_min.png" height="100%">
          </div>
          <div id="today-score-container" class="score-container">
            <table class="table table-striped">
              <tr>
                <th class="text-center">#</th>
                <th class="text-center">Character</th>
                <th class="text-center">&#9679;</th>
                <th class="text-center">Victories</th>
              </tr>
              <?php getPlayersScores($today_condition, $level_condition) ?>
            </table>
          </div>
          <button id="toggle-today" type="button" class="btn btn-default btn-xs">More</button>
        </div>
        <div class="col-lg-3 col-md-6" style="padding: 0 10px;">
          <p class="h3">Last 7 days</p>
          <div class="score-faction-container">
            <img src="img/alliance_min.png" height="100%"> <span style="color: white; font-size: 20px;"><strong>&nbsp;&nbsp;<?= $alliance_last7 ?>&nbsp;&nbsp;  -&nbsp;&nbsp;<?= $horde_last7 ?>&nbsp;&nbsp;</strong></span> <img src="img/horde_min.png" height="100%">
          </div>
          <div id="last7-score-container" class="score-container">
            <table class="table table-striped">
              <tr>
                <th class="text-center">#</th>
                <th class="text-center">Character</th>
                <th class="text-center">&#9679;</th>
                <th class="text-center">Victories</th>
              </tr>
              <?php getPlayersScores($last7_condition, $level_condition) ?>
            </table>
          </div>
          <button id="toggle-last7" type="button" class="btn btn-default btn-xs">More</button>
        </div>
        <div class="col-lg-3 col-md-6" style="padding: 0 10px;">
          <p class="h3">This month</p>
          <div class="score-faction-container">
            <img src="img/alliance_min.png" height="100%"> <span style="color: white; font-size: 20px;"><strong>&nbsp;&nbsp;<?= $alliance_month ?>&nbsp;&nbsp;  -&nbsp;&nbsp;<?= $horde_month ?>&nbsp;&nbsp;</strong></span> <img src="img/horde_min.png" height="100%">
          </div>
          <div id="month-score-container" class="score-container">
            <table class="table table-striped">
              <tr>
                <th class="text-center">#</th>
                <th class="text-center">Character</th>
                <th class="text-center">&#9679;</th>
                <th class="text-center">Victories</th>
              </tr>
              <?php getPlayersScores($month_condition, $level_condition) ?>
            </table>
          </div>
          <button id="toggle-month" type="button" class="btn btn-default btn-xs">More</button>
        </div>
        <div class="col-lg-3 col-md-6" style="padding: 0 10px;">
          <p class="h3">Overall</p>
          <div class="score-faction-container">
            <img src="img/alliance_min.png" height="100%"> <span style="color: white; font-size: 20px;"><strong>&nbsp;&nbsp;<?= $alliance_overall ?>&nbsp;&nbsp;  -&nbsp;&nbsp;<?= $horde_overall ?>&nbsp;&nbsp;</strong></span> <img src="img/horde_min.png" height="100%">
          </div>
          <div id="overall-score-container" class="score-container">
            <table class="table table-striped">
              <tr>
                <th class="text-center">#</th>
                <th class="text-center">Character</th>
                <th class="text-center">&#9679;</th>
                <th class="text-center">Victories</th>
              </tr>
              <?php getPlayersScores("", $level_condition) ?>
            </table>
          </div>
          <button id="toggle-overall" type="button" class="btn btn-default btn-xs">More</button>
        </div>
      </div>

      <div id="footer">
        <hr>
        <p class="h5 text-center">&#9679;&nbsp;<a target="_blank" href="https://github.com/ShinDarth/PvPstats"><strong>PvPstats</strong></a> for <a  target="_blank" href="<?= $server_url ?>"><?= $server_name ?></a> is free software coded by <a target="_blank" href="http://shinworld.altervista.org/"><strong>ShinDarth</strong></a>&nbsp;&#9679;</p>
        <p class="text-center" style="margin-top: 20px"><iframe src="http://ghbtns.com/github-btn.html?user=ShinDarth&repo=PvPstats&type=watch&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="110" height="20"></iframe>&nbsp;<iframe src="http://ghbtns.com/github-btn.html?user=ShinDarth&repo=PvPstats&type=fork&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="95" height="20"></iframe>&nbsp;<iframe src="http://ghbtns.com/github-btn.html?user=ShinDarth&type=follow&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="165" height="20"></iframe></p>
      </div>

    </div><!-- /.container -->


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
      $(function () {

        var level = "<?= $level ?>";

        $('#link-' + level).addClass("active");

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

        $('#toggle-today').click(function () {
          if ($('#toggle-today').html() == "More")
          {
            $('#today-score-container').css("max-height", "798px");
            $('#toggle-today').html("Less");
          }
          else
          {
            $('#today-score-container').css("max-height", "417px");
            $('#toggle-today').html("More");
          }
        });

        $('#toggle-last7').click(function () {
          if ($('#toggle-last7').html() == "More")
          {
            $('#last7-score-container').css("max-height", "798px");
            $('#toggle-last7').html("Less");
          }
          else
          {
            $('#last7-score-container').css("max-height", "417px");
            $('#toggle-last7').html("More");
          }
        });

        $('#toggle-month').click(function () {
          if ($('#toggle-month').html() == "More")
          {
            $('#month-score-container').css("max-height", "798px");
            $('#toggle-month').html("Less");
          }
          else
          {
            $('#month-score-container').css("max-height", "417px");
            $('#toggle-month').html("More");
          }
        });

        $('#toggle-overall').click(function () {
          if ($('#toggle-overall').html() == "More")
          {
            $('#overall-score-container').css("max-height", "798px");
            $('#toggle-overall').html("Less");
          }
          else
          {
            $('#overall-score-container').css("max-height", "417px");
            $('#toggle-overall').html("More");
          }
        });

      });

    </script>
  </body>
</html>

<?php $db->close(); ?>
