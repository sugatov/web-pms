#!/bin/bash
CI=true

DBNAME=pms
DBUSER=pms
DBPASSWD=pms

echo "Updating repos..."
sudo apt-get update > /dev/null 2>&1
sudo apt-get install -y python-software-properties debconf-utils curl

echo "Adding repos and keys..."
sudo apt-key adv --recv-keys --keyserver hkp://keyserver.ubuntu.com:80 0xcbcb082a1bb943db
sudo add-apt-repository 'deb http://mirror.mephi.ru/mariadb/repo/10.0/ubuntu precise main'
sudo apt-add-repository ppa:chris-lea/node.js
echo "Updating repos..."
sudo apt-get update > /dev/null 2>&1

echo "Installing MariaDB..."
debconf-set-selections <<< "mysql-server mysql-server/root_password password root"
debconf-set-selections <<< "mysql-server mysql-server/root_password_again password root"
sudo apt-get install -y mariadb-server mariadb-common mariadb-client > /dev/null 2>&1
mysql -uroot -proot -e "create database $DBNAME"
mysql -uroot -proot -e "grant all privileges on $DBNAME.* to '$DBUSER'@'localhost' identified by '$DBPASSWD'"

echo "Installing PHP..."
sudo apt-get install -y php5-cli php5-cgi php5-common php5-mysql php-apc > /dev/null 2>&1
echo "Copying 'php.ini'..."
sudo cp /vagrant/.provisions/php.ini /etc/php5/conf.d/php.ini

echo "Upgrading tzdata..."
sudo apt-get install --only-upgrade -y tzdata > /dev/null 2>&1

echo "Installing Redis..."
sudo apt-get install -y redis-server > /dev/null 2>&1

echo "Installing LightTPD..."
sudo apt-get install -y lighttpd > /dev/null 2>&1
sudo service lighttpd stop
sudo update-rc.d -f lighttpd remove
sudo sed -i '/server\.errorlog/d' /etc/lighttpd/lighttpd.conf
sudo lighty-enable-mod fastcgi fastcgi-php
echo "Copying 'lighttpd.conf'..."
sudo cp -f /vagrant/.provisions/lighttpd.conf /etc/lighttpd/conf-enabled/99-lighttpd.conf
echo "Installing 'lighttpdlog' executable (foreground verbose mode)..."
sudo cp /vagrant/.provisions/lighttpdlog /usr/local/bin/lighttpdlog
sudo chmod +x /usr/local/bin/lighttpdlog

echo "Installing Node.js..."
sudo apt-get install -y nodejs > /dev/null 2>&1
echo "Installing Git..."
sudo apt-get install -y git > /dev/null 2>&1

echo "Installing Gulp, Bower..."
sudo npm install -g gulp bower > /dev/null 2>&1

echo "Installing Composer..."
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

echo "Installing Psysh..."
sudo wget -q -O /usr/local/bin/psysh psysh.org/psysh
sudo chmod +x /usr/local/bin/psysh

echo "Installing 'deploy' executable..."
sudo cp /vagrant/.provisions/deploy /usr/local/bin/deploy
sudo chmod +x /usr/local/bin/deploy

echo "Making folders..."
sudo mkdir /storage
sudo mkdir /storage/filestorage
sudo mkdir /storage/uploads
sudo chmod -R 777 /storage
sudo chown -R vagrant:vagrant /storage

echo "Copying 'rc.local'..."
sudo cp -f /vagrant/.provisions/rc.local /etc/rc.local

echo "Moving 'www' directory..."
sudo rm -rf /var/www
sudo ln -fs /vagrant/public_html /var/www


echo "System will be shut down. You'll need to start it again using 'vagrant up'"
sudo init 0
