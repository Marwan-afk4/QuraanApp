<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Google\Auth\Credentials\ServiceAccountCredentials;

class FCMHelper
{
    public static function getAccessToken(): ?string
    {
        $credentialsPath = storage_path('app/firebase/thadathwithquran-96bcf55492b7.json');

        $scopes = ['https://www.googleapis.com/auth/firebase.messaging'];

        $creds = new ServiceAccountCredentials($scopes, $credentialsPath);
        $token = $creds->fetchAuthToken();

        return $token['access_token'] ?? null;
    }

    public static function sendPushNotification($fcmToken, $title, $body, $data = [])
    {
        $accessToken = self::getAccessToken();

        $payload = [
            'message' => [
                'token' => $fcmToken,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'data' => $data,
            ]
        ];

        $response = Http::withToken($accessToken)
        ->withoutVerifying() // Disable SSL verification (not secure for production)
        ->post("https://fcm.googleapis.com/v1/projects/thadathwithquran/messages:send", $payload);

        return $response->json();
    }
}
