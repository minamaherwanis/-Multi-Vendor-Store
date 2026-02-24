<?php

namespace App\Http\Controllers\Api;

use App\Events\DeliveryLocationUpdated;
use App\Http\Controllers\Controller;
use App\Models\Delivery;
use Illuminate\Http\Request;

class DeliveriesController extends Controller
{
        public function show(Delivery $delivery)
    {
        return response()->json([
           
            'latitude' => $delivery->latitude,
            'longitude' => $delivery->longitude,

        ]);
    }

    public function update(Request $request, Delivery $delivery)
    {

        $request->validate([
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
        ]);
        $delivery->update([
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),

        ]);
        event(new DeliveryLocationUpdated($delivery,$request->latitude,$request->longitude));
        return $delivery;
    }
}
