<?php
namespace App\Service;

class Scanner {
    private $rules = [
        'danger_functions' => [
            '/assert\(/i' => '危险函数 assert',
            '/eval\(/i' => '危险函数 eval',
            '/system\(/i' => '危险函数 system',
            '/exec\(/i' => '危险函数 exec',
            '/preg_replace\(.\/e/ui' => 'preg_replace /e 模式'
        ],
        'base64' => '/base64_decode\([\'"]{1,2}([A-Za-z0-9\+\/=]+)/'
    ];

    public function scanDirectory($path) {
        $results = [];
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path)
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $content = file_get_contents($file->getPathname());
                $fileResults = $this->checkRules($content, $file->getPathname());
                if (!empty($fileResults)) {
                    $results = array_merge($results, $fileResults);
                }
            }
        }

        return $results;
    }

    private function checkRules($content, $filePath) {
        $results = [];
        foreach ($this->rules['danger_functions'] as $pattern => $ruleName) {
            if (preg_match_all($pattern, $content, $matches)) {
                foreach ($matches[0] as $match) {
                    $results[] = [
                        'file_path' => $filePath,
                        'risk_level' => 3,
                        'match_rule' => $ruleName,
                        'code_snippet' => $match
                    ];
                }
            }
        }
        return $results;
    }
}
