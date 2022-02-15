<?php

require_once("config.php");
require_once("variables.php");
require_once("functions.php");
require_once("factionScores.php");

if (isset($_GET['id']) && is_numeric($_GET['id']))
{
  $id = intval($_GET['id']);

  $query = sprintf("SELECT * FROM pvpstats_battlegrounds WHERE id = %d",
                   $id);

  $result = $db->query($query);

  if (!$result)
    die(mysqli_error($db));
  else if ($result->num_rows > 0)
  {
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

    $query_max_min = "SELECT MAX(id), MIN(id) FROM pvpstats_battlegrounds";
    $max_min = $db->query($query_max_min)->fetch_row();
    $max = $max_min[0];
    $min = $max_min[1];
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


    <?php if (!isset($id) || $result->num_rows == 0) { require_once("navbar.php"); } else { ?>
    <div class="text-center">
      <?php if($id != $min) { ?>
      <a style="margin: 2px 20px;"href="battleground.php?id=<?= $id - 1 ?>"><button id="search" type="submit" class="btn btn-default">&larr; Prev</button></a>
      <?php } else { ?>
      <a href="#" style="margin: 2px 20px;"><button id="search" type="submit" class="btn btn-default" disabled>&larr; Prev</button></a>
      <?php } ?>
      <a style="margin: 2px 20px;"href="battleground.php"><button id="search" type="submit" class="btn btn-default">Back</button></a>
      <?php if($id != $max) { ?>
      <a style="margin: 2px 20px;"href="battleground.php?id=<?= $id + 1 ?>"><button id="search" type="submit" class="btn btn-default">Next &rarr;</button></a>
      <?php } else { ?>
      <a href="#" style="margin: 2px 20px;"><button id="search" type="submit" class="btn btn-default" disabled>Next &rarr;</button></a>
      <?php } ?>
    </div>
    <?php } ?>

    <div class="container">

      <div class="main-title"></div>

      <?php
      if (!isset($id))
      {
        $day = "";
        $year = date("Y"); // year should NEVER be null
        $month = 0;
        $level = 0;
        $limit = 20;
        $search = 0;
        $correct = true;

        if (isset($_GET['search']) && $_GET['search'] == 1)
        {
          if (isset($_GET['day']) && $_GET['day'] != "")
          {
            if (is_numeric($_GET['day']) && $_GET['day'] > 0 && $_GET['day'] <= 31)
              $day    = intval(mysqli_real_escape_string($db, $_GET['day']));
            else
              $correct = false;
          }
          if (isset($_GET['year']) && $_GET['year'] != "")
          {
            if (is_numeric($_GET['year']) && $_GET['year'] > 2000 && $_GET['year'] <= date("Y"))
              $year   = intval(mysqli_real_escape_string($db, $_GET['year']));
            else
              $correct = false;
          }
          if (isset($_GET['month']) && $_GET['month'] != "")
          {
            if (is_numeric($_GET['month']) && $_GET['month'] >= 0 && $_GET['month'] <= 12)
              $month  = intval(mysqli_real_escape_string($db, $_GET['month']));
            else
              $correct = false;
          }
          if (isset($_GET['level']) && $_GET['level'] != "")
          {
            if (is_numeric($_GET['level']) && $_GET['level'] >= 0)
              $level  = intval(mysqli_real_escape_string($db, $_GET['level']));
            else
              $correct = false;
          }
          if (isset($_GET['limit']) && $_GET['limit'] != "")
          {
            if (is_numeric($_GET['limit']) && $_GET['limit'] > 0 && $_GET['limit'] <= $max_results_allowed)
              $limit  = intval($_GET['limit']);
            else
              $correct = false;
          }

          $search = 1;
        }

      ?>
      <p class="h4 text-center">Search for detailed scores:</p>
      <form class="form-inline text-center" role="form" method="GET">
        <input name="search" type="hidden" value="1">
        <div class="form-group">
          <input class="form-control text-center" style="width: 50px; height: 26px; padding: 2px;" name="day" type="text" value="<?= $day ?>" placeholder="Day">
        </div>
        <div class="form-group">
          <select id="select-month" name="month" class="text-center">
            <option id="month0" value="0">All months</option>
            <option id="month1" value="1">January </option>
            <option id="month2" value="2">February</option>
            <option id="month3" value="3">March</option>
            <option id="month4" value="4">April</option>
            <option id="month5" value="5">May </option>
            <option id="month6" value="6">June </option>
            <option id="month7" value="7">July</option>
            <option id="month8" value="8">August</option>
            <option id="month9" value="9">September</option>
            <option id="month10" value="10">October</option>
            <option id="month11" value="11">November</option>
            <option id="month12" value="12">December</option>
          </select>
        </div>
        <div class="form-group">
          <input class="form-control text-center" style="width: 65px; height: 26px; padding: 2px;" name="year" type="text" value="<?= $year ?>" placeholder="Year">
        </div>
        <span style="color: white" class="nohover hidden-xs hidden-sm">&#9679;</span>
        <div class="form-group">
          <select id="select-type" name="type" class="text-center">
            <option value="0">All types</option>
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
        </div>
        <span style="color: white" class="nohover hidden-xs hidden-sm">&#9679;</span>
        <div class="form-group">
          <select id="select-level" name="level" class="text-center">
            <option value="0">All levels</option>
            <?php
        if ($expansion < 3)
        {
          switch ($expansion)
          {
            case 0: // Classic only
            ?>
            <option value="6">60</option>
            <?php
              break;
            case 1: // TBC only
            ?>
            <option value="7<?= $type_link ?>">70</option>
            <option value="6"></option>60-69
            <?php
              break;
            case 2: // WOTLK only
            ?>
            <option value="8">80</option>
            <option value="7">70-79</option>
            <option value="6">60-69</option>
            <?php
              break;
          }
            ?>
            <option value="5">50-59</option>
            <option value="4">40-49</option>
            <option value="3">30-39</option>
            <option value="2">20-29</option>
            <option value="1">10-19</option>
            <?php } else { ?>
            <option value="16">85</option>
            <option value="15">80-84</option>
            <option value="14">75-79</option>
            <option value="13">70-74</option>
            <option value="12">65-69</option>
            <option value="11">60-64</option>
            <option value="10">55-59</option>
            <option value="9">50-54</option>
            <option value="8">45-49</option>
            <option value="7">40-44</option>
            <option value="6">35-39</option>
            <option value="5">30-34</option>
            <option value="4">25-29</option>
            <option value="3">20-24</option>
            <option value="2">15-19</option>
            <option value="1">10-14</option>
            <?php } ?>
          </select>
        </div>
        <span style="color: white" class="nohover hidden-xs hidden-sm">&#9679;</span>
        <div class="form-group">
          Display <input class="form-control text-center" style="width: 50px; height: 26px; padding: 2px;" name="limit" type="text" value="<?= $limit ?>" placeholder="20"> results
        </div>
        <button id="search" type="submit" class="btn btn-default">Search</button>
      </form>

      <br>
      <div style="padding: 0 10px;">
        <p class="h4 text-center">Search results:</p>
        <div style="border: 1px solid grey" class="table-responsive">
          <table class="table table-hover text-center" data-sortable>
            <thead>
              <tr>
                <th class="text-center th-elem hover-pointer" onClick="thfocus(this)">#</th>
                <th class="text-center th-elem hover-pointer" onClick="thfocus(this)">Type</th>
                <th class="text-center th-elem hover-pointer" onClick="thfocus(this)">Level Bracket</th>
                <th class="text-center th-elem hover-pointer" onClick="thfocus(this)">End Date</th>
                <th class="text-center th-elem hover-pointer" onClick="thfocus(this)">End Time</th>
              </tr>
            </thead>
            <tbody>
              <?php getBattleGrounds($day, $month, $year, $level_condition, $type_condition, $limit); ?>
            </tbody>
          </table>
        </div>
      </div>

      <?php } else if ($result->num_rows == 0) { ?>

      <p class="lead text-center">BattleGround having id <strong><?= $id ?></strong> not found.</p>
      <p class="lead text-center"><a href="battleground.php">&larr; Back</a></p>

      <?php } else {
        // this line is needed to fix an indentation bug
      ?>

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

        $query = sprintf("
            SELECT
                   pvpstats_players.winner,
                   pvpstats_players.score_killing_blows,
                   pvpstats_players.score_deaths,
                   pvpstats_players.score_honorable_kills,
                   pvpstats_players.score_bonus_honor,
                   pvpstats_players.score_damage_done,
                   pvpstats_players.score_healing_done,
                   pvpstats_players.attr_1,
                   pvpstats_players.attr_2,
                   pvpstats_players.attr_3,
                   pvpstats_players.attr_4,
                   pvpstats_players.attr_5,
                   pvpstats_players.character_guid,
                   characters.name AS `character_name`,
                   characters.gender AS `character_gender`,
                   characters.class AS `character_class`,
                   characters.race AS `character_race`
            FROM pvpstats_players 
            INNER JOIN characters ON characters.guid = pvpstats_players.character_guid
            AND battleground_id = %d 
            ORDER BY score_killing_blows DESC",
                         $id);

        $result = $db->query($query);

        if (!$result)
          die(mysqli_error($db));

          while (($row = $result->fetch_array()) != null)
          {
            printf("<tr>");

            if (!(isset($armory_url)) || $armory_url == "") {
              $player_name = sprintf("<span style=\"color: %s; \"><strong>%s</strong></a>",
                getPlayerColorInBG($row['winner'], $winner_faction, $row['character_guid']),
                $row['character_name']
              );
            } else {
              $player_name = sprintf("<a style=\"color: %s; \" target=\"_blank\" href=\"%s%s\"><strong>%s</strong></a>",
                getPlayerColorInBG($row['winner'], $winner_faction, $row['character_guid']),
                $armory_url,
                $row['character_name'],
                $row['character_name']
              );
            }

            printf("<td>%s</td>",
                   $player_name);

            printf("<td style=\"min-width: 49px; padding-left: 0; padding-right: 0;\"><img src=\"img/class/%d.gif\"> <img src=\"img/race/%d-%d.gif\"></td>",
                   $row['character_class'],
                   $row['character_race'],
                   $row['character_gender']
            );

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

      <div id="footer">
        <hr>
        <?php /* I worked hard to make PvPstats open and free for everyone. Please, do not remove the credits. */ ?>
        <p class="h6 text-center">&#9679;&nbsp;<a target="_blank" href="https://github.com/FrancescoBorzi/PvPstats"><strong>PvPstats</strong></a> for <a  target="_blank" href="<?= $server_url ?>"><?= $server_name ?></a> is free software created by <a target="_blank" href="http://shinworld.altervista.org/"><strong>ShinDarth</strong></a> and released under the <a target="_blank" href="https://github.com/FrancescoBorzi/PvPstats/blob/master/LICENSE">GNU AGPL license</a>&nbsp;&#9679;</p>
        <p class="text-center" style="margin-top: 20px"><iframe src="http://ghbtns.com/github-btn.html?user=FrancescoBorzi&repo=PvPstats&type=watch&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="110" height="20"></iframe>&nbsp;<iframe src="http://ghbtns.com/github-btn.html?user=FrancescoBorzi&repo=PvPstats&type=fork&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="95" height="20"></iframe>&nbsp;<iframe src="http://ghbtns.com/github-btn.html?user=FrancescoBorzi&type=follow&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="165" height="20"></iframe></p>
      </div>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/sortable.min.js"></script>
    <script>
      $(document).ready(function () {

        <?php if (!isset($id) || $result->num_rows == 0) { ?>

        $('#detailed-scores').addClass("active");
        $("#select-month option[value='<?= $month ?>']").attr("selected","selected");
        $("#select-level option[value='<?= $level ?>']").attr("selected","selected");

        <?php if (!$correct) { ?>
        $('#search').click();
        <?php } ?>

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
            $('.guild-members-container').css("max-height", "798px");
            $('#toggle-guild-members').html("Less");
        }
            else
            {
            $('.guild-members-container').css("max-height", "417px");
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
            $('.bg-day-container').css("max-height", "798px");
            $('#toggle-bg-day').html("Less");
        }
            else
            {
            $('.bg-day-container').css("max-height", "417px");
            $('#toggle-bg-day').html("More");
        }
        });

            <?php } ?>
            <?php } ?>

        });

            function thfocus(element)
            {
            $('.th-elem').each(function() {
            $(this).css("color", "#FFF");
        });

            $(element).css("color", "yellow");
        }
    </script>

  </body>
</html>

<?php $db->close(); ?>
