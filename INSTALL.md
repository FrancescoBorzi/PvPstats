How to install PvPstats system
========

1) Clone the repository:
```
git clone https://github.com/ShinDarth/PvPstats.git
```


2) Apply **install/character_pvpstats.sql** file to your **characters database**.



3) Go in the git source folder of your core and **apply the patch** located in /path/to/PvPstats/install/

- if you are using **TrinityCore** with **WOTLK** (game version **3.x.x**):
```
git am --signoff < /path/to/PvPstats/install/TrinityCore-PvPstats.patch
```
- if you are using **CMaNGOS** with **WOTLK** (game version **3.x.x**):
```
git am --signoff < /path/to/PvPstats/install/CMaNGOS-PvPstats.patch
```
- if you are using **CMaNGOS** with **TBC** (game version **2.x.x**):
```
git am --signoff < /path/to/PvPstats/install/CMaNGOS-TBC-PvPstats.patch
```
- if you are using **CMaNGOS** with **Classic** (game version **1.x.x**):
```
git am --signoff < /path/to/PvPstats/install/CMaNGOS-Classic-PvPstats.patch
```
if one of these patches returns any error, it probably means I have to update it to fit with latest core version, in such case please [fill a bug report](https://github.com/ShinDarth/PvPstats/issues/new).



4) **Rebuild your core**



5) Open the "**web**" folder and copy all contents into a new folder of your web server (e.g. /var/www/PvPstats)



6) Open the file **config.php** and edit it properly (it's quite commented).

Do not forget to set the parameters for database connections and your expansion.



Please report any bug at: https://github.com/ShinDarth/PvPstats/issues
