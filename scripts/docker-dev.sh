#!/bin/bash

# Script para Linux/Mac - Comandos Docker útiles para desarrollo

show_menu() {
    echo "================================"
    echo "     POSFEQQ Docker Manager"
    echo "================================"
    echo ""
    echo "Seleccione una opción:"
    echo "1. Construir y levantar contenedores"
    echo "2. Levantar contenedores (sin build)"
    echo "3. Parar contenedores"
    echo "4. Ver logs"
    echo "5. Ejecutar comando en app container"
    echo "6. Entrar al container de la app"
    echo "7. Ejecutar migraciones"
    echo "8. Limpiar cache de Laravel"
    echo "9. Instalar dependencias de Composer"
    echo "10. Instalar dependencias de NPM"
    echo "11. Salir"
    echo ""
}

while true; do
    show_menu
    read -p "Ingrese su opción (1-11): " choice
    
    case $choice in
        1)
            echo "Construyendo y levantando contenedores..."
            docker-compose up -d --build
            ;;
        2)
            echo "Levantando contenedores..."
            docker-compose up -d
            ;;
        3)
            echo "Parando contenedores..."
            docker-compose down
            ;;
        4)
            echo "Mostrando logs..."
            docker-compose logs -f
            ;;
        5)
            read -p "Ingrese el comando a ejecutar: " cmd
            docker-compose exec app $cmd
            ;;
        6)
            echo "Entrando al container de la app..."
            docker-compose exec app bash
            ;;
        7)
            echo "Ejecutando migraciones..."
            docker-compose exec app php artisan migrate
            ;;
        8)
            echo "Limpiando cache..."
            docker-compose exec app php artisan config:clear
            docker-compose exec app php artisan cache:clear
            docker-compose exec app php artisan view:clear
            ;;
        9)
            echo "Instalando dependencias de Composer..."
            docker-compose exec app composer install
            ;;
        10)
            echo "Instalando dependencias de NPM..."
            docker-compose exec app npm install
            ;;
        11)
            echo "Saliendo..."
            exit 0
            ;;
        *)
            echo "Opción inválida. Por favor, seleccione 1-11."
            ;;
    esac
    
    echo ""
    read -p "Presione Enter para continuar..."
done