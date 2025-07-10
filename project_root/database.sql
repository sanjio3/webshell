CREATE TABLE `scan_tasks` (
  `id` BIGINT PRIMARY KEY AUTO_INCREMENT,
  `task_id` VARCHAR(36) UNIQUE,
  `target_path` TEXT,
  `status` TINYINT DEFAULT 0,  # 0等待 1进行中 2完成
  `created_at` DATETIME
);

CREATE TABLE `malware_results` (
  `id` BIGINT PRIMARY KEY AUTO_INCREMENT,
  `task_id` VARCHAR(36),
  `file_path` TEXT,
  `risk_level` TINYINT,  # 1低危 2中危 3高危
  `match_rule` TEXT,
  `code_snippet` TEXT,
  `created_at` DATETIME
);
