<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'ticket_id',
        'file_name',
        'file_location',
    ];
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
    
}
