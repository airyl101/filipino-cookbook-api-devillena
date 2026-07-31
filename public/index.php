<?php

// Load the required files from Composer
require __DIR__ . '/../vendor/autoload.php';

// Load configuration
$config = require __DIR__ . '/../config.php';

// Import the classes needed for Slim
use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


// Create the Slim app
$app = AppFactory::create();

// Allows the API to receive JSON data from requests
$app->addBodyParsingMiddleware();

// Set the base folder where the API is located
$app->setBasePath('/filipino-cookbook-api/public');

// Enable the routing feature of Slim
$app->addRoutingMiddleware();

// Shows detailed errors while developing the API
$app->addErrorMiddleware(true, true, true);


// ==============================
// DATABASE CONNECTION
// ==============================

try {

    // Connect to the MySQL database
    $pdo = new PDO(
    "mysql:host={$config['db']['host']};dbname={$config['db']['database']};charset={$config['db']['charset']}",
    $config['db']['username'],
    $config['db']['password']
    );

    // Show database errors if there are problems
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    // Stop the program if the database connection fails
    die("Database Connection Failed: " . $e->getMessage());
}


// ==============================
// API TOKEN
// ==============================

// Token used to protect the API routes
$TOKEN = $config['api_token'];


// ==============================
// AUTHENTICATION MIDDLEWARE
// ==============================

$buildJsonResponse = function (Response $response, $payload, int $status = 200): Response {
    $response->getBody()->write(json_encode($payload));

    return $response
        ->withStatus($status)
        ->withHeader('Content-Type', 'application/json');
};

$validatePositiveInteger = function ($value, string $fieldName) {
    if (!is_numeric($value) || (int)$value <= 0 || (string)(int)$value !== (string)$value) {
        return "$fieldName must be a positive integer.";
    }

    return null;
};

$validateRequiredString = function ($value, string $fieldName, int $maxLength = 255) {
    if (!is_string($value) || trim($value) === '') {
        return "$fieldName is required.";
    }

    $trimmed = trim($value);
    if (mb_strlen($trimmed) > $maxLength) {
        return "$fieldName must be at most $maxLength characters.";
    }

    return null;
};

$validateIngredientIds = function ($value) {
    if (!is_array($value) || count($value) === 0) {
        return 'ingredient_ids must be a non-empty array.';
    }

    foreach ($value as $ingredientId) {
        if (!is_numeric($ingredientId) || (int)$ingredientId <= 0) {
            return 'ingredient_ids must contain only positive integers.';
        }
    }

    return null;
};

// Checks if the user has the correct API token
$authMiddleware = function (Request $request, $handler) use ($TOKEN) {

    // Get the token from the request header
    $header = $request->getHeaderLine('Authorization');


    // Check if the token is valid
    if ($header !== "Bearer " . $TOKEN) {

        // Create an error response for unauthorized users
        $response = new Slim\Psr7\Response();

        $response->getBody()->write(json_encode([
            "status" => "error",
            "message" => "Unauthorized access. Valid API token is required."
        ]));

        return $response
            ->withStatus(401)
            ->withHeader('Content-Type', 'application/json');
    }


    // Continue if the token is correct
    return $handler->handle($request);
};

// ==============================
// PUBLIC WELCOME ROUTE
// ==============================

// Default route to check if the API is running
$app->get('/', function (Request $request, Response $response) {

    // Return a welcome message in JSON format
    $response->getBody()->write(json_encode([
        "message" => "Welcome to the Secured Filipino Cookbook API",
        "note" => "Use a valid Bearer token to access /api endpoints."
    ]));

    // Set response format as JSON
    return $response->withHeader('Content-Type', 'application/json');
});


// ==============================
// GET ALL FOODS
// ==============================

// Get all foods with their category, origin, and ingredients
// Requires a valid API token
$app->get('/api/foods', function (Request $request, Response $response) use ($pdo) {

    // Get food details together with category and origin information
    $sql = "
        SELECT
            f.food_id,
            f.food_name,
            c.category_name,
            o.origin_name,
            f.instructions
        FROM foods f
        JOIN categories c ON f.category_id = c.category_id
        JOIN origins o ON f.origin_id = o.origin_id
    ";

    // Run the query
    $stmt = $pdo->query($sql);

    // Store all food records
    $foods = $stmt->fetchAll(PDO::FETCH_ASSOC);


    // Get ingredients for each food
    foreach ($foods as &$food) {

        $ingredientSQL = "
            SELECT i.ingredient_name
            FROM food_ingredients fi
            JOIN ingredients i
                ON fi.ingredient_id = i.ingredient_id
            WHERE fi.food_id = ?
        ";

        // Prepare and run the ingredient query
        $ingredientStmt = $pdo->prepare($ingredientSQL);
        $ingredientStmt->execute([$food['food_id']]);


        // Add ingredients to the food information
        $food['ingredients'] =
            $ingredientStmt->fetchAll(PDO::FETCH_COLUMN);
    }


    // Return all foods as JSON
    $response->getBody()->write(json_encode($foods));

    return $response->withHeader('Content-Type', 'application/json');

})->add($authMiddleware);


