
# CoffeeMlyny – Laravel Setup

## 🐳 Docker Setup (Recommended)

The easiest way to run this project is using Docker. This method requires only Docker and Docker Compose installed on your computer.

### Prerequisites
- Docker
- Docker Compose

### Quick Start

1. Clone the repository:
```bash
git clone git@github.com:RadoslavMuntag/CoffeeMlyny.git
cd CoffeeMlyny
```

2. Start the application:
```bash
docker-compose up -d
```

3. Open in browser: `http://localhost:8000`

The application will automatically:
- Install all dependencies
- Set up the PostgreSQL database
- Run migrations
- Seed the database
- Build frontend assets
- Create storage symlinks

### Docker Commands

Stop the application:
```bash
docker-compose down
```

View logs:
```bash
docker-compose logs -f app
```

Access the application container:
```bash
docker-compose exec app bash
```

Rebuild the application:
```bash
docker-compose up -d --build
```

---

## 🧩 Manual Installation (Alternative)

If you prefer to run the project without Docker:

### Požiadavky

- PHP >= 8.2  
- Composer  
- PostgreSQL
- Node.js >= 18
- Laravel >= 12

---

## ⚙️ Inštalácia projektu

```bash
git clone git@github.com:RadoslavMuntag/CoffeeMlyny.git
cd CoffeeMlyny/coffe-mlyny
composer install
cp .env.example .env
php artisan key:generate
npm install
npm run build
```

## 🛠️ Konfigurácia databázy

Uprav `.env` súbor:

```env
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

## 🗃️ Migrácie a seedery

```bash
php artisan migrate --seed
```

## 🔗 Symlink pre obrázky

```bash
php artisan storage:link
```

## 🚀 Spustenie servera

```bash
php artisan serve
```

Otvor v prehliadači: `http://localhost:8000`
