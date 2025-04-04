<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payments;
use Illuminate\Http\Request;
use Carbon\Carbon;


class PaymentController extends Controller
{



    public function getPayments()
    {
        $payments = Payments::with('user')->get();

        // Check each payment and update status if end_date has passed
        foreach ($payments as $payment) {
            if (
                $payment->status === 'active' &&
                $payment->end_date !== null &&
                Carbon::parse($payment->end_date)->isPast()
            ) {
                $payment->status = 'inactive';
                $payment->save();
            }
        }

        $payments = Payments::with('user')->get();

        $data = $payments->map(function ($payment) {
            return [
                'id' => $payment->id,
                'user_id' => $payment->user_id,
                'user_name' => $payment->user->name,
                'user_email' => $payment->user->email,
                'amount' => $payment->amount,
                'plan_name' => $payment->plan_name,
                'status' => $payment->status,
                'end_date' => $payment->end_date,
            ];
        });

        return response()->json(['user_payment' => $data]);
    }


    public function deletePayment($id){
        $payment = Payments::find($id);
        $payment->delete();
        $data = [
            'message' => 'Payment Deleted Successfully',
        ];
        return response()->json($data);
    }
}
