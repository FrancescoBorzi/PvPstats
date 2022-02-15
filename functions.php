<?php

function getPlayerColorByRace(int $race): string
{
  global  $alliance_color, $horde_color;

  switch ($race)
  {
    case 1:
    case 3:
    case 4:
    case 7:
    case 11:
    case 22:
      $color = $alliance_color;
      break;

    case 2:
    case 5:
    case 6:
    case 8:
    case 9:
    case 10:
      $color = $horde_color;
      break;

    default:
      $color = "";
  }

  return $color;
}

function getPlayerColorByGuid(int $guid): string
{
  global $db;

  $query = sprintf("SELECT race FROM characters WHERE guid = %d", $guid);
  $row = $db->query($query)->fetch_row();
  return getPlayerColorByRace($row[0]);
}

// TODO: this method does not work when there is no winner faction (rare case)
function getPlayerColorInBG($is_winner, $winner_faction, $guid)
{
  global $alliance_color, $horde_color, $ALLIANCE, $HORDE;

  if ($winner_faction == $ALLIANCE)
  {
    if ($is_winner)
      return $alliance_color;
    else
      return $horde_color;
  }
  else if ($winner_faction == $HORDE)
  {
    if ($is_winner)
      return $horde_color;
    else
      return $alliance_color;
  }
  else
  {
    // Fallback in case of draw
    // it will work properly only if there is no crossfaction
    // and no character has changed its faction
    return getPlayerColorByGuid($guid);
  }
}

function getGuildName($guildid)
{
  global $db;

  $query = sprintf("SELECT name FROM guild WHERE guildid = %d", $guildid);
  $row = $db->query($query)->fetch_row();

  return $row[0];
}

function getFactionScores($time_cond, $level_cond, $type_cond)
{
  global $db, $ALLIANCE, $HORDE;

  $score = array();

  if ($time_cond != "")
    $time_cond = "AND " . $time_cond;

  if ($level_cond != "")
    $level_cond = "AND " . $level_cond;

  if ($type_cond != "")
    $type_cond = "AND " . $type_cond;

  $query = sprintf("
    SELECT COUNT(*) FROM pvpstats_battlegrounds 
    WHERE winner_faction = %d %s %s %s 
    UNION SELECT COUNT(*) FROM pvpstats_battlegrounds WHERE winner_faction = %d %s %s %s;",
                   $ALLIANCE,
                   $time_cond,
                   $level_cond,
                   $type_cond,
                   $HORDE,
                   $time_cond,
                   $level_cond,
                   $type_cond);

  $result = $db->query($query);

  if (!$result)
    die(mysqli_error($db));

  $row = $result->fetch_row();
  $score[0] = $row[0];

  $row = $result->fetch_row();

  if ($row != null)
    $score[1] = $row[0];
  else
    $score[1] = $score[0];

  return $score;
}

function getPlayersScores($time_cond, $level_cond, $type_cond)
{
  global $db, $limit, $players_group_and_order, $armory_url, $ALLIANCE, $HORDE, $ALLIANCE_RACES, $HORDE_RACES;

  if ($time_cond != "")
    $time_cond = "AND " . $time_cond;

  if ($level_cond != "")
    $level_cond = "AND " . $level_cond;

  if ($type_cond != "")
    $type_cond = "AND " . $type_cond;


  $query = sprintf("
    SELECT
      character_guid,
      count(character_guid) AS `count`,
      characters.name AS `character_name`,
      characters.gender AS `character_gender`,
      characters.class AS `character_class`,
      characters.race AS `character_race`
    FROM pvpstats_players 
    INNER JOIN pvpstats_battlegrounds ON pvpstats_players.battleground_id = pvpstats_battlegrounds.id 
    INNER JOIN characters ON pvpstats_players.character_guid = characters.guid 
    WHERE characters.deleteDate IS NULL 
    AND pvpstats_players.winner = 1 
    %s %s %s %s %s",
                   $time_cond,
                   $level_cond,
                   $type_cond,
                   $players_group_and_order,
                   $limit);

  $result = $db->query($query);

  if (!$result)
    die(mysqli_error($db));

  $position = 0;
  $prev_score = -1;

  while (($row = $result->fetch_array()) != null)
  {
    if ($prev_score != $row['count'])
      $position++;

    if (!(isset($armory_url)) || $armory_url == "") {
      $player_name = sprintf("<span style=\"color: %s; \"><strong>%s</strong></a>",
        getPlayerColorByRace($row['character_race']),
        $row['character_name']);
    } else {
      $player_name = sprintf("<a style=\"color: %s; \" target=\"_blank\" href=\"%s%s\"><strong>%s</strong></a>",
        getPlayerColorByRace($row['character_race']),
        $armory_url,
        $row['character_name'],
        $row['character_name']);
    }

    printf("<tr><td>%d</td><td>%s</td><td style=\"min-width: 46px; padding-left: 0; padding-right: 0;\"><img src=\"img/class/%d.gif\"> <img src=\"img/race/%d-%d.gif\"></td><td>%d</td></tr>",
           $position,
           $player_name,
           $row['character_class'],
           $row['character_race'],
           $row['character_gender'],
           $row['count']);

    $prev_score = $row['count'];
  }
}

