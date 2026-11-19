# Patel Offset — Printing E-commerce Website

Laravel 12 website for an offset & digital printing business: product catalog with quantity-based pricing,
design file upload, cart & checkout with **Razorpay**, order tracking, inquiry/quote forms, click-to-call /
email / WhatsApp buttons, and an admin panel (orders, inquiries, products, categories).

## Requirements
- PHP 8.2+ (with `pdo_mysql`, `mbstring`, `openssl`, `curl`, `fileinfo`)
- Composer
- MySQL 8 / MariaDB

## Setup

```bash
git clone https://github.com/kishansejani/pateloffset.git
cd pateloffset
composer install
cp .env.example .env
php artisan key:generate
```

Edit `.env`:

```env
APP_NAME="Patel Offset"
APP_URL=http://pateloffset.test

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pateloffset
DB_USERNAME=root
DB_PASSWORD=

# Site contact details (used for call / email / WhatsApp buttons)
SITE_PHONE="+919876543210"
SITE_WHATSAPP="919876543210"
SITE_EMAIL="info@pateloffset.com"
SITE_ADDRESS="Patel Offset, Main Road, Gujarat, INDIA"
SITE_HOURS="Mon - Sat : 9:30 AM - 8:00 PM"

# Razorpay — https://dashboard.razorpay.com/app/keys
RAZORPAY_KEY=
RAZORPAY_SECRET=

ADMIN_EMAIL=admin@pateloffset.com
ADMIN_PASSWORD=change-me
```

### Database — choose one

**A. Import the included dump** (catalog, reviews, admin user):

```bash
mysql -u root -p -e "CREATE DATABASE pateloffset CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
mysql -u root -p pateloffset < database/pateloffset.sql
```
(or import `database/pateloffset.sql` through phpMyAdmin / MySQL Workbench)

**B. Fresh install from migrations + seed data:**

```bash
php artisan migrate --seed
```

Then:

```bash
php artisan storage:link
php artisan serve
```

## Admin panel
`/admin` — login with `ADMIN_EMAIL` / `ADMIN_PASSWORD` from `.env` (when seeding).
**Change the admin password before going live.**

## Razorpay test payments
With `rzp_test_` keys use an Indian test card: `5267 3181 8797 5449`, any future expiry, any CVV, OTP `1234`.

## Shared hosting (InfinityFree etc.)
See `deploy/infinityfree/` — root `.htaccess` + `index.php` that route requests into `public/`,
and `env-production.txt` with the settings for hosts without symlink support (`PUBLIC_DISK_ROOT=public/storage`).
