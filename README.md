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
| GET | `/` | Display the API welcome message |
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

- Display the API welcome message
- Retrieve all Filipino foods
- Retrieve food details by ID
- Search foods by name
- Retrieve food categories
- Retrieve ingredients
- Add new food records
- Display the number of foods under each category
- Retrieve a randomly selected Filipino food
- Authenticate API requests
- Return JSON responses

-----

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

### GET /

**Description**

Displays the welcome message of the Filipino Cookbook API and confirms that the API is running.

**Example Request**

```
GET http://localhost/filipino-cookbook-api/public/
```

**Example Successful Response**

```json
{
    "message": "Welcome to the Secured Filipino Cookbook API",
    "note": "Use a valid Bearer token to access /api endpoints."
}
```

---

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

<img width="958" height="415" alt="get-foods" src="https://github.com/user-attachments/assets/fc7a9f4f-d36f-4a44-95b4-3745cafaa2ed" />

---

### GET /api/foods/{id}

Returns the details of a specific Filipino food.

**Example Request**

```
GET /api/foods/1
```

**Example Successful Response**
<img width="997" height="348" alt="get-food-by-id" src="https://github.com/user-attachments/assets/db65cc1c-728a-491f-a21a-ddb0b2f20387" />

---

### GET /api/foods/search/{name}

Searches Filipino foods by name.

**Example Request**

```
GET /api/foods/search/adobo
```

**Example Successful Response**
<img width="995" height="400" alt="get-food-by-name" src="https://github.com/user-attachments/assets/19740bbc-1bcd-401a-9683-e50c7e160c0e" />

---

### GET /api/categories

Returns all food categories.

**Example Request**

```
GET /api/categories
```

**Example Successful Response**
<img width="700" height="348" alt="categories" src="https://github.com/user-attachments/assets/d80ecf72-d5fa-4775-b20a-df7672ed7ab0" />

---

### GET /api/ingredients

Returns all ingredients.

**Example Request**

```
GET /api/ingredients
```

**Example Successful Response**
<img width="766" height="397" alt="ingredients" src="https://github.com/user-attachments/assets/e766bf47-6e45-4198-9c96-6a2003b349e9" />

---

### POST /api/foods

Adds a new Filipino food.

**Required Headers**

```
Authorization: Bearer dmmmsu-cookbook-token-2026
Content-Type: application/json
```

**Example Request**

```json
{
    "food_name": "Sample Food",
    "category_id": 1,
    "origin_id": 1,
    "instructions": "Cook the ingredients.",
    "ingredient_ids": [1,2,3]
}
```
**Example Successful Response**
<img width="897" height="832" alt="add-food-success" src="https://github.com/user-attachments/assets/e83bd464-613c-4953-a58e-eec6f88a584d" />

---

### GET /api/categories/summary

Returns the number of foods under each category.

**Example Request**

```
GET /api/categories/summary
```

**Example Successful Response**
<img width="927" height="412" alt="category-summary" src="https://github.com/user-attachments/assets/fe8757f6-97f1-485d-80e8-4a9a4a74e168" />

---

### GET /api/foods/random

Returns one randomly selected Filipino food.

**Example Request**

```
GET /api/foods/random
```

**Example Successful Response**
<img width="1063" height="406" alt="random-food" src="https://github.com/user-attachments/assets/a0f444ce-6023-4d41-901e-45ab8c4283c8" />

---

**Example Error Response**

```json
{
    "status": "error",
    "message": "Unauthorized access. Valid API token is required."
}
```
----

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

- GET `/`
   <img width="777" height="227" alt="public-welcome" src="https://github.com/user-attachments/assets/33892575-2c90-4e87-8077-2bf0a6fd389f" />
----

- GET `/api/foods`
    <img width="958" height="415" alt="get-foods" src="https://github.com/user-attachments/assets/52db657e-f251-4685-bad0-2f3c5f238c40" />
----

- GET `/api/foods/{id}`
    <img width="997" height="348" alt="get-food-by-id" src="https://github.com/user-attachments/assets/dbdf8123-635a-4f1f-8f18-ed812a0746f1" />
----

- GET `/api/foods/search/{name}`
    <img width="995" height="400" alt="get-food-by-name" src="https://github.com/user-attachments/assets/2f70fced-cfd7-4d64-8674-8e5c99bff0b4" />
----

- GET `/api/categories`
    <img width="700" height="348" alt="categories" src="https://github.com/user-attachments/assets/0fadb630-8959-404e-a76e-16da99be1226" />

----

- GET `/api/ingredients`
    <img width="766" height="397" alt="ingredients" src="https://github.com/user-attachments/assets/01b644d5-c4de-4f51-88d6-d8f578938180" />

----

- POST `/api/foods`
    <img width="897" height="832" alt="add-food-success" src="https://github.com/user-attachments/assets/6daf90df-cb8c-4b68-8e5a-6fe453b7716e" />

----

- GET `/api/categories/summary`
    <img width="927" height="412" alt="category-summary" src="https://github.com/user-attachments/assets/7b3d9578-67bc-42ab-81c3-d32e3b601406" />

----

- GET `/api/foods/random`
    <img width="1063" height="406" alt="random-food" src="https://github.com/user-attachments/assets/4c2d03d7-8915-4e09-ac63-aef341f21a92" />

----

- Input validation error (400 Bad Request)
    <img width="942" height="622" alt="validation-error" src="https://github.com/user-attachments/assets/9f4fc26e-a35b-42b6-98a5-a42a7ea1d273" />

----

- Unauthorized access (401 Unauthorized)
    <img width="896" height="257" alt="unauthorized" src="https://github.com/user-attachments/assets/9826803c-4ea0-4b41-a76f-c5c25943beb5" />

----

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
