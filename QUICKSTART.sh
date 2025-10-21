#!/bin/bash

# 🚀 Striggo - Quick Start Script
# Este script configura automaticamente o projeto

echo "🎓 Striggo - Configuração Rápida"
echo "================================"
echo ""

# Cores
GREEN='\033[0;32m'
BLUE='\033[0;34m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Diretório do projeto
PROJECT_DIR="/Users/andreprado/dev/striggo-app"
COMPOSER_PATH="/Users/andreprado/composer.phar"

cd "$PROJECT_DIR"

echo -e "${BLUE}1. Instalando dependências do Composer...${NC}"
php "$COMPOSER_PATH" install --quiet
echo -e "${GREEN}✓ Composer instalado${NC}"
echo ""

echo -e "${BLUE}2. Instalando dependências do NPM...${NC}"
npm install --silent
echo -e "${GREEN}✓ NPM instalado${NC}"
echo ""

echo -e "${BLUE}3. Configurando ambiente...${NC}"
if [ ! -f .env ]; then
    cp .env.example .env
    echo -e "${GREEN}✓ Arquivo .env criado${NC}"
else
    echo -e "${GREEN}✓ Arquivo .env já existe${NC}"
fi
echo ""

echo -e "${BLUE}4. Gerando application key...${NC}"
php artisan key:generate --force
echo -e "${GREEN}✓ Key gerada${NC}"
echo ""

echo -e "${BLUE}5. Criando banco de dados SQLite...${NC}"
touch database/database.sqlite
echo -e "${GREEN}✓ Banco criado${NC}"
echo ""

echo -e "${BLUE}6. Configurando .env para SQLite...${NC}"
# Configurar .env para usar SQLite
if grep -q "DB_CONNECTION=mysql" .env; then
    sed -i '' 's/DB_CONNECTION=mysql/DB_CONNECTION=sqlite/' .env
    sed -i '' '/^DB_HOST=/d' .env
    sed -i '' '/^DB_PORT=/d' .env
    sed -i '' '/^DB_USERNAME=/d' .env
    sed -i '' '/^DB_PASSWORD=/d' .env
    echo "DB_DATABASE=$PROJECT_DIR/database/database.sqlite" >> .env
fi
echo -e "${GREEN}✓ .env configurado${NC}"
echo ""

echo -e "${BLUE}7. Instalando Laravel Breeze...${NC}"
php "$COMPOSER_PATH" require laravel/breeze --dev --quiet
php artisan breeze:install blade --quiet
echo -e "${GREEN}✓ Breeze instalado${NC}"
echo ""

echo -e "${BLUE}8. Instalando Livewire...${NC}"
php "$COMPOSER_PATH" require livewire/livewire --quiet
echo -e "${GREEN}✓ Livewire instalado${NC}"
echo ""

echo -e "${BLUE}9. Executando migrations...${NC}"
php artisan migrate --force
echo -e "${GREEN}✓ Migrations executadas${NC}"
echo ""

echo -e "${BLUE}10. Populando banco de dados...${NC}"
php artisan db:seed --force
echo -e "${GREEN}✓ 50 questões carregadas${NC}"
echo -e "${GREEN}✓ 15 badges criadas${NC}"
echo -e "${GREEN}✓ Usuário de teste criado${NC}"
echo ""

echo -e "${BLUE}11. Compilando assets...${NC}"
npm run build
echo -e "${GREEN}✓ Assets compilados${NC}"
echo ""

echo ""
echo "=========================================="
echo -e "${GREEN}✅ Setup Completo!${NC}"
echo "=========================================="
echo ""
echo "📝 Credenciais de Teste:"
echo "   Email: test@example.com"
echo "   Senha: password"
echo ""
echo "🚀 Para iniciar o servidor:"
echo "   php artisan serve"
echo ""
echo "🌐 Acesse:"
echo "   http://localhost:8000"
echo ""
echo "✨ Bons estudos!"
echo ""
