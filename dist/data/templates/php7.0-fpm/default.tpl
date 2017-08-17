[%user%]
user = %user%
group = jailed
listen = /run/php/php7.0-fpm-%user%.sock
listen.owner = www-data
listen.group = www-data
pm = dynamic
pm.max_children = 10
pm.start_servers = 3
pm.min_spare_servers = 2
pm.max_spare_servers = 4
pm.max_requests = 200
chroot = /home/%user%
chdir = /
php_admin_value[doc_root] = /www/%domain%
php_admin_value[disable_functions] = exec,passthru,shell_exec,system
