# POSFEQQ Docker Setup

Este proyecto ahora incluye una configuración completa de Docker para desarrollo y despliegue.

## Servicios incluidos

- **app**: Aplicación Laravel PHP 7.4-FPM
- **nginx**: Servidor web Nginx
- **mysql**: Base de datos MySQL 8.0
- **redis**: Cache Redis
- **queue**: Worker de colas de Laravel
- **scheduler**: Scheduler de Laravel para cron jobs
- **phpmyadmin**: Interfaz web para administrar MySQL

## Requisitos previos

- Docker
- Docker Compose

## Configuración inicial

1. **Copiar archivo de entorno:**
   ```bash
   cp .env.docker .env
   ```

2. **Construir y levantar contenedores:**
   ```bash
   docker-compose up -d --build
   ```

3. **Ejecutar migraciones:**
   ```bash
   docker-compose exec app php artisan migrate
   ```

## Comandos útiles

### Scripts automatizados
- **Windows**: `scripts\docker-dev.bat`
- **Linux/Mac**: `scripts/docker-dev.sh`

### Comandos manuales

**Levantar servicios:**
```bash
docker-compose up -d
```

**Parar servicios:**
```bash
docker-compose down
```

**Ver logs:**
```bash
docker-compose logs -f
```

**Ejecutar comandos Artisan:**
```bash
docker-compose exec app php artisan migrate
docker-compose exec app php artisan tinker
```

**Acceder al container:**
```bash
docker-compose exec app bash
```

**Instalar dependencias:**
```bash
docker-compose exec app composer install
docker-compose exec app npm install
```

## URLs de acceso

- **Aplicación**: http://localhost
- **phpMyAdmin**: http://localhost:8080

## Credenciales de base de datos

- **Host**: mysql (dentro de containers) / localhost:3306 (desde host)
- **Base de datos**: pos
- **Usuario**: pos_user
- **Contraseña**: pos_password
- **Root password**: root_password

## Estructura de archivos Docker

```
docker/
├── nginx/
│   ├── nginx.conf          # Configuración principal de Nginx
│   └── sites/
│       └── default.conf    # Configuración del sitio
├── php/
│   └── php.ini            # Configuración de PHP
├── mysql/
│   └── my.cnf             # Configuración de MySQL
├── supervisor/
│   └── supervisord.conf   # Configuración de Supervisor
└── entrypoint.sh          # Script de inicialización
```

## Variables de entorno

El archivo `.env.docker` incluye todas las configuraciones necesarias para Docker:

- Base de datos configurada para el container MySQL
- Redis configurado para el container Redis
- Configuraciones de cache y sesión optimizadas

## Troubleshooting

**Si hay problemas con permisos:**
```bash
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
docker-compose exec app chmod -R 775 storage bootstrap/cache
```

**Si hay problemas con la base de datos:**
```bash
docker-compose down
docker volume rm posfeqq_mysql_data
docker-compose up -d
```

**Limpiar cache:**
```bash
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan view:clear
```