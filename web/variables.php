<?php

// colors

$alliance_color = "#1a67f4";
$horde_color = "#cd0a0e";

// query variables

$HORDE = 0;
$ALLIANCE = 1;

$BATTLEGROUND_AV = 1;  // Alterac Valley
$BATTLEGROUND_WS = 2;  // Warsong Gulch
$BATTLEGROUND_AB = 3;  // Arathi Basin
$BATTLEGROUND_EY = 7;  // Eye of the Storm
$BATTLEGROUND_SA = 9;  // Strand of the Ancients
$BATTLEGROUND_IC = 30; // Isle of Conquest

$limit = "LIMIT 0,20";
$players_group_and_order = "GROUP BY character_guid ORDER BY count(character_guid) DESC";

$limit_guilds = "LIMIT 0,5";
$guilds_group_and_order = "GROUP BY guild.name ORDER BY COUNT(guild.name) DESC";

// query conditions

$today_condition = "DATE(date) = DATE(NOW())";
$last7_condition = "DATEDIFF(NOW(), date) < 7";
$month_condition = "MONTH(date) = MONTH(NOW()) AND YEAR(date) = YEAR(NOW())";

switch ($expansion)
{
  case 0:
    $MAX_LEVEL = 6;
    break;
  case 1:
    $MAX_LEVEL = 7;
    break;
  case 2:
    $MAX_LEVEL = 8;
    break;
}

if (isset($_GET['level']) && $_GET['level'] <= $MAX_LEVEL && $_GET['level'] > 0)
{
  $level_condition = "bracket_id = " . $_GET['level'];
  $level = $_GET['level'];
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
      $type_condition = "type = " . $_GET['type'];
      break;

    default:
      $type_condition = "";
  }
}
else
    $type_condition = "";

?>
