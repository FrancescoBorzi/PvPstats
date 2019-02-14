### How to install PvPstats system in AzerothCore or TrinityCore

1) Update your core and database to **latest revision** (recommended), or manually import [this commit](https://github.com/TrinityCore/TrinityCore/commit/b65172910c4f65c3ddd3a7c7ca3d3c7330f4a1f0) (not recommended).

2) Open your **worldserver.conf** file and set:
```
Battleground.StoreStatistics.Enable = 1
```

3) Clone the repository into your web server (e.g. /var/www/):
```
git clone https://github.com/FrancescoBorzi/PvPstats.git
```

4) Copy the file **config.php.dist** and rename the copy to **config.php**, then open and edit it properly (it's quite commented).

Do not forget to set the parameters for database connections and your expansion.



Please report any bug at: https://github.com/FrancescoBorzi/PvPstats/issues
