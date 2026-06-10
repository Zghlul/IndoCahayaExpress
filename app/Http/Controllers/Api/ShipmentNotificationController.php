<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShipmentNotificationController extends Controller
{
    public function checkNew(Request $request)
    {
        // Hanya untuk role admin/dev/owner
        $user = Auth::user();
        if (!$user || !in_array($user->role, ['admin', 'dev', 'owner'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $since = $request->query('since');
        $query = Shipment::orderBy('created_at', 'desc');

        if ($since) {
            $query->where('created_at', '>', $since);
        }

        $newShipments = $query->limit(10)->get(['id', 'awb_number', 'receiver_name', 'created_at']);

        return response()->json([
            'new_shipments' => $newShipments,
        ]);
    }
}