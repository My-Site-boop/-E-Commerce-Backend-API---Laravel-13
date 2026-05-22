# API Documentation

## Register
POST /api/register

Body:
```json
{
  "name": "Ritik",
  "email": "ritik@gmail.com",
  "password": "123456"
}

## Login
POST /api/login

Body:
```json
{
  "email": "ritik@gmail.com",
  "password": "123456"
}

## Create Categories
POST /api/categories

Auth: Bearer Token
Body:
```json
{
  "parent_id": null,
  "name": "Mobiles",
  "slug": "mobiles",
  "status": 1
}

## Create Product
POST /api/product

Auth: Bearer Token
Body:
```json
{
category_id: 1
name: iPhone 15
slug: iphone-15
sku: IPHONE15
description: Apple smartphone
price: 70000
discount_price: 65000
stock_quantity: 10
status: 1
images[]: file
}

## Place Order

POST /api/orders

Auth: Bearer Token

Body:

{
  "items": [
    {
      "product_id": 1,
      "quantity": 2
    }
  ]
}

## Dashboard

GET /api/dashboard

Auth: Bearer Token
