# Docker based LAMP

LAMP is abbreviate of Linux Apache MySQL/MariaDB PHP.

That means complete environment for development on PHP language.

## How to use

Copy docker-compose.yml from dist example

    cp docker-compose.dist.yml docker-compose.yml

If you plan to use this image in production - do not forget to modify php.ini accordingly in dockerfile step #3, e.g.:

    RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

Then build docker image

    docker-compose build

after that we need to load images containers we created in our docker-compose.yml into our docker image:

    docker-compose pull

and run composition

    docker-compose up -d

After this you may go to http://localhost or 127.0.0.1 and will see the Apache (NGINX) default index page.

Of course, you want to pass your PHP files to this composition, for this you
need to overwrite (or add) strings like:

    - ./app:/var/www/html

to your path with sources, e.g.: `- ../my-sources-in-parent-folder:/var/www/html`.

If you don't like `/var/www/html` path, you may create your own apache config and bind it into `php` / `volumes`

or, if you use fpm based container, then write config for NGINX and bind it into `nginx` container.

## Links

* [Video on YouTube](https://www.youtube.com/watch?v=he-Rps8VcFk) about Docker LAMP
  composition (on Russian language)
* [Video on YouTube](https://www.youtube.com/watch?v=qxGlQZIbpHM) about minimal
  version of PHP-FPM and xDebug (on Russian language)