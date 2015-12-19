<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="visible-xs visible-sm navbar-brand" href="#"><?= $server_name ?> PvPstats</a>
    </div>
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav navbar-center">
        <li class="link-all"><a href="index.php<?= $type_link_all ?>">All Levels</a></li>
        <li><a class="nohover visible-lg">&#9679;</a></li>
        <?php

  $BATTLEGROUND_AV_sel = $BATTLEGROUND_WS_sel = $BATTLEGROUND_AB_sel = $BATTLEGROUND_EY_sel = $BATTLEGROUND_SA_sel = $BATTLEGROUND_IC_sel = $BATTLEGROUND_TP_sel = $BATTLEGROUND_BFG_sel = "";

        if (isset($_GET['type']))
        {
          switch ($_GET['type'])
          {
            case $BATTLEGROUND_AV:
              $BATTLEGROUND_AV_sel = "selected";
              break;
            case $BATTLEGROUND_WS:
              $BATTLEGROUND_WS_sel = "selected";
              break;
            case $BATTLEGROUND_AB:
              $BATTLEGROUND_AB_sel = "selected";
              break;
            case $BATTLEGROUND_EY:
              $BATTLEGROUND_EY_sel = "selected";
              break;
            case $BATTLEGROUND_SA:
              $BATTLEGROUND_SA_sel = "selected";
              break;
            case $BATTLEGROUND_IC:
              $BATTLEGROUND_IC_sel = "selected";
              break;
            case $BATTLEGROUND_TP:
              $BATTLEGROUND_TP_sel = "selected";
              break;
            case $BATTLEGROUND_BFG:
              $BATTLEGROUND_BFG_sel = "selected";
              break;
          }
        }

        if ($expansion < 3)
        {
          switch ($expansion)
          {
            case 0: // Classic only
        ?>

        <li class="link-6"><a href="index.php?level=6<?= $type_link ?>">60</a></li>

        <?php
          break;

            case 1: // TBC only
        ?>
        <li class="link-7"><a href="index.php?level=7<?= $type_link ?>">70</a></li>
        <li class="link-6"><a href="index.php?level=6<?= $type_link ?>">60-69</a></li>
        <?php
          break;

            case 2: // WOTLK only
        ?>
        <li class="link-8"><a href="index.php?level=8<?= $type_link ?>">80</a></li>
        <li class="link-7"><a href="index.php?level=7<?= $type_link ?>">70-79</a></li>
        <li class="link-6"><a href="index.php?level=6<?= $type_link ?>">60-69</a></li>
        <?php
          break;
          }
        ?>

        <li class="link-5"><a href="index.php?level=5<?= $type_link ?>">50-59</a></li>
        <li class="link-4"><a href="index.php?level=4<?= $type_link ?>">40-49</a></li>
        <li class="link-3"><a href="index.php?level=3<?= $type_link ?>">30-39</a></li>
        <li class="link-2"><a href="index.php?level=2<?= $type_link ?>">20-29</a></li>
        <li class="link-1"><a href="index.php?level=1<?= $type_link ?>">10-19</a></li>

        <?php
        }
        else
        {
        ?>
        <li class="link-16"><a href="index.php?level=16<?= $type_link ?>">85</a></li>
        <li class="dropdown link-13 link-14 link-15">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">70-84 <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li class="link-15"><a href="index.php?level=15<?= $type_link ?>">80-84</a></li>
            <li class="link-14"><a href="index.php?level=14<?= $type_link ?>">75-79</a></li>
            <li class="link-13"><a href="index.php?level=13<?= $type_link ?>">70-74</a></li>
          </ul>
        </li>
        <li class="dropdown link-9 link-10 link-11 link-12">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">50-69 <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li class="link-12"><a href="index.php?level=12<?= $type_link ?>">65-69</a></li>
            <li class="link-11"><a href="index.php?level=11<?= $type_link ?>">60-64</a></li>
            <li class="link-10"><a href="index.php?level=10<?= $type_link ?>">55-59</a></li>
            <li class="link-9"><a href="index.php?level=9<?= $type_link ?>">50-54</a></li>
          </ul>
        </li>
        <li class="dropdown link-5 link-6 link-7 link-8">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">30-49 <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li class="link-8"><a href="index.php?level=8<?= $type_link ?>">45-49</a></li>
            <li class="link-7"><a href="index.php?level=7<?= $type_link ?>">40-44</a></li>
            <li class="link-6"><a href="index.php?level=6<?= $type_link ?>">35-39</a></li>
            <li class="link-5"><a href="index.php?level=5<?= $type_link ?>">30-34</a></li>
          </ul>
        </li>
        <li class="dropdown link-1 link-2 link-3 link-4">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">10-29 <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li class="link-4"><a href="index.php?level=4<?= $type_link ?>">25-29</a></li>
            <li class="link-3"><a href="index.php?level=3<?= $type_link ?>">20-24</a></li>
            <li class="link-2"><a href="index.php?level=2<?= $type_link ?>">15-19</a></li>
            <li class="link-1"><a href="index.php?level=1<?= $type_link ?>">10-14</a></li>
          </ul>
        </li>

        <?php
        }
        ?>
        <li><a class="nohover visible-lg">&#9679;</a></li>
        <li id="detailed-scores"><a href="battleground.php">Detailed Scores</a></li>
        <li><a class="nohover visible-lg">&#9679;</a></li>
        <li id="top100"><a href="top100.php">Top100</a></li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</div>
