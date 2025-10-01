<?php

namespace App\Repositories;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class LogRepository
{
    public function logActivity(string $activity, ?string $ipAddress = null)
    {
        return Log::create([
            'user_id' => Auth::id(),
            'activity' => $activity,
            'ip_address' => $ipAddress,
        ]);
    }
}
