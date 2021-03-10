<?php

// colors

$alliance_color = "#1a67f4";
$horde_color = "#cd0a0e";
$none_color = "#888";

// query variables

$HORDE = 0;
$ALLIANCE = 1;
$NONE = 2;

$HORDE_RACES = "2, 5, 6, 8, 9, 10";
$ALLIANCE_RACES = "1, 3, 4, 7, 11, 22";

$BATTLEGROUND_AV = 1;   // Alterac Valley
$BATTLEGROUND_WS = 2;   // Warsong Gulch
$BATTLEGROUND_AB = 3;   // Arathi Basin
$BATTLEGROUND_EY = 7;   // Eye of the Storm
$BATTLEGROUND_SA = 9;   // Strand of the Ancients
$BATTLEGROUND_IC = 30;  // Isle of Conquest
$BATTLEGROUND_TP  = 108; // Twin Peaks
$BATTLEGROUND_BFG = 120; // Battle For Gilneas

$limit = "LIMIT 0,20";
$players_group_and_order = "GROUP BY character_guid ORDER BY count(character_guid) DESC";

$limit_guilds = "LIMIT 0,5";
$guilds_group_and_order = "GROUP BY guild.guildid ORDER BY COUNT(guild.guildid) DESC";

// query conditions

$today_condition = "DATE(date) = DATE(NOW())";
$last7_condition = "DATEDIFF(NOW(), date) < 7";
$month_condition = "MONTH(date) = MONTH(NOW()) AND YEAR(date) = YEAR(NOW())";

switch ($expansion)
{
  case 0:
    $MAX_BRACKET_ID = 6;
    break;
  case 1:
    $MAX_BRACKET_ID = 7;
    break;
  case 2:
    $MAX_BRACKET_ID = 8;
    break;
  case 3:
    $MAX_BRACKET_ID = 16;
    break;
}

if (isset($_GET['level']) && $_GET['level'] <= $MAX_BRACKET_ID && $_GET['level'] > 0 && is_numeric($_GET['level']))
{
  $level = intval(mysqli_real_escape_string($db, $_GET['level']));
  $level_condition = "bracket_id = " . $level;
}
else
{
  $level_condition = "";
  $level = "all";
}

if (isset($_GET['type']))
{
  switch ($_GET['type'])
  {
    case $BATTLEGROUND_AV:
    case $BATTLEGROUND_WS:
    case $BATTLEGROUND_AB:
    case $BATTLEGROUND_EY:
    case $BATTLEGROUND_SA:
    case $BATTLEGROUND_IC:
      $type = intval(mysqli_real_escape_string($db, $_GET['type']));
      $type_condition = "type = " . $type;
      break;

    default:
      $type_condition = "";
  }

  $type_link      = "&" . $type;
  $type_link_all  = "?" . $type;
}
else
  $type_link_all = $type_link = $type_condition = "";

?>
