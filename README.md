
# CoffeeMlyny – Laravel Setup

## 🧩 Požiadavky

- PHP >= 8.1  
- Composer  
- PostgreSQL
- Laravel >= 12

---

## ⚙️ Inštalácia projektu

```bash
git clone git@github.com:RadoslavMuntag/CoffeeMlyny.git
cd CoffeeMlyny/coffe-mlyny
composer install
cp .env.example .env
php artisan key:generate
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
