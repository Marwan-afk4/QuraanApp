<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\FCMHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function sendToUser(Request $request)
{
    // Validate the request to ensure required fields are present
    $request->validate([
        'title' => 'required|string',
        'body' => 'required|string',
        'fcm_token' => 'required|string', // Validate that an FCM token is provided
    ]);

    // Retrieve the target FCM token from the request
    $fcmToken = $request->fcm_token;

    // Check if the FCM token is valid (optional check if you'd like)
    if (empty($fcmToken)) {
        return response()->json(['error' => 'FCM token is required'], 422);
    }

    // Send the push notification to the specific FCM token
    $response = FCMHelper::sendPushNotification(
        $fcmToken,            // Target FCM token
        $request->title,      // Notification title
        $request->body,       // Notification body
        ['click_action' => 'FLUTTER_NOTIFICATION_CLICK'] // Additional data (optional)
    );

    // Return the response from Firebase
    return response()->json(['message' => 'Notification sent', 'response' => $response]);
}

}
