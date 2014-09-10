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
    <meta name="description" content="PvPstats, see who is winning!">
    <meta name="author" content="ShinDarth">

    <title><?= $server_name ?> PvPstats</title>

    <link href="css/bootstrap-cyborg.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/index-style.css" rel="stylesheet">


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
            <li class="link-all"><a href="index.php<?= $type_link_all ?>">All levels</a></li>
            <?php

            $BATTLEGROUND_AV_sel = $BATTLEGROUND_WS_sel = $BATTLEGROUND_AB_sel = $BATTLEGROUND_EY_sel = $BATTLEGROUND_SA_sel = $BATTLEGROUND_IC_sel = "";

            if (isset($_GET['type']))
            {
              switch ($_GET['type'])
              {
                case $BATTLEGROUND_AV:
                  $BATTLEGROUND_AV_sel = "selected";
                  break;
                case $BATTLEGROUND_WS:
                  $BATTLEGROUND_WS_sel = "selected";
                  break;
                case $BATTLEGROUND_AB:
                  $BATTLEGROUND_AB_sel = "selected";
                  break;
                case $BATTLEGROUND_EY:
                  $BATTLEGROUND_EY_sel = "selected";
                  break;
                case $BATTLEGROUND_SA:
                  $BATTLEGROUND_SA_sel = "selected";
                  break;
                case $BATTLEGROUND_IC:
                  $BATTLEGROUND_IC_sel = "selected";
                  break;
              }
            }

            if ($expansion < 3)
            {
              switch ($expansion)
              {
                case 0: // Classic only
                  ?>

              <li class="link-6"><a href="index.php?level=6<?= $type_link ?>">60</a></li>

                  <?php
                  break;

                case 1: // TBC only
                  ?>
              <li class="link-7"><a href="index.php?level=7<?= $type_link ?>">70</a></li>
              <li class="link-6"><a href="index.php?level=6<?= $type_link ?>">60-69</a></li>
                  <?php
                  break;

                case 2: // WOTLK only
                  ?>
              <li class="link-8"><a href="index.php?level=8<?= $type_link ?>">80</a></li>
              <li class="link-7"><a href="index.php?level=7<?= $type_link ?>">70-79</a></li>
              <li class="link-6"><a href="index.php?level=6<?= $type_link ?>">60-69</a></li>
                  <?php
                  break;
              }
            ?>

            <li class="link-5"><a href="index.php?level=5<?= $type_link ?>">50-59</a></li>
            <li class="link-4"><a href="index.php?level=4<?= $type_link ?>">40-49</a></li>
            <li class="link-3"><a href="index.php?level=3<?= $type_link ?>">30-39</a></li>
            <li class="link-2"><a href="index.php?level=2<?= $type_link ?>">20-29</a></li>
            <li class="link-1"><a href="index.php?level=1<?= $type_link ?>">10-19</a></li>

            <?php
            }
            else
            {
            ?>
            <li class="link-16"><a href="index.php?level=16<?= $type_link ?>">85</a></li>
            <li class="dropdown link-13 link-14 link-15">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">70-84 <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li class="link-15"><a href="index.php?level=15<?= $type_link ?>">80-84</a></li>
                <li class="link-14"><a href="index.php?level=14<?= $type_link ?>">75-79</a></li>
                <li class="link-13"><a href="index.php?level=13<?= $type_link ?>">70-74</a></li>
              </ul>
            </li>
            <li class="dropdown link-9 link-10 link-11 link-12">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">50-69 <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li class="link-12"><a href="index.php?level=12<?= $type_link ?>">65-69</a></li>
                <li class="link-11"><a href="index.php?level=11<?= $type_link ?>">60-64</a></li>
                <li class="link-10"><a href="index.php?level=10<?= $type_link ?>">55-59</a></li>
                <li class="link-9"><a href="index.php?level=9<?= $type_link ?>">50-54</a></li>
              </ul>
            </li>
            <li class="dropdown link-5 link-6 link-7 link-8">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">30-49 <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li class="link-8"><a href="index.php?level=8<?= $type_link ?>">45-49</a></li>
                <li class="link-7"><a href="index.php?level=7<?= $type_link ?>">40-44</a></li>
                <li class="link-6"><a href="index.php?level=6<?= $type_link ?>">35-39</a></li>
                <li class="link-5"><a href="index.php?level=5<?= $type_link ?>">30-34</a></li>
              </ul>
            </li>
            <li class="dropdown link-1 link-2 link-3 link-4">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">10-29 <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li class="link-4"><a href="index.php?level=4<?= $type_link ?>">25-29</a></li>
                <li class="link-3"><a href="index.php?level=3<?= $type_link ?>">20-24</a></li>
                <li class="link-2"><a href="index.php?level=2<?= $type_link ?>">15-19</a></li>
                <li class="link-1"><a href="index.php?level=1<?= $type_link ?>">10-14</a></li>
              </ul>
            </li>

            <?php
            }
            ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">

      <div class="main-title">
        <p class="text-center h3"><?= $server_name ?> PvP statistics</p>
        <div id="logo">
          <img id="logo_img" class="img-responsive" alt="PvPstats logo" src="<?= $server_logo ?>">
        </div>
      </div>

      <div class="row text-center">
        <div id="stats_info">
          The statistics count the amount of victories in &nbsp;
          <form method="GET">
            <?php if (isset($_GET['level'])) { ?>
            <input type="hidden" name="level" value="<?= $_GET['level'] ?>">
            <?php } ?>
            <select name="type" onChange='this.form.submit()'>
              <option value="0">All</option>
              <option value="<?= $BATTLEGROUND_AV ?>" <?= $BATTLEGROUND_AV_sel ?>>Alterac Valley</option>
              <option value="<?= $BATTLEGROUND_WS ?>" <?= $BATTLEGROUND_WS_sel ?>>Warsong Gulch</option>
              <option value="<?= $BATTLEGROUND_AB ?>" <?= $BATTLEGROUND_AB_sel ?>>Arathi Basin</option>
              <option value="<?= $BATTLEGROUND_EY ?>" <?= $BATTLEGROUND_EY_sel ?>>Eye of the Storm</option>
              <option value="<?= $BATTLEGROUND_SA ?>" <?= $BATTLEGROUND_SA_sel ?>>Strand of the Ancients</option>
              <option value="<?= $BATTLEGROUND_IC ?>" <?= $BATTLEGROUND_IC_sel ?>>Isle of Conquest</option>
            </select>
            <noscript><input type="submit" value="Submit"></noscript>
          </form>
         &nbsp; Battlegrounds from <span style="color: orange;"><strong><?= $online_from ?></strong></span>
        </div>
        <div class="col-lg-3 col-sm-6" style="padding: 0 10px;">
          <p class="h3">Today</p>
          <div class="score-faction-container">
            <img src="img/alliance_min.png" height="100%"> <span style="color: white; font-size: 20px;"><strong>&nbsp;&nbsp;<?= $alliance_today ?>&nbsp;&nbsp;  -&nbsp;&nbsp;<?= $horde_today ?>&nbsp;&nbsp;</strong></span> <img src="img/horde_min.png" height="100%">
          </div>
          <div id="today-score-container" class="today-score-container score-container">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Character</th>
                  <th class="text-center">&#9679;</th>
                  <th class="text-center">Victories</th>
                </tr>
              </thead>
              <tbody>
                <?php getPlayersScores($today_condition, $level_condition, $type_condition) ?>
              </tbody>
            </table>
          </div>
          <button id="toggle-today" type="button" class="btn btn-default btn-xs">More</button>
        </div>
        <div class="col-lg-3 col-sm-6" style="padding: 0 10px;">
          <p class="h3">Last 7 days</p>
          <div class="score-faction-container">
            <img src="img/alliance_min.png" height="100%"> <span style="color: white; font-size: 20px;"><strong>&nbsp;&nbsp;<?= $alliance_last7 ?>&nbsp;&nbsp;  -&nbsp;&nbsp;<?= $horde_last7 ?>&nbsp;&nbsp;</strong></span> <img src="img/horde_min.png" height="100%">
          </div>
          <div id="last7-score-container" class="last7-score-container score-container">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Character</th>
                  <th class="text-center">&#9679;</th>
                  <th class="text-center">Victories</th>
                </tr>
              </thead>
              <tbody>
                <?php getPlayersScores($last7_condition, $level_condition, $type_condition) ?>
              </tbody>
            </table>
          </div>
          <button id="toggle-last7" type="button" class="btn btn-default btn-xs">More</button>
        </div>
        <div class="col-lg-3 col-sm-6" style="padding: 0 10px;">
          <p class="h3">This month</p>
          <div class="score-faction-container">
            <img src="img/alliance_min.png" height="100%"> <span style="color: white; font-size: 20px;"><strong>&nbsp;&nbsp;<?= $alliance_month ?>&nbsp;&nbsp;  -&nbsp;&nbsp;<?= $horde_month ?>&nbsp;&nbsp;</strong></span> <img src="img/horde_min.png" height="100%">
          </div>
          <div id="month-score-container" class="month-score-container score-container">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Character</th>
                  <th class="text-center">&#9679;</th>
                  <th class="text-center">Victories</th>
                </tr>
              </thead>
              <tbody>
                <?php getPlayersScores($month_condition, $level_condition, $type_condition) ?>
              </tbody>
            </table>
          </div>
          <button id="toggle-month" type="button" class="btn btn-default btn-xs">More</button>
        </div>
        <div class="col-lg-3 col-sm-6" style="padding: 0 10px;">
          <p class="h3">Overall</p>
          <div class="score-faction-container">
            <img src="img/alliance_min.png" height="100%"> <span style="color: white; font-size: 20px;"><strong>&nbsp;&nbsp;<?= $alliance_overall ?>&nbsp;&nbsp;  -&nbsp;&nbsp;<?= $horde_overall ?>&nbsp;&nbsp;</strong></span> <img src="img/horde_min.png" height="100%">
          </div>
          <div id="overall-score-container" class="overall-score-container score-container">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Character</th>
                  <th class="text-center">&#9679;</th>
                  <th class="text-center">Victories</th>
                </tr>
              </thead>
              <tbody>
                <?php getPlayersScores("", $level_condition, $type_condition) ?>
              </tbody>
            </table>
          </div>
          <button id="toggle-overall" type="button" class="btn btn-default btn-xs">More</button>
        </div>
      </div>

      <?php if ($show_guilds > 0) { ?>

      <div class="row text-center">
        <div class="col-lg-3 col-sm-6" style="padding: 0 10px;">
          <p class="h4" style="margin-top: 32px">Guilds Today</p>
          <div class="today-score-container score-container">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Guild</th>
                  <th class="text-center">Victories</th>
                </tr>
              </thead>
              <tbody>
                <?php getGuildsScores($today_condition, $level_condition, $type_condition) ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6" style="padding: 0 10px;">
          <p class="h4" style="margin-top: 32px">Guilds Last 7 days</p>
          <div class="last7-score-container score-container">
            <table class="table table-striped">
              <thead>
              <tr>
                <th class="text-center">#</th>
                <th class="text-center">Guild</th>
                <th class="text-center">Victories</th>
              </tr>
              <?php getGuildsScores($last7_condition, $level_condition, $type_condition) ?>
            </table>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6" style="padding: 0 10px;">
          <p class="h4" style="margin-top: 32px">Guilds This month</p>
          <div class="month-score-container score-container">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Guild</th>
                  <th class="text-center">Victories</th>
                </tr>
              </thead>
              <tbody>
                <?php getGuildsScores($month_condition, $level_condition, $type_condition) ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6" style="padding: 0 10px;">
          <p class="h4" style="margin-top: 32px">Guilds Overall</p>
          <div class="overall-score-container score-container">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Guild</th>
                  <th class="text-center">Victories</th>
                </tr>
              </thead>
              <tbody>
                <?php getGuildsScores("", $level_condition, $type_condition) ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <p class="text-center" style="margin-top: 5px">The victories of guilds are the amount of victories of each current guild member.</p>

      <?php } ?>

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

        $('.link-' + level).addClass("active");

        var alliance = "blue";
        var horde = "red";
        var none = "grey";

        if (<?= $alliance_today ?> > <?= $horde_today ?>)
        {
          $('.today-score-container').css("border", "1px solid " + alliance);
        }
        else if (<?= $alliance_today ?> < <?= $horde_today ?>)
        {
          $('.today-score-container').css("border", "1px solid " + horde);
        }
        else
        {
          $('.today-score-container').css("border", "1px solid " + none);
        }

        if (<?= $alliance_last7 ?> > <?= $horde_last7 ?>)
        {
          $('.last7-score-container').css("border", "1px solid " + alliance);
        }
        else if (<?= $alliance_last7 ?> < <?= $horde_last7 ?>)
        {
          $('.last7-score-container').css("border", "1px solid " + horde);
        }
        else
        {
          $('.last7-score-container').css("border", "1px solid " + none);
        }

        if (<?= $alliance_month ?> > <?= $horde_month ?>)
        {
          $('.month-score-container').css("border", "1px solid " + alliance);
        }
        else if (<?= $alliance_month ?> < <?= $horde_month ?>)
        {
          $('.month-score-container').css("border", "1px solid " + horde);
        }
        else
        {
          $('.month-score-container').css("border", "1px solid " + none);
        }

        if (<?= $alliance_overall ?> > <?= $horde_overall ?>)
        {
          $('.overall-score-container').css("border", "1px solid " + alliance);
        }
        else if (<?= $alliance_overall ?> < <?= $horde_overall ?>)
        {
          $('.overall-score-container').css("border", "1px solid " + horde);
        }
        else
        {
          $('.overall-score-container').css("border", "1px solid " + none);
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
