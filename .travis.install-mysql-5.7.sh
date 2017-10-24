echo "TEST123"
wget http://dev.mysql.com/get/mysql-apt-config_0.3.2-1ubuntu14.04_all.deb
sudo dpkg -i mysql-apt-config_0.3.2-1ubuntu14.04_all.deb
sudo apt-get update -q
sudo apt-get install mysql-server-5.7
sudo mysql_upgrade