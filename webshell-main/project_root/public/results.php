<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Model\ScanTask;


$taskId = $_GET['task_id'] ?? null;
if (!$taskId) {
    die("无效任务ID");
}



// 获取扫描结果
$scanTask = new ScanTask();
$stmt = $scanTask->getPdo()->prepare("SELECT * FROM malware_results WHERE task_id = ?");
$stmt->execute([$taskId]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 获取任务信息
$taskStmt = $scanTask->getPdo()->prepare("SELECT target_path FROM scan_tasks WHERE task_id = ?");
$taskStmt->execute([$taskId]);
$task = $taskStmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>扫描结果</title>
</head>
<body>
    <h2>扫描结果（任务 ID: <?= htmlspecialchars($taskId) ?>）</h2>
    
    <?php if (!empty($results)): ?>
        <table border="1">
            <tr>
                <th>文件路径</th>
                <th>风险等级</th>
                <th>匹配规则</th>
                <th>代码片段</th>
            </tr>
            <?php foreach ($results as $result): ?>
                <tr>
                    <td><?= htmlspecialchars($result['file_path']) ?></td>
                    <td><?= htmlspecialchars($result['risk_level']) ?></td>
                    <td><?= htmlspecialchars($result['match_rule']) ?></td>
                    <td><code><?= htmlspecialchars($result['code_snippet']) ?></code></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>未检测到恶意文件。</p>
    <?php endif; ?>
</body>
</html>