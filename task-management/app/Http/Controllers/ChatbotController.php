<?php
namespace App\Http\Controllers;

use App\Models\ChatbotMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ChatbotController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $userId = Auth::check() ? Auth::id() : null;
        // dd($userId);

        $user = auth()->user();

        $chat             = new ChatbotMessage();
        $chat->message    = $request->message;
        $chat->ip_address = $request->ip() ?? '';
        $chat->sender_id  = Session::get('user_id');
        $chat->save();

        // Send to Facebook
        $accessToken = 'EAA3q9I0pZCPoBO4fyamu8nh5Wtx9fB1OtHB3tsM9hwOuZCkcK1ZAYFkDhZCG1K1etBiDrvno34YIyBWcljoX5n5VZA3N2hkBjCGeOyzUXeul4adRQIuL398Fmq4H4ek3NfZA3w9ZBuLmd9RdFmeIF65ksrVZAAp09ZAi4l1WXP21C2ZBdpr0zQ6lvdgysF0aJhNhZBZCv4gK1ABvCfaV6bt0HgZDZD';
        $recipientId = '9266832620088889'; //profile id
        // $recipientId = '617805081422489'; // page id

        Http::post("https://graph.facebook.com/v22.0/me/messages?access_token={$accessToken}", [
//         Http::post("https://graph.facebook.com/{$recipientId}/subscribed_apps
//   ?subscribed_fields=feed
//   &access_token={$accessToken}", [
            'recipient' => [
                'id' => $recipientId,
            ],
            'message'   => [
                'text' => $request->message,
            ],
        ]);

        return response()->json(['status' => 'Message saved successfully']);
    }

    public function fetchMessages(Request $request)
    {
        $messages = ChatbotMessage::orderBy('created_at', 'asc')->get();

        return response()->json($messages);
    }

}
