<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Bank;
use App\Models\CustomerBank;
use App\Models\BankPrices;
use App\Models\RateType;
use App\Mail\SendLinkToCustomer;
use Log;
use DB;

class SendFormToCustomer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sendFormToCustomer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Form Link To Update Prices';

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
     * @return int
     */
    public function handle()
    {
        $matchingData = Bank::join('customer_bank', function ($join) {
            $join->on('banks.name', '=', 'customer_bank.bank_name')
                ->on('banks.state_id', '=', 'customer_bank.state')
                ->on('banks.city_id', '=', 'customer_bank.city_id');
        })
        ->select('banks.*', 'customer_bank.bank_email')
        ->get();
        foreach ($matchingData as $value) {
            $bank_email = $value->bank_email;
            $cp_email = $value->cp_email;
            $id = $value->id;
            $rt = RateType::orderby('display_order')->get();
            $prices = [];
            foreach ($rt as $key => $rate) {
                $data = BankPrices::select('bank_prices.*', 'banks.name as bank_name','rate_types.name')
                ->join('banks', 'bank_prices.bank_id', 'banks.id')
                ->join('rate_types', 'rate_types.id', 'bank_prices.rate_type_id')
                ->whereIn('bank_prices.created_at', function ($query) use ($id,$rate) {
                    $query->selectRaw('MAX(created_at)')
                        ->from('bank_prices')
                        ->where('rate_type_id', $rate->id)
                        ->where('is_checked', 1)
                        ->where('bank_id', $id)
                        ->groupBy('bank_id');
                })
                ->where('rate_type_id', $rate->id)
                ->where('is_checked', 1)
                ->where('bank_id', $id) // Assuming $banks is an array containing selected bank IDs
                ->groupBy('bank_id') // Group by bank_id to get the latest rate for each bank in the current rate type
                ->orderBy('current_rate', 'DESC')
                ->first();
                array_push($prices,$data);
            }
            // Mail::to($bank_email)->send(new SendLinkToCustomer($id));
            Mail::to($cp_email)->send(new SendLinkToCustomer($id,$prices));
            Log::info($prices);
        }
    }
}
