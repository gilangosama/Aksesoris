<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use Exception;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$clientKey = config('services.midtrans.client_key');
        Config::$isProduction = config('services.midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Create a Snap transaction and get the redirect URL
     * 
     * @param array $data Transaction data
     * @return array
     */
    public function createTransaction(array $data)
    {
        try {
            $snapToken = Snap::getSnapToken($data);
            
            return [
                'status' => 'success',
                'snap_token' => $snapToken,
                'message' => 'Snap token generated successfully'
            ];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Get transaction status
     * 
     * @param string $orderId Order ID
     * @return array
     */
    public function getTransactionStatus($orderId)
    {
        try {
            $status = Transaction::status($orderId);
            
            return [
                'status' => 'success',
                'data' => $status
            ];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Format payment data for Midtrans
     * 
     * @param string $orderId Unique order ID
     * @param int $amount Total amount in IDR
     * @param string $customerEmail Customer email
     * @param string $customerName Customer name
     * @param array $items Items array (name, quantity, price)
     * @return array
     */
    public function formatPaymentData($orderId, $amount, $customerEmail, $customerName, $items = [])
    {
        $paymentData = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'email' => $customerEmail,
                'first_name' => $customerName,
            ],
        ];

        if (!empty($items)) {
            $paymentData['item_details'] = $items;
        }

        return $paymentData;
    }
}
