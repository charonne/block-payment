<?php

namespace App\Http\Controllers;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Address;
use App\Payment;
use App\Factory\Bitcoin;

class AddressController extends Controller
{
    
    
    /**
     * Add the payment code
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function code(Request $request)
    {
        $idkey = $request->input('code');
        
        // Rules
        $rules = [
            'code' => 'required',
        ];
        
        // Make validator
        $validator = Validator::make($request->all(), $rules);
        
        // Get Payment
        $payment = Payment::where('id_key', '=', $idkey)->first();
        
        if ($payment) {
            return redirect()->action(
                'AddressController@show', ['idkey' => $idkey]
            );
        } else {
            // View
            $validator->errors()->add('code', 'The payment code is invalid.');
            return redirect('/')
                        ->withErrors($validator)
                        ->withInput();
        }
        
    }
    
    /**
     * Add a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $idkey)
    {
        // Data
        $bitcoinAddress = $request->input('bitcoin_address');
        $privateKey = $request->input('private_key');
        $email = $request->input('email');
        $name = $request->input('name');
        $check = $request->input('check');
        
        // Get Payment
        $payment = Payment::where('id_key', '=', $idkey)->first();
        $payment->increment('nb_participant');
        $payment->save();
        
        // Rules
        $rules = [
            'email' => 'required|email',
            'name' => 'required',
            'check' => 'required',
            'bitcoin_address' => 'required',
        ];
        
        // Make validator
        $validator = Validator::make($request->all(), $rules);
        
        // Bitcoin address already registered
        $addressExist = Address::where('bitcoin_address', '=', $bitcoinAddress)->where('payment_id', '=', $payment->id)->first();
        
        // Bitcoin validator
        $bitcoin = new Bitcoin();
        if ($bitcoin->validate($bitcoinAddress) == false) {
            $validator->errors()->add('bitcoin_address', 'The bitcoin address is invalid.');
            return redirect('address/' . $idkey)
                        ->withErrors($validator)
                        ->withInput();
        } elseif ($addressExist) {
            $validator->errors()->add('bitcoin_address', 'This account is already registered, please wait for the payment.');
            return redirect('address/' . $idkey)
                        ->withErrors($validator)
                        ->withInput();
        } else {
            if ($validator->fails()) {
                return redirect('address/' . $idkey)
                            ->withErrors($validator)
                            ->withInput();
            }
        }
        
        // Store address
        $address = new Address;
        $address->payment_id = $payment->id;
        $address->bitcoin_address = $bitcoinAddress;
        $address->private_key = $privateKey;
        $address->email = $email;
        $address->name = $name;
        $address->status = 0;
        $address->save();
        
        // Display
        return view('address.address', ['valid' => 1, 'address' => $address]);
    }
    
    public function show($idkey)
    {
        // Get Payment
        $payment = Payment::where('id_key', '=', $idkey)->first();
        
        // If payment status is finished
        if ($payment->status == 1) {
            // Display
            return view('address.address', ['valid' => -1, 'idkey' => $idkey]);
        }
        
        // Display
        return view('address.address', ['valid' => 0, 'idkey' => $idkey]);
    }
}
