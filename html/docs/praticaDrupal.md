# Práctica 2. Instalación de Drupal

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



## INSTALACIÓN DE DRUPAL

### Descarga Drupal 9

Podemos descargarlo a través del enlace oficial  [Página oficial de descargas de Drupal 9](https://www.drupal.org/download/).

Está la última versión disponible de Drupal en paquetes .zip y .tar.gz (descargamos el .tar.gz)

```text
wget --content-disposition https://www.drupal.org/download-latest/tar.gz
```



### Cómo instalar Drupal en Ubuntu 20.04 LTS

Para poder **instalar Drupal 9 en Ubuntu 20.04 LTS** es necesario realizar una serie de tareas en el sistema, de modo que posteriormente el instalador web corra sin problemas. A continuación detallamos todos los pasos necesarios.

Y lo descomprimimos

```text
tar xf drupal-9.X.X.tar.gz -C /var/www/html
```

Como el nombre del nuevo subdirectorio creado contiene el número de versión en su nombre, puede ser buena idea crear un enlace simbólico sin números:

```
sudo ln -s /var/www/html/drupal-9.X.X /var/www/html/drupal
```



Como Drupal 9 necesita escribir en su propio directorio de instalación, cambiaremos la propiedad del mismo y de su contenido al usuario con el que corre el servicio web en Ubuntu 20.04:



```
sudo chown -R www-data: /var/www/html/drupal/
```



### Servicio web

Como Drupal está orientado a uso con Apache, ativaremos algunos módulos que no trae activos por defecto:

```
a2enmod expires headers rewrite
```

El uso de estos módulos se realiza a través de archivos *.htaccess*, que no son interpretados por defecto, ajuste que añadiremos al archivo de configuración que crearemos para hacer la aplicación navegable a través de un alias:

```
nano /etc/apache2/sites-available/drupal.conf
```

Y copiamos el siguiente contenido

```

<VirtualHost *:80>
  DocumentRoot "/var/www/html/drupal"
  ServerName drupal.miservidor.com
  ServerAlias www.drupal.miservidor.com
  ErrorLog /var/log/apache2/error-autentication-drupal.log
  CustomLog /var/log/apache2/access-autentication-drupal.log combined
</VirtualHost>
```

Guardamos los cambios y activamos la configuración:

```
a2ensite drupal.conf
```

Y reiniciamos el servicio web para aplicar todos estos ajustes:

```
systemctl restart apache2
```



### Base de datos

Drupal 9 se apoya sobre el servicio de bases de datos existente en la máquina Ubuntu 20.04 LTS, admitiéndose varios motores de los que veremos los dos más populares. Veremos cómo crear las bases de datos y usuarios que necesita la aplicación.

##### MARIADB/MYSQL

Conectamos al servicio con el cliente *mysql* y un usuario administrador:

```
mysql -u root -p
```



Creamos la base de datos:

```
> create database drupal9 charset utf8mb4 collate utf8mb4_unicode_ci;
```



Si usamos MariaDB o MySQL 5 creamos el usuario de forma trivial:

```
> create user drupal9@localhost identified by 'XXXXXXXX';
```



Concedemos los privilegios al usuario sobre la base:

```
> grant all privileges on drupal9.* to drupal9@localhost;
```



Y cerramos la conexión:

```
> exit;
```



### PHP

Drupal 9 necesita la disponibilidad de ciertas extensiones en Ubuntu 20.04 LTS que obtendremos desde los repositorios de la distribución. Por ello, actualizamos las listas de paquetes:

```
apt update
```



E instalamos las extensiones necesarias. En el caso de trabajar con la versión nativa de PHP en Ubuntu 20.04:

```
apt install -y php-apcu php-gd php-mbstring php-uploadprogress php-xml
```



Se necesitará también la extensión que corresponda al motor de bases de datos sobre el que corra Drupal 9, aplicándose lo ya dicho para la nomenclatura de los paquetes, siendo en el caso de MariaDB/MySQL:

```
apt install -y php-mysql
```



Terminada la instalación hay que recargar la configuración del servicio web:

```
systemctl reload apache2
```



![Pantallazo muestra del funcionamiento dentro de la máquina de wp](../practica-DAW-wp/html/resources/instalacion-drupal.png "Pantallazo muestra del funcionamiento dentro de la máquina de wp")



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