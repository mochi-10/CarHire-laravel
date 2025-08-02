<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MpesaService
{
    protected $consumerKey;
    protected $consumerSecret;
    protected $passkey;
    protected $shortcode;
    protected $environment;

    public function __construct()
    {
        $this->consumerKey = config('services.mpesa.consumer_key');
        $this->consumerSecret = config('services.mpesa.consumer_secret');
        $this->passkey = config('services.mpesa.passkey');
        $this->shortcode = config('services.mpesa.shortcode');
        $this->environment = config('services.mpesa.environment', 'sandbox');
    }

    public function initiateSTKPush($phoneNumber, $amount, $reference)
    {
        try {
            $accessToken = $this->getAccessToken();
            
            $timestamp = date('YmdHis');
            $password = base64_encode($this->shortcode . $this->passkey . $timestamp);
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->post($this->getBaseUrl() . '/mpesa/stkpush/v1/processrequest', [
                'BusinessShortCode' => $this->shortcode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'TransactionType' => 'CustomerPayBillOnline',
                'Amount' => $amount,
                'PartyA' => $this->formatPhoneNumber($phoneNumber),
                'PartyB' => $this->shortcode,
                'PhoneNumber' => $this->formatPhoneNumber($phoneNumber),
                'CallBackURL' => route('mpesa.callback'),
                'AccountReference' => $reference,
                'TransactionDesc' => 'Car Hire Payment - ' . $reference,
            ]);

            Log::info('M-Pesa STK Push Response', [
                'phone' => $phoneNumber,
                'amount' => $amount,
                'reference' => $reference,
                'response' => $response->json()
            ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('M-Pesa STK Push Error', [
                'error' => $e->getMessage(),
                'phone' => $phoneNumber,
                'amount' => $amount
            ]);
            
            return [
                'success' => false,
                'message' => 'Failed to initiate payment: ' . $e->getMessage()
            ];
        }
    }

    protected function getAccessToken()
    {
        $credentials = base64_encode($this->consumerKey . ':' . $this->consumerSecret);
        
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $credentials,
            'Content-Type' => 'application/json',
        ])->get($this->getBaseUrl() . '/oauth/v1/generate?grant_type=client_credentials');

        $data = $response->json();
        return $data['access_token'] ?? null;
    }

    protected function getBaseUrl()
    {
        return $this->environment === 'production' 
            ? 'https://api.safaricom.co.ke'
            : 'https://sandbox.safaricom.co.ke';
    }

    protected function formatPhoneNumber($phone)
    {
        // Remove any non-digit characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // If it starts with 0, replace with 254
        if (substr($phone, 0, 1) === '0') {
            $phone = '254' . substr($phone, 1);
        }
        
        // If it starts with +, remove it
        if (substr($phone, 0, 1) === '+') {
            $phone = substr($phone, 1);
        }
        
        // If it doesn't start with 254, add it
        if (substr($phone, 0, 3) !== '254') {
            $phone = '254' . $phone;
        }
        
        return $phone;
    }

    public function handleCallback($callbackData)
    {
        Log::info('M-Pesa Callback Received', $callbackData);
        
        // Extract the result code and other details
        $resultCode = $callbackData['Body']['stkCallback']['ResultCode'] ?? null;
        $merchantRequestID = $callbackData['Body']['stkCallback']['MerchantRequestID'] ?? null;
        $checkoutRequestID = $callbackData['Body']['stkCallback']['CheckoutRequestID'] ?? null;
        
        if ($resultCode === 0) {
            // Payment successful
            $resultDesc = $callbackData['Body']['stkCallback']['ResultDesc'] ?? 'Success';
            $amount = $callbackData['Body']['stkCallback']['CallbackMetadata']['Item'][0]['Value'] ?? null;
            $mpesaReceiptNumber = $callbackData['Body']['stkCallback']['CallbackMetadata']['Item'][1]['Value'] ?? null;
            $transactionDate = $callbackData['Body']['stkCallback']['CallbackMetadata']['Item'][3]['Value'] ?? null;
            $phoneNumber = $callbackData['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Value'] ?? null;
            
            return [
                'success' => true,
                'result_code' => $resultCode,
                'result_desc' => $resultDesc,
                'amount' => $amount,
                'mpesa_receipt_number' => $mpesaReceiptNumber,
                'transaction_date' => $transactionDate,
                'phone_number' => $phoneNumber,
                'merchant_request_id' => $merchantRequestID,
                'checkout_request_id' => $checkoutRequestID
            ];
        } else {
            // Payment failed
            $resultDesc = $callbackData['Body']['stkCallback']['ResultDesc'] ?? 'Failed';
            
            return [
                'success' => false,
                'result_code' => $resultCode,
                'result_desc' => $resultDesc,
                'merchant_request_id' => $merchantRequestID,
                'checkout_request_id' => $checkoutRequestID
            ];
        }
    }
} 