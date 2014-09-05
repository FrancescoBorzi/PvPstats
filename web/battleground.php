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
      die("Cannot find battleground with id <strong>" . $id . "</strong> in pvpstats_battlegrounds table");

    $row = $result->fetch_array();

    $type = $row['type'];
    $winner_faction = $row['winner_faction'];
    $datetime = $row['date'];
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

    <div class="container">

      <?php if (!isset($id)) { ?>

      <?php } else { ?>

      <table class="table">
        <tr>
          <th>Character</th>
          <th>&#9679;</th>

          <th>Killing Blows</th>
          <th>Deaths</th>
          <th>Honorable Kills</th>
          <th>Bonus Honor</th>
          <th>Damage Done</th>
          <th>Healing Done</th>

          <th>Attr1</th>
          <th>Attr2</th>
          <th>Attr3</th>
          <th>Attr4</th>
          <th>Attr5</th>
        </tr>

        <?php

          $query = sprintf("SELECT * FROM pvpstats_players WHERE battleground_id = %d",
                     $id);

          $result = $db->query($query);

          if (!$result)
            die("Cannot find battleground with id <strong>" . $id . "</strong> in pvpstats_players table.");

          while (($row = $result->fetch_array()) != null)
          {
            printf("<tr>");

            printf("<td>%s</td>", $row['battleground_id']);
            printf("<td>%s</td>", $row['character_guid']);

            printf("<td>%s</td>", $row['score_killing_blows']);
            printf("<td>%s</td>", $row['score_deaths']);
            printf("<td>%s</td>", $row['score_honorable_kills']);
            printf("<td>%s</td>", $row['score_bonus_honor']);
            printf("<td>%s</td>", $row['score_damage_done']);
            printf("<td>%s</td>", $row['score_healing_done']);

            printf("<td>%s</td>", $row['attr_1']);
            printf("<td>%s</td>", $row['attr_2']);
            printf("<td>%s</td>", $row['attr_3']);
            printf("<td>%s</td>", $row['attr_4']);
            printf("<td>%s</td>", $row['attr_5']);

            printf("</tr>");
          }
        ?>

      </table>

      <?php } ?>

    </div>

  </body>
</html>

<?php $db->close(); ?>
