<?php

class CartControllers {

    // Assuming you're using a session to store cart data
    public function __construct() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['carts'])) {
            $_SESSION['carts'] = [];
        }
    }

    // Create a new cart for a specific user
    public function createCart($data, $userId) {
        // Check if userId exists in session
        if (!isset($_SESSION['carts'][$userId])) {
            $_SESSION['carts'][$userId] = [];
        }

        // Add the product to the user's cart
        $_SESSION['carts'][$userId][] = $data;

        return json_encode([
            "status" => true,
            "message" => "Cart created successfully",
            "cart" => $_SESSION['carts'][$userId]
        ]);
    }

    // Get all carts
    public function getAllCarts() {
        return json_encode([
            "status" => true,
            "message" => "All carts retrieved",
            "carts" => $_SESSION['carts']
        ]);
    }

    // Get all carts for a specific user
    public function getCartAllOfUser($userId) {
        if (isset($_SESSION['carts'][$userId])) {
            return json_encode([
                "status" => true,
                "message" => "User's carts retrieved",
                "carts" => $_SESSION['carts'][$userId]
            ]);
        } else {
            return json_encode([
                "status" => false,
                "message" => "No cart found for this user"
            ]);
        }
    }

    // Get a specific cart by userId and cartId
    public function getCartByIdOfUser($userId, $cartId) {
        if (isset($_SESSION['carts'][$userId]) && isset($_SESSION['carts'][$userId][$cartId])) {
            return json_encode([
                "status" => true,
                "message" => "Cart retrieved",
                "cart" => $_SESSION['carts'][$userId][$cartId]
            ]);
        } else {
            return json_encode([
                "status" => false,
                "message" => "Cart not found for this user and cart ID"
            ]);
        }
    }

    // Delete all carts for a specific user
    public function deleteCartAllOfUser($userId) {
        if (isset($_SESSION['carts'][$userId])) {
            unset($_SESSION['carts'][$userId]);

            return json_encode([
                "status" => true,
                "message" => "All carts deleted for this user"
            ]);
        } else {
            return json_encode([
                "status" => false,
                "message" => "No carts found to delete for this user"
            ]);
        }
    }

    // Delete a specific cart by userId and cartId
    public function deleteCartByIdOfUser($userId, $cartId) {
        if (isset($_SESSION['carts'][$userId]) && isset($_SESSION['carts'][$userId][$cartId])) {
            unset($_SESSION['carts'][$userId][$cartId]);

            // Re-index the array after deletion
            $_SESSION['carts'][$userId] = array_values($_SESSION['carts'][$userId]);

            return json_encode([
                "status" => true,
                "message" => "Cart deleted",
            ]);
        } else {
            return json_encode([
                "status" => false,
                "message" => "Cart not found for this user and cart ID"
            ]);
        }
    }

    // Delete all carts
    public function deleteAllCarts() {
        $_SESSION['carts'] = [];

        return json_encode([
            "status" => true,
            "message" => "All carts deleted"
        ]);
    }
}


