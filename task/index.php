<?php

require_once './config/database.php';
require_once './models/task.php';

$request_method=$_SERVER["REQUEST_METHOD"];
$data=json_encode(file_get_contents('php://input'),true);

$db=(new Database())->getConnection();
$model=new TaskModel($db);
$controller=new TaskController($model);



try {
    switch ($request_method){
        case "POST":
            echo json_encode($postController->createPost($data));
            break;
        case "GET":
            echo json_encode($postController->getTask($data));
        case "PUT":
            echo json_encode($postController->updateTask($data));
        case "DELETE":
            echo json_encode($postController->deleteTask($data));
        default:
            echo json_encode(["status"=>false,"message"=>"Service not found"]);
    }
    
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}