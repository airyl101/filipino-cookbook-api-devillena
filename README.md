# Filipino Cookbook API

## Description

The Filipino Cookbook API is a RESTful API developed using PHP, Slim Framework, and MySQL. It provides JSON data about Filipino foods, food categories, ingredients, and food origins. The API demonstrates RESTful web service development with token-based authentication and is intended for educational purposes.

---

## Repository Information

**Repository Name**

```
filipino-cookbook-api-devillena
```

**Repository Description**

A RESTful Filipino Cookbook API developed using PHP, Slim Framework, and MySQL for API Development laboratory activities.

---

## Features

- Retrieve all Filipino foods
- Retrieve a specific food by ID
- Search foods by name
- Retrieve all food categories
- Retrieve all ingredients
- Add a new food with ingredients
- Token-based authentication
- JSON responses
- Category summary endpoint
- Random Filipino food endpoint
- Input validation for requests

---

## Technologies Used

- PHP 8.x
- Slim Framework
- MySQL
- Composer
- JSON
- Apache
- XAMPP
- Thunder Client
- Git
- GitHub

---

## Repository Contents

This repository contains:

- Complete Filipino Cookbook API source code
- SQL database file (`filipino_cookbook_api.sql`)
- `composer.json`
- `composer.lock`
- API routes
- Database connection files
- Authentication and security files
- Configuration instructions
- `.gitignore`
- `README.md`

---

## Project Structure

```text
filipino-cookbook-api-devillena/
│── public/
│   ├── index.php
│   └── .htaccess
│── composer.json
│── composer.lock
│── filipino_cookbook_api.sql
│── config.example.php
│── README.md
│── .gitignore
```

> **Note:** The `vendor` folder should not be uploaded to GitHub. Run `composer install` after cloning the repository.

---

# Installation Guide

### 1. Clone the repository

```bash
git clone https://github.com/airyl101/filipino-cookbook-api-devillena.git
```

### 2. Open the project folder

```bash
cd filipino-cookbook-api-devillena
```

### 3. Install Composer dependencies

```bash
composer install
```

### 4. Import the database

Import

```
filipino_cookbook_api.sql
```

into your MySQL server.

### 5. Create the configuration file

Copy

```
config.example.php
```

Rename it to

```
config.php
```

Update the values:

```php
<?php

$dbHost = "localhost";
$dbName = "filipino_cookbook_api";
$dbUser = "root";
$dbPass = "";
```

### 6. Start XAMPP

Start:

- Apache
- MySQL

### 7. Access the API

```
http://localhost/filipino-cookbook-api/public
```

---

# Configuration Instructions

Example configuration:

```php
<?php

$dbHost = "localhost";
$dbName = "filipino_cookbook_api";
$dbUser = "YOUR_DATABASE_USERNAME";
$dbPass = "YOUR_DATABASE_PASSWORD";
```

The actual `config.php` should **not** be uploaded.

Only upload:

```
config.example.php
```

---

# Security

The API uses:

- Bearer Token Authentication
- Input Validation
- Prepared Statements (PDO)

---

# API Endpoints

| Method | Endpoint | Description |
|---------|----------|-------------|
| GET | `/api/foods` | Retrieve all Filipino foods |
| GET | `/api/foods/{id}` | Retrieve a specific Filipino food by ID |
| GET | `/api/foods/search/{name}` | Search Filipino foods by name |
| GET | `/api/categories` | Retrieve all food categories |
| GET | `/api/ingredients` | Retrieve all ingredients |
| POST | `/api/foods` | Add a new Filipino food |
| GET | `/api/categories/summary` | Retrieve the number of foods under each category |
| GET | `/api/foods/random` | Retrieve a randomly selected Filipino food |

---

# API Documentation

## API Title

**Filipino Cookbook API**

---

## API Description

The Filipino Cookbook API is a RESTful API developed using PHP, Slim Framework, and MySQL. It provides JSON-formatted information about Filipino foods, categories, ingredients, and food origins. The API is intended for students and developers who want to learn RESTful API development and integrate cookbook data into their own applications.

### Purpose of the API

- Provide Filipino cookbook information through RESTful API endpoints.
- Demonstrate RESTful API development using PHP and Slim Framework.

### Type of Information Provided

- Filipino foods
- Food categories
- Food origins
- Food ingredients

### Intended Users

- Students
- Developers
- API consumers

### Main Functions

- Retrieve all Filipino foods
- Retrieve food details by ID
- Search foods by name
- Retrieve food categories
- Retrieve ingredients
- Add new food records
- Authenticate API requests
- Return JSON responses

---

## Database Setup

### Database Name

```
filipino_cookbook_api
```

### SQL File

```
filipino_cookbook_api.sql
```

### Tables

- foods
- categories
- origins
- ingredients
- food_ingredients

### Table Relationships

