CREATE DATABASE webshell_scanner 
  DEFAULT CHARACTER SET utf8mb4 
  COLLATE utf8mb4_unicode_ci;

USE webshell_scanner;

CREATE TABLE `scan_tasks` (
  `id` BIGINT PRIMARY KEY AUTO_INCREMENT,
  `task_id` VARCHAR(36) UNIQUE NOT NULL,
  `target_path` TEXT NOT NULL,
  `status` TINYINT DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `malware_results` (
  `id` BIGINT PRIMARY KEY AUTO_INCREMENT,
  `task_id` VARCHAR(36) NOT NULL,
  `file_path` TEXT NOT NULL,
  `risk_level` TINYINT DEFAULT 1,
  `match_rule` TEXT NOT NULL,
  `code_snippet` TEXT,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
