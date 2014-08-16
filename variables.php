<?php

$alliance_color = "#1a67f4";
$horde_color = "#cd0a0e";

// query variables

$ALLIANCE = 469;
$HORDE = 67;
$limit = "LIMIT 0,20";
$players_group_and_order = "GROUP BY character_guid ORDER BY count(character_guid) DESC";

// query conditions

$today_condition = "DATE(date) = DATE(NOW())";
$last7_condition = "DATEDIFF(NOW(), date) < 7";
$month_condition = "MONTH(date) = MONTH(NOW()) AND YEAR(date) = YEAR(NOW())";

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

?>
