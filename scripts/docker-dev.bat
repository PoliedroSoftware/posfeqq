@echo off
REM Script para Windows - Comandos Docker útiles para desarrollo

echo ================================
echo     POSFEQQ Docker Manager
echo ================================
echo.
echo Seleccione una opción:
echo 1. Construir y levantar contenedores
echo 2. Levantar contenedores (sin build)
echo 3. Parar contenedores
echo 4. Ver logs
echo 5. Ejecutar comando en app container
echo 6. Entrar al container de la app
echo 7. Ejecutar migraciones
echo 8. Limpiar cache de Laravel
echo 9. Instalar dependencias de Composer
echo 10. Instalar dependencias de NPM
echo 11. Salir
echo.

set /p choice="Ingrese su opción (1-11): "

if "%choice%"=="1" goto build_up
if "%choice%"=="2" goto up
if "%choice%"=="3" goto down
if "%choice%"=="4" goto logs
if "%choice%"=="5" goto exec_command
if "%choice%"=="6" goto bash
if "%choice%"=="7" goto migrate
if "%choice%"=="8" goto clear_cache
if "%choice%"=="9" goto composer_install
if "%choice%"=="10" goto npm_install
if "%choice%"=="11" goto exit

:build_up
echo Construyendo y levantando contenedores...
docker-compose up -d --build
goto end

:up
echo Levantando contenedores...
docker-compose up -d
goto end

:down
echo Parando contenedores...
docker-compose down
goto end

:logs
echo Mostrando logs...
docker-compose logs -f
goto end

:exec_command
set /p cmd="Ingrese el comando a ejecutar: "
docker-compose exec app %cmd%
goto end

:bash
echo Entrando al container de la app...
docker-compose exec app bash
goto end

:migrate
echo Ejecutando migraciones...
docker-compose exec app php artisan migrate
goto end

:clear_cache
echo Limpiando cache...
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan view:clear
goto end

:composer_install
echo Instalando dependencias de Composer...
docker-compose exec app composer install
goto end

:npm_install
echo Instalando dependencias de NPM...
docker-compose exec app npm install
goto end

:end
echo.
echo Operación completada.
pause