<?php
namespace App\Service;

class Deobfuscator {
    public function decodeBase64($content) {
        return preg_replace_callback(
            '/base64_decode\([\'"]{1,2}([A-Za-z0-9\+\/=]+)[\'"]{1,2}\)/',
            function($matches) {
                return '"' . base64_decode($matches[1]) . '"';
            },
            $content
        );
    }

    public function resolveConcat($content) {
        return preg_replace(
            '/"([^"]+)"\s*\.\s*"([^"]*)"/', 
            '"' . $matches[1] . $matches[2] . '"', 
            $content
        );
    }
}
