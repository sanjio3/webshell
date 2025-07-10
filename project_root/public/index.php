<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Model\ScanTask;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['dir'])) {
        $uploadDir = __DIR__ . '/../scans/' . uniqid();
        
        // ZIP 文件上传
        if ($_FILES['dir']['type'] === 'application/zip') {
            $zip = new ZipArchive();
            if ($zip->open($_FILES['dir']['tmp_name']) === TRUE) {
                $zip->extractTo($uploadDir);
                $zip->close();
            }
        } else {
            // 普通目录上传（需手动压缩后上传）
            mkdir($uploadDir, 0755, true);
            copy($_FILES['dir']['tmp_name'], "$uploadDir/" . $_FILES['dir']['name']);
        }

        // 创建任务
        $taskId = uniqid();
        $scanTask = new ScanTask();
        $scanTask->createTask($taskId, $uploadDir);

        // 重定向到扫描页面
        header("Location: /scan.php?task_id=$taskId");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>WebShell 扫描器</title>
</head>
<body>
    <h2>上传待扫描目录</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="dir" accept=".zip" required>
        <button type="submit">开始扫描</button>
    </form>
</body>
</html>
