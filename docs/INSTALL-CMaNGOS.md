How to install PvPstats system in CMaNGOS
========

1) Clone the repository into your web server (e.g. /var/www/):
```
git clone https://github.com/ShinDarth/PvPstats.git
```

2) Apply **install/character_pvpstats.sql** file to your **characters database**.

3) Go in the git source folder of your core and apply the patch located in /path/to/PvPstats/install/

- if you are using CMaNGOS with **WOTLK** (game version **3.x.x**) type:
```
git am --signoff < /path/to/PvPstats/install/CMaNGOS-WOTLK-PvPstats.patch
```

- if you are using CMaNGOS with **TBC** (game version **2.x.x**) type:
```
git am --signoff < /path/to/PvPstats/install/CMaNGOS-TBC-PvPstats.patch
```

- if you are using CMaNGOS with **Classic** (game version **1.x.x**) type:
```
git am --signoff < /path/to/PvPstats/install/CMaNGOS-Classic-PvPstats.patch
```


If one of these patches returns an error, it probably means I have to update it to fit with latest core version, in such case please  [fill a bug report](https://github.com/ShinDarth/PvPstats/issues).

4) Rebuild your core

5) Open your **mangosd.conf** file and set:
```
Battleground.StoreStatistics.Enable = 1
```

6) Copy the file **config.php.dist** and rename the copy to **config.php**, then open and edit it properly (it's quite commented).

Do not forget to set the parameters for database connections and your expansion.


Please report any bug at: https://github.com/ShinDarth/PvPstats/issues
