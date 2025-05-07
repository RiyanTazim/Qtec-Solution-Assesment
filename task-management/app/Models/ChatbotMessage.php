<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatbotMessage extends Model
{
    use HasFactory;

    protected $table = 'chatbot';

    protected $fillable = [
        'message',
        'sender_id',
        'timestamp',
    ];

    public $timestamps = false; // Set to true if your table has created_at/updated_at
}
