<?php

$score_today = getFactionScores($today_condition, $level_condition, $type_condition);
$alliance_today = $score_today[0];
$horde_today = $score_today[1];

$score_last7 = getFactionScores($last7_condition, $level_condition, $type_condition);
$alliance_last7 = $score_last7[0];
$horde_last7 = $score_last7[1];

$score_month = getFactionScores($month_condition, $level_condition, $type_condition);
$alliance_month = $score_month[0];
$horde_month = $score_month[1];

$score_overall = getFactionScores("", $level_condition, $type_condition);
$alliance_overall = $score_overall[0];
$horde_overall = $score_overall[1];

?>
