<?php
$config = include '../config.php';
$dsn = "mysql:host={$config['db']['host']};dbname={$config['db']['dbname']};charset={$config['db']['charset']}";
try {
    $pdo = new PDO($dsn, $config['db']['user'], $config['db']['password']);
    echo "连接成功！";
} catch (PDOException $e) {
    die("连接失败: " . $e->getMessage());
}
?>