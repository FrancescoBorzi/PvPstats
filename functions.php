<?php

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

function getPlayersScores($time_cond, $level_cond)
{
  global $db, $limit, $players_group_and_order, $amory_url;


  if ($time_cond == "" && $level_cond == "")
    $where = "";
  else
    $where = "WHERE";

  if ($time_cond != "" && $level_cond != "")
    $level_cond = "AND " . $level_cond;

  $query = sprintf("SELECT character_guid, count(character_guid) FROM pvpstats_players %s %s %s %s %s",
                   $where,
                   $time_cond,
                   $level_cond,
                   $players_group_and_order,
                   $limit);

  $result = $db->query($query);

  $row = $result->fetch_row();

  if ($row == null)
    return;

  $position = 1;

  printf("<tr><td>%d</td><td><a target=\"_blank\" href=\"%s%s\">%s</a></td><td>%d</td></tr>",
           $position,
           $amory_url,
           getPlayerName($row[0]),
           getPlayerName($row[0]),
           $row[1]);

  $prev_score = $row[1];


  while (($row = $result->fetch_row()) != null)
  {
    if ($prev_score != $row[1])
      $position++;

    printf("<tr><td>%d</td><td><a target=\"_blank\" href=\"%s%s\">%s</a></td><td>%d</td></tr>",
           $position,
           $amory_url,
           getPlayerName($row[0]),
           getPlayerName($row[0]),
           $row[1]);

    $prev_score = $row[1];
  }
}?>
