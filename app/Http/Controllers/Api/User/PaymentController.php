<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PaymentController extends Controller
{




    public function addPayment(Request $request){
        $user = $request->user();

        $validation = Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'plan_name' => 'required|string',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        }

        // Determine the end date based on the plan_name
        $endDate = null;
        if (strtolower($request->plan_name) === 'month') {
            $endDate = Carbon::now()->addMonth();
        } elseif (strtolower($request->plan_name) === 'year') {
            $endDate = Carbon::now()->addYear();
        }

        $payment = Payments::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'plan_name' => $request->plan_name,
            'status' => 'active',
            'end_date' => $endDate,
        ]);

        return response()->json(['message' => 'Payment Added Successfully', 'payment' => $payment]);
    }

}
