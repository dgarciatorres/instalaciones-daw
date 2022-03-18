# Práctica 1. Instalación de Wordpress: apache + php + mariadbPágina

## LAMP

### Instalación base

```
vagrant init bento/ubuntu-20.04
```

Edita el Vagrantile para hacer el forward del puerto 8080 al puerto 80

```
Vagrant.configure("2") do |config|
  config.vm.box = "bento/ubuntu-20.04"
  config.vm.network "forwarded_port", guest: 80, host: 8080
end
```


Levanta y actualiza el sistema


```
vagrant up
vagrant ssh
sudo apt update
```

### Instalación mariadb

Instalación del servidor de base de datos

```
sudo apt install mariadb-server
```

