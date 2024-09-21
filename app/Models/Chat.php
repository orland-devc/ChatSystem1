<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Chat extends Model
{
    protected $fillable = ['sender_id', 'receiver_id', 'content', 'is_read'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function scopeLastChatBetween($query, $userId1, $userId2)
    {
        return $query->where(function ($query) use ($userId1, $userId2) {
            $query->where('sender_id', $userId1)->where('receiver_id', $userId2);
        })->orWhere(function ($query) use ($userId1, $userId2) {
            $query->where('sender_id', $userId2)->where('receiver_id', $userId1);
        })->orderBy('created_at', 'desc')->first();
    }

    
    public function formatChatTime($timestamp)
    {
        $time = Carbon::parse($timestamp);
        $now = Carbon::now();

        if ($time->diffInSeconds($now) < 60) {
            return 'just now';
        } elseif ($time->isToday()) {
            return $time->format('h:i A');
        } elseif ($time->diffInHours($now) < 24) {
            return $time->format('h:i A');
        } elseif ($time->diffInDays($now) < 7) {
            return $time->format('l'); // Day of the week
        } elseif ($time->diffInDays($now) < 365) {
            return $time->format('M d'); // Short month and day
        } else {
            return $time->format('M d Y'); // Short month, day, and year
        }
    }

    function truncateMessage($message, $limit = 10)
    {
        return strlen($message) > $limit ? substr($message, 0, $limit) . '...' : $message;
    }

}
