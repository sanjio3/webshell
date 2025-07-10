<?php
namespace App\Model;

class ScanTask extends Model {
    public function createTask($taskId, $path) {
        $stmt = $this->pdo->prepare("INSERT INTO scan_tasks (task_id, target_path) VALUES (?, ?)");
        $stmt->execute([$taskId, $path]);
    }

    public function updateStatus($taskId, $status) {
        $stmt = $this->pdo->prepare("UPDATE scan_tasks SET status = ? WHERE task_id = ?");
        $stmt->execute([$status, $taskId]);
    }
}
