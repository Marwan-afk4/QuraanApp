<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\FCMHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function broadcastNotification(Request $request)
{
    $request->validate([
        'title' => 'required|string',
        'body' => 'required|string',
    ]);

    $tokens = User::whereNotNull('fcm_token')
        ->where('fcm_token', '!=', '')
        ->pluck('fcm_token')
        ->toArray();

    if (empty($tokens)) {
        return response()->json(['error' => 'No FCM tokens found'], 404);
    }

    $responses = [];

    foreach ($tokens as $token) {
        $responses[] = [
            'token' => $token,
            'response' => FCMHelper::sendPushNotification(
                $token, // ✅ Single token
                $request->title,
                $request->body,
                ['click_action' => 'FLUTTER_NOTIFICATION_CLICK']
            )
        ];
    }

    return response()->json([
        'message' => 'Broadcast sent to ' . count($tokens) . ' users',
        'responses' => $responses,
    ]);
}

}