// ==============================
// SEARCH FOOD BY NAME
// ==============================

// Search foods using the food name
// Requires a valid API token
$app->get('/api/foods/search/{name}', function (Request $request, Response $response, $args) use ($pdo, $buildJsonResponse, $validateRequiredString) {

    // Get the search keyword from the URL
    $name = $args['name'];
    $nameError = $validateRequiredString($name, 'name', 100);

    if ($nameError) {
        return $buildJsonResponse($response, [
            "status" => "error",
            "message" => $nameError
        ], 400);
    }

    // Find foods that contain the given keyword
    $sql = "
        SELECT
            f.food_id,
            f.food_name,
            c.category_name,
            o.origin_name,
            f.instructions
        FROM foods f
        JOIN categories c ON f.category_id = c.category_id
        JOIN origins o ON f.origin_id = o.origin_id
        WHERE f.food_name LIKE ?
    ";

    $stmt = $pdo->prepare($sql);

    // Search using partial matching
    $stmt->execute(["%$name%"]);


    // Store the search results
    $foods = $stmt->fetchAll(PDO::FETCH_ASSOC);


    // Get ingredients for each result
    foreach ($foods as &$food) {

        $ingredientSQL = "
            SELECT i.ingredient_name
            FROM food_ingredients fi
            JOIN ingredients i
                ON fi.ingredient_id = i.ingredient_id
            WHERE fi.food_id = ?
        ";


        $ingredientStmt = $pdo->prepare($ingredientSQL);
        $ingredientStmt->execute([$food['food_id']]);


        $food['ingredients'] =
            $ingredientStmt->fetchAll(PDO::FETCH_COLUMN);
    }


    // Return the matching foods
    return $buildJsonResponse($response, $foods);

})->add($authMiddleware);

// ==============================
// GET FOOD BY ID
// ==============================

// Get a specific food using its ID
// Requires a valid API token
$app->get('/api/foods/random', function (Request $request, Response $response) use ($pdo, $buildJsonResponse) {

    $sql = "
        SELECT
            f.food_id,
            f.food_name,
            c.category_name,
            o.origin_name,
            f.instructions
        FROM foods f
        JOIN categories c ON f.category_id = c.category_id
        JOIN origins o ON f.origin_id = o.origin_id
        ORDER BY RAND()
        LIMIT 1
    ";

    $stmt = $pdo->query($sql);
    $food = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$food) {
        return $buildJsonResponse($response, [
            "status" => "error",
            "message" => "No food found"
        ], 404);
    }

    $ingredientSQL = "
        SELECT i.ingredient_name
        FROM food_ingredients fi
        JOIN ingredients i
            ON fi.ingredient_id = i.ingredient_id
        WHERE fi.food_id = ?
    ";

    $ingredientStmt = $pdo->prepare($ingredientSQL);
    $ingredientStmt->execute([$food['food_id']]);
    $food['ingredients'] = $ingredientStmt->fetchAll(PDO::FETCH_COLUMN);

    return $buildJsonResponse($response, $food);

})->add($authMiddleware);

$app->get('/api/foods/{id}', function (Request $request, Response $response, $args) use ($pdo, $buildJsonResponse, $validatePositiveInteger) {

    // Get the food ID from the URL
    $id = $args['id'];
    $idError = $validatePositiveInteger($id, 'id');

    if ($idError) {
        return $buildJsonResponse($response, [
            "status" => "error",
            "message" => $idError
        ], 400);
    }

    // Find the food with its category and origin
    $sql = "
        SELECT
            f.food_id,
            f.food_name,
            c.category_name,
            o.origin_name,
            f.instructions
        FROM foods f
        JOIN categories c ON f.category_id = c.category_id
        JOIN origins o ON f.origin_id = o.origin_id
        WHERE f.food_id = ?
    ";


    // Run the query using the given ID
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    $food = $stmt->fetch(PDO::FETCH_ASSOC);


    // Check if the food exists
    if (!$food) {

        return $buildJsonResponse($response, [
            "status" => "error",
            "message" => "Food not found"
        ], 404);
    }


    // Get the ingredients of the selected food
    $ingredientSQL = "
        SELECT i.ingredient_name
        FROM food_ingredients fi
        JOIN ingredients i
            ON fi.ingredient_id = i.ingredient_id
        WHERE fi.food_id = ?
    ";


    $ingredientStmt = $pdo->prepare($ingredientSQL);
    $ingredientStmt->execute([$id]);


    // Add ingredients to the food details
    $food['ingredients'] = $ingredientStmt->fetchAll(PDO::FETCH_COLUMN);


    // Return the food information as JSON
    return $buildJsonResponse($response, $food);

})->add($authMiddleware);


