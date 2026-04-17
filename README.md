# AirConnect Backend

[![CI/CD](https://github.com/Santiago4lvz/AirConnect-Backend/actions/workflows/ci-cd.yml/badge.svg)]
[![License](https://img.shields.io/badge/license-MIT-blue.svg)]

Backend del proyecto **AirConnect**, una API desarrollada para gestionar servicios relacionados con transporte aéreo, reservas y administración de usuarios.

El sistema proporciona endpoints para manejar autenticación, gestión de vuelos, reservas y administración del sistema.

---

# Tabla de Contenidos

* [Descripción](#descripción)
* [Requisitos Previos](#requisitos-previos)
* [Stack Tecnológico](#stack-tecnológico)
* [Instalación](#instalación)
* [Ejecutar Localmente](#ejecutar-localmente)
* [Tests](#tests)
* [Estructura del Proyecto](#estructura-del-proyecto)
* [Variables de Entorno](#variables-de-entorno)
* [Contribución](#contribución)
* [Licencia](#licencia)
* [logs] (#logs)
* [Ambiente de pruebas](#ambiente-de-pruebas)
* [pre-produccion](#ambiente-de-pre-producción)
* [Autores](#autores)


---

# Descripción

**AirConnect Backend** es una API REST desarrollada para gestionar la lógica del sistema AirConnect.

Permite administrar:

* Usuarios
* Autenticación
* Reservas
* Información del sistema

El backend expone endpoints que pueden ser consumidos por aplicaciones web o móviles.

---

# Requisitos Previos

Antes de ejecutar el proyecto debes tener instalado:

* PHP 8.1+
* Composer
* MySQL o MariaDB
* SQL Server
* Node.js 18+
* Docker 

---

# Stack Tecnológico

Backend

* Laravel
* PHP

Base de Datos

* SQLserver

Contenedores

* Docker

Control de versiones

* Git
* GitHub

Testing

* PHPUnit
* PhPTest


CI/CD

* GitHub Actions

---

# Instalación

Clonar el repositorio:

```bash
git clone -b proyecto-integrador --single-branch https://github.com/Santiago4lvz/AirConnect-Backend.git
cd AirConnect-Backend
```

Instalar dependencias de PHP:

```bash
composer install
```

Copiar variables de entorno:

```bash
cp .env.example .env
```

Generar clave de la aplicación:

```bash
php artisan key:generate
```

Configurar base de datos en el archivo `.env`.

Ejecutar migraciones:

```bash
php artisan migrate
```

---

# Ejecutar Localmente

Iniciar servidor de desarrollo:

```bash
php artisan serve
```

La API estará disponible en:

```
http://localhost:8000
```

---

# Tests

Ejecutar todos los tests:

```bash
php artisan test
```
Ejecutar test unitarianmente

```bash
php artisan test tests/Unit/passwordTest.php
```
o
```bash
php artisan test test/Unit/PassowrdHidenTest.php
```

Los tests se encuentran en la carpeta:

```
tests/
```

Ejecutar phpstan (Código Estatico)

```bash
./vendor/bin/phpstan analyse
```



---

# Estructura del Proyecto

```
AirConnect-Backend
│
├ app
│ ├ Http
│ │ └ Controllers
│ ├ Models
│
├ routes
│ ├ api.php
│ └ web.php
│
├ tests
│
├ docs
│ ├ api
│ ├ architecture
│ └ guides
│
├ Dockerfile
├ docker-compose.yml
├ README.md
└ package.json
```

---

# Variables de Entorno

El proyecto utiliza variables de entorno definidas en el archivo `.env`.

Ejemplo:

```
APP_NAME=AirConnect
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost 

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=airconnect
DB_USERNAME=root
DB_PASSWORD=
```

---

# Contribución

Para contribuir al proyecto:

1. Crear una nueva rama

```
git checkout -b feature/nueva-funcionalidad
```

2. Realizar los cambios necesarios

3. Hacer commit

```
git commit -m "feat: nueva funcionalidad"
```

4. Subir la rama

```
git push origin feature/nueva-funcionalidad
```

5. Crear un **Pull Request** en GitHub.

---

# Licencia

Este proyecto se distribuye bajo la licencia **MIT**.

---

# Logs
 Herramienta: log-viewere

 instalación
```
 composer require opcodesio/log-viewer
 php artisan log-viewer:publish
```
Uso
Una vez la instalación se a completado se podra acceder desde el navegador
```
{APP_URL}/log-viewer
```
# Ambiente de pruebas

Ejecutar el .env de pruebas

```
copy .env .env.testing
```
ejecutar migraciones

```
php artisan migrate
```

# Ambiente de pre-producción

Ejecutar el archivo setup.sh

```
./setup.sh
```


# Autores

Equipo de desarrollo del proyecto **AirConnect**

* Integrantes del Proyecto Integrador

Ayala Salaya Ingrid

Jimenez Garcia Said Humberto

May Gamas Sebastian

Morales Ramirez Jorge de Jesus

Santiago Alvarez Mario Alfonso

Tah Moo Carlos Misael