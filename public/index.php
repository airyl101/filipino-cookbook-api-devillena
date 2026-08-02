<?php

// Load the required files from Composer
require __DIR__ . '/../vendor/autoload.php';

// Load the database configuration file
require __DIR__ . '/../config.php';

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
    "mysql:host=$dbHost;dbname=$dbName;charset=utf8",
    $dbUser,
    $dbPass
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
$TOKEN = "dmmmsu-cookbook-token-2026";


// ==============================
// AUTHENTICATION MIDDLEWARE
// ==============================

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

// ======================================================
// NEW API ENDPOINT #2
// Get a Randomly Selected Filipino Food
// ======================================================

$app->get('/api/foods/random', function (Request $request, Response $response) use ($pdo) {

    $sql = "
        SELECT
            f.food_id,
            f.food_name,
            c.category_name,
            o.origin_name,
            f.instructions
        FROM foods f
        JOIN categories c
            ON f.category_id = c.category_id
        JOIN origins o
            ON f.origin_id = o.origin_id
        ORDER BY RAND()
        LIMIT 1
    ";

    $stmt = $pdo->query($sql);

    $food = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($food) {

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

    $response->getBody()->write(json_encode($food));

    return $response->withHeader('Content-Type','application/json');

})->add($authMiddleware);

// ==============================
// SEARCH FOOD BY NAME
// ==============================

// Search foods using the food name
// Requires a valid API token
$app->get('/api/foods/search/{name}', function (Request $request, Response $response, $args) use ($pdo) {

    // Get the search keyword from the URL
    $name = $args['name'];

    // ======================================================
// PART 1 ENHANCEMENT - SECURITY FEATURE
// Input Validation
// ======================================================

// Check if the search text is empty
if (trim($name) === '') {

    $response->getBody()->write(json_encode([
        "status" => "error",
        "message" => "Search keyword cannot be empty."
    ]));

    return $response
        ->withStatus(400)
        ->withHeader('Content-Type', 'application/json');
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
    $response->getBody()->write(json_encode($foods));

    return $response->withHeader('Content-Type', 'application/json');

})->add($authMiddleware);


// ==============================
// GET FOOD BY ID
// ==============================

// Get a specific food using its ID
// Requires a valid API token
$app->get('/api/foods/{id:[0-9]+}', function (Request $request, Response $response, $args) use ($pdo) {

    // Get the food ID from the URL
    $id = $args['id'];

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

        $response->getBody()->write(json_encode([
            "status" => "error",
            "message" => "Food not found"
        ]));

        return $response
            ->withStatus(404)
            ->withHeader('Content-Type', 'application/json');
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
    $response->getBody()->write(json_encode($food));

    return $response->withHeader('Content-Type', 'application/json');

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
// GET ALL CATEGORIES
// ==============================

// Get all food categories from the database
// Requires a valid API token
$app->get('/api/categories', function (Request $request, Response $response) use ($pdo) {

    // Get all records from the categories table
    $stmt = $pdo->query("SELECT * FROM categories");


    // Store the category data
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);


    // Return categories as JSON
    $response->getBody()->write(json_encode($categories));


    return $response->withHeader('Content-Type', 'application/json');

})->add($authMiddleware);

// ======================================================
// NEW API ENDPOINT #1
// Get the Number of Foods Under Each Category
// ======================================================

$app->get('/api/categories/summary', function (Request $request, Response $response) use ($pdo) {

    $sql = "
        SELECT
            c.category_name,
            COUNT(f.food_id) AS total_foods
        FROM categories c
        LEFT JOIN foods f
            ON c.category_id = f.category_id
        GROUP BY c.category_id
        ORDER BY c.category_name
    ";

    $stmt = $pdo->query($sql);

    $summary = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response->getBody()->write(json_encode($summary));

    return $response->withHeader('Content-Type','application/json');

})->add($authMiddleware);


// ==============================
// ADD NEW FOOD
// ==============================

// Add a new food together with its ingredients
// Requires a valid API token
$app->post('/api/foods', function (Request $request, Response $response) use ($pdo) {


    // Get the data sent from the client
    $data = $request->getParsedBody();


    // ======================================================
    // PART 1 ENHANCEMENT - SECURITY FEATURE
    // Input Validation
    // ======================================================
    if (

        !isset($data['food_name']) ||
        trim($data['food_name']) === '' ||

        !isset($data['category_id']) ||
        !is_numeric($data['category_id']) ||

        !isset($data['origin_id']) ||
        !is_numeric($data['origin_id']) ||

        !isset($data['instructions']) ||
        trim($data['instructions']) === '' ||

        !isset($data['ingredient_ids']) ||
        !is_array($data['ingredient_ids']) ||
        count($data['ingredient_ids']) == 0

    ) {

        // Return an error if some information is missing
        $response->getBody()->write(json_encode([
            "status" => "error",
            "message" => "Missing required fields."
        ]));


        return $response
            ->withStatus(400)
            ->withHeader('Content-Type', 'application/json');
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
    $response->getBody()->write(json_encode([
        "status" => "success",
        "message" => "Food added successfully."
    ]));


    // Return status 201 because a new record was created
    return $response
        ->withStatus(201)
        ->withHeader('Content-Type', 'application/json');

})->add($authMiddleware);

// Start the API
$app->run();
