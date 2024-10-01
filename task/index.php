<?php

require_once './config/database.php';
require_once './models/task.php';
require_once './controllers/taskControllers.php';

$request_method=$_SERVER["REQUEST_METHOD"];
$data=json_decode(file_get_contents('php://input'),true);

$db=(new Database())->getConnection();
$model=new TaskModel($db);
$controller=new TaskController($model);

try {
    switch ($request_method){
        case "POST":
            echo json_encode($controller->createTask($data));
            break;
        case "GET":
            echo json_encode($controller->getTask($data));
            break;
        case "PUT":
            echo json_encode($controller->updateTask($data));
            break;
        case "DELETE":
            echo json_encode($controller->deleteTask($data));
            break;
        default:
            echo json_encode(["status"=>false,"message"=>"Service not found"]);
    }
    
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}