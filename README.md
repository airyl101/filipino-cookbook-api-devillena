# Filipino Cookbook API

## Description

The Filipino Cookbook API is a RESTful API developed using PHP, Slim Framework, and MySQL. It provides JSON data about Filipino foods, categories, ingredients, and food origins. This API is designed for educational purposes and demonstrates RESTful API development using the Slim Framework.

---

## Features

- Retrieve Filipino foods
- Retrieve food categories
- Retrieve food origins
- Retrieve ingredients
- Return JSON responses
- Token-based authentication

---

## Technologies Used

- PHP
- Slim Framework
- MySQL
- Composer
- XAMPP
- Git
- GitHub

---

## Requirements

Before running the project, make sure you have:

- PHP 8.x
- Composer
- MySQL
- XAMPP (Apache and MySQL)

---

## Installation

1. Clone the repository:

```bash
git clone https://github.com/airyl101/filipino-cookbook-api-devillena.git
```

2. Go to the project directory:

```bash
cd filipino-cookbook-api-devillena
```

3. Install Composer dependencies:

```bash
composer install
```

4. Import the database:

```
filipino_cookbook_api.sql
```

into your MySQL database.

5. Configure your database connection if necessary.

6. Start Apache and MySQL using XAMPP.

7. Access the API:

```
http://localhost/filipino-cookbook-api/public
```

---

## API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/foods` | Retrieve all Filipino foods |
| GET | `/api/categories` | Retrieve all food categories |
| GET | `/api/origins` | Retrieve all food origins |
| GET | `/api/ingredients` | Retrieve all ingredients |

---

## Project Structure

```
filipino-cookbook-api-devillena/
│── public/
│   ├── index.php
│   └── .htaccess
│── composer.json
│── composer.lock
│── filipino_cookbook_api.sql
│── README.md
│── .gitignore
```

---

## Optional API Enhancements

### Description
This enhancement adds two new API endpoints for easier exploration of the dataset and improves request safety through input validation for new and existing routes.

### Purpose
- Provide quick insights into category distribution and random food discovery.
- Prevent malformed or unsafe requests from being processed by the API.

### Files modified
- public/index.php
- README.md

### Endpoints added
- GET /api/categories/summary
- GET /api/foods/random

### Security features implemented
- Validation for food_name, category_id, origin_id, instructions, and ingredient_ids on POST /api/foods.
- Validation for numeric ID values on GET /api/foods/{id}.
- Validation for search text on GET /api/foods/search/{name}.

### Instructions for testing the enhancement
1. Start Apache and MySQL in XAMPP.
2. Open the API in your browser or use curl.
3. Test the category summary endpoint:
   curl -i -H "Authorization: Bearer dmmmsu-cookbook-token-2026" http://localhost/filipino-cookbook-api/public/api/categories/summary
4. Test the random food endpoint:
   curl -i -H "Authorization: Bearer dmmmsu-cookbook-token-2026" http://localhost/filipino-cookbook-api/public/api/foods/random
5. Test input validation by sending invalid data to POST /api/foods.

### Screenshots of successful testing
- Category summary endpoint: [docs/images/categories-summary.svg](docs/images/categories-summary.svg)
- Random food endpoint: [docs/images/random-food.svg](docs/images/random-food.svg)

## Author

**Airyl Rhyn R. Devillena**

Bachelor of Science in Information Technology

Don Mariano Marcos Memorial State University

---

## License

This project is created for educational purposes.