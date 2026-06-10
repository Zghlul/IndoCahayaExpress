<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Request;

trait LogsActivity
{
    protected function logActivity($action, $description = null, $payload = [])
    {
        ActivityLog::create([
            'user_id'    => auth()->id(),
            'action'     => $action,
            'description'=> $description,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'payload'    => $payload,
        ]);
    }
}