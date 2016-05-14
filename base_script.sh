#!/bin/bash
ln -s /opt/VBoxGuestAdditions-4.3.10/lib/VBoxGuestAdditions /usr/lib/VBoxGuestAdditions

# shits and giggles #
alias fucking=sudo

apt-get update
apt-get -y install python-software-properties

# add needed repos and update #
apt-add-repository --yes ppa:ondrej/apache2
apt-add-repository --yes ppa:ondrej/php5
apt-add-repository --yes ppa:chris-lea/node.js
apt-get update

# basic tools #
apt-get -y install vim curl

# APACHE STUFF should be v2.2.22#
apt-get -y install apache2

# give apache some settings #
echo "ServerName tdrewards.com.rawstudios.ca" >> /etc/apache2/httpd.conf
echo "DocumentRoot /var/www" >> /etc/apache2/httpd.conf

# modify the envvars to have the global directory variable #
echo "export RAWPROJECTS=/var/www/" >> /etc/apache2/envvars

# enable mod_rewrite #
a2enmod rewrite

# install php5 and enable it should be v5.4.3#
apt-get -y install php5 php5-mcrypt php5-curl php5-gd php5-imap php5-xdebug
php5enmod mcrypt
php5enmod gd
php5enmod imap

# configure xdebug #
echo "xdebug.remote_enable = 1" >> /etc/php5/mods-available/xdebug.ini
echo "xdebug.remote_connect_back = 1" >> /etc/php5/mods-available/xdebug.ini
echo "xdebug.remote_port = 9000" >> /etc/php5/mods-available/xdebug.ini
echo "xdebug.scream=0" >> /etc/php5/mods-available/xdebug.ini
echo "xdebug.cli_color=1" >> /etc/php5/mods-available/xdebug.ini
echo "xdebug.show_local_vars=1" >> /etc/php5/mods-available/xdebug.ini

apt-get -y install libapache2-mod-php5
a2enmod php5

# restart apache2 #
service apache2 restart

# install mysql-server #
debconf-set-selections <<< 'mysql-server mysql-server/root_password password war0662'
debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password war0662'
apt-get -y install mysql-server php5-mysql
apt-get -y install libapache2-mod-auth-mysql 

# add root user to specific IP to differentiate between vagrant boxes #
mysql -uroot -pwar0662 -e "CREATE USER 'root'@'%' IDENTIFIED BY 'war0662'; GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' WITH GRANT OPTION;"
# add rawdev users #
mysql -uroot -pwar0662 -e "CREATE USER 'rawdev'@'localhost' IDENTIFIED BY 'war0662'; GRANT ALL PRIVILEGES ON *.* TO 'rawdev'@'localhost';"

# create tdrewards related databases #
mysql -uroot -pwar0662 -e "CREATE DATABASE teammob CHARSET utf8 COLLATE utf8_unicode_ci;"

# add permissions to rawdev, rawdev2, rawdev3 for the tdrewards tables #
mysql -uroot -pwar0662 -e "GRANT ALL PRIVILEGES ON teammob.* TO 'rawdev'@'localhost';"

# restart apache2 #
service apache2 restart

# change mysql config to allow connections to it #
sed -i "s/bind-address.*/bind-address = 0.0.0.0/" /etc/mysql/my.cnf

# restart mysql #
service mysql restart

# install nodejs v0.10.29 #
apt-get -y install nodejs

# install composer globally #
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# install bower v1.3.8 globally #
npm install bower -g

# install git #
apt-get -y install git

# install zip #
apt-get -y install zip

# install jre #
apt-get -y install default-jre

apt-get autoclean