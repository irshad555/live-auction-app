<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageSent;
use App\Models\ChatMessage;

class ChatController extends Controller
{
    public function send(Request $request)
    {
        $message = ChatMessage::create([
            'product_id' => $request->product_id,
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        broadcast(new MessageSent(auth()->user()->name, $request->message, $request->product_id))->toOthers();

        return response()->json(['success' => true]);
    }
}