function getGuildsScores($time_cond, $level_cond, $type_cond, $top100 = false)
{
  global $db, $limit_guilds, $guilds_group_and_order, $guild_armory_url;

  if ($time_cond != "")
    $time_cond = "AND " . $time_cond;

  if ($level_cond != "")
    $level_cond = "AND " . $level_cond;

  if ($type_cond != "")
    $type_cond = "AND " . $type_cond;

  if ($top100)
    $query_limit = "LIMIT 0, 100";
  else
    $query_limit = $limit_guilds;

  $query = sprintf("
    SELECT
           guild.name,
           COUNT(guild.name),
           guild.guildid,
           lcharacters.race AS leader_race
    FROM pvpstats_players 
    INNER JOIN pvpstats_battlegrounds ON pvpstats_players.battleground_id = pvpstats_battlegrounds.id 
    AND pvpstats_players.winner = 1
    INNER JOIN guild_member ON guild_member.guid = pvpstats_players.character_guid 
    INNER JOIN guild ON guild_member.guildid = guild.guildid
    INNER JOIN characters ON pvpstats_players.character_guid = characters.guid 
    AND characters.deleteDate IS NULL 
    INNER JOIN characters AS lcharacters ON lcharacters.guid = guild.leaderguid 
    %s %s %s %s %s",
                   $time_cond,
                   $level_cond,
                   $type_cond,
                   $guilds_group_and_order,
                   $query_limit);

  $result = $db->query($query);

  if (!$result)
    die(mysqli_error($db));

  $position = 0;
  $prev_score = -1;

  while (($row = $result->fetch_array()) != null)
  {
    if ($prev_score != $row[1])
      $position++;

    if (!(isset($guild_armory_url)) || $guild_armory_url == "") {
      $guild_name = sprintf("<span style=\"color: %s; \"><strong>%s</strong></a>",
                          getPlayerColorByRace($row['leader_race']),
                          $row[0]);
    } else {
      $guild_name = sprintf("<a style=\"color: %s; \" target=\"_blank\" href=\"%s%d\"><strong>%s</strong></a>",
        getPlayerColorByRace($row['leader_race']),
        $guild_armory_url,
        $row[2],
        $row[0]);
    }

    if ($top100)
    {
      printf("<tr id=\"%s\"><td>%d</td><td>%s</td><td>%d</td></tr>",
             $row[0],
             $position,
             $guild_name,
             $row[1]);
    }
    else
    {
      printf("<tr><td>%d</td><td>%s</td><td>%d</td></tr>",
             $position,
             $guild_name,
             $row[1]);
    }

    $prev_score = $row[1];
  }
}

function getGuildsMembers($battleground_id)
{
  global $db, $guilds_group_and_order, $guild_armory_url;

  $query = sprintf("
    SELECT 
           guild.name, 
           COUNT(guild.name), 
           guild.guildid,
           lcharacters.race AS leader_race
    FROM pvpstats_players 
    INNER JOIN pvpstats_battlegrounds ON pvpstats_players.battleground_id = pvpstats_battlegrounds.id 
    AND pvpstats_battlegrounds.id = %s 
    INNER JOIN guild_member ON guild_member.guid = pvpstats_players.character_guid 
    INNER JOIN guild ON guild_member.guildid = guild.guildid 
    INNER JOIN characters ON pvpstats_players.character_guid = characters.guid 
    AND characters.deleteDate IS NULL 
    INNER JOIN characters AS lcharacters ON lcharacters.guid = guild.leaderguid
    %s",
                   $battleground_id,
                   $guilds_group_and_order);

  $result = $db->query($query);

  if (!$result)
    die(mysqli_error($db));

  $position = 0;
  $prev_score = -1;

  while (($row = $result->fetch_array()) != null)
  {
    if ($prev_score != $row[1])
      $position++;

    if (!(isset($guild_armory_url)) || $guild_armory_url == "") {
      $guild_name = sprintf("<span style=\"color: %s; \"><strong>%s</strong></a>",
        getPlayerColorByRace($row['leader_race']),
        $row[0]);
    } else {
      $guild_name = sprintf("<a style=\"color: %s; \" target=\"_blank\" href=\"%s%s\"><strong>%s</strong></a>",
        getPlayerColorByRace($row['leader_race']),
        $guild_armory_url,
        $row[0],
        $row[0]);
    }

    printf("<tr><td>%d</td><td>%s</td><td>%d</td></tr>",
           $position,
           $guild_name,
           $row[1]);

    $prev_score = $row[1];
  }
}

