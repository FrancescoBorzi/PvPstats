<?php

  # Your server name
  $server_name = "TrinityCore";

  # Your server url
  $server_url = "http://www.trinitycore.org/";

  # Your server armory url including character name param
  $amory_url = "http://www.truewow.org/armory/character.php?n=";

  # The date PvPstats system is online from
  $online_from = "01/08/2014";

  # Connection to the database of characters (address, username, password, database)
  $db = new mysqli("localhost","trinitycore","trinitycore","characters");

  if (mysqli_connect_error())
    die('Connect Error (' . mysqli_connect_errno() . ') '
        . mysqli_connect_error());

?>
