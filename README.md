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
| Method | Endpoint                                                                          | Description                |
| ------ | ----------------------- | -------------------------- |
| GET    | `/api/v1/product/index`                                                           | List products |
| GET    | `/api/v1/product/index?type=simple&name=iPhone&min_price=100&max_price=1500`      | List products with filters |

| GET    | `/api/v1/product/show/{id}`                                                       | Show single product        |
| POST   | `/api/v1/product/store`                                                           | Create new product         |
| PUT    | `/api/v1/product/update/{id}`                                                      | Update existing product    |
| DELETE | `/api/v1/product/destroy/{id}`                                                    | Delete product             |

Filtering Parameters (GET /products)

| Parameter   | Example  | Description                           |
| ----------- | -------- | ------------------------------------- |
| `type`      | `simple` | Filter by product type                |
| `name`      | `iphone` | Partial match on name in `en` or `ar` |
| `min_price` | `500`    | Minimum price                         |
| `max_price` | `1000`   | Maximum price                         |

## 🧪 Postman
1- GET URL/api/v1/product/index
2- GET URL/api/v1/product/index?type=simple&name=iPhone&min_price=100&max_price=1500
3- POST URL/api/v1/product/store
{
  "type": "simple",
  "name": {
    "en": "iPhone 15",
    "ar": "آيفون 15"
  },
  "price": 999,
  "original_price": 1199,
  "is_featured": true,
  "ai_suggested": true
}
//////////////////////////
{
  "type": "variable",
  "name": {
    "en": "Running Shoes",
    "ar": "أحذية جري"
  },
  "discount": 100,
  "image": "https://via.placeholder.com/300",
  "is_featured": false,
  "ai_suggested": true,
  "variations": [
    {
      "price": 120,
      "variations": { "size": 42, "color": "Black" }
    },
    {
      "price": 130,
      "variations": { "size": 43, "color": "White" }
    }
  ]
}
4- GET URL/api/v1/product/show/1
5- PUT URL/api/v1/product/update/1
{
  "type": "simple",
  "name": {
    "en": "MacBook Pro",
    "ar": "ماك بوك برو"
  },
  "price": 2000,
  "original_price": 2500,
  "discount": 500,
  "image": "https://via.placeholder.com/300",
  "is_featured": true,
  "ai_suggested": false
}
//////////////////////////////////
{
  "type": "variable",
  "name": {
    "en": "Running Shoes",
    "ar": "أحذية جري"
  },
  "discount": 100,
  "image": "https://via.placeholder.com/300",
  "is_featured": false,
  "ai_suggested": true,
  "variations": [
    {
      "price": 120,
      "variations": { "size": 42, "color": "Black" }
    },
    {
      "price": 130,
      "variations": { "size": 43, "color": "White" }
    }
  ]
}
6- DELETE URL/api/v1/product/destroy/1
