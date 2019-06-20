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

    <?php require_once("navbar.php"); ?>

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
              <?php if ($expansion > 0) { ?>
              <option value="<?= $BATTLEGROUND_EY ?>" <?= $BATTLEGROUND_EY_sel ?>>Eye of the Storm</option>
              <?php if ($expansion > 1) { ?>
              <option value="<?= $BATTLEGROUND_SA ?>" <?= $BATTLEGROUND_SA_sel ?>>Strand of the Ancients</option>
              <option value="<?= $BATTLEGROUND_IC ?>" <?= $BATTLEGROUND_IC_sel ?>>Isle of Conquest</option>
              <?php if ($expansion > 2) { ?>
              <option value="<?= $BATTLEGROUND_TP ?>" <?= $BATTLEGROUND_TP_sel ?>>Twin Peaks</option>
              <option value="<?= $BATTLEGROUND_BFG ?>" <?= $BATTLEGROUND_BFG_sel ?>>Battle For Gilneas</option>
              <?php } } } ?>
            </select>
            <noscript><input type="submit" value="Submit"></noscript>
          </form>
          &nbsp; Battlegrounds starting from <span style="color: orange;"><strong><?= $online_from ?></strong></span>
        </div>
        <div class="col-lg-3 col-sm-6" style="padding: 0 10px;">
          <p class="h3">Today</p>
          <div class="score-faction-container">
            <img src="img/alliance_min.png" height="100%"> <span style="color: white; font-size: 20px;"><strong>&nbsp;&nbsp;<?= $alliance_today ?>&nbsp;&nbsp;  -&nbsp;&nbsp;<?= $horde_today ?>&nbsp;&nbsp;</strong></span> <img src="img/horde_min.png" height="100%">
          </div>
          <div class="today-score-container score-container table-responsive">
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
          <div class="last7-score-container score-container table-responsive">
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
          <div class="month-score-container score-container table-responsive">
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
          <div class="overall-score-container score-container table-responsive">
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
              </thead>
              <tbody>
                <?php getGuildsScores($last7_condition, $level_condition, $type_condition) ?>
              </tbody>
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
        <?php /* I worked hard to make PvPstats open and free for everyone. Please, do not remove the credits. */ ?>
        <p class="h6 text-center">&#9679;&nbsp;<a target="_blank" href="https://github.com/FrancescoBorzi/PvPstats"><strong>PvPstats</strong></a> for <a  target="_blank" href="<?= $server_url ?>"><?= $server_name ?></a> is free software created by <a target="_blank" href="http://shinworld.altervista.org/"><strong>ShinDarth</strong></a> and released under the <a target="_blank" href="https://github.com/FrancescoBorzi/PvPstats/blob/master/LICENSE">GNU AGPL license</a>&nbsp;&#9679;</p>
        <p class="text-center" style="margin-top: 20px"><iframe src="http://ghbtns.com/github-btn.html?user=FrancescoBorzi&repo=PvPstats&type=watch&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="110" height="20"></iframe>&nbsp;<iframe src="http://ghbtns.com/github-btn.html?user=FrancescoBorzi&repo=PvPstats&type=fork&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="95" height="20"></iframe>&nbsp;<iframe src="http://ghbtns.com/github-btn.html?user=FrancescoBorzi&type=follow&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="165" height="20"></iframe></p>
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
            $('.today-score-container').css("max-height", "798px");
            $('#toggle-today').html("Less");
          }
          else
          {
            $('.today-score-container').css("max-height", "417px");
            $('#toggle-today').html("More");
          }
        });

        $('#toggle-last7').click(function () {
          if ($('#toggle-last7').html() == "More")
          {
            $('.last7-score-container').css("max-height", "798px");
            $('#toggle-last7').html("Less");
          }
          else
          {
            $('.last7-score-container').css("max-height", "417px");
            $('#toggle-last7').html("More");
          }
        });

        $('#toggle-month').click(function () {
          if ($('#toggle-month').html() == "More")
          {
            $('.month-score-container').css("max-height", "798px");
            $('#toggle-month').html("Less");
          }
          else
          {
            $('.month-score-container').css("max-height", "417px");
            $('#toggle-month').html("More");
          }
        });

        $('#toggle-overall').click(function () {
          if ($('#toggle-overall').html() == "More")
          {
            $('.overall-score-container').css("max-height", "798px");
            $('#toggle-overall').html("Less");
          }
          else
          {
            $('.overall-score-container').css("max-height", "417px");
            $('#toggle-overall').html("More");
          }
        });

      });

    </script>
  </body>
</html>

<?php $db->close(); ?>
