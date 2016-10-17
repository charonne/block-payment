<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Address;
use App\Payment;

use BlockIo;
use App\Factory\Bitcoin;

class PaymentCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:check {idkey}';
    protected $paymentAddress = null;
    
    private $chunksLimit = 2500;
    private $amount = '0.00030000';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check payments from a list';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Start
        $this->info('Block Payment Start');
        
        // Get id key
        $idkey = $this->argument('idkey');
        
        // Get Payment
        $payment = Payment::where('id_key', '=', $idkey)->first();
        if (!$payment) {
            $this->error('Payment ' . $idkey . ' not found!');
            exit(0);
        }
        
        // Get all addresses
        $addresses = Address::where('payment_id', '=', $payment->id)->get();
        $nbParticipant = count($addresses);
        
        // Get all addresses
        $bitcoin = new Bitcoin();
        $this->line('Check ' . $nbParticipant . ' addresses');
        foreach ($addresses as $index => $address) {
            $balance = $bitcoin->getBalance($address->bitcoin_address);
            if ($balance == 0) {
                $this->info($address->bitcoin_address . ': ' . $balance);
                $address->status = 1;
                $address->save();
            } else {
                $this->error($address->bitcoin_address . ': ' . $balance);
                $address->status = -1;
                $address->save();
            }
        }
        
        // Exit
        $this->info('\o/ All payments have been checked');
        $this->line('Closing');
    }
}
