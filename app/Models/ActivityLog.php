<?php

namespace App\Models;   // <-- NAMESPACE WAJIB DITAMBAHKAN

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id', 'action', 'description', 
        'ip_address', 'user_agent', 'payload'
    ];
    
    protected $casts = [
        'payload' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}