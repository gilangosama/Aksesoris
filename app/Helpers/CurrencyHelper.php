<?php

namespace App\Helpers;

class CurrencyHelper
{
    const EXCHANGE_RATE = 15000; // 1 USD = 15,000 Rp

    /**
     * Convert USD to Rupiah
     */
    public static function usdToRp(float $usd): int
    {
        return (int) ($usd * self::EXCHANGE_RATE);
    }

    /**
     * Format amount as Indonesian Rupiah
     * Example: formatRp(2500000) => "Rp 2.500.000"
     */
    public static function formatRp(?int $amount): string
    {
        if ($amount === null) {
            return 'Rp 0';
        }
        
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }

    /**
     * Format number without currency symbol
     * Example: format(2500000) => "2.500.000"
     */
    public static function format(?int $amount): string
    {
        if ($amount === null) {
            return '0';
        }
        
        return number_format($amount, 0, ',', '.');
    }

    /**
     * Parse rupiah string to integer
     * Example: parseRp("Rp 2.500.000") => 2500000
     */
    public static function parseRp(string $input): int
    {
        $cleaned = preg_replace('/[^0-9]/', '', $input);
        return (int) $cleaned;
    }
}