function getBattleGroundsOfDay($date)
{
  global $db, $time_format, $ALLIANCE, $HORDE, $alliance_color, $horde_color, $none_color;

  $query = sprintf("SELECT * FROM pvpstats_battlegrounds WHERE DATE(date) = DATE('%s') ORDER BY date DESC;",
                   $date);

  $result = $db->query($query);

  if (!$result)
    die(mysqli_error($db));

  while (($row = $result->fetch_array()) != null)
  {
    $datetime = new DateTime($row['date']);
    $time = $datetime->format($time_format);

    if ($row['winner_faction'] == $ALLIANCE)
      $color = $alliance_color;
    else if ($row['winner_faction'] == $HORDE)
      $color = $horde_color;
    else
      $color = $none_color;

    printf("<tr style=\"color: %s; font-weight: bold;\" class=\"hover-pointer\" onClick=\"location.href='battleground.php?id=%s'\"><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr></a>",
           $color,
           $row['id'],
           $row['id'],
           getBattleGroundTypeShortName($row['type']),
           getLevelRangeByBracketId($row['bracket_id']),
           $time);
  }
}

function getBattleGrounds($day, $month, $year, $level_cond, $type_cond, $limit)
{
  global $db, $date_format, $time_format, $ALLIANCE, $HORDE, $alliance_color, $horde_color, $none_color;

  if ($year != "")
    $year_cond = sprintf("YEAR(date) = '%s'", $year);
  else
    die("Function getBattleGrounds() called passing year = null");

  if ($month != "" && $month != 0)
    $month_cond = sprintf("AND MONTH(date) = '%s'", $month);
  else
    $month_cond = "";

  if ($day != "")
    $day_cond = sprintf("AND DAY(date) = '%s'", $day);
  else
    $day_cond = "";

  if ($level_cond != "")
    $level_cond = "AND " . $level_cond;
  else
    $level_cond = "";

  if ($type_cond != "")
    $type_cond = "AND " . $type_cond;
  else
    $type_cond = "";

  $query = sprintf("SELECT * FROM pvpstats_battlegrounds WHERE %s %s %s %s %s ORDER BY date DESC LIMIT 0, %d;",
                   $year_cond,
                   $month_cond,
                   $day_cond,
                   $level_cond,
                   $type_cond,
                   $limit);

  $result = $db->query($query);

  if (!$result)
    die(mysqli_error($db));

  while (($row = $result->fetch_array()) != null)
  {
    $datetime = new DateTime($row['date']);
    $date = $datetime->format($date_format);
    $time = $datetime->format($time_format);

    if ($row['winner_faction'] == $ALLIANCE)
      $color = $alliance_color;
    else if ($row['winner_faction'] == $HORDE)
      $color = $horde_color;
    else
      $color = $none_color;

    printf("<tr style=\"color: %s; font-weight: bold;\" class=\"hover-pointer\" onClick=\"location.href='battleground.php?id=%s'\"><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr></a>",
           $color,
           $row['id'],
           $row['id'],
           getBattleGroundTypeName($row['type']),
           getLevelRangeByBracketId($row['bracket_id']),
           $date,
           $time);
  }
}

