<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatbotMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;


class FacebookWebhookController extends Controller
{
    // public function verify(Request $request)
    // {
    //     $VERIFY_TOKEN = "my_secure_token_123";

    //     $mode = $request->input('hub_mode');
    //     $token = $request->input('hub_verify_token');
    //     $challenge = $request->input('hub_challenge');

    //     if ($mode && $token && $mode === 'subscribe' && $token === $VERIFY_TOKEN) {
    //         return response($challenge, 200);
    //     }

    //     return response('Forbidden', 403);
    // }

    // public function handle(Request $request)
    // {
    //     $data = $request->all();

    //     if (!empty($data['entry'][0]['messaging'])) {
    //         foreach ($data['entry'][0]['messaging'] as $messageEvent) {
    //             $senderId = $messageEvent['sender']['id'] ?? null;
    //             $messageText = $messageEvent['message']['text'] ?? null;

    //             if ($senderId && $messageText) {
    //                 ChatbotMessage::create([
    //                     'message' => $messageText,
    //                     'sender_id' => $senderId, // this is the PSID from FB
    //                     'direction' => 'incoming', // optional field
    //                 ]);
    //             }
    //         }
    //     }

    //     return response()->json(['status' => 'ok']);
    // }


    // public function verifyToken(Request $request)
    // {
    //     $verify_token = 'your_custom_verify_token'; // Use this same token in Facebook

    //     $mode = $request->get('hub_mode');
    //     $token = $request->get('hub_verify_token');
    //     $challenge = $request->get('hub_challenge');

    //     if ($mode === 'subscribe' && $token === $verify_token) {
    //         return response($challenge, 200);
    //     }

    //     return response('Verification token mismatch', 403);
    // }

    // public function webhook(Request $request)
    // {
    //     // Log the payload or handle message receiving logic
    //     Log::info('Facebook webhook triggered:');
    //     Log::info($request->all());

    //     return response('EVENT_RECEIVED', 200);
    // }

    // public function webhook(Request $request)
    // {
    //     if ($request->isMethod('get')) {
    //         $verify_token = 'your_custom_verify_token'; // must match Facebook's token input
    
    //         if (
    //             $request->input('hub_mode') === 'subscribe' &&
    //             $request->input('hub_verify_token') === $verify_token
    //         ) {
    //             return response($request->input('hub_challenge'), 200);
    //         }
    
    //         return response('Verification token mismatch', 403);
    //     }
    
    //     // POST request handling (messages/events)
    //     Log::info('Facebook webhook received:', $request->all());
    
    //     return response('EVENT_RECEIVED', 200);
    // }

    public function webhook(Request $request)
{
    // dd('sdvdsv');
    if ($request->isMethod('get')) {
        $verify_token = 'your_custom_verify_token';

        if (
            $request->input('hub_mode') === 'subscribe' &&
            $request->input('hub_verify_token') === $verify_token
        ) {
            return response($request->input('hub_challenge'), 200);
        }

        return response('Verification token mismatch', 403);
    }

    // Log the payload
    Log::info('Facebook webhook received:', $request->all());

    // Process incoming message
    $data = $request->all();

    if (isset($data['entry'][0]['messaging'][0])) {
        $messaging = $data['entry'][0]['messaging'][0];

        $senderId = $messaging['sender']['id'];
        $messageText = $messaging['message']['text'] ?? null;

        if ($messageText) {
            ChatbotMessage::create([
                'message'    => $messageText,
                'sender_id'  => $senderId,
                'ip_address' => $request->ip(),
            ]);

            // Optional: auto-reply
            $accessToken = 'YOUR_PAGE_ACCESS_TOKEN';
            Http::post("https://graph.facebook.com/v19.0/me/messages?access_token={$accessToken}", [
                'recipient' => ['id' => $senderId],
                'message' => ['text' => 'Thanks for messaging us!'],
            ]);
        }
    }

    return response('EVENT_RECEIVED', 200);
}

}