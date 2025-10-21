# 🚀 Guia de Instalação - Striggo

## Passo a Passo Completo

### 1. Instalar Dependências

```bash
cd /Users/andreprado/dev/striggo-app

# Instalar dependências do Composer
php /Users/andreprado/composer.phar install

# Instalar dependências do NPM
npm install
```

### 2. Configurar Ambiente

```bash
# Copiar .env
cp .env.example .env

# Gerar key
php artisan key:generate

# Criar banco SQLite
touch database/database.sqlite
```

### 3. Editar .env

Configure o banco de dados para SQLite:

```env
DB_CONNECTION=sqlite
DB_DATABASE=/Users/andreprado/dev/striggo-app/database/database.sqlite
```

### 4. Instalar Breeze e Livewire

```bash
# Breeze
php /Users/andreprado/composer.phar require laravel/breeze --dev
php artisan breeze:install blade

# Livewire
php /Users/andreprado/composer.phar require livewire/livewire
```

### 5. Rodar Migrations e Seeds

```bash
php artisan migrate
php artisan db:seed
```

### 6. Compilar Assets

```bash
npm run dev
# ou: npm run build
```

### 7. Iniciar Servidor

```bash
php artisan serve
```

Acesse: **http://localhost:8000**

Login: **test@example.com** / **password**

---

## ✅ Pronto!

Agora você tem:
- ✓ 50 questões carregadas
- ✓ 15 badges configuradas
- ✓ Usuário de teste criado
- ✓ Sistema de gamificação funcionando
- ✓ Dashboard, Prática e Estatísticas prontos
