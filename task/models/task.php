<?php

class TaskModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function insert($title, $description = null)
    {
        $stmt = $this->conn->prepare("INSERT INTO task(title,description) values(?,?)");
        $stmt->bind_param("ss", "$title", $description);
        if ($stmt->execute()) {
            $data = $this->getTaskByTitle($title);
            return ["status" => True, "payload" => $data["payload"]];
        }
    }

    public function getTaskByTitle($title)
    {
        $stmt = $this->conn->prepare("SELECT * FROM task where title=?");
        $stmt->bind_param("s", $title);
        $stmt->execute();
        $task = $stmt->get_result()->fetch_assoc();
        if ($task) {
            return ["status" => true, "payload" => $task];
        }
        return false;
    }

    public function getAllTask()
    {
        $stmt = $this->conn->prepare("SELECT * FROM task");
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $task[] = $row;
        }
        return ["status" => true, "payload" => $task];
    }

    public function deleteTask($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM task where id=?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            return ["status" => True, "message" => " Deleted task "];
        } else {
            return ["status" => false, "message" => " Failed to Delete task "];
        }
    }

    public function updateTask($id, $title, $description)
    {
        $stmt = $this->conn->prepare("UPDATE task SET title=?, description=? WHERE id=?");
        $stmt->bind_param("ssi", $title, $description, $id);
        if ($stmt->execute()) {
            $data = $this->getTaskByTitle($title);
            return ["status" => True, "payload" => $data["payload"]];
        } else {
            return ["satus" => false, "message" => "Failed to update"];
        }
    }
}
