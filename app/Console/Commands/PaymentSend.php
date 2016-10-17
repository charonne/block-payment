<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Address;
use App\Payment;

use BlockIo;
use App\Factory\Bitcoin;

class PaymentSend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:send {idkey}';
    protected $paymentAddress = null;
    
    private $chunksLimit = 2500;
    private $amount = '0.00030000';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send payments to a list';

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
     * Block payment
     */
    public function blockPayment($addresses)
    {
        // Block IO
        $apiKey = config('api.blockio.apiKey');
        $pin = config('api.blockio.pin');
        $version = 2; // the API version to use
        $block_io = new BlockIo($apiKey, $pin, $version);

        // Get bitcoin utils
        $bitcoin = new Bitcoin();
        
        // Get all addresses
        $totalAmount = 0;
        foreach ($addresses as $index => $address) {
            $paymentList[$address] = $this->amount;
            $totalAmount += $this->amount;
        }
        
        $this->line("Total amount to pay is: " . $totalAmount . " BTC, $" . $bitcoin->getDollarPrice($totalAmount));
        
        // Get payment address
        $this->line("Get block.io address for payment");
        $blockAddresses = $block_io->get_my_addresses();
        $paymentAddress = null;
        foreach($blockAddresses->data->addresses as $address) {
            $this->line("Wallet address: " . $address->address . ", has: " . $address->available_balance);
            if ($address->available_balance > $totalAmount) {
                $this->line($address->address . ' has ' . $address->available_balance . ', enough for ' . $totalAmount . ' payments');
                $this->paymentAddress = $address->address;
                break;
            }
        }
        
        // Check if sufficient balance
        if (is_null($this->paymentAddress)) {
            $this->error('Sorry, no sufficient balance');
            exit(0);
        }
        
        // Ask to continue
        $this->info("You are about to pay " . count($addresses) . " users for a total of " . $totalAmount . " BTC, $" . $bitcoin->getDollarPrice($totalAmount));
        if ($this->confirm('Do you wish to continue? [y|N]')) {
            //
            $this->info('You approve the payment');
        } else {
            $this->error("You didn't approve the payment");
            exit(0);
        }
        
        // Start payments
        $this->line('Start block.io payments');
        
        $chunks = array_chunk($paymentList, $this->chunksLimit, true);
        $i = 1;
        foreach ($chunks as $chunk) {
			try {
                // Format payments to strings
                $keys = array();
				$values = array();
                
                $sum = 0;
                foreach ($chunk as $key => $value) {
					array_push($keys, $key);
					array_push($values, $value);
                    $sum = bcadd($sum, $value, 8);
				}
                
                $paymentAddresses = implode (',', $keys);
				$paymentAmounts = implode (',', $values);
                
                // Send payment
                /*
                $this->line('Lot: ' . $i . '/' . count($chunks) . ', ' . $sum . ' BTC');
                $blockTx = $block_io->withdraw_from_addresses(array(
                    'amounts' => $paymentAmounts,
                    'from_addresses' => $this->paymentAddress,
                    'to_addresses' => $paymentAddresses,
                    'priority' => 'medium'
                ));
                
                // Success
                if ($blockTx->status == 'success') {
                    $this->info("Lot " . $i . " payments successful, tx: " . $blockTx->data->txid);
                } else {
                    $this->error("Lot " . $i . " failed");
                    print_r($blockTx);
                }
                */
            } catch (error $e) {
				$this->writeln("ERROR $i: ". $e->getMessage() . "\n<br />\n");
			}
            $i++;
        }
        
        return 1;
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
        } elseif ($payment->status == 1) {
            $this->error("Warning: payments already sent");
        }
        
        // Get all addresses
        $addresses = Address::where('payment_id', '=', $payment->id)->get();
        $nbParticipant = count($addresses);
        
        $this->line('Payment ' . $idkey . ' found');
        $this->line('Number of addresses ' . $payment->nb_participant . ' on ' . $payment->nb_address);
        
        // Get all addresses
        foreach ($addresses as $index => $address) {
            $paymentList[] = $address->bitcoin_address;
        }
        
        // Send payments
        if ($this->blockPayment($paymentList)) {
            $payment->status = 1;
            $payment->save();
        }
        
        // Exit
        $this->info('\o/ All payments have been sent');
        $this->line('Closing');
    }
}
