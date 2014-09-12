<?php

  require_once("config.php");
  require_once("variables.php");
  require_once("functions.php");
  require_once("factionScores.php");

  if (isset($_GET['id']) && is_numeric($_GET['id']))
  {
    $id = $_GET['id'];

    $query = sprintf("SELECT * FROM pvpstats_battlegrounds WHERE id = %d",
                     $id);

    $result = $db->query($query);

    if (!$result)
      die("Error querying: " . $query);

    $row = $result->fetch_array();

    $type = $row['type'];
    $winner_faction = $row['winner_faction'];
    $bracket_id = $row['bracket_id'];
    $datetime = new DateTime($row['date']);

    $bracket_level_range = getLevelRangeByBracketId($bracket_id);
    $type_name = getBattleGroundTypeName($type);

    $date = $datetime->format($date_format);
    $time = $datetime->format($time_format);

    $month = $datetime->format('M');
    $year = $datetime->format('Y');

    $month_and_year = $month . " " . $year;

    $this_day_condition = "DATE(date) = DATE('" . $row['date'] . "')";
    $this_month_condition = "MONTH(date) = MONTH('" . $row['date'] . "') AND YEAR(date) = YEAR('" . $row['date'] . "')";
    $this_level_condition = "bracket_id = " . $bracket_id;

    $score_this_day = getFactionScores($this_day_condition, $this_level_condition, "");
    $score_this_month = getFactionScores($this_month_condition, $this_level_condition, "");

    $alliance_today = $score_today[0];
    $horde_today = $score_today[1];

    $alliance_this_day = $score_this_day[0];
    $horde_this_day = $score_this_day[1];

    $alliance_this_month = $score_this_month[0];
    $horde_this_month = $score_this_month[1];

    switch($winner_faction)
    {
      case $ALLIANCE:
        $winner_text = "<span style=\"color: " . $alliance_color . "\">Alliance Wins</span>";
        break;
      case $HORDE:
        $winner_text = "<span style=\"color: " . $horde_color . "\">Horde Wins</span>";
        break;
      case $NONE:
        $winner_text = "Draw";
        break;
    }
  }

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
          <?php if (!isset($id) || $result->num_rows == 0) { require_once("navbar.php"); } else { ?>
          <li><a href="battleground.php">&larr; Back</a></li>
          <?php } ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">

      <div class="main-title"></div>

      <?php if (!isset($id)) { ?>

      <p class="lead text-center">Script under working!</p>

      <?php } else if ($result->num_rows == 0) { ?>

      <p class="lead text-center">BattleGround having id <strong><?= $id ?></strong> not found.</p>

      <?php } else { ?>

      <div class="row">
        <div class="col-xs-4">
          <p class="lead text-left"><span style="color: yellow">[<?= $bracket_level_range ?>]</span> <span style="color: white"><?= $type_name ?></span></p>
        </div>
        <div class="col-xs-4">
          <p class="lead text-center"><?= $winner_text ?></p>
        </div>
        <div class="col-xs-4">
          <p class="lead text-right" style="color: white"><?= $date ?> <span style="color: pink">[<?= $time ?>]</span></p>
        </div>
      </div>

      <div id="bg-table-container" class="table-responsive">
        <table id="bg-table" class="table table-hover text-center" data-sortable>
          <thead>
            <tr>
              <th id="character" class="th-elem text-center" onClick="thfocus(this)">Character</th>
              <th id="class" class="th-elem text-center" onClick="thfocus(this)">&#9679;</th>

              <th id="killing-blows" class="th-elem text-center" onClick="thfocus(this)">Killing Blows</th>
              <th id="deaths" class="th-elem text-center" onClick="thfocus(this)">Deaths</th>
              <th id="honorable-kills" class="th-elem text-center" onClick="thfocus(this)">Honorable Kills</th>
              <th id="bonus-honor" class="th-elem text-center" onClick="thfocus(this)">Bonus Honor</th>
              <th id="damage-done" class="th-elem text-center" onClick="thfocus(this)">Damage Done</th>
              <th id="healing" class="th-elem text-center" onClick="thfocus(this)">Healing Done</th>

              <?php

              switch($type)
              {
                case $BATTLEGROUND_AV:
                  $attrs = '<th id="attr1" class="th-elem text-center" onClick="thfocus(this)">Graveyards Assaulted</th>'
                         . '<th id="attr2" class="th-elem text-center" onClick="thfocus(this)">Graveyards Defended</th>'
                         . '<th id="attr3" class="th-elem text-center" onClick="thfocus(this)">Towers Assaulted</th>'
                         . '<th id="attr4" class="th-elem text-center" onClick="thfocus(this)">Towers Defended</th>'
                         . '<th id="attr5" class="th-elem text-center" onClick="thfocus(this)">Mines Captured</th>';
                  $attr_count = 5;
                  break;

                case $BATTLEGROUND_WS:
                case $BATTLEGROUND_TP:
                  $attrs = '<th id="attr1" class="th-elem text-center" onClick="thfocus(this)">Flags Captured</th>'
                         . '<th id="attr2" class="th-elem text-center" onClick="thfocus(this)">Flags Returned</th>';
                  $attr_count = 2;
                  break;

                case $BATTLEGROUND_AB:
                case $BATTLEGROUND_IC:
                case $BATTLEGROUND_BFG:
                  $attrs = '<th id="attr1" class="th-elem text-center" onClick="thfocus(this)">Bases Assaulted</th>'
                         . '<th id="attr2" class="th-elem text-center" onClick="thfocus(this)">Bases Defended</th>';
                  $attr_count = 2;
                  break;

                case $BATTLEGROUND_EY:
                  $attrs = '<th id="attr1" class="th-elem text-center" onClick="thfocus(this)">Flags Captured</th>';
                  $attr_count = 1;
                  break;

                case $BATTLEGROUND_SA:
                  $attrs = '<th id="attr1" class="th-elem text-center" onClick="thfocus(this)">Demolishers Destroyed</th>'
                         . '<th id="attr2" class="th-elem text-center" onClick="thfocus(this)">Gates Destroyed</th>';
                  $attr_count = 2;
                  break;

                default:
                  $attrs = '<th id="attr1" class="th-elem text-center" onClick="thfocus(this)">Attr1</th>'
                         . '<th id="attr2" class="th-elem text-center" onClick="thfocus(this)">Attr2</th>'
                         . '<th id="attr3" class="th-elem text-center" onClick="thfocus(this)">Attr3</th>'
                         . '<th id="attr4" class="th-elem text-center" onClick="thfocus(this)">Attr4</th>'
                         . '<th id="attr5" class="th-elem text-center" onClick="thfocus(this)">Attr5</th>';
                  $attr_count = 5;
              }

              echo $attrs;

              ?>
            </tr>
          </thead>

          <tbody>

            <?php

              $query = sprintf("SELECT * FROM pvpstats_players WHERE battleground_id = %d",
                         $id);

              $result = $db->query($query);

              if (!$result)
                die("Cannot find battleground with id <strong>" . $id . "</strong> in pvpstats_players table.");

              while (($row = $result->fetch_array()) != null)
              {
                printf("<tr>");

                printf("<td><a style=\"color: %s; \" target=\"_blank\" href=\"%s%s\"><strong>%s</strong></a></td>",
                       getPlayerColor($row['character_guid']),
                       $armory_url,
                       getPlayerName($row['character_guid']),
                       getPlayerName($row['character_guid']));
                printf("<td style=\"padding-left: 0; padding-right: 0;\"><img src=\"img/class/%d.gif\"> <img src=\"img/race/%d-%d.gif\"></td>",
                       getPlayerClass($row['character_guid']),
                       getPlayerRace($row['character_guid']),
                       getPlayerGender($row['character_guid']));

                printf("<td>%s</td>", $row['score_killing_blows']);
                printf("<td>%s</td>", $row['score_deaths']);
                printf("<td>%s</td>", $row['score_honorable_kills']);
                printf("<td>%s</td>", $row['score_bonus_honor']);
                printf("<td>%s</td>", $row['score_damage_done']);
                printf("<td>%s</td>", $row['score_healing_done']);

                printf("<td>%s</td>", $row['attr_1']);

                if ($attr_count > 1)
                {
                  printf("<td>%s</td>", $row['attr_2']);

                  if ($attr_count > 2)
                  {
                    printf("<td>%s</td>", $row['attr_3']);

                    if ($attr_count > 3)
                    {
                      printf("<td>%s</td>", $row['attr_4']);

                      if ($attr_count > 4)
                        printf("<td>%s</td>", $row['attr_5']);
                    }
                  }

                }

                printf("</tr>");
              }
            ?>

          </tbody>

        </table>
      </div>

      <?php if ($additional_statistics != 0) { ?>
      <br>

      <div class="row text-center">
        <div class="col-lg-3 col-sm-6" style="padding: 0 10px;">
          <p class="h4">Guild Members</p>
          <div class="score-faction-container">
            Amount of members joined this BG
          </div>
          <div class="guild-members-container score-container" style="border: 1px solid grey">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Guild</th>
                  <th class="text-center">Members</th>
                </tr>
              </thead>
              <tbody>
                <?php getGuildsMembers($id) ?>
              </tbody>
            </table>
          </div>
          <button id="toggle-guild-members" type="button" class="btn btn-default btn-xs">More</button>
        </div>
        <div class="col-lg-3 col-sm-6" style="padding: 0 10px;">
          <p class="h4"><?= $date ?> <span style="color: yellow">[<?= $bracket_level_range ?>]</span></p>
          <div class="score-faction-container">
            <img src="img/alliance_min.png" height="100%"> <span style="color: white; font-size: 20px;"><strong>&nbsp;&nbsp;<?= $alliance_this_day ?>&nbsp;&nbsp;  -&nbsp;&nbsp;<?= $horde_this_day ?>&nbsp;&nbsp;</strong></span> <img src="img/horde_min.png" height="100%">
          </div>
          <div class="this-day-score-container score-container">
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
                <?php getPlayersScores($this_day_condition, $this_level_condition, "") ?>
              </tbody>
            </table>
          </div>
          <button id="toggle-this-day" type="button" class="btn btn-default btn-xs">More</button>
        </div>
        <div class="col-lg-3 col-sm-6" style="padding: 0 10px;">
          <p class="h4"><?= $month_and_year ?> <span style="color: yellow">[<?= $bracket_level_range ?>]</span></p>
          <div class="score-faction-container">
            <img src="img/alliance_min.png" height="100%"> <span style="color: white; font-size: 20px;"><strong>&nbsp;&nbsp;<?= $alliance_this_month ?>&nbsp;&nbsp;  -&nbsp;&nbsp;<?= $horde_this_month ?>&nbsp;&nbsp;</strong></span> <img src="img/horde_min.png" height="100%">
          </div>
          <div class="this-month-score-container score-container">
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
                <?php getPlayersScores($this_month_condition, $this_level_condition, $type_condition) ?>
              </tbody>
            </table>
          </div>
          <button id="toggle-this-month" type="button" class="btn btn-default btn-xs">More</button>
        </div>
        <div class="col-lg-3 col-sm-6" style="padding: 0 10px;">
          <p class="h4">BattleGrounds of the day</p>
          <div class="score-faction-container">
            All BattleGrounds played <?= $date ?>
          </div>
          <div class="bg-day-container score-container" style="border: 1px solid grey">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Type</th>
                  <th class="text-center">&#9679;</th>
                  <th class="text-center">End time</th>
                </tr>
              </thead>
              <tbody>
                <?php getBattleGroundsOfDay($date); ?>
              </tbody>
            </table>
          </div>
          <button id="toggle-bg-day" type="button" class="btn btn-default btn-xs">More</button>
        </div>
      </div>

      <?php } ?>

      <?php } ?>

    </div>

    <div id="footer">
      <hr>
      <p class="h5 text-center">&#9679;&nbsp;<a target="_blank" href="https://github.com/ShinDarth/PvPstats"><strong>PvPstats</strong></a> for <a  target="_blank" href="<?= $server_url ?>"><?= $server_name ?></a> is free software coded by <a target="_blank" href="http://shinworld.altervista.org/"><strong>ShinDarth</strong></a>&nbsp;&#9679;</p>
      <p class="text-center" style="margin-top: 20px"><iframe src="http://ghbtns.com/github-btn.html?user=ShinDarth&repo=PvPstats&type=watch&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="110" height="20"></iframe>&nbsp;<iframe src="http://ghbtns.com/github-btn.html?user=ShinDarth&repo=PvPstats&type=fork&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="95" height="20"></iframe>&nbsp;<iframe src="http://ghbtns.com/github-btn.html?user=ShinDarth&type=follow&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="165" height="20"></iframe></p>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/sortable.min.js"></script>
    <script>
    $(document).ready(function () {

      <?php if (!isset($id) || $result->num_rows == 0) { ?>

      $('#detailed-scores').addClass("active");

      <?php } else { ?>

      $('#killing-blows').click();

      var winner_faction = <?= $winner_faction ?>;
      var alliance = "blue";
      var horde = "red";
      var none = "grey";

      switch (winner_faction)
      {
          case <?= $ALLIANCE ?>:
            $('#bg-table-container').css("border", "1px solid " + alliance);
            break;
          case <?= $HORDE ?>:
             $('#bg-table-container').css("border", "1px solid " + horde);
             break;
          case <?= $NONE ?>:
             $('#bg-table-container').css("border", "1px solid " + none);
             break;
      }

      <?php if ($additional_statistics > 0) { ?>

      if (<?= $alliance_this_day ?> > <?= $horde_this_day ?>)
      {
        $('.this-day-score-container').css("border", "1px solid " + alliance);
      }
      else if (<?= $alliance_this_day ?> < <?= $horde_this_day ?>)
      {
        $('.this-day-score-container').css("border", "1px solid " + horde);
      }
      else
      {
        $('.this-day-score-container').css("border", "1px solid " + none);
      }

      if (<?= $alliance_this_month ?> > <?= $horde_this_month ?>)
      {
        $('.this-month-score-container').css("border", "1px solid " + alliance);
      }
      else if (<?= $alliance_this_month ?> < <?= $horde_this_month ?>)
      {
        $('.this-month-score-container').css("border", "1px solid " + horde);
      }
      else
      {
        $('.this-month-score-container').css("border", "1px solid " + none);
      }

      $('#toggle-guild-members').click(function () {
        if ($('#toggle-guild-members').html() == "More")
        {
          $('.guild-members-score-container').css("max-height", "798px");
          $('#toggle-guild-members').html("Less");
        }
        else
        {
          $('.guild-members-score-container').css("max-height", "417px");
          $('#toggle-guild-members').html("More");
        }
      });

      $('#toggle-this-day').click(function () {
        if ($('#toggle-this-day').html() == "More")
        {
          $('.this-day-score-container').css("max-height", "798px");
          $('#toggle-this-day').html("Less");
        }
        else
        {
          $('.this-day-score-container').css("max-height", "417px");
          $('#toggle-this-day').html("More");
        }
      });

      $('#toggle-this-month').click(function () {
        if ($('#toggle-this-month').html() == "More")
        {
          $('.this-month-score-container').css("max-height", "798px");
          $('#toggle-this-month').html("Less");
        }
        else
        {
          $('.this-month-score-container').css("max-height", "417px");
          $('#toggle-this-month').html("More");
        }
      });

      $('#toggle-bg-day').click(function () {
        if ($('#toggle-bg-day').html() == "More")
        {
          $('.bg-day-score-container').css("max-height", "798px");
          $('#toggle-bg-day').html("Less");
        }
        else
        {
          $('.bg-day-score-container').css("max-height", "417px");
          $('#toggle-bg-day').html("More");
        }
      });

      <?php } ?>
      <?php } ?>

    });

    function thfocus(element)
    {
      $('.th-elem').each(function() {
        $( this ).css("color", "#FFF");
      });

      $(element).css("color", "yellow");
    }
    </script>

  </body>
</html>

<?php $db->close(); ?>
