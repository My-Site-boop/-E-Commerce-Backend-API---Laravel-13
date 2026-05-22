# E-Commerce Backend API - Laravel 13

## Features
- Laravel Sanctum Authentication
- Product CRUD
- Category CRUD with nested category support
- Order Management
- Stock deduction
- Dashboard API
- Search, filter, pagination
- Image upload
- API Resource responses
- Form Request validation

## Setup

``bash
- git clone YOUR_REPO_URL
- cd ecommerce-api
- composer install
- cp .env.example .env
- php artisan key:generate
- php artisan migrate --seed
- php artisan storage:link
- php artisan serve

## API Base URL
 http://127.0.0.1:8000/api

## Authentication

Use Bearer Token from login API.

## Main APIs
# Auth
- POST /api/register
- POST /api/login
- POST /api/logout

 # Products
- GET /api/products
- POST /api/products
- GET /api/products/{id}
- PUT /api/products/{id}
- DELETE /api/products/{id}

# Categories
- GET /api/categories
- POST /api/categories
- PUT /api/categories/{id}
- DELETE /api/categories/{id}

# Orders
- POST /api/orders
- GET /api/orders
- GET /api/orders/{id}

# Dashboard
- GET /api/dashboard
