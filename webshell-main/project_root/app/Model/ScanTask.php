<?php
namespace App\Model;

class ScanTask extends Model {
    public function createTask(string $taskId, string $targetPath): void {
        $stmt = $this->getPdo()->prepare("INSERT INTO scan_tasks (task_id, target_path) VALUES (?, ?)");
        $stmt->execute([$taskId, $targetPath]);
    }

    public function updateStatus(string $taskId, int $status): void {
        $stmt = $this->getPdo()->prepare("UPDATE scan_tasks SET status = ? WHERE task_id = ?");
        $stmt->execute([$status, $taskId]);
    }
}