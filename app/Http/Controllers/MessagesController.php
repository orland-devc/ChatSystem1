<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        // Get chats with the latest message for each sender
        $chats = Message::select('sender_id', 'receiver_id')
            ->where('receiver_id', $userId)
            ->orWhere('sender_id', $userId)
            ->groupBy('sender_id', 'receiver_id')
            ->with('sender', 'latest_message')
            ->get();

        return view('messages.index', compact('chats'));
    }

    public function show($id)
    {
        $userId = Auth::id();
        $messages = Message::where(function ($query) use ($id, $userId) {
            $query->where('sender_id', $userId)->where('receiver_id', $id);
        })->orWhere(function ($query) use ($id, $userId) {
            $query->where('sender_id', $id)->where('receiver_id', $userId);
        })->get();

        $chatWith = User::find($id)->name;

        return response()->json([
            'chatWith' => $chatWith,
            'messages' => $messages,
            'currentUserId' => $userId
        ]);
    }

    public function store(Request $request, $id)
    {
        $userId = Auth::id();

        $message = Message::create([
            'sender_id' => $userId,
            'receiver_id' => $id,
            'body' => $request->body,
            'is_read' => false,
            'is_archived' => false
        ]);

        return response()->json($message);
    }
}
