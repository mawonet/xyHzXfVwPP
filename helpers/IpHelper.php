<?php
namespace app\helpers;

class IpHelper
{
    public static function maskLastTwo(string $ip): string
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $parts = explode('.', $ip);
            if (count($parts) === 4) {
                $parts[2] = '*';
                $parts[3] = '*';
                return implode('.', $parts);
            }
            return $ip;
        }

        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $bin = inet_pton($ip);
            if ($bin === false) return $ip;
            $words = [];
            for ($i = 0; $i < 8; $i++) {
                $word = unpack("n", substr($bin, $i * 2, 2))[1];
                $words[] = dechex($word);
            }
            foreach ($words as &$w) { $w = ltrim($w, '0'); if ($w === '') $w = '0'; }
            $words[6] = '*';
            $words[7] = '*';
            return implode(':', $words);
        }

        return $ip;
    }
}