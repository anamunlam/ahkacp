server {
    listen 80;
    server_name %domain% %alias%;
    root /home/%user%/www/%domain%/public_html;
    index index.php index.html;
    access_log   /var/log/nginx/%domain%-access.log;
    error_log    /var/log/nginx/%domain%-error.log error;
    
    error_page 403 /403.html;
    location = /403.html {
        root /home/%user%/www/%domain%/error_docs;
        internal;
    }
    
    error_page 404 /404.html;
    location = /404.html {
        root /home/%user%/www/%domain%/error_docs;
        internal;
    }

    error_page 500 502 503 504 /50x.html;
    location = /50x.html {
        root /home/%user%/www/%domain%/error_docs;
        internal;
    }

    location / {
        proxy_pass http://127.0.0.1:8080;
        proxy_set_header Host "%domain%";
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }

    location ~*.(ogg|ogv|svg|svgz|eot|otf|woff|mp4|ttf|css|rss|atom|js|jpg|jpeg|gif|png|ico|zip|tgz|gz|rar|bz2|doc|xls|exe|ppt|tar|mid|midi|wav|bmp|rtf|cur)$ {
        expires max;
        log_not_found off;
        access_log off;
    }

    location ~ \.php$ {
        try_files $uri =404;
        include fastcgi_params;
        fastcgi_pass unix:/run/php/php7.0-fpm-%domain%.sock;
        fastcgi_split_path_info ^(.+\.php)(.*)$;
        fastcgi_param  SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    location ~* "/\.(htaccess|htpasswd)$" {
        deny    all;
        return  404;
    }
}
