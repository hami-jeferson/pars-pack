<?php

namespace App\Http\Controllers;

use App\Http\Resources\AppResource;
use App\Models\App;
use App\Models\ExpiredSubscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function getExpiredSubscriptions(Request $request)
    {
        $payLoad = [];
        // Get the latest record of expired subscriptions count.
        $latestRecord = ExpiredSubscription::LastRecord()->first();
        if($latestRecord){
            $apps = App::all();

            $data = [
                'sync_date' => $latestRecord->sync_date,
                'total_expired_count' => $latestRecord->expired_count,
                'details' => AppResource::collection($apps)->toArray($request),
            ];

            $payLoad = [
                'success' => true,
                'data' => $data,
            ];
        }else{
            $payLoad = ['success'=>false,
                        'message'=>'There is no data(synchronization service not run yet.)'];
        }

        // Return the count of expired subscriptions.
        return response()->json($payLoad);
    }
}
