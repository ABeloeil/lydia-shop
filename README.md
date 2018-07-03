lydia-shop
=====

Light integration of the lydia api.

## 1 . Instalation

Clone the project locally
```bash
git clone git@github.com:ABeloeil/lydia-shop.git
```

## 2 . Install dependencies
Install php dependencies:
```bash
composer install
```

Install javascript dependencies:
```bash
yarn #or npm install
```

## 3 . Configuration
Configure a nginx virtual host:
```nginx
server {
    listen 80;
    server_name localhost;
    root /[...]/lydia-shop/web;

    client_max_body_size 1024M;

    #    Do not log access to robots.txt, to keep the logs cleaner
    location = /robots.txt { access_log off; log_not_found off; }

    #    Do not log access to the favicon, to keep the logs cleaner
    location = /favicon.ico { access_log off; log_not_found off; }

    location / {
        try_files $uri @rewriteapp;
    }

    location @rewriteapp {
        # rewrite all to app_dev.php, change it to app.php for production usage
        rewrite ^(.*)$ /app_dev.php/$1 last; 
    }

    location ~ ^/(app|app_dev|config)\.php(/|$) {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param HTTPS off;
    }
}
```

And restart nginx
```bash
sudo service nginx restart
```

Complete your parameters.yml to connect to the database and the lydia api.

## 4 . Assets

Build the react application with webpack:

```bash
yarn webpack #or npm run webpack
```

## 5 . Database

To be fully functionnal, you still need to execute some command to finish database configuration:

```bash
bin/console doctrine:database:create
bin/console doctrine:schema:update -f
bin/console doctrine:fixtures:load -n
```

## 6 . File permissions

Allow cache and logs to be write in /var (linux)

```bash
 HTTPDUSER=$(ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1)

 sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX var
 sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX var
 ```

For file permissions on other os, please [Symfony documentation](https://symfony.com/doc/3.4/setup/file_permissions.html)

After all those steps you can enjoy your shop !