// ==============================
// GET ALL INGREDIENTS
// ==============================

// Get all ingredients stored in the database
// Requires a valid API token
$app->get('/api/ingredients', function (Request $request, Response $response) use ($pdo) {

    // Get all records from the ingredients table
    $stmt = $pdo->query("SELECT * FROM ingredients");

    // Store the ingredients data
    $ingredients = $stmt->fetchAll(PDO::FETCH_ASSOC);


    // Return ingredients as JSON
    $response->getBody()->write(json_encode($ingredients));

    return $response->withHeader('Content-Type', 'application/json');

})->add($authMiddleware);


// ==============================
// GET CATEGORY SUMMARY
// ==============================

$app->get('/api/categories/summary', function (Request $request, Response $response) use ($pdo, $buildJsonResponse) {

    $sql = "
        SELECT
            c.category_id,
            c.category_name,
            COUNT(f.food_id) AS food_count
        FROM categories c
        LEFT JOIN foods f ON f.category_id = c.category_id
        GROUP BY c.category_id, c.category_name
        ORDER BY c.category_name
    ";

    $stmt = $pdo->query($sql);
    $summary = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $buildJsonResponse($response, $summary);

})->add($authMiddleware);

// ==============================
// GET ALL CATEGORIES
// ==============================

// Get all food categories from the database
// Requires a valid API token
$app->get('/api/categories', function (Request $request, Response $response) use ($pdo, $buildJsonResponse) {

    // Get all records from the categories table
    $stmt = $pdo->query("SELECT * FROM categories");


    // Store the category data
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);


    // Return categories as JSON
    return $buildJsonResponse($response, $categories);

})->add($authMiddleware);


// ==============================
// ADD NEW FOOD
// ==============================

// Add a new food together with its ingredients
// Requires a valid API token
$app->post('/api/foods', function (Request $request, Response $response) use ($pdo, $buildJsonResponse, $validateRequiredString, $validatePositiveInteger, $validateIngredientIds) {


    // Get the data sent from the client
    $data = $request->getParsedBody();

    if (!is_array($data)) {
        $body = $request->getBody();
        $body->rewind();
        $rawBody = $body->getContents();
        $decodedBody = json_decode($rawBody, true);

        if (is_array($decodedBody)) {
            $data = $decodedBody;
        } else {
            $data = [];
        }
    }

    if (!is_array($data)) {
        $data = [];
    }

    $errors = [];
    $foodNameError = $validateRequiredString($data['food_name'] ?? null, 'food_name', 100);
    $categoryError = $validatePositiveInteger($data['category_id'] ?? null, 'category_id');
    $originError = $validatePositiveInteger($data['origin_id'] ?? null, 'origin_id');
    $instructionsError = $validateRequiredString($data['instructions'] ?? null, 'instructions', 1000);
    $ingredientError = $validateIngredientIds($data['ingredient_ids'] ?? null);

    if ($foodNameError) {
        $errors[] = $foodNameError;
    }
    if ($categoryError) {
        $errors[] = $categoryError;
    }
    if ($originError) {
        $errors[] = $originError;
    }
    if ($instructionsError) {
        $errors[] = $instructionsError;
    }
    if ($ingredientError) {
        $errors[] = $ingredientError;
    }

    if (!empty($errors)) {
        return $buildJsonResponse($response, [
            "status" => "error",
            "message" => "Validation failed.",
            "errors" => $errors
        ], 400);
    }


    // Insert the new food information into the foods table
    $sql = "INSERT INTO foods (food_name, category_id, origin_id, instructions)
            VALUES (?, ?, ?, ?)";


    // Prepare the SQL statement
    $stmt = $pdo->prepare($sql);


    // Save the food details received from the request
    $stmt->execute([
        $data['food_name'],
        $data['category_id'],
        $data['origin_id'],
        $data['instructions']
    ]);


    // Get the ID of the newly added food
    $foodId = $pdo->lastInsertId();

    // Save the ingredients connected to the new food
    foreach ($data['ingredient_ids'] as $ingredientId) {


        // Insert the food and ingredient relationship
        $ingredientStmt = $pdo->prepare(
            "INSERT INTO food_ingredients (food_id, ingredient_id)
             VALUES (?, ?)"
        );


        // Save each selected ingredient
        $ingredientStmt->execute([
            $foodId,
            $ingredientId
        ]);
    }

    // Send a success response after adding the food
    return $buildJsonResponse($response, [
        "status" => "success",
        "message" => "Food added successfully."
    ], 201);

})->add($authMiddleware);

// Start the API
$app->run();