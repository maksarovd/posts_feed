#!/bin/bash
mysql -u root -proot -e "CREATE USER maksarovd@localhost IDENTIFIED BY '1'";
mysql -u root -proot -e "GRANT ALL PRIVILEGES ON * . * TO maksarovd@localhost";
mysql -u root -proot -e "FLUSH PRIVILEGES";
mysql -u maksarovd -p1 database < dump.sql



