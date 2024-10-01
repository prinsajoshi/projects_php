<?php
//composer require firebase/php-jwt 
require 'vendor/autoload.php';
use \Firebase\JWT\JWT;

require 'config.php';

function generateJWT($userId){
    $issuedAt=time();
    $expirationTime=$issuedAt+3600;
    $payload=[
        'iat'=>$issuedAt,
        'exp'=>$expirationTime,
        'sub'=>$userId
    ];
    return JWT::encode($payload,JWT_SECRET_KEY,'HS256');
}


function validateJWT($token) {
    try {
        return JWT::decode($token,JWT_SECRET_KEY,['HS256']);
    } catch (Exception $e) {
        return null;  // Invalid token
    }
}

header("Content-Type:application/json");

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['username']) && isset($_POST['password'])){
    if ($_POST['username']==='admin' && $_POST['password']==='admin'){
        $token=generateJWT(1); //assuming userId is 1
        echo json_encode(['token'=>$token]);
    }else{
        http_response_code(401);
        echo json_encode(['message'=>'Unauthorized']);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD']==='GET'){
    $header=apache_request_headers();
    if (isset($header['Authorization'])){
        $token=str_replace('Bearer','',$header['Authorization']);
        $decoded=validateJWT($token);
        
        if($decoded){
            echo json_encode(['message'=>'Welcome to the protected API']);
        }else{
            http_response_code(401);
            echo json_encode(['message'=>'Unauthorized']);
        }
    }else {
        http_response_code(401);
        echo json_encode(['message' => 'Authorization header missing']);
    }
}

/*
Local storage:
// Storing the token
localStorage.setItem('token', 'YOUR_JWT_TOKEN');

// Retrieving the token
const token = localStorage.getItem('token');

Session Storage:
// Storing the token
sessionStorage.setItem('token', 'YOUR_JWT_TOKEN');

// Retrieving the token
const token = sessionStorage.getItem('token');

Cookies:
// Setting the cookie in PHP
setcookie('jwt', 'YOUR_JWT_TOKEN', [
    'expires' => time() + 3600,  // 1 hour expiration
    'path' => '/',
    'domain' => 'your-domain.com',
    'secure' => true,  // Ensures cookie is sent over HTTPS
    'httponly' => true,  // JavaScript can't access the cookie
    'samesite' => 'Strict'  // Prevent CSRF attacks
]);

In memory storage:
let token = 'YOUR_JWT_TOKEN'; // Only valid during the current session


*/