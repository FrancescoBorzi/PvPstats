<?php

  require_once("config.php");

  $ALLIANCE = 469;
  $HORDE = 67;

  // query conditions

  $today_condition = "DAY(date) = DAY(NOW())";
  $last7_condition = "DATEDIFF(NOW(), date) < 7";
  $month_condition = "MONTH(date) = MONTH(NOW())";

  if (isset($_GET['level']) && $_GET['level'] < 9 && $_GET['level'] > 0)
  {
    $level_condition = "level = " . $_GET['level'];
    $level = $_GET['level'];
  }
  else
  {
    $level_condition = "";
    $level = "all";
  }

  function getPlayerName($guid)
  {
    global $db;

    $query = sprintf("SELECT name FROM characters WHERE guid = %d;", $guid);
    $row = $db->query($query)->fetch_array();

    return $row['name'];
  }

  function getFactionScores($time_cond, $level_cond)
  {
    global $db, $ALLIANCE, $HORDE;

    $score[2];

    if ($time_cond != "")
      $time_cond = "AND " . $time_cond;

    if ($level_cond != "")
      $level_cond = "AND " . $level_cond;

    $query = sprintf("SELECT COUNT(*) FROM pvpstats_faction WHERE faction = %d %s %s UNION SELECT COUNT(*) FROM pvpstats_faction WHERE faction = %d %s %s;",
                     $ALLIANCE, $time_cond, $level_cond, $HORDE, $time_cond, $level_cond);

    $result = $db->query($query);

    $row = $result->fetch_row();
    $score[0] = $row[0];

    $row = $result->fetch_row();

    if ($row != null)
      $score[1] = $row[0];
    else
      $score[1] = 0;

    return $score;
  }

  // just for testing

  $alliance_today = 2;
  $horde_today = 1;

  $alliance_last7 = 8;
  $horde_last7 = 9;

  $alliance_month = 32;
  $horde_month = 26;

  $alliance_overall = 64;
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
            <li id="link-all"><a href="index.php">All levels</a></li>
            <li id="link-8"><a href="index.php?level=8">80</a></li>
            <li id="link-7"><a href="index.php?level=7">70-79</a></li>
            <li id="link-6"><a href="index.php?level=6">60-69</a></li>
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
        <div class="col-md-3 col-sm-6" style="padding: 0 10px;">
          <p class="h3">Today</p>
          <div class="score-faction-container">
            <img src="img/alliance_min.png" height="100%"> <span style="color: white; font-size: 20px;"><strong>&nbsp;&nbsp;<?= $alliance_today ?>&nbsp;&nbsp;  -&nbsp;&nbsp;<?= $horde_today ?>&nbsp;&nbsp;</strong></span> <img src="img/horde_min.png" height="100%">
          </div>
          <div id="today-score-container" class="score-container">
            <table class="table table-striped">
              <tr>
                <th class="text-center">#</th>
                <th class="text-center">Character</th>
                <th class="text-center">Victories</th>
              </tr>
              <tr>
                <td>1</td>
                <td>Namename</td>
                <td>22</td>
              </tr>
              <tr>
                <td>2</td>
                <td>Namename</td>
                <td>21</td>
              </tr>
              <tr>
                <td>3</td>
                <td>Namename</td>
                <td>20</td>
              </tr>
              <tr>
                <td>4</td>
                <td>Namename</td>
                <td>19</td>
              </tr>
              <tr>
                <td>5</td>
                <td>Namename</td>
                <td>18</td>
              </tr>
              <tr>
                <td>6</td>
                <td>Namename</td>
                <td>17</td>
              </tr>
              <tr>
                <td>7</td>
                <td>Namename</td>
                <td>16</td>
              </tr>
              <tr>
                <td>8</td>
                <td>Namename</td>
                <td>15</td>
              </tr>
              <tr>
                <td>9</td>
                <td>Namename</td>
                <td>14</td>
              </tr>
              <tr>
                <td>10</td>
                <td>Namename</td>
                <td>13</td>
              </tr>
              <tr>
                <td>11</td>
                <td>Namename</td>
                <td>22</td>
              </tr>
              <tr>
                <td>12</td>
                <td>Namename</td>
                <td>21</td>
              </tr>
              <tr>
                <td>13</td>
                <td>Namename</td>
                <td>20</td>
              </tr>
              <tr>
                <td>14</td>
                <td>Namename</td>
                <td>19</td>
              </tr>
              <tr>
                <td>15</td>
                <td>Namename</td>
                <td>18</td>
              </tr>
              <tr>
                <td>16</td>
                <td>Namename</td>
                <td>17</td>
              </tr>
              <tr>
                <td>17</td>
                <td>Namename</td>
                <td>16</td>
              </tr>
              <tr>
                <td>18</td>
                <td>Namename</td>
                <td>15</td>
              </tr>
              <tr>
                <td>19</td>
                <td>Namename</td>
                <td>14</td>
              </tr>
              <tr>
                <td>20</td>
                <td>Namename</td>
                <td>13</td>
              </tr>
            </table>
          </div>
          <button id="toggle-today" type="button" class="btn btn-default btn-xs">More</button>
        </div>
        <div class="col-md-3 col-sm-6" style="padding: 0 10px;">
          <p class="h3">Last 7 days</p>
          <div class="score-faction-container">
            <img src="img/alliance_min.png" height="100%"> <span style="color: white; font-size: 20px;"><strong>&nbsp;&nbsp;<?= $alliance_last7 ?>&nbsp;&nbsp;  -&nbsp;&nbsp;<?= $horde_last7 ?>&nbsp;&nbsp;</strong></span> <img src="img/horde_min.png" height="100%">
          </div>
          <div id="last7-score-container" class="score-container">
            <table class="table table-striped">
              <tr>
                <th class="text-center">#</th>
                <th class="text-center">Character</th>
                <th class="text-center">Victories</th>
              </tr>
              <tr>
                <td>1</td>
                <td>Namename</td>
                <td>22</td>
              </tr>
              <tr>
                <td>2</td>
                <td>Namename</td>
                <td>21</td>
              </tr>
              <tr>
                <td>3</td>
                <td>Namename</td>
                <td>20</td>
              </tr>
              <tr>
                <td>4</td>
                <td>Namename</td>
                <td>19</td>
              </tr>
              <tr>
                <td>5</td>
                <td>Namename</td>
                <td>18</td>
              </tr>
              <tr>
                <td>6</td>
                <td>Namename</td>
                <td>17</td>
              </tr>
              <tr>
                <td>7</td>
                <td>Namename</td>
                <td>16</td>
              </tr>
              <tr>
                <td>8</td>
                <td>Namename</td>
                <td>15</td>
              </tr>
              <tr>
                <td>9</td>
                <td>Namename</td>
                <td>14</td>
              </tr>
              <tr>
                <td>10</td>
                <td>Namename</td>
                <td>13</td>
              </tr>
              <tr>
                <td>11</td>
                <td>Namename</td>
                <td>22</td>
              </tr>
              <tr>
                <td>12</td>
                <td>Namename</td>
                <td>21</td>
              </tr>
              <tr>
                <td>13</td>
                <td>Namename</td>
                <td>20</td>
              </tr>
              <tr>
                <td>14</td>
                <td>Namename</td>
                <td>19</td>
              </tr>
              <tr>
                <td>15</td>
                <td>Namename</td>
                <td>18</td>
              </tr>
              <tr>
                <td>16</td>
                <td>Namename</td>
                <td>17</td>
              </tr>
              <tr>
                <td>17</td>
                <td>Namename</td>
                <td>16</td>
              </tr>
              <tr>
                <td>18</td>
                <td>Namename</td>
                <td>15</td>
              </tr>
              <tr>
                <td>19</td>
                <td>Namename</td>
                <td>14</td>
              </tr>
              <tr>
                <td>20</td>
                <td>Namename</td>
                <td>13</td>
              </tr>
            </table>
          </div>
          <button id="toggle-last7" type="button" class="btn btn-default btn-xs">More</button>
        </div>
        <div class="col-md-3 col-sm-6" style="padding: 0 10px;">
          <p class="h3">This month</p>
          <div class="score-faction-container">
            <img src="img/alliance_min.png" height="100%"> <span style="color: white; font-size: 20px;"><strong>&nbsp;&nbsp;<?= $alliance_month ?>&nbsp;&nbsp;  -&nbsp;&nbsp;<?= $horde_month ?>&nbsp;&nbsp;</strong></span> <img src="img/horde_min.png" height="100%">
          </div>
          <div id="month-score-container" class="score-container">
            <table class="table table-striped">
              <tr>
                <th class="text-center">#</th>
                <th class="text-center">Character</th>
                <th class="text-center">Victories</th>
              </tr>
              <tr>
                <td>1</td>
                <td>Namename</td>
                <td>22</td>
              </tr>
              <tr>
                <td>2</td>
                <td>Namename</td>
                <td>21</td>
              </tr>
              <tr>
                <td>3</td>
                <td>Namename</td>
                <td>20</td>
              </tr>
              <tr>
                <td>4</td>
                <td>Namename</td>
                <td>19</td>
              </tr>
              <tr>
                <td>5</td>
                <td>Namename</td>
                <td>18</td>
              </tr>
              <tr>
                <td>6</td>
                <td>Namename</td>
                <td>17</td>
              </tr>
              <tr>
                <td>7</td>
                <td>Namename</td>
                <td>16</td>
              </tr>
              <tr>
                <td>8</td>
                <td>Namename</td>
                <td>15</td>
              </tr>
              <tr>
                <td>9</td>
                <td>Namename</td>
                <td>14</td>
              </tr>
              <tr>
                <td>10</td>
                <td>Namename</td>
                <td>13</td>
              </tr>
              <tr>
                <td>11</td>
                <td>Namename</td>
                <td>22</td>
              </tr>
              <tr>
                <td>12</td>
                <td>Namename</td>
                <td>21</td>
              </tr>
              <tr>
                <td>13</td>
                <td>Namename</td>
                <td>20</td>
              </tr>
              <tr>
                <td>14</td>
                <td>Namename</td>
                <td>19</td>
              </tr>
              <tr>
                <td>15</td>
                <td>Namename</td>
                <td>18</td>
              </tr>
              <tr>
                <td>16</td>
                <td>Namename</td>
                <td>17</td>
              </tr>
              <tr>
                <td>17</td>
                <td>Namename</td>
                <td>16</td>
              </tr>
              <tr>
                <td>18</td>
                <td>Namename</td>
                <td>15</td>
              </tr>
              <tr>
                <td>19</td>
                <td>Namename</td>
                <td>14</td>
              </tr>
              <tr>
                <td>20</td>
                <td>Namename</td>
                <td>13</td>
              </tr>
            </table>
          </div>
          <button id="toggle-month" type="button" class="btn btn-default btn-xs">More</button>
        </div>
        <div class="col-md-3 col-sm-6" style="padding: 0 10px;">
          <p class="h3">Overall</p>
          <div class="score-faction-container">
            <img src="img/alliance_min.png" height="100%"> <span style="color: white; font-size: 20px;"><strong>&nbsp;&nbsp;<?= $alliance_overall ?>&nbsp;&nbsp;  -&nbsp;&nbsp;<?= $horde_overall ?>&nbsp;&nbsp;</strong></span> <img src="img/horde_min.png" height="100%">
          </div>
          <div id="overall-score-container" class="score-container">
            <table class="table table-striped">
              <tr>
                <th class="text-center">#</th>
                <th class="text-center">Character</th>
                <th class="text-center">Victories</th>
              </tr>
              <tr>
                <td>1</td>
                <td>Namename</td>
                <td>22</td>
              </tr>
              <tr>
                <td>2</td>
                <td>Namename</td>
                <td>21</td>
              </tr>
              <tr>
                <td>3</td>
                <td>Namename</td>
                <td>20</td>
              </tr>
              <tr>
                <td>4</td>
                <td>Namename</td>
                <td>19</td>
              </tr>
              <tr>
                <td>5</td>
                <td>Namename</td>
                <td>18</td>
              </tr>
              <tr>
                <td>6</td>
                <td>Namename</td>
                <td>17</td>
              </tr>
              <tr>
                <td>7</td>
                <td>Namename</td>
                <td>16</td>
              </tr>
              <tr>
                <td>8</td>
                <td>Namename</td>
                <td>15</td>
              </tr>
              <tr>
                <td>9</td>
                <td>Namename</td>
                <td>14</td>
              </tr>
              <tr>
                <td>10</td>
                <td>Namename</td>
                <td>13</td>
              </tr>
              <tr>
                <td>11</td>
                <td>Namename</td>
                <td>22</td>
              </tr>
              <tr>
                <td>12</td>
                <td>Namename</td>
                <td>21</td>
              </tr>
              <tr>
                <td>13</td>
                <td>Namename</td>
                <td>20</td>
              </tr>
              <tr>
                <td>14</td>
                <td>Namename</td>
                <td>19</td>
              </tr>
              <tr>
                <td>15</td>
                <td>Namename</td>
                <td>18</td>
              </tr>
              <tr>
                <td>16</td>
                <td>Namename</td>
                <td>17</td>
              </tr>
              <tr>
                <td>17</td>
                <td>Namename</td>
                <td>16</td>
              </tr>
              <tr>
                <td>18</td>
                <td>Namename</td>
                <td>15</td>
              </tr>
              <tr>
                <td>19</td>
                <td>Namename</td>
                <td>14</td>
              </tr>
              <tr>
                <td>20</td>
                <td>Namename</td>
                <td>13</td>
              </tr>
            </table>
          </div>
          <button id="toggle-overall" type="button" class="btn btn-default btn-xs">More</button>
        </div>
      </div>

      <div id="footer">
        <hr>
        <p class="h5 text-center">&#9679;&nbsp;<a target="_blank" href="https://github.com/ShinDarth/PvPstats"><strong>PvPstats</strong></a> for <a  target="_blank" href="<?= $server_url ?>"><?= $server_name ?></a> is free software coded by <a target="_blank" href="http://shinworld.altervista.org/"><strong>ShinDarth</strong></a>&nbsp;&#9679;</p>
        <p class="text-center" style="margin-top: 20px"><iframe src="http://ghbtns.com/github-btn.html?user=ShinDarth&repo=PvPstats&type=watch&count=true"
  allowtransparency="true" frameborder="0" scrolling="0" width="110" height="20"></iframe>&nbsp;<iframe src="http://ghbtns.com/github-btn.html?user=ShinDarth&repo=PvPstats&type=fork&count=true"
  allowtransparency="true" frameborder="0" scrolling="0" width="95" height="20"></iframe>&nbsp;<iframe src="http://ghbtns.com/github-btn.html?user=ShinDarth&type=follow&count=true"
  allowtransparency="true" frameborder="0" scrolling="0" width="165" height="20"></iframe>
