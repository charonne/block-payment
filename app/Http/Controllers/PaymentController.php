<?php

namespace App\Http\Controllers;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Address;
use App\Payment;
use App\Factory\KeyUtils;

class PaymentController extends Controller
{
   
    /**
     * Add a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Data
        $title = $request->input('title');
        $nbAddress = $request->input('nb_address');
        
        // Rules
        $rules = [
            'nb_address' => 'required|integer|min:1',
        ];
        
        // Make validator
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return redirect('payment')
                        ->withErrors($validator)
                        ->withInput();
        }
        
        // Generate key
        $key = new KeyUtils();
        $idKey = $key->generate(4);
        
        // Store payment
        $payment = new Payment;
        $payment->title = $title;
        $payment->nb_address = $request->nb_address;
        $payment->id_key = $idKey;
        $payment->nb_participant = 0;
        $payment->status = 0;
        $payment->save();
        
        // Get all payments
        $payments = Payment::orderBy('created_at', 'desc')->get();
        
        // Display
        return view('payment.payment', ['valid' => 1, 'payments' => $payments, 'payment' => $payment]);
    }
    
    public function show()
    {
        if (Auth::check()) {
            // Get all payments
            $payments = Payment::orderBy('created_at', 'desc')->get();
            
            // Display
            return view('payment.payment', ['valid' => 0, 'payments' => $payments]);
        } else {
            return redirect()->route('home');
        }
            
    }
    
    public function participants($idkey)
    {
        // Get Payment
        $payment = Payment::where('id_key', '=', $idkey)->first();
        
        // Get all participants
        $participants = Address::where('payment_id', '=', $payment->id)->get();
       
        // Display
        return view('payment.participants', ['valid' => 0, 'participants' => $participants]);
    }
}