```
categories --> foods <-- origins
                  |
                  |
          food_ingredients
                  |
                  |
            ingredients
```

Import the SQL file into MySQL before running the API.

---

## Base URL

```
http://localhost/filipino-cookbook-api/public/api
```

---

## Authentication Instructions

This API uses **Bearer Token Authentication**.

### Required Header

```
Authorization: Bearer dmmmsu-cookbook-token-2026
```

### Accept Header

```
Accept: application/json
```

If the token is missing or invalid, the API returns:

```json
{
    "status": "error",
    "message": "Unauthorized access. Valid API token is required."
}
```

---

## Endpoint Documentation

### GET /api/foods

**Description**

Returns all Filipino foods stored in the database.

**Required Headers**

```
Authorization: Bearer dmmmsu-cookbook-token-2026
Accept: application/json
```

**Example Request**

```
GET http://localhost/filipino-cookbook-api/public/api/foods
```

**Example Successful Response**

```json
[
    {
        "food_id": 1,
        "food_name": "Adobo",
        "category_name": "Main Dish",
        "origin_name": "Luzon"
    }
]
```

**Example Error Response**

```json
{
    "status": "error",
    "message": "Unauthorized access. Valid API token is required."
}
```

---

### GET /api/foods/{id}

Returns the details of a specific Filipino food.

**Example Request**

```
GET /api/foods/1
```

---

### GET /api/foods/search/{name}

Searches Filipino foods by name.

**Example Request**

```
GET /api/foods/search/adobo
```

---

### GET /api/categories

Returns all food categories.

**Example Request**

```
GET /api/categories
```

---

### GET /api/ingredients

Returns all ingredients.

**Example Request**

```
GET /api/ingredients
```

---

### POST /api/foods

Adds a new Filipino food.

**Required Headers**

```
Authorization: Bearer dmmmsu-cookbook-token-2026
Content-Type: application/json
```

**Example Request Body**

```json
{
    "food_name": "Sample Food",
    "category_id": 1,
    "origin_id": 1,
    "instructions": "Cook the ingredients.",
    "ingredient_ids": [1,2,3]
}
```

---

### GET /api/categories/summary

Returns the number of foods under each category.

---

### GET /api/foods/random

Returns one randomly selected Filipino food.

---

## HTTP Status Codes

| Status Code | Meaning |
|-------------|---------|
| 200 | Request completed successfully |
| 201 | Resource created successfully |
| 400 | Invalid request or parameter |
| 401 | Missing or invalid authentication |
| 403 | Access is not allowed |
| 404 | Requested resource was not found |
| 429 | Too many requests |
| 500 | Internal server error |

---

# Optional API Enhancements

## Description of the Enhancement

The API has been enhanced by adding two new endpoints and implementing input validation to improve both usability and security.

## Purpose of the Enhancement

- Display the number of foods available in each category.
- Return a randomly selected Filipino food.
- Validate user input before processing requests.

## Files Modified

- `public/index.php`
- `README.md`

## Endpoints Added

- GET `/api/categories/summary`
- GET `/api/foods/random`

## Security Features Implemented

- Input validation for required fields
- Validation for numeric IDs
- Validation for empty input values

## Instructions for Testing the Enhancement

1. Start Apache and MySQL.
2. Run `composer install`.
3. Import the SQL database.
4. Configure `config.php`.
5. Open Thunder Client or Postman.
6. Add the Authorization header:

```
Authorization: Bearer dmmmsu-cookbook-token-2026
```

7. Test:

```
GET /api/categories/summary
```

8. Test:

```
GET /api/foods/random
```

9. Test the input validation by submitting invalid data to:

```
POST /api/foods
```

The API should return an appropriate error message.

---

# Testing Evidence

Include screenshots showing:

- GET `/api/foods`
- GET `/api/foods/{id}`
- GET `/api/foods/search/{name}`
- GET `/api/categories`
- GET `/api/ingredients`
- POST `/api/foods`
- GET `/api/categories/summary`
- GET `/api/foods/random`
- Input validation error (400 Bad Request)
- Unauthorized access (401 Unauthorized)

Add a short caption below each screenshot describing the result.

---

# Repository Verification Checklist

After cloning the repository:

- Clone or download the repository
- Run `composer install`
- Import the SQL database
- Configure `config.php`
- Start Apache and MySQL
- Run the API
- Test all endpoints
- Verify JSON responses
- Confirm no sensitive information was uploaded
- Verify installation instructions are complete
- Confirm another student can install and use the API

---

## Developer Information

**Student Name:** Airyl Rhyn R. Devillena

**Course:** Bachelor of Science in Information Technology

**University:** Don Mariano Marcos Memorial State University

**GitHub Username:** airyl101

**Repository:** https://github.com/airyl101/filipino-cookbook-api-devillena

**Date Completed:** July 31, 2026

---

## License

This project was developed for educational purposes as part of the API Development laboratory activities.