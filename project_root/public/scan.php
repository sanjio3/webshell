<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Model\ScanTask;
use App\Service\Scanner;

$taskId = $_GET['task_id'] ?? null;
if (!$taskId) {
    die("无效任务ID");
}

// 获取任务路径
$stmt = (new ScanTask())->pdo->prepare("SELECT target_path FROM scan_tasks WHERE task_id = ?");
$stmt->execute([$taskId]);
$task = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$task) {
    die("任务不存在");
}

// 开始扫描
$scanner = new Scanner();
$results = $scanner->scanDirectory($task['target_path']);

// 保存结果
$pdo = (new ScanTask())->pdo;
$stmt = $pdo->prepare("INSERT INTO malware_results 
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

// 更新任务状态
(new ScanTask())->updateStatus($taskId, 2);
?>

<h2>扫描完成</h2>
<a href="/results.php?task_id=<?= $taskId ?>">查看结果</a>
