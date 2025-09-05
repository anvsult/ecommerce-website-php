# PHP E-Commerce Project 🛒

A Laravel-based E-Commerce application that allows users to browse products, add them to a cart, and manage orders. This project demonstrates a full-stack web app with user authentication, admin management, and a responsive UI.

---

## 🎥 Video Showcase

Check out a video walkthrough of the project here: [YouTube Video Link](https://www.youtube.com/watch?v=ntgppRco2U4)

---

## 💻 Prerequisites

Make sure you have the following installed:

- PHP >= 8.1
- Composer
- MySQL (or another supported DB)
- Node.js & npm

---

## 🚀 Getting Started

### 1. Clone the repository

```bash
git clone https://github.com/anvsult/php-final-project-ecommerce
cd PHP_ECommerce_FinalProject
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Copy the environment file

```bash
cp .env.example .env
```

### 4. Generate the Laravel application key

```bash
php artisan key:generate
```

### 5. Configure your database

Open `.env` and set your database credentials:

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

Create the database if it doesn’t exist:

```sql
CREATE DATABASE ecommerce_db;
```

### 6. Run migrations

```bash
php artisan migrate
```

Seed the database with sample data:

```bash
php artisan db:seed
```

Or reset and seed fresh:

```bash
php artisan migrate:fresh --seed
```

### 7. Clear caches

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### 8. Run the local development server

```bash
php artisan serve
```

Open your browser and visit:\
[http://127.0.0.1:8000](http://127.0.0.1:8000)

Enjoy!
