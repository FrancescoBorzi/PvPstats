<?php

require_once("config.php");

if (isset($_GET['id']) && is_numeric($_GET['id']))
{
    $guildId = intval(mysqli_real_escape_string($db, $_GET['id']));
}
else
{
    die("Invalid guild ID");
}

require_once("variables.php");
require_once("functions.php");

$guildName = getGuildName($guildId);

if (!$guildName) {
    die("Guild not found");
}

function getGuildPlayers()
{
    global $db, $players_group_and_order, $guildId;

    $query = sprintf("SELECT 
                        character_guid, 
                        count(character_guid) AS `count`, 
                        characters.name AS `character_name`,
                        characters.class AS `character_class`,
                        characters.race AS `character_race`,
                        characters.gender AS `character_gender`,
                        characters.level AS `character_level`,
                        characters.totalKills AS `character_totalKills`
                    FROM pvpstats_players 
                    INNER JOIN pvpstats_battlegrounds ON pvpstats_players.battleground_id = pvpstats_battlegrounds.id AND pvpstats_players.winner = 1 
                    INNER JOIN characters ON pvpstats_players.character_guid = characters.guid AND characters.deleteDate IS NULL 
                    INNER JOIN guild_member ON guild_member.guid = characters.guid AND guild_member.guildid = %d
                    %s LIMIT 0,100",
        $guildId,
        $players_group_and_order);

    $result = $db->query($query);

    if (!$result) {
        die(mysqli_error($db));
    }

    $position = 0;
    $prev_score = 0;

    while (($row = $result->fetch_array()) != null)
    {
        if ($prev_score != $row['count']) {
            $position++;
        }

        $player_name = sprintf("<span style=\"color: %s; \"><strong>%s</strong></a>",
            getPlayerColorByRace($row['character_race']),
            $row['character_name']);

        printf("
            <tr>
                <td>%d</td>
                <td>%s</td>
                <td style=\"min-width: 46px; padding-left: 0; padding-right: 0;\"><img src=\"img/class/%d.gif\"> <img src=\"img/race/%d-%d.gif\"></td>
                <td>%s</td>
                <td>%d</td>
                <td><strong>%d</strong></td>
            </tr>",
            $position,
            $player_name,
            $row['character_class'],
            $row['character_race'],
            $row['character_gender'],
            $row['character_level'],
            $row['character_totalKills'],
            $row['count']
        );

        $prev_score = $row['count'];
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
    <link href="css/top100-style.css" rel="stylesheet">
  </head>

  <body>

    <?php require_once("navbar.php"); ?>

    <div class="container">

      <div class="row text-center">
        <div class="col-sm-12 col-lg-10 col-lg-offset-1" style="padding: 0 10px;">
          <div class="main-title" style="margin-top: 30px;">
            <p class="text-center h4">Guild <span style="color: orange;">&lt;<?=$guildName?>&gt;</span> of <?=$server_name?></p>
          </div>
          <p class="text-center" style="margin-top: 5px">The sum of the victories of all guild members determines the guild score in the <a href="top100.php">Top100</a>.</p>
          <div class="top100 table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Character</th>
                  <th class="text-center">&#9679;</th>
                  <th class="text-center">Level</th>
                  <th class="text-center">Kills</th>
                  <th class="text-center">Victories</th>
                </tr>
              </thead>
              <tbody>
                <?php getGuildPlayers(); ?>
              </tbody>
            </table>
          </div>
        </div>

      </div>

      <div id="footer">
        <hr>
        <?php /* I worked hard to make PvPstats open and free for everyone. Please, do not remove the credits. */ ?>
        <p class="h6 text-center">&#9679;&nbsp;<a target="_blank" href="https://github.com/FrancescoBorzi/PvPstats"><strong>PvPstats</strong></a> for <a  target="_blank" href="<?= $server_url ?>"><?= $server_name ?></a> is free software created by <a target="_blank" href="http://shinworld.altervista.org/"><strong>ShinDarth</strong></a> and released under the <a target="_blank" href="https://github.com/FrancescoBorzi/PvPstats/blob/master/LICENSE">GNU AGPL license</a>&nbsp;&#9679;</p>
        <p class="text-center" style="margin-top: 20px"><iframe src="http://ghbtns.com/github-btn.html?user=FrancescoBorzi&repo=PvPstats&type=watch&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="110" height="20"></iframe>&nbsp;<iframe src="http://ghbtns.com/github-btn.html?user=FrancescoBorzi&repo=PvPstats&type=fork&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="95" height="20"></iframe>&nbsp;<iframe src="http://ghbtns.com/github-btn.html?user=FrancescoBorzi&type=follow&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="165" height="20"></iframe></p>
      </div>

    </div><!-- /.container -->

  </body>
</html>

<?php $db->close(); ?>


