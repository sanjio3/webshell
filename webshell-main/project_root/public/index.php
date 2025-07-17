<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Model\ScanTask;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['dir'])) {
        $taskId = uniqid();
        $uploadDir = __DIR__ . '/../scans/' . $taskId;

        echo "任务 ID: $taskId<br>";
        echo "目标路径: $uploadDir<br>";

        if ($_FILES['dir']['type'] === 'application/zip') {
            $zip = new ZipArchive();
            $zipPath = $_FILES['dir']['tmp_name'];
            
            if ($zip->open($zipPath) === TRUE) {
                $zip->extractTo($uploadDir);
                $zip->close();
                echo "ZIP 解压成功<br>";
            } else {
                die("ZIP 解压失败");
            }
        } else {
            mkdir($uploadDir, 0755, true);
            copy($_FILES['dir']['tmp_name'], "$uploadDir/" . $_FILES['dir']['name']);
            echo "文件已复制到: $uploadDir/".$_FILES['dir']['name']."<br>";
        }

        try {
            $scanTask = new ScanTask();
            $scanTask->createTask($taskId, $uploadDir);
            echo "任务已创建<br>";
        } catch (Exception $e) {
            die("任务创建失败: " . $e->getMessage());
        }

        // 正确定义跳转路径
        $redirectUrl = "scan.php?task_id=$taskId";
        echo "跳转路径: $redirectUrl<br>";
        echo "<script>setTimeout(function() { window.location.href = '$redirectUrl'; }, 1000);</script>";
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>简单WebShell 扫描器</title>
</head>
<body>
    <h2>上传待扫描目录</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="dir" accept=".zip" required>
        <button type="submit">开始扫描</button>
    </form>
</body>
</html>