</p>
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
            $('#today-score-container').css("max-height", "778px");
            $('#toggle-today').html("Less");
          }
          else
          {
            $('#today-score-container').css("max-height", "407px");
            $('#toggle-today').html("More");
          }
        });

        $('#toggle-last7').click(function () {
          if ($('#toggle-last7').html() == "More")
          {
            $('#last7-score-container').css("max-height", "778px");
            $('#toggle-last7').html("Less");
          }
          else
          {
            $('#last7-score-container').css("max-height", "407px");
            $('#toggle-last7').html("More");
          }
        });

        $('#toggle-month').click(function () {
          if ($('#toggle-month').html() == "More")
          {
            $('#month-score-container').css("max-height", "778px");
            $('#toggle-month').html("Less");
          }
          else
          {
            $('#month-score-container').css("max-height", "407px");
            $('#toggle-month').html("More");
          }
        });

        $('#toggle-overall').click(function () {
          if ($('#toggle-overall').html() == "More")
          {
            $('#overall-score-container').css("max-height", "778px");
            $('#toggle-overall').html("Less");
          }
          else
          {
            $('#overall-score-container').css("max-height", "407px");
            $('#toggle-overall').html("More");
          }
        });


      });

    </script>
  </body>
</html>

<?php $db->close(); ?>
