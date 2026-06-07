<?php
namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    // جيب كاع المستعملين باش نهدرو معاهم
    public function getContacts()
    {
        return response()->json(User::all());
    }

    // جيب الميساجات بيني وبين شي حد
    public function getMessages($user1_id, $user2_id)
    {
        $messages = Message::where(function($q) use ($user1_id, $user2_id) {
            $q->where('sender_id', $user1_id)->where('receiver_id', $user2_id);
        })->orWhere(function($q) use ($user1_id, $user2_id) {
            $q->where('sender_id', $user2_id)->where('receiver_id', $user1_id);
        })->orderBy('created_at', 'asc')->get();

        return response()->json($messages);
    }

    // صيفط ميساج جديد
    public function store(Request $request)
    {
        $message = Message::create([
            'sender_id' => $request->sender_id,
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
        ]);
        return response()->json($message, 201);
    }
}