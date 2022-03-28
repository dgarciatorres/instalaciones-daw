# Práctica 1. Instalación de Wordpress: apache + php + mariadb

## LAMP

### Instalación base

```text
vagrant init bento/ubuntu-20.04
```

Edita el Vagrantile para hacer el forward del puerto 8080 al puerto 80

```text
Vagrant.configure("2") do |config|
  config.vm.box = "bento/ubuntu-20.04"
  config.vm.network "forwarded_port", guest: 80, host: 8080
end
```

Levanta y actualiza el sistema

```text
vagrant up
vagrant ssh
sudo apt update
```

### Instalación mariadb

Instalación del servidor de base de datos

```text
sudo apt install mariadb-server
```

### Apache y PHP

Instalación de apache2 y del módulo que permite que apache2 interprete PHP (apache2 hará el papel de servidor web y de servidor de aplicaciones).

```text
sudo apt install apache2 libapache2-mod-php php php-mysq
```

### Configuración de PHP

Archivos de configuración de PHP

* `/etc/php/7.4/cli`: Configuración de php para `php7.4-cli` (ejecución de php desde la línea de comandos)
* `/etc/php/7.4/apache2`: Configuración de php para apache2 usado como módulo
* `/etc/php/7.4/apache2/php.ini`: Configuración de php
* `/etc/php/7.4/fpm`: Configuración de php para php-fpm
* `/etc/php/7.4/mods-available`: Módulos disponibles de php

### Comprobación

Creamos un fichero `info.php` en el `documentRoot` (`/var/www/html` ?) con el siguiente contenido:

```php
<?php phpinfo(); ?>
```

Accedemos con el navegador. Si no aparece la información de php y vemos el contenido que hemos escrito, es que no se ha instalado correctamente. Tendrías que ver algo similar a esto:

![Pantallazo muestra de la información de PHP](/resources/info-php.jpg "Pantallazo muestra de la información de PHP")

## CREACIÓN Y CONFIGURACIÓN DE LA BASE DE DATOS

### Creación de la base de datos

Accedemos a nuesta base de datos

```text
mysql -u root -p
```

Creamos una base de datos que vamos a llamar "wordpress"

```text
create database wordpress;
use wordpress;
```

Creamos un usuario llamado "user"

```text
create user 'user'@'localhost';
```

Le damos privilegios a ese usuario sobre la base de datos y su contraseña es 'password'

```text
grant all privileges on wordpress.* to 'user'@'localhost' identified by 'password';
flush privileges;
```

Salimos de la base de datos

```text
Bye
```

## INSTALACIÓN DE WP

### Requisitos para la instalación

* PHP versión 7.4 o superior.
* MySQL versión 5.7 o superior O MariaDB versión 10.2 o superior.
* Compatible con HTTPS

Nos vamos al virtualHost

```text
cd /var/www/html
```

Para descargar Wordpress nos vamos a la página oficial y copiamos la ruta de enlace del botón de descarga. Con la herramienta "wget" lo descargamos

```text
wget https://es.wordpress.org/latest-es_ES.zip
```

Y lo descomprimimos

```text
unzip latest-es_ES.zip
```

Si no tenemos unzip lo podemos descargar

```text
apt install unzip 
```

![Pantallazo muestra del funcionamiento dentro de la máquina de wp](/resources/wordpress.jpg "Pantallazo muestra del funcionamiento dentro de la máquina de wp")

Durante la instalación se crea un archivo de configuració, para que sea capaz de escribirlo el document root debe pertener al usuario "www-data".

Para esto volvemos a la caperta raiz "www" y ejecutamos el siguiente comando:

```text
cd ..
chown -R www-data:www-data html/
```

### Configuración de WP

Para poder llevar a cabo la intalacion es necesaria la siguiente información:

1. Nombre de la base de datos >> **wordpress**
1. Usuario de la base de datos >> **user**
1. Contraseña de la base de datos **password**
1. Servidor de la base de datos **localhost**
1. Prefijo de la tabla (si quieres ejecutar más de un WordPress en una sola base de datos) **wp_**

A continuación nos pedirá que rellenemos los datos de la página:

* Título
* Usuario
* Contraseña
* Correo electrónico

> Si no trabajamos en local es aconsejable marcar la opción "Pedir a los motores de búsqueda que no indexen este sitio" para que no se indexe la página hasta que terminemos el desarrollo.

Para poder entrar en la adminisitración de nuestro WP tendremos que incorporar en la barra de direcciones /wp-admin

```text
dominiodelsitio.com/wp-admin
```