function getTop100Players()
{
  global $db, $players_group_and_order, $armory_url, $guild_armory_url;

  $query = sprintf("
    SELECT
        character_guid,
        count(character_guid) AS `count`,
        characters.name AS `character_name`,
        characters.class AS `character_class`,
        characters.race AS `character_race`,
        characters.gender AS `character_gender`,
        characters.level AS character_level,
        guild.guildid AS guild_id,
        guild.name AS guild_name
    FROM pvpstats_players
    INNER JOIN pvpstats_battlegrounds ON pvpstats_players.battleground_id = pvpstats_battlegrounds.id
    INNER JOIN characters ON pvpstats_players.character_guid = characters.guid 
    INNER JOIN guild_member ON guild_member.guid = pvpstats_players.character_guid 
    INNER JOIN guild ON guild_member.guildid = guild.guildid
    WHERE characters.deleteDate IS NULL 
    AND pvpstats_players.winner = 1 %s LIMIT 0,100",
                   $players_group_and_order);

  $result = $db->query($query);

  if (!$result)
    die(mysqli_error($db));

  $position = 0;
  $prev_score = -1;

    while (($row = $result->fetch_array()) != null)
    {
      if ($prev_score != $row['count'])
        $position++;

      if (!(isset($armory_url)) || $armory_url == "") {
        $player_name = sprintf("<span style=\"color: %s; \"><strong>%s</strong></a>",
          getPlayerColorByRace($row['character_race']),
          $row['character_name']);
      } else {
        $player_name = sprintf("<a style=\"color: %s; \" target=\"_blank\" href=\"%s%s\"><strong>%s</strong></a>",
          getPlayerColorByRace($row['character_race']),
          $armory_url,
          $row['character_name'],
          $row['character_name']);
      }

      if (!(isset($guild_armory_url)) || $guild_armory_url == "") {
        $guild_name = sprintf("<span style=\"color: %s; \"><strong>%s</strong></a>",
          getPlayerColorByRace($row['character_race']),
          $row['guild_name']);
      } else {
        $guild_name = sprintf("<a style=\"color: %s; \" target=\"_blank\" href=\"%s%s\"><strong>%s</strong></a>",
          getPlayerColorByRace($row['character_race']),
          $guild_armory_url,
          $row['guild_id'],
          $row['guild_name']);
      }

      printf("
        <tr>
            <td>%d</td>
            <td>%s</td>
            <td style=\"min-width: 46px; padding-left: 0; padding-right: 0;\"><img src=\"img/class/%d.gif\"> <img src=\"img/race/%d-%d.gif\"></td>
            <td>%s</td>
            <td>%s</td>
            <td>%d</td>
        </tr>",
        $position,
        $player_name,
        $row['character_class'],
        $row['character_race'],
        $row['character_gender'],
        $row['character_level'],
        $guild_name,
        $row['count']);

      $prev_score = $row['count'];
    }
}

function getLevelRangeByBracketId($bracket_id)
{
  global $expansion;

  if ($expansion < 3)
  {
    switch ($bracket_id)
    {
      case 1:
        return "10-19";
      case 2:
        return "20-29";
      case 3:
        return "30-39";
      case 4:
        return "40-49";
      case 5:
        return "50-59";
      case 6:
        if ($expansion > 0) return "60-69";
        return "60";
      case 7:
        if ($expansion > 1) return "70-79";
        return "70";
      case 8:
        return "80";
    }
  }
  else
  {
    switch ($bracket_id)
    {
      case 1:
        return "10-14";
      case 2:
        return "15-19";
      case 3:
        return "20-24";
      case 4:
        return "25-29";
      case 5:
        return "30-34";
      case 6:
        return "35-39";
      case 7:
        return "40-44";
      case 8:
        return "45-49";
      case 9:
        return "50-54";
      case 10:
        return "55-59";
      case 11:
        return "60-64";
      case 12:
        return "65-69";
      case 13:
        return "70-74";
      case 14:
        return "75-79";
      case 15:
        return "80-84";
      case 16:
        return "85";
    }
  }
}

function getBattleGroundTypeName($type)
{
  global $BATTLEGROUND_AV, $BATTLEGROUND_WS, $BATTLEGROUND_AB, $BATTLEGROUND_EY, $BATTLEGROUND_SA, $BATTLEGROUND_IC, $BATTLEGROUND_TP, $BATTLEGROUND_BFG;

  switch($type)
  {
    case $BATTLEGROUND_AV:
      return "Alterac Valley";
    case $BATTLEGROUND_WS:
      return "Warsong Gulch";
    case $BATTLEGROUND_AB:
      return "Arathi Basin";
    case $BATTLEGROUND_EY:
      return "Eye of the Storm";
    case $BATTLEGROUND_SA:
      return "Strand of the Ancients";
    case $BATTLEGROUND_IC:
      return "Isle of Conquest";
    case $BATTLEGROUND_TP:
      return "Twin Peaks";
    case $BATTLEGROUND_BFG:
      return "Battle For Gilneas";
  }
}

function getBattleGroundTypeShortName($type)
{
  global $BATTLEGROUND_AV, $BATTLEGROUND_WS, $BATTLEGROUND_AB, $BATTLEGROUND_EY, $BATTLEGROUND_SA, $BATTLEGROUND_IC, $BATTLEGROUND_TP, $BATTLEGROUND_BFG;

  switch($type)
  {
    case $BATTLEGROUND_AV:
      return "AV";
    case $BATTLEGROUND_WS:
      return "WG";
    case $BATTLEGROUND_AB:
      return "AB";
    case $BATTLEGROUND_EY:
      return "EotS";
    case $BATTLEGROUND_SA:
      return "SotA";
    case $BATTLEGROUND_IC:
      return "IoC";
    case $BATTLEGROUND_TP:
      return "TP";
    case $BATTLEGROUND_BFG:
      return "BFG";
  }
}

?>
