<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Model\ScanTask;

$taskId = $_GET['task_id'] ?? null;
if (!$taskId) {
    die("无效任务ID");
}

// 获取结果
$pdo = (new ScanTask())->pdo;
$stmt = $pdo->prepare("SELECT * FROM malware_results WHERE task_id = ?");
$stmt->execute([$taskId]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>扫描结果</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap @5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>扫描结果</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>文件路径</th>
                <th>风险等级</th>
                <th>匹配规则</th>
                <th>代码片段</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $result): ?>
            <tr class="<?= $result['risk_level'] == 3 ? 'table-danger' : 'table-warning' ?>">
                <td><?= htmlspecialchars($result['file_path']) ?></td>
                <td><?= $result['risk_level'] ?></td>
                <td><?= htmlspecialchars($result['match_rule']) ?></td>
                <td><code><?= htmlspecialchars($result['code_snippet']) ?></code></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
