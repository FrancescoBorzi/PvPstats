<?php

  # Your server name
  $server_name = "TrinityCore";

  # Your server url
  $server_url = "http://www.trinitycore.org/";

  # Your server armory url including character name param
  $amory_url = "http://www.truewow.org/armory/character.php?n=";

  # Your server armory url including guild name param
  $guild_amory_url = "http://www.truewow.org/armory/guild.php?n=";

  # The date PvPstats system is online from
  $online_from = "01/08/2014";

  # Show guilds
  # 0 = don't show
  # 1 = show
  $show_guilds = 1;

  # Your server expansion
  #   0 = Classic
  #   1 = The Burning Crusade
  #   2 = Wrath of The Lich King
  $expansion = 2;

  # Connection to the database of characters (address, username, password, database)
  $db = new mysqli("localhost","root","password","characters");

  if (mysqli_connect_error())
    die('Connect Error (' . mysqli_connect_errno() . ') '
        . mysqli_connect_error());

  if ($expansion < 0 || $expansion > 2)
    die("Wrong value provided for expansion parameter. Please config your expansion.");

?>
