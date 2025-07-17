<?php
namespace App\Model;

use PDO;

class Model {
    protected $pdo;

    public function __construct() {
        $config = include __DIR__ . '/../../config.php';
        $dsn = "mysql:host={$config['db']['host']};dbname={$config['db']['dbname']};charset={$config['db']['charset']}";
        $this->pdo = new PDO($dsn, $config['db']['user'], $config['db']['password']);
    }

    // ✅ 添加此方法
    public function getPdo(): PDO {
        return $this->pdo;
    }
}