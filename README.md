# Laravel Product Auction System

This is a Laravel-based auction platform that allows users to list products for bidding, manage live auctions via Pusher, and schedule periodic tasks using Laravel Scheduler.

---

## 📦 Setup Instructions

### 1. Clone the Repository

```bash
git clone https://github.com/your-repo.git
cd your-repo
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node Dependencies

```bash
npm install
```

### 4. Build Frontend Assets

```bash
npm run dev
```

> You can use `npm run build` for production.

### 5. Configure Environment File

Copy the `.env.example` file and set the necessary environment variables:

```bash
cp .env.example .env
php artisan key:generate
```

Update your `.env` with database and broadcasting config:

```env
APP_NAME=LaravelAuction
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db
DB_USERNAME=your_user
DB_PASSWORD=your_password

BROADCAST_DRIVER=pusher

PUSHER_APP_ID=2023472
PUSHER_APP_KEY=43252690d0e0f2445890
PUSHER_APP_SECRET=5680bb69a71ae309756c
PUSHER_APP_CLUSTER=ap2
```

---

## 💃🏻 Database Setup

### Run Migrations

```bash
php artisan migrate
```

### Seed Initial Data

```bash
php artisan db:seed
```

> Seeds include product statuses and demo data for testing.

---

## ⏱️ Task Scheduling

To enable Laravel's task scheduling, set the following cron job:

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

> This runs Laravel’s scheduler every minute. Use it for things like auto-ending auctions or sending notifications.

---

## 📡 Broadcasting with Pusher

The system uses **Pusher** for real-time broadcasting (e.g., live bidding updates). Ensure your `.env` is configured correctly as shown above.

You’ll also need to set this in `config/broadcasting.php`:

```php
'pusher' => [
    'driver' => 'pusher',
    'key' => env('PUSHER_APP_KEY'),
    'secret' => env('PUSHER_APP_SECRET'),
    'app_id' => env('PUSHER_APP_ID'),
    'options' => [
        'cluster' => env('PUSHER_APP_CLUSTER'),
        'useTLS' => true,
    ],
],
```

---

## 🧠 Architecture Decisions

- **Laravel** handles MVC, RESTful APIs, and scheduling.
- **DataTables.js** for dynamic product listing.
- **jQuery & AJAX** for CRUD operations in modals.
- **Bootstrap modal** for add/edit forms.
- **Pusher** enables real-time features (e.g., bidding updates).
- **Laravel Scheduler** used for time-based auction events.

---

## 🔧 Local Development

### Run Local Server

```bash
php artisan serve
```

### Run Webpack Dev Server

```bash
npm run dev
```

---

## ✅ Features

- Live Product Listings
- Modal-based Product Creation/Editing
- Soft Delete and Real-time UI Updates
- Real-time Broadcast (via Pusher)
- Task Scheduling for Auction Lifecycle

---

## 🙋‍♂️ Questions?

Please raise an issue or reach out via email if you encounter any problems setting it up.

