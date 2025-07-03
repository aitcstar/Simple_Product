# 📦 Laravel Product API

This is a Laravel-based RESTful API for managing products with support for variations, filtering, validation, and error handling.

---

## 🛠️ Setup Instructions

1. Clone the repository or unzip the project.
2. Install dependencies:

```bash
composer install
php artisan migrate
php artisan db:seed --class=ProductSeeder 
