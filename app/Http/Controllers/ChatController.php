<?php
namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{

    public function getChatList()
    {
        $authUserId = Auth::id();
        $contacts = Chat::where('sender_id', $authUserId)
                        ->orWhere('receiver_id', $authUserId)
                        ->orderBy('created_at', 'desc')
                        ->get()
                        ->unique(function ($chat) use ($authUserId) {
                            return $chat->sender_id === $authUserId ? $chat->receiver_id : $chat->sender_id;
                        });
    
        return view('messages.chat-list', compact('contacts'))->render();
    }
    
    public function getConversation(Request $request)
    {
        $authUserId = Auth::id();
        $contactId = $request->input('contact_id');
        $conversation = Chat::where(function ($query) use ($authUserId, $contactId) {
            $query->where('sender_id', $authUserId)
                  ->where('receiver_id', $contactId);
        })->orWhere(function ($query) use ($authUserId, $contactId) {
            $query->where('sender_id', $contactId)
                  ->where('receiver_id', $authUserId);
        })->orderBy('created_at', 'asc')->get();
    
        return view('messages.conversation', compact('conversation'))->render();
    }
    
    public function sendMessage(Request $request)
    {
        $authUserId = Auth::id();
        $contactId = $request->input('contact_id');
        $message = $request->input('message');
    
        $chat = Chat::create([
            'sender_id' => $authUserId,
            'receiver_id' => $contactId,
            'content' => $message,
            'is_read' => false,
        ]);
    
        return view('messages.single-message', compact('chat'))->render();
    }
    

}
