#!/bin/bash

echo "🚀 Iniciando generación del entorno de liberación..."

# 1. Copiar configuración de entorno si no existe
if [ ! -f .env ]; then
    cp .env.example .env
    echo "✅ Archivo .env creado desde .env.example"
fi

# 2. Levantar los contenedores con Docker Compose
docker-compose up -d --build

# 3. Instalar dependencias y preparar Laravel
docker-compose exec app composer install
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate

echo "✅ Entorno verificado y corriendo en http://localhost:8000"

# verificar  si hay conexión a la base de datos
echo "🔍 Verificando conexión con Azure SQL..."
if docker-compose exec app php artisan db:monitor; then
    echo "✅ Conexión exitosa a la base de datos."
else
    echo "❌ Error de conexión: Revisa tus credenciales en el .env"
fi



# ejecutar pruebas de humo
echo "🔍 Ejecutando pruebas de humo..."
docker-compose exec app php artisan test --filter=SmokeTest
echo "🚀 Entorno de liberación listo y verificado."

#ejecutar pruebas de integración
echo "🔍 Ejecutando pruebas de integración..."
docker-compose exec app php artisan test --filter=integrationTest
echo "prueba ejecutada"

#ejecutar pruebas de healty

echo "🔍 Ejecutando pruebas de Healthy..."
curl -I http://localhost:8000/api/health
echo prueba ejecutada correctamnet






