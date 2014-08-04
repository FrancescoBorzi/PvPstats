<?php

  # Your server name
  $server_name = "TrinityCore";

  # Your server url
  $server_url = "http://www.trinitycore.org/";

  # The date PvPstats system is online from
  $online_from = "01/08/2014";

  # Connection to the database of characters (address, username, password, database)
  $connection = mysqli_connect("localhost","trinitycore","trinitycore","characters");

  //if (mysqli_connect_errno($connection))
    //echo "Failed to connect to MySQL: " . mysqli_connect_error();
?>
