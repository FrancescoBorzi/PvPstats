How to install PvPstats system in CMaNGOS
========

1) Update your core and database to **latest revision** .

2) Open your **mangosd.conf** file and set:
```
Battleground.StoreStatistics.Enable = 1
```

3) Clone the repository into your web server (e.g. /var/www/):
```
git clone https://github.com/FrancescoBorzi/PvPstats.git
```

4) Copy the file **config.php.dist** and rename the copy to **config.php**, then open and edit it properly (it's quite commented).

Do not forget to set the parameters for database connections and your expansion.
