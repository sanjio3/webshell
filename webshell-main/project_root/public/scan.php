<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Model\ScanTask;
use App\Service\Scanner;

$taskId = $_GET['task_id'] ?? null;
if (!$taskId) {
    die("无效任务ID");
}

$scanTask = new ScanTask();

$stmt = $scanTask->getPdo()->prepare("SELECT target_path FROM scan_tasks WHERE task_id = ?");
$stmt->execute([$taskId]);
$task = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$task) {
    die("任务不存在");
}

$scanner = new Scanner();
$results = $scanner->scanDirectory($task['target_path']);

$stmt = $scanTask->getPdo()->prepare("INSERT INTO malware_results 
    (task_id, file_path, risk_level, match_rule, code_snippet) 
    VALUES (?, ?, ?, ?, ?)");

foreach ($results as $result) {
    $stmt->execute([
        $taskId,
        $result['file_path'],
        $result['risk_level'],
        $result['match_rule'],
        $result['code_snippet']
    ]);
}

$scanTask->updateStatus($taskId, 2);
?>
<h2>扫描完成</h2>
<a href="results.php?task_id=<?= $taskId ?>">查看结果</a>