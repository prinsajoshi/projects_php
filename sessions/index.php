<?php
require_once './controllers/CartControllers.php';

$requested_method = $_SERVER["REQUEST_METHOD"];
$data = json_decode(file_get_contents('php://input'), true);

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); // Correct key is REQUEST_URI
$path_segments = explode('/', trim($path, '/')); // Split URL by '/' to get segments

$controller = new CartControllers();

switch ($requested_method) {
    case "POST":
        if ($path_segments[0] == 'cart' && isset($path_segments[1])) {
            $userId = $path_segments[1];
            echo json_encode($controller->createCart($data, $userId));
        }
        break;
    
    case "GET":
        if ($path_segments[0] == 'cart') {
            // Get specific cart by ID (e.g., /cart/1/2) (/cart/userId/Product_name)  
            if (isset($path_segments[1]) && isset($path_segments[2])) {
                $userId = $path_segments[1];
                $cartId = $path_segments[2];
                echo $controller->getCartByIdOfUser($userId, $cartId);
            } elseif (isset($path_segments[1])) {
                $userId = $path_segments[1];
                echo $controller->getCartAllOfUser($userId);
            } else {
                // Get all carts
                echo $controller->getAllCarts();
            }
        }
        break;

    case "DELETE": // Corrected method to "DELETE"
        if ($path_segments[0] == 'cart') {
            // Delete specific cart by ID (e.g., /cart/1/2) (/cart/userId/Product_name)  
            if (isset($path_segments[1]) && isset($path_segments[2])) {
                $userId = $path_segments[1];
                $cartId = $path_segments[2];
                echo $controller->deleteCartByIdOfUser($userId, $cartId);
            } elseif (isset($path_segments[1])) {
                $userId = $path_segments[1];
                echo $controller->deleteCartAllOfUser($userId);
            } else {
                // Delete all carts
                echo $controller->deleteAllCarts();
            }
        }
        break;
    
    default:
        echo json_encode(["status" => false, "message" => "Service request not available"]);
}


/*
$_SESSION['carts'] = [
    'user1' => [
        [
            ['name' => 'apple', 'price' => 50, 'quantity' => 2],
            ['name' => 'banana', 'price' => 20, 'quantity' => 3],
        ]
    ],
    'user2' => [
        [
            ['name' => 'apple', 'price' => 50, 'quantity' => 2],
            ['name' => 'banana', 'price' => 20, 'quantity' => 3],
        ]
    ]
];
*/

/*
Alternatively, if you prefer accessing the last element using the array index, you can do this:

php
Copy code
$last_segment = $path_segments[count($path_segments) - 1];
 */
