<VirtualHost 127.0.0.1:8080>
    ServerName %domain%
    ServerAdmin %email%
    DocumentRoot /home/%user%/www/%domain%

    <Directory /home/%user%/www/%domain%/>
        AllowOverride All
        Options -Indexes
        Require all granted
    </Directory>

    <FilesMatch "^\.ht">
        Require all denied
    </FilesMatch>

    <IfModule !mod_php7.c>
    <IfModule proxy_fcgi_module>
        # Enable http authorization headers
        <IfModule setenvif_module>
            SetEnvIfNoCase ^Authorization$ "(.+)" HTTP_AUTHORIZATION=$1
        </IfModule>

        <FilesMatch ".+\.ph(p[3457]?|t|tml)$">
            SetHandler "proxy:unix:/run/php/php7.0-fpm-%user%.sock"
        </FilesMatch>
        <FilesMatch ".+\.phps$">
            # Deny access to raw php sources by default
            # To re-enable it's recommended to enable access to the files
            # only in specific virtual host or directory
            Require all denied
        </FilesMatch>
        # Deny access to files without filename (e.g. '.php')
        <FilesMatch "^\.ph(p[3457]?|t|tml|ps)$">
            Require all denied
        </FilesMatch>
    </IfModule>
    </IfModule>
</VirtualHost>
