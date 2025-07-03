# 📦 Laravel Product API

A RESTful API built with Laravel to manage products and their variations, supporting multilingual names and filtering.

---


### 1. Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed --class=ProductSeeder 
php artisan serve


## 🧱 Database Structure

### `products` Table

| Column         | Type       | Description                                 |
|----------------|------------|---------------------------------------------|
| id             | int        | Primary key                                 |
| type           | enum       | `simple` or `variable`                      |
| name           | json       | Product name in multiple languages (`en`, `ar`) |
| price          | decimal    | Final price of product (nullable if variable) |
| original_price | decimal    | Original price before discount (nullable)   |
| discount       | decimal    | Discount value (nullable)                   |
| image          | string     | Path to product image (nullable)            |
| is_featured    | boolean    | Whether the product is featured (default: false) |
| ai_suggested   | boolean    | AI recommendation flag (default: false)     |
| timestamps     | timestamps | Created at / Updated at                     |

---

### `product_variations` Table

| Column     | Type     | Description                                   |
|------------|----------|-----------------------------------------------|
| id         | int      | Primary key                                   |
| product_id | int      | Foreign key to `products` (on delete cascade) |
| variations | string   | Description of variation (size/color/etc)     |
| price      | decimal  | Price for this variation                      |
| timestamps | -        | Created at / Updated at                       |

---

## 🧪 How to Test Endpoints


API Routes
| Method | Endpoint                | Description                |
| ------ | ----------------------- | -------------------------- |
| GET    | `/api/v1/product`      | List products with filters |
| GET    | `/api/v1/product/{id}` | Show single product        |
| POST   | `/api/v1/product`      | Create new product         |
| PUT    | `/api/v1/product/{id}` | Update existing product    |
| DELETE | `/api/v1/product/{id}` | Delete product             |

Filtering Parameters (GET /products)

| Parameter   | Example  | Description                           |
| ----------- | -------- | ------------------------------------- |
| `type`      | `simple` | Filter by product type                |
| `name`      | `iphone` | Partial match on name in `en` or `ar` |
| `min_price` | `500`    | Minimum price                         |
| `max_price` | `1000`   | Maximum price                         |
