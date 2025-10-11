<?php

namespace App\Services;

use App\Models\GlobalSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MayarService
{
    protected $apiKey;
    protected $webhookToken;
    protected $redirectUrl;
    protected $isSandbox;
    protected $baseUrl;

    public function __construct()
    {
        $settings = GlobalSetting::first();

        if (!$settings) {
            throw new \Exception('Global settings not found. Please configure payment settings first.');
        }

        $this->apiKey = $settings->mayar_api_key;
        $this->webhookToken = $settings->mayar_webhook_token;
        $this->redirectUrl = $settings->mayar_redirect_url;
        $this->isSandbox = (bool) $settings->mayar_sandbox;

        // Set base URL based on environment
        $this->baseUrl = $this->isSandbox
            ? 'https://api.mayar.club/hl/v1'
            : 'https://api.mayar.id/hl/v1';

        Log::info('MayarService initialized', [
            'is_sandbox' => $this->isSandbox,
            'base_url' => $this->baseUrl,
            'api_key_set' => !empty($this->apiKey),
            'redirect_url' => $this->redirectUrl
        ]);
    }

    /**
     * Create payment request
     */
    public function createPaymentRequest($params)
    {
        try {
            Log::info('Creating Mayar payment request', [
                'order_id' => $params['order'] ?? 'unknown',
                'amount' => $params['amount'] ?? 0,
                'description' => $params['description'] ?? ''
            ]);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json'
            ])
                ->timeout(30)
                ->post($this->baseUrl . '/payment/create', $params);

            if (!$response->successful()) {
                Log::error('Mayar API error', [
                    'status' => $response->status(),
                    'response' => $response->body(),
                    'request_params' => $params
                ]);

                throw new \Exception('Failed to create payment request: ' . $response->body());
            }

            $data = $response->json();

            Log::info('Mayar payment request created successfully', [
                'payment_id' => $data['data']['id'] ?? 'unknown',
                'link' => $data['data']['link'] ?? '',
                'status' => $data['data']['status'] ?? 'unknown'
            ]);

            return $data;
        } catch (\Exception $e) {
            Log::error('Failed to create Mayar payment request', [
                'error' => $e->getMessage(),
                'params' => $params
            ]);

            throw $e;
        }
    }

    /**
     * Get payment detail
     */
    public function getPaymentDetail($paymentId)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json'
            ])
                ->timeout(30)
                ->get($this->baseUrl . '/payment/' . $paymentId);

            if (!$response->successful()) {
                throw new \Exception('Failed to get payment detail: ' . $response->body());
            }

            $data = $response->json();

            Log::info('Payment detail retrieved', [
                'payment_id' => $paymentId,
                'status' => $data['data']['status'] ?? 'unknown'
            ]);

            return $data;
        } catch (\Exception $e) {
            Log::error('Failed to get payment detail', [
                'error' => $e->getMessage(),
                'payment_id' => $paymentId
            ]);

            throw $e;
        }
    }

    /**
     * Get all payment requests (with pagination)
     */
    public function getPaymentRequests($page = 1, $pageSize = 10)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json'
            ])
                ->timeout(30)
                ->get($this->baseUrl . '/payment', [
                    'page' => $page,
                    'pageSize' => $pageSize
                ]);

            if (!$response->successful()) {
                throw new \Exception('Failed to get payment requests: ' . $response->body());
            }

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Failed to get payment requests', [
                'error' => $e->getMessage(),
                'page' => $page
            ]);

            throw $e;
        }
    }

    /**
     * Reopen payment request
     */
    public function reopenPaymentRequest($paymentId)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json'
            ])
                ->timeout(30)
                ->post($this->baseUrl . '/payment/' . $paymentId . '/reopen');

            if (!$response->successful()) {
                throw new \Exception('Failed to reopen payment request: ' . $response->body());
            }

            $data = $response->json();

            Log::info('Payment request reopened', [
                'payment_id' => $paymentId,
                'status' => $data['data']['status'] ?? 'unknown'
            ]);

            return $data;
        } catch (\Exception $e) {
            Log::error('Failed to reopen payment request', [
                'error' => $e->getMessage(),
                'payment_id' => $paymentId
            ]);

            throw $e;
        }
    }

    /**
     * Handle Mayar webhook notification
     */
    public function handleWebhook($webhookData)
    {
        try {
            Log::info('Processing Mayar webhook', [
                'payment_id' => $webhookData['id'] ?? 'unknown',
                'status' => $webhookData['status'] ?? 'unknown',
                'amount' => $webhookData['amount'] ?? 0
            ]);

            // Verify webhook token if provided
            $receivedToken = request()->header('X-Webhook-Token');
            if ($this->webhookToken && $receivedToken !== $this->webhookToken) {
                Log::error('Invalid webhook token', [
                    'expected' => $this->webhookToken,
                    'received' => $receivedToken
                ]);
                throw new \Exception('Invalid webhook token');
            }

            Log::info('Webhook verified successfully', [
                'payment_id' => $webhookData['id']
            ]);

            return [
                'payment_id' => $webhookData['id'],
                'status' => $webhookData['status'],
                'amount' => $webhookData['amount'],
                'order' => $webhookData['order'] ?? null,
                'description' => $webhookData['description'] ?? null,
                'created_at' => $webhookData['createdAt'] ?? null,
                'link' => $webhookData['link'] ?? null
            ];
        } catch (\Exception $e) {
            Log::error('Failed to handle Mayar webhook', [
                'error' => $e->getMessage(),
                'data' => $webhookData
            ]);

            throw $e;
        }
    }

    /**
     * Build payment request parameters for Mayar API
     */
    public function buildPaymentParams($orderId, $amount, $description, $customerName = null, $customerEmail = null, $customerMobile = null)
    {
        $params = [
            'name' => $customerName ?? 'Customer',
            'email' => $customerEmail ?? 'customer@example.com',
            'amount' => (int) $amount,
            'mobile' => $customerMobile ?? '08123456789', // Use provided mobile or default
            'description' => $description,
            'expiredAt' => now()->addHours(24)->format('c') // 24 hours from now ISO 8601
        ];

        // Add redirect URL if configured
        if ($this->redirectUrl) {
            $params['redirectUrl'] = $this->redirectUrl;
        }

        return $params;
    }

    /**
     * Get payment URL from payment response
     */
    public function getPaymentUrl($paymentResponse)
    {
        $link = $paymentResponse['data']['link'] ?? null;

        if (!$link) {
            throw new \Exception('Payment link not found in response');
        }

        // Return the link directly as it's already a full URL
        return $link;
    }

    /**
     * Check if webhook token is valid
     */
    public function isValidWebhookToken($token)
    {
        return $this->webhookToken && $token === $this->webhookToken;
    }
}
