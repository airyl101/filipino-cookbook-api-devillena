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
- XAMPP
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
| GET | `/api/foods` | Retrieve all foods |
| GET | `/api/foods/{id}` | Retrieve a food by ID |
| GET | `/api/foods/search/{name}` | Search foods |
| GET | `/api/categories` | Retrieve all categories |
| GET | `/api/ingredients` | Retrieve all ingredients |
| POST | `/api/foods` | Add a new food |

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

### GET `/api/categories/summary`

Returns the number of foods under each category.

### GET `/api/foods/random`

Returns one randomly selected Filipino food.

## Security Features Implemented

Input Validation

The API validates:

- Required request fields
- Numeric IDs
- Empty input values

This prevents invalid requests from being processed.

## Instructions for Testing the Enhancement

1. Start Apache and MySQL.
2. Run:

```bash
composer install
```

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

# Screenshots of Successful Endpoint Testing

Include screenshots showing:

- GET `/api/foods`
- GET `/api/foods/{id}`
- GET `/api/foods/search/{name}`
- GET `/api/categories`
- GET `/api/ingredients`
- POST `/api/foods`
- GET `/api/categories/summary`
- GET `/api/foods/random`
- Input validation error
- Unauthorized access (optional)

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
- Confirm no sensitive information is uploaded
- Verify installation instructions are complete

---

## Author

**Airyl Rhyn R. Devillena**

Bachelor of Science in Information Technology

Don Mariano Marcos Memorial State University

---

## License

This project was developed for educational purposes as part of the API Development laboratory activities.