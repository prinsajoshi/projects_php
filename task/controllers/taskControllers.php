<?php

class TaskController
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function createTask($data)
    {
        if (isset($data["title"])) {
            $sucess = $this->model->getTaskByTitle($data["title"]);
            if ($sucess["status"]) {
                return ["status" => false, "message" => "title already exit"];
            }
            return $this->model->insert($data["title"], $data["description"]?? null);
        }else{
            return ["status" => false, "message" => "title is not set"];
        }
    }

    public function getTask($data)
    {
        if (isset($data["title"])) {
            return $this->model->getTaskByTitle($data["title"]);
        }
        return $this->model->getAllTask();
    }

    public function updateTask($data)
    {
        if (isset($data["id"], $data["title"]) || isset($data["id"], $data["title"], $data["description"])) {
            return $this->model->updateTask($data["id"], $data["title"], $data["description"]?? null);
        }
        return ["status" => false, "message" => "title and id is not set for update"];
    }

    public function deleteTask($data)
    {
        if (isset($data["id"])) {
            return $this->model->deleteTask($data["id"]);
        }
        return ["status" => false, "message" => "Failed to Delete task "];
    }
}
