<?php
require_once 'enums/ProductCategory.php';
require_once 'enums/ProductStatus.php';

use Enums\ProductCategory;
use Enums\ProductStatus;

header('Content-Type: application/json');

// Sample products (in-memory storage for simplicity)
$products = [];

// Helper function to find a product by ID
function findProductById($id) {
    global $products;
    return array_filter($products, fn($product) => $product['id'] === $id);
}

// API Endpoint
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

switch ($requestMethod) {
    case 'GET':
        if ($requestUri[0] === 'api' && $requestUri[1] === 'products') {
            // Return all products
            echo json_encode(array_values($products));
        } elseif ($requestUri[0] === 'api' && $requestUri[1] === 'products' && isset($requestUri[2])) {
            // Return a single product by ID
            $productId = (int)$requestUri[2];
            $product = findProductById($productId);
            if ($product) {
                echo json_encode(array_values($product)[0]);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Product not found"]);
            }
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Not Found"]);
        }
        break;

    case 'POST':
        if ($requestUri[0] === 'api' && $requestUri[1] === 'products') {
            $data = json_decode(file_get_contents("php://input"), true);

            // Basic validation
            if (empty($data['name']) || empty($data['category']) || empty($data['status']) || empty($data['price'])) {
                http_response_code(400);
                echo json_encode(["message" => "Missing required fields"]);
                break;
            }

            // Validate category and status
            try {
                $category = ProductCategory::from($data['category']);
                $status = ProductStatus::from($data['status']);
            } catch (\ValueError $e) {
                http_response_code(400);
                echo json_encode(["message" => "Invalid category or status"]);
                break;
            }

            // Create a new product
            $newProduct = [
                "id" => count($products) + 1,
                "name" => $data['name'],
                "category" => $category->value,
                "status" => $status->value,
                "price" => $data['price']
            ];
            $products[] = $newProduct;

            echo json_encode($newProduct);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Not Found"]);
        }
        break;

    case 'PUT':
        if ($requestUri[0] === 'api' && $requestUri[1] === 'products' && isset($requestUri[2])) {
            $productId = (int)$requestUri[2];
            $data = json_decode(file_get_contents("php://input"), true);

            // Find existing product
            $product = findProductById($productId);
            if (!$product) {
                http_response_code(404);
                echo json_encode(["message" => "Product not found"]);
                break;
            }

            // Validate updates
            if (isset($data['category'])) {
                try {
                    $category = ProductCategory::from($data['category']);
                } catch (\ValueError $e) {
                    http_response_code(400);
                    echo json_encode(["message" => "Invalid category"]);
                    break;
                }
            }

            if (isset($data['status'])) {
                try {
                    $status = ProductStatus::from($data['status']);
                } catch (\ValueError $e) {
                    http_response_code(400);
                    echo json_encode(["message" => "Invalid status"]);
                    break;
                }
            } 

            // Update the product details
            $existingProduct = array_values($product)[0];
            $updatedProduct = array_merge($existingProduct, $data);
            $updatedProduct['category'] = $category->value ?? $existingProduct['category'];
            $updatedProduct['status'] = $status->value ?? $existingProduct['status'];

            // Replace the old product with the updated product
            foreach ($products as &$prod) {
                if ($prod['id'] === $productId) {
                    $prod = $updatedProduct;
                    break;
                }
            }

            echo json_encode($updatedProduct);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Not Found"]);
        }
        break;

    case 'DELETE':
        if ($requestUri[0] === 'api' && $requestUri[1] === 'products' && isset($requestUri[2])) {
            $productId = (int)$requestUri[2];
            $product = findProductById($productId);

            if ($product) {
                $products = array_filter($products, fn($prod) => $prod['id'] !== $productId);
                echo json_encode(["message" => "Product deleted successfully"]);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Product not found"]);
            }
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Not Found"]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["message" => "Method Not Allowed"]);
}
?>
