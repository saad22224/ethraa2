<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Visa;
use Illuminate\Support\Str;

class CardController extends Controller
{




    public function createCard()
    {
        $user = auth()->user();
        $secret = env('STRIGA_SECRET');
        $apiKey = env('STRIGA_API_KEY');
        $method = 'POST';
        $endpoint = '/card/create';

        // 🧠 مهم: لازم يكون عندك userId موجود مسبقاً
        $threeDSecurePassword = $this->generateStrong3DSecurePassword();

        $body = [
            "userId" => $user->striga_customer_id,
            "type" => "VIRTUAL",
            "currency" => "EUR",
            "nameOnCard" => $user->name, // أو أي اسم يظهر على البطاقة
            "threeDSecurePassword" => $threeDSecurePassword // يفضل توليده تلقائيًا أو تخزينه بأمان
        ];

        $timestamp = (string) round(microtime(true) * 1000); // مللي ثانية
        $bodyHash = md5(json_encode($body));
        $stringToSign = $timestamp . $method . $endpoint . $bodyHash;
        $signature = hash_hmac('sha256', $stringToSign, $secret);
        $authorizationHeader = 'HMAC ' . $timestamp . ':' . $signature;

        $response = Http::withHeaders([
            'Authorization' => $authorizationHeader,
            'api-key' => $apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://www.sandbox.striga.com/api/v1' . $endpoint, $body);

        // 🎯 تسجيل اللوجات
        Log::info("Create Card - Timestamp: {$timestamp}");
        Log::info("Create Card - Authorization: {$authorizationHeader}");
        Log::info("Create Card - Body: " . json_encode($body));
        Log::info("Create Card - Response: " . $response->body());

        if ($response->successful()) {
            $card = $response->json();

            Visa::create([
                'user_id' => $user->id,
                'card_id' => $card['id'],
                'masked_pan' => $card['maskedPan'],
                'last4' => $card['last4'],
                'expiry_month' => $card['expiryMonth'],
                'expiry_year' => $card['expiryYear'],
                'currency' => $card['currency'] ?? 'EUR',
                'status' => $card['status'] ?? 'PENDING',
            ]);

            return response()->json(['message' => 'Card created successfully']);
        }

        return response()->json(['error' => 'Card creation failed', 'details' => $response->json()], 400);
    }



        function generateStrong3DSecurePassword(): string
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!"#;:?&*()+=/\\,.[\]{}';
        $length = 12;
        return substr(str_shuffle(str_repeat($chars, ceil($length / strlen($chars)))), 0, $length);
    }
}
