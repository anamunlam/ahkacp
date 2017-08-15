#!/bin/bash

next() {
  printf "%-70s\n" "-" | sed 's/\s/-/g'
}

ahka() {
  L=$( printf "%-18s\n" " " )
  next
  echo "${L} ###  #   # #   #  ###   ###  ####"
  echo "${L}#   # #   # #  #  #   # #   # #   #"
  echo "${L}##### ##### ###   ##### #     ####"
  echo "${L}#   # #   # #  #  #   # #   # #"
  echo "${L}#   # #   # #   # #   #  ###  #"
  next
}

RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[0;33m'
PLAIN='\033[0m'

echo -e "${YELLOW}Updating...${PLAIN}"
echo "deb http://packages.dotdeb.org jessie all" > /etc/apt/sources.list.d/dotdeb.list
echo "deb-src http://packages.dotdeb.org jessie all" >> /etc/apt/sources.list.d/dotdeb.list
wget -qO - http://www.dotdeb.org/dotdeb.gpg | apt-key add -
apt-get update

#apache and php
echo -e "${YELLOW}Installing Apache and PHP${PLAIN}"
apt-get install apache2 php7.0-cli php7.0-curl php7.0-dev php7.0-zip php7.0-fpm php7.0-gd php7.0-xml php7.0-mysql php7.0-mcrypt php7.0-mbstring php7.0-opcache -y

echo -e "${YELLOW}Configuring PHP...${PLAIN}"
sed -i 's/pm.max_children = .*/pm.max_children = 10/' /etc/php/7.0/fpm/pool.d/www.conf
sed -i 's/pm.max_requests = .*/pm.max_requests = 200/' /etc/php/7.0/fpm/pool.d/www.conf

sed -i 's/^;cgi.fix_pathinfo.*/cgi.fix_pathinfo = 0/' /etc/php/7.0/fpm/php.ini
sed -i 's/upload_max_filesize = .*/upload_max_filesize = 8M/' /etc/php/7.0/fpm/php.ini
sed -i 's/max_execution_time = .*/max_execution_time = 60/' /etc/php/7.0/fpm/php.ini
sed -i 's/max_input_vars = .*/max_input_vars = 5000/' /etc/php/7.0/fpm/php.ini

echo "zend_extension=opcache.so" > /etc/php/7.0/mods-available/opcache.ini
echo "opcache.memory_consumption=128" >> /etc/php/7.0/mods-available/opcache.ini
echo "opcache.max_accelerated_files=10000" >> /etc/php/7.0/mods-available/opcache.ini
echo "opcache.max_wasted_percentage=10" >> /etc/php/7.0/mods-available/opcache.ini
echo "opcache.validate_timestamps=1" >> /etc/php/7.0/mods-available/opcache.ini

echo -e "${YELLOW}Configuring Apache...${PLAIN}"
sed -i 's@^\(Listen\) 80$@\1 127.0.0.1:8080@' /etc/apache2/ports.conf
sed -i 's@^\(<VirtualHost\) \*\:80@\1 127.0.0.1:8080>@' /etc/apache2/sites-available/000-default.conf

a2enmod proxy_fcgi setenvif
a2enmod rewrite
a2enconf php7.0-fpm
service apache2 restart
#end apache and php

#nginx
echo -e "${YELLOW}Installing Nginx...${PLAIN}"
apt-get install nginx unzip -y

echo -e "${YELLOW}Configuring Nginx...${PLAIN}"
GZIP="client_body_buffer_size 10K;\n\tclient_header_buffer_size 1k;\n\tclient_max_body_size 8m;\n\tlarge_client_header_buffers 4 16k;\n\tfastcgi_buffers 16 16k;\n\tfastcgi_buffer_size 32k;\n\n\tinclude \/etc\/nginx\/cloudflare.conf;"
CFCONF=$(wget -qO- "https://www.cloudflare.com/ips-v4")'\n'$(wget -qO- "https://www.cloudflare.com/ips-v6")'\nreal_ip_header CF-Connecting-IP;'
echo -e "${CFCONF}" > /etc/nginx/cloudflare.conf
sed -i 's@\(^[^a-z]\)@set_real_ip_from \1@' /etc/nginx/cloudflare.conf
sed -i 's@\([^;]$\)@\1;@' /etc/nginx/cloudflare.conf
sed -i 's/# \(gzip_vary.*\)/\1/' /etc/nginx/nginx.conf
sed -i 's/# \(gzip_proxied.*\)/\1/' /etc/nginx/nginx.conf
sed -i 's/# \(gzip_comp_level.*\)/\1/' /etc/nginx/nginx.conf
sed -i 's/# \(gzip_buffers 16.*\)/\1/' /etc/nginx/nginx.conf
sed -i 's/# \(gzip_http_version.*\)/\1/' /etc/nginx/nginx.conf
sed -i 's/# \(gzip_types.*\)/\1\n\n\t'"${GZIP}"'/' /etc/nginx/nginx.conf

if [[ ! -f /etc/nginx/sites-available/default.bak ]]; then
  mv /etc/nginx/sites-available/default /etc/nginx/sites-available/default.bak
fi

wget -qO /etc/nginx/sites-available/default "https://github.com/anamunlam/ahkacp/raw/master/debian/nginx_site_detault_php7.0.conf" --no-check-certificate
#end nginx

#admin
mkdir -p /usr/local/ahkacp/ssl
wget -qO latest.zip "https://github.com/anamunlam/ahkacp/archive/Latest.zip" --no-check-certificate
unzip latest.zip
cp -rf ahkacp-Latest/dist/* /usr/local/ahkacp
rm -rf ahkacp-Latest latest.zip

servername=$(hostname -f)
mask1='(([[:alnum:]](-?[[:alnum:]])*)\.)'
mask2='*[[:alnum:]](-?[[:alnum:]])+\.[[:alnum:]]{2,}'
if ! [[ "$servername" =~ ^${mask1}${mask2}$ ]]; then
  if [ ! -z "$servername" ]; then
    servername="$servername.example.com"
  else
    servername="example.com"
  fi
fi

openssl req -x509 -nodes -days 365 -newkey rsa:4096 -keyout certificate.key -out certificate.crt \
    -subj "/C=ID/ST=Kalimantan Selatan/L=Banjarmasin/O=AhkaNet/CN=${servername}"

useradd -m admin
echo -e "123456\n123456\n" | passwd admin

wget -qO /etc/nginx/sites-available/admin.conf "https://github.com/anamunlam/ahkacp/raw/master/debian/nginx_site_admin_php7.0.conf" --no-check-certificate
ln -s /etc/nginx/sites-available/admin.conf /etc/nginx/sites-enabled/admin.conf

RAM=$( free -m | awk '/Mem/ {print $2}' )
RAM=$( awk 'BEGIN{printf "%i", '$RAM' - 256}' )
MAXCHILD=$( awk 'BEGIN{printf "%i", '$RAM' / 30}' )

echo "[anam]" > /etc/php/7.0/fpm/pool.d/admin.conf
echo "user = admin" >> /etc/php/7.0/fpm/pool.d/admin.conf
echo "group = admin" >> /etc/php/7.0/fpm/pool.d/admin.conf
echo "listen = /run/php/php7.0-fpm-admin.sock" >> /etc/php/7.0/fpm/pool.d/admin.conf
echo "listen.owner = www-data" >> /etc/php/7.0/fpm/pool.d/admin.conf
echo "listen.group = www-data" >> /etc/php/7.0/fpm/pool.d/admin.conf
echo "pm = dynamic" >> /etc/php/7.0/fpm/pool.d/admin.conf
echo "pm.max_children = ${MAXCHILD}" >> /etc/php/7.0/fpm/pool.d/admin.conf
echo "pm.start_servers = 3" >> /etc/php/7.0/fpm/pool.d/admin.conf
echo "pm.min_spare_servers = 2" >> /etc/php/7.0/fpm/pool.d/admin.conf
echo "pm.max_spare_servers = 4" >> /etc/php/7.0/fpm/pool.d/admin.conf
echo "pm.max_requests = 200" >> /etc/php/7.0/fpm/pool.d/admin.conf
echo "chdir = /" >> /etc/php/7.0/fpm/pool.d/admin.conf
#end admin

echo -e "${YELLOW}Restarting service...${PLAIN}"
service php7.0-fpm restart
service nginx restart

clear
ahka
echo ""
echo "url      : http://server_ip:2082"
echo "user     : admin"
echo "password : 123456"
next
