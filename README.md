PvPstats
========

This software **is still under development and testing phase** but feel free to use it.

This is a **very rough** graphical preview, to just let understand what this software is about: http://shinworld.altervista.org/pvpstats/


## Introduction

PvPstats is an utility for **TrinityCore** and **CMaNGOS** that allows to store and display data about **Battleground scores**. It consists in a (small) core modification and a web application written in PHP.

Each time a Battleground ends, PvPstats stores in the database who won: players, faction, level range and datetime.

It currently supports:

- [TrinityCore with WOTLK (3.x.x game version)](https://github.com/TrinityCore/TrinityCore)
- [CMaNGOS with WOTLK (3.x.x game version)](https://github.com/CMaNGOS/mangos-wotlk)
- [CMaNGOS with TBC (2.x.x game version)](https://github.com/CMaNGOS/mangos-tbc)
- [CMaNGOS with Classic (1.x.x game version)](https://github.com/CMaNGOS/mangos-classic)

But since this is a free and open source project, you are more than welcome to fork it and adapt to different emulator or game version.

The web application displays the amount of **victories** of **factions** and **top 20 players** of:

- **Current day**
- **Last 7 days**
- **Current month**
- **Overall**

both **for all levels** and **for every level range (10-19, ... , 70-79, 80)**.

The web applications uses the framework [Bootstrap](https://github.com/twbs/bootstrap) which makes it fully responsive, supporting different window and screen sizes (e.g. desktop, tablet, mobile, etc..).

## Screenshots

Screenshots will come soon!

## Install

See [How to install PvPstats system](https://github.com/ShinDarth/PvPstats/blob/master/INSTALL.md)
