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



### Instalación de Drupal

Para poder llevar a cabo la intalacion es necesaria la siguiente información:

1. En la página inicial del instalador web elegiremos el idioma de la instalación. >> **Español**

   ![Pantallazo que muestras el proceso de instalación de Drupal](https://github.com/dgarciatorres/instalaciones-daw/blob/main/html/resources/drupal-idioma.png?raw=true "Pantallazo que muestras el proceso de instalación de Drupal")

   

   Nos indica que tenemos que crear un directorio para las traducciones

   ```
   mkdir sites/default/files/
   cd files
   mkdir sites/default/files/translations
   ```

   

1. A continuación seleccionamos el perfil de instalación que necesitamos: >> **Estándar** 

1. El siguiente paso es la comprobación de requisitos para la instalación, destacándose aquellos que no se cumplen.

1. Conexión con base de datos:

   ![drupal-instalacion.png](https://github.com/dgarciatorres/instalaciones-daw/blob/main/html/resources/drupal-configuracion-sitio.png?raw=true "Pantallazo que muestras el proceso de instalación de Drupal")

   

1. Configuración del sitio

   ![drupal-instalacion.png](https://github.com/dgarciatorres/instalaciones-daw/blob/main/html/resources/drupal-instalacion.png?raw=true "Pantallazo que muestras el proceso de instalación de Drupal")





-----



user dgarciatorres

Pass 3unnHJu#Cx$t
