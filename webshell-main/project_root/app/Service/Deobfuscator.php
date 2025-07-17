<?php
namespace App\Service;

class Deobfuscator {
    /**
     * 解析并解码 Base64 编码的字符串
     * @param string $content 需要处理的内容
     * @return string 处理后的结果
     */
    public function decodeBase64($content) {
        return preg_replace_callback(
            '/base64_decode\((["\'])([A-Za-z0-9\+\/=]+)\1\)/',
            function ($matches) {
                // 匹配格式：base64_decode('...') 或 base64_decode("...")
                return '"' . base64_decode($matches[2]) . '"';
            },
            $content
        );
    }

    /**
     * 解析字符串拼接操作（如 "a" . "b" -> "ab"）
     * @param string $content 需要处理的内容
     * @return string 处理后的结果
     */
    public function resolveConcat($content) {
        return preg_replace_callback(
            '/(["\'])([^"\']+?)\s*\.\s*(["\'])([^"\']+?)\3/',
            function ($matches) {
                // 匹配格式："a" . "b" 或 'a' . 'b'
                return $matches[1] . $matches[2] . $matches[4] . $matches[1];
            },
            $content
        );
    }
}