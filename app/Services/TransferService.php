<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;
use App\Models\DeviceToken;


class TransferService
{
    public function sendNotification($userId, $body, $data = [])
    {
        $deviceToken = DeviceToken::where('user_id', $userId)->value('device_token');
        if (!$deviceToken) return 'No device token found';

        $accessToken = $this->getAccessToken();
        $projectId = env('FIREBASE_PROJECT_ID');

        $payload = [
            'message' => [
                'token' => $deviceToken,
                'notification' => [
                    'body' => $body,
                ],
            ]
        ];

        if (!empty($data)) {
            $stringData = [];
            foreach ($data as $key => $value) {
                $stringData[(string)$key] = (string)$value;
            }
            $payload['message']['data'] = $stringData;
        }

        $response = Http::withToken($accessToken)
            ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", $payload);
        \Log::info('FCM Status Code: ' . $response->status());
        \Log::info($data);
        \Log::info('FCM Raw Body: ' . $response->body());
        \Log::info('FCM JSON Parsed: ', $response->json() ?? []);
        return $response->json();
    }

    protected function getAccessToken()
    {
        $clientEmail = env('FIREBASE_CLIENT_EMAIL');
        $privateKey = str_replace("\\n", "\n", env('FIREBASE_PRIVATE_KEY'));

        $now = time();
        $payload = [
            'iss' => $clientEmail,
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud' => 'https://oauth2.googleapis.com/token',
            'iat' => $now,
            'exp' => $now + 3600,
        ];

        $jwt = JWT::encode($payload, $privateKey, 'RS256');

        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ]);

        return $response['access_token'] ?? null;
    }
}
