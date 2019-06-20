PvPstats
========
# ![logo](https://raw.githubusercontent.com/FrancescoBorzi/PvPstats/master/logo/PvPstats.png)

## Introduction

PvPstats is an utility for **AzerothCore**, **TrinityCore** and **CMaNGOS** that allows to store and display data about **Battleground scores**. It consists in a core modification and a web application written in **PHP**. It's released under the [GNU AGPL v3 License](https://github.com/FrancescoBorzi/PvPstats/blob/master/LICENSE).

**Note that the core modification has been included in the [AzerothCore](https://github.com/AzerothCore/), [TrinityCore](https://github.com/TrinityCore/) and [CMaNGOS](https://github.com/cmangos/) official repositories, so you will need to enable it only (as explained in install instructions linked below)**.

Each time a Battleground ends, PvPstats stores in the database all Battlegrounds:

- Date & time
- Winner faction
- Type (which BattleGround is)
- Bracket level range

For each Battleground it also stores player:

- Killing blows
- Deaths
- Honorable Kills
- Bonus Honor
- Damage done
- Healing done
- and the other various data (like Warsong Gulch capped/returned flags, Arathi Basin assaulted/defended bases, EoS capped flags, etc...)

In a nutshell, **it saves all datas you can see when the BattleGround ends in the score window**.


It currently supports:

- [AzerothCore with WOTLK (3.x.x game version)](https://github.com/azerothcore/azerothcore-wotlk)
- [TrinityCore with Cataclysm (4.x.x game version)](https://gitlab.com/trinitycore/TrinityCore_434/)
- [TrinityCore with WOTLK (3.x.x game version)](https://github.com/TrinityCore/TrinityCore/tree/3.3.5)
- [CMaNGOS with WOTLK (3.x.x game version)](https://github.com/CMaNGOS/mangos-wotlk)
- [CMaNGOS with TBC     (2.x.x game version)](https://github.com/CMaNGOS/mangos-tbc)
- [CMaNGOS with Classic   (1.x.x game version)](https://github.com/CMaNGOS/mangos-classic)
- All other server applications based on those listed above (if they are updated).

But since this is a free and open source project, you are more than welcome to fork it and adapt to different emulator or game version.

The web application currently displays the amount of **victories** of **factions**, **top 20 players** and **top 5 guilds** of:

- **Current day**
- **Last 7 days**
- **Current month**
- **Overall**

both **for all levels** and **for every level range (10-19, ... , 70-79, 80)**.

It also displays:

- **Detailed BattleGround scores informations** (battleground.php script)
- **Top100 players and guilds** (top100.php script)

The web application uses the framework [Bootstrap](https://github.com/twbs/bootstrap) which makes it fully **responsive**, supporting **different window and screen sizes** (e.g. desktop, tablet, mobile, etc..). It also uses the [jQuery](https://github.com/jquery/jquery) and [Sortable](https://github.com/HubSpot/sortable) JavaScript Libraries.

The web application is secure against SQL-Injection attacks, tested with [sqlmap](https://github.com/sqlmapproject/sqlmap).

## Install

- [How to install PvPstats system in TrinityCore or AzerothCore](https://github.com/FrancescoBorzi/PvPstats/blob/master/docs/INSTALL-TrinityCore.md)

- [How to install PvPstats system in CMaNGOS](https://github.com/FrancescoBorzi/PvPstats/blob/master/docs/INSTALL-CMaNGOS.md)

### Contribute

You can help us [opening a new issue](https://github.com/FrancescoBorzi/PvPstats/issues/new) to report a bug or a suggestion

or you can [donate](https://www.paypal.me/francesco92dev) to support us.


## Live preview

Do you want to see PvPstats in action? [See who is using PvPstats](http://shinworld.altervista.org/PvPstats/).

## Screenshots

![PvPstats Index](http://shinworld.altervista.org/PvPstats/img/index.png "PvPstats Index")
![PvPstats BattleGround search](http://shinworld.altervista.org/PvPstats/img/battleground1.png "PvPstats BattleGround search")
![PvPstats BattleGround score](http://shinworld.altervista.org/PvPstats/img/battleground2.png "PvPstats BattleGround score")
![PvPstats Top100](http://shinworld.altervista.org/PvPstats/img/top100.png "PvPstats Top100")
