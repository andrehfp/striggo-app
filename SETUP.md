# Striggo - Sistema Gamificado de Estudos CFC

## 📋 Status do Projeto

### ✅ Concluído
- [x] Projeto Laravel 11 criado
- [x] 50 questões extraídas e estruturadas em JSON
- [x] Migrations criadas (Questions, UserProgress, UserAnswers, Badges)
- [x] Models implementados (Question, UserProgress, UserAnswer, Badge, User)
- [x] Seeders criados (QuestionSeeder com 50 questões, BadgeSeeder com 15 badges)
- [x] GamificationService implementado (lógica de XP, levels, streaks, badges)

### ⏳ Em Desenvolvimento
- [ ] Componentes Livewire (QuestionCard, ProgressBar, StreakCounter, etc.)
- [ ] Views Blade e roteamento
- [ ] Modo Prática com feedback em tempo real
- [ ] Modo Simulado (50 questões, 4 horas)
- [ ] Página de Estatísticas com gráficos

---

## 🚀 Como Configurar e Rodar

### Pré-requisitos
- PHP 8.3+
- Composer
- Node.js/NPM

### 1. Instalar dependências

```bash
cd /Users/andreprado/dev/striggo-app

# Composer dependencies
php /Users/andreprado/composer.phar install

# NPM dependencies
npm install

# Instalar Laravel Breeze com Livewire
php artisan breeze:install --with=livewire
```

### 2. Configurar banco de dados

```bash
# Copiar .env (já deve estar criado)
cp .env.example .env

# Gerar application key
php artisan key:generate

# Criar banco SQLite
touch database/database.sqlite

# Configurar .env para SQLite
# DB_CONNECTION=sqlite
# DB_DATABASE=/Users/andreprado/dev/striggo-app/database/database.sqlite
```

### 3. Rodar Migrations

```bash
php artisan migrate
```

### 4. Popular banco com Seeders

```bash
php artisan db:seed
```

Isso vai:
- Criar 50 questões da Prova Tipo 1
- Criar 15 badges
- Criar usuário de teste (email: test@example.com, senha: password)

### 5. Instalar Livewire

```bash
php /Users/andreprado/composer.phar require livewire/livewire

# Publicar assets
php artisan livewire:publish-config
```

### 6. Build assets

```bash
npm run dev
# ou para produção: npm run build
```

### 7. Rodar servidor

```bash
php artisan serve
```

Acesse em: `http://localhost:8000`

---

## 🎮 Sistema de Gamificação

### XP e Níveis
- **Acerto**: +10 XP
- **Erro**: +3 XP
- **Nível**: A cada 100 XP = 1 nível

### Streaks (Sequências)
- Contador de dias consecutivos estudando
- Reseta se o usuário não estudar por um dia

### Badges (15 total)
1. 🎯 Primeira Resposta
2. 🎉 10 Acertos
3. ⭐ 50 Acertos
4. 🔥 Sete Dias Seguidos
5. 👑 Mês de Dedicação
6. 💪 Nível 5
7. 🚀 Nível 10
8. 💯 90% de Precisão
9. 💯 Centena (100 questões)
10. 🎓 Especialista em Categoria
11. 📝 Prova Simulada Completa
12. 🌅 Madrugador
13. ⚡ Raio Veloz
14. 🔄 Retorno Triunfante
15. 💎 Perfeição (10 acertos seguidos)

---

## 📁 Estrutura do Código

```
striggo-app/
├── app/
│   ├── Models/
│   │   ├── User.php (com relações)
│   │   ├── Question.php
│   │   ├── UserProgress.php
│   │   ├── UserAnswer.php
│   │   └── Badge.php
│   ├── Services/
│   │   └── GamificationService.php
│   ├── Http/
│   │   ├── Livewire/ (próximo: componentes)
│   │   └── Controllers/ (próximo: controllers)
│
├── database/
│   ├── migrations/
│   │   ├── 2025_10_21_000000_create_questions_table.php
│   │   ├── 2025_10_21_000001_create_user_progress_table.php
│   │   ├── 2025_10_21_000002_create_user_answers_table.php
│   │   └── 2025_10_21_000003_create_badges_table.php
│   ├── seeders/
│   │   ├── QuestionSeeder.php (50 questões)
│   │   ├── BadgeSeeder.php (15 badges)
│   │   └── DatabaseSeeder.php
│   └── questions.json (50 questões)
│
└── resources/views/ (próximo: views Blade)
```

---

## 🎯 Próximos Passos

### 1. Componentes Livewire
Criar components interativos:
- `QuestionCard.php` - Exibe questão e captura resposta
- `ProgressBar.php` - Barra de XP/Nível
- `StreakCounter.php` - Contador de streak
- `DailyGoal.php` - Meta diária circular
- `BadgesList.php` - Grid de conquistas

### 2. Views Blade
- `dashboard.blade.php` - Dashboard principal
- `practice.blade.php` - Modo prática
- `simulated.blade.php` - Modo simulado
- `statistics.blade.php` - Estatísticas
- `achievements.blade.php` - Conquistas

### 3. Controllers
- `DashboardController` - Dashboard
- `PracticeController` - Modo prática
- `SimulatedController` - Modo simulado
- `StatisticsController` - Estatísticas

### 4. Rotas
```
GET    / (redirect to dashboard)
GET    /dashboard - Dashboard
GET    /pratica - Modo prática
POST   /pratica/answer - Submeter resposta
GET    /simulado - Modo simulado
GET    /estatisticas - Estatísticas
GET    /conquistas - Conquistas
```

---

## 💻 Comandos Úteis

```bash
# Fazer migrate + seed
php artisan migrate:fresh --seed

# Rodar migrations apenas
php artisan migrate

# Rodar seeders
php artisan db:seed

# Criar novo modelo com migration
php artisan make:model Question -m

# Criar componente Livewire
php artisan livewire:make QuestionCard

# Rodar testes
php artisan test

# Limpar cache
php artisan cache:clear
```

---

## 📝 Notas

- Usuário de teste: `test@example.com` / `password`
- Banco de dados: SQLite (local, nenhuma configuração adicional necessária)
- Autenticação: Laravel Breeze com Livewire
- Frontend: Tailwind CSS + Alpine.js

---

## 📞 Suporte

Para problemas ou dúvidas sobre a configuração, verifique:
1. Se o PHP está na versão 8.3+
2. Se o Composer foi instalado corretamente
3. Se o arquivo `.env` está configurado
4. Se o banco SQLite foi criado em `database/database.sqlite`
