<?php

// colors

$alliance_color = "#1a67f4";
$horde_color = "#cd0a0e";

// query variables

$ALLIANCE = 0;
$HORDE = 1;

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
  $level_condition = "level = " . $_GET['level'];
  $level = $_GET['level'];
}
else
{
  $level_condition = "";
  $level = "all";
}

?>
