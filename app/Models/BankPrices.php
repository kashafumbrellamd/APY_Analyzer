<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bank;
use App\Models\CustomerBank;
use App\Models\CustomPackageBanks;
use App\Models\RateType;
use DB;

class BankPrices extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_id',
        'rate_type_id',
        'rate',
        'previous_rate',
        'current_rate',
        'change',
        'is_checked',
    ];
    public function rates(){
        return $this->belongsTo(RateType::class);
    }

    public function BankPricesWithType($id)
    {
        // $latestRates = BankPrices::select('bank_prices.*', 'rate_types.name as rate_type_name')
        // ->join('rate_types', 'rate_types.id', '=', 'bank_prices.rate_type_id')
        // ->where('bank_prices.bank_id',$id)
        // ->groupBy('bank_prices.rate_type_id')
        // ->latest('bank_prices.created_at')
        // ->get();
        // $id=2;
        $latestRates= BankPrices::select('bank_prices.id', 'bank_prices.rate_type_id','bank_prices.previous_rate','bank_prices.current_rate','bank_prices.change', 'bank_prices.rate', 'bank_prices.created_at','bank_prices.is_checked','rate_types.name as rate_type_name')
        ->whereIn('bank_prices.created_at', function ($query) use ($id) {
            $query->selectRaw('MAX(created_at)')
                ->from('bank_prices')
                ->where('bank_id', $id)
                ->groupBy('rate_type_id');
        })
        ->where('bank_prices.bank_id', $id)
        ->join('rate_types', 'bank_prices.rate_type_id', '=', 'rate_types.id')
        ->get();
        //BankPrices::distinct('rate_type_id')->where('bank_id',$id)->with('rates')->get();
        // dd($latestRates);
        return $latestRates;
    }

    public function BankReports($selected_bank_type)
    {
        $filter = CustomerBank::where('id',auth()->user()->bank_id)->first();
        if($filter->display_reports == 'state' && $selected_bank_type == ""){
            $banks = Bank::where('state_id',$filter->state)->get();
        }elseif ($filter->display_reports == 'msa' && $selected_bank_type == ""){
            $banks = Bank::where('msa_code',$filter->msa_code)->get();
        }elseif ($filter->display_reports == 'state' && $selected_bank_type != ""){
            $banks = Bank::where('state_id',$filter->state)->where('bank_type_id',$selected_bank_type)->get();
        }elseif ($filter->display_reports == 'msa' && $selected_bank_type != ""){
            $banks = Bank::where('msa_code',$filter->msa_code)->where('bank_type_id',$selected_bank_type)->get();
        }elseif($filter->display_reports == 'custom' && $selected_bank_type == ""){
            $selected_banks = CustomPackageBanks::where('bank_id',$filter->id)->pluck('customer_selected_bank_id')->toArray();
            $banks = Bank::whereIn('id',$selected_banks)->get();
        }else{
            $selected_banks = CustomPackageBanks::where('bank_id',$filter->id)->where('bank_type_id',$selected_bank_id)->pluck('customer_selected_bank_id')->toArray();
            $banks = Bank::whereIn('id',$selected_banks)->get();
        }
        $rate_types = RateType::orderby('id','ASC')->get();
        foreach ($banks as $key => $bank) {
            foreach ($rate_types as $re_key => $rt) {
                $bank[$rt->id] = BankPrices::where('bank_id',$bank->id)
                ->where('rate_type_id',$rt->id)
                ->where('is_checked',1)
                ->orderby('id','DESC')
                ->first();
            }
        }
        return $banks;
    }

    public function SeperateReports($type,$code)
    {
        if($type == 'state')
        {
            $banks = Bank::where('state_id',$code)->pluck('id')->toArray();
        }
        elseif($type == 'msa')
        {
            $banks = Bank::where('msa_code',$code)->pluck('id')->toArray();
        }
        else
        {
            $filter = CustomerBank::where('id',auth()->user()->bank_id)->first();
            if($filter->display_reports == 'state'){
                $banks = Bank::where('state_id',$filter->state)->pluck('id')->toArray();
            }elseif ($filter->display_reports == 'msa') {
                $banks = Bank::where('msa_code',$filter->msa_code)->pluck('id')->toArray();
            }else{
                $banks = CustomPackageBanks::where('bank_id',$filter->id)->pluck('customer_selected_bank_id')->toArray();
                //$banks = Bank::whereIn('id',$selected_banks)->get();
            }
        }
        $rate_types = RateType::orderby('id','ASC')->get();
        foreach ($rate_types as $key => $rt) {
            $id = $rt->id;
            $rt['banks'] = BankPrices::select('bank_prices.*','banks.name as bank_name')
            ->join('banks','bank_prices.bank_id','banks.id')
            ->whereIn('bank_prices.created_at', function ($query) use ($id) {
                $query->selectRaw('MAX(created_at)')
                    ->from('bank_prices')
                    ->where('rate_type_id', $id)
                    ->where('is_checked',1)
                    ->groupBy('bank_id')
                    ->get();
            })
            ->whereIn('bank_id',$banks)
            ->orderby('current_rate','DESC')
            ->get();
        }
        return $rate_types;
    }

    public function BankReportsWithState($state_id,$selected_bank_type)
    {
        if($selected_bank_type == ""){
            $banks = Bank::where('state_id',$state_id)
            ->join('custom_package_banks','banks.id','custom_package_banks.customer_selected_bank_id')
            ->select('banks.*')
            ->get();
        }else{
            $banks = Bank::where('state_id',$state_id)
            ->join('custom_package_banks','banks.id','custom_package_banks.customer_selected_bank_id')
            ->where('banks.bank_type_id',$selected_bank_type)
            ->select('banks.*')
            ->get();

        }
        $rate_types = RateType::orderby('id','ASC')->get();
        foreach ($banks as $key => $bank) {
            foreach ($rate_types as $re_key => $rt) {
                $bank[$rt->id] = BankPrices::where('bank_id',$bank->id)
                ->where('rate_type_id',$rt->id)
                ->where('is_checked',1)
                ->orderby('id','DESC')
                ->first();
            }
        }
        return $banks;
    }
    public function BankReportsWithMsa($msa,$selected_bank_type)
    {
        $filter = CustomerBank::where('id',auth()->user()->bank_id)->first();
        if($selected_bank_type == ""){
            $banks = Bank::where('state_id',$filter->state)->where('msa_code',$msa)->get();
        }else{
            $banks = Bank::where('state_id',$filter->state)->where('msa_code',$msa)->where('bank_type_id',$selected_bank_type)->get();
        }
        $rate_types = RateType::orderby('id','ASC')->get();
        foreach ($banks as $key => $bank) {
            foreach ($rate_types as $re_key => $rt) {
                $bank[$rt->id] = BankPrices::where('bank_id',$bank->id)
                ->where('rate_type_id',$rt->id)
                ->where('is_checked',1)
                ->orderby('id','DESC')
                ->first();
            }
        }
        return $banks;
    }

    public function get_min_max_func()
    {
        $filter = CustomerBank::where('id',auth()->user()->bank_id)->first();
        if($filter->display_reports == 'custom'){
            $selected_banks = CustomPackageBanks::where('bank_id',$filter->id)->pluck('customer_selected_bank_id')->toArray();
            $rate_types = RateType::orderby('id','ASC')->get();
            foreach ($rate_types as $re_key => $rt) {
                $id = $rt->id;
                $rt->c_max = BankPrices::whereIn('bank_id',$selected_banks)->whereIn('bank_prices.created_at', function ($query) use ($id) {
                    $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                    ->where('is_checked',1)->groupBy('bank_id');
                })->max('current_rate');
                $rt->p_max = BankPrices::whereIn('bank_id',$selected_banks)->whereIn('bank_prices.created_at', function ($query) use ($id) {
                    $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                    ->where('is_checked',1)->groupBy('bank_id');
                })->max('previous_rate');
                $rt->c_min = BankPrices::whereIn('bank_id',$selected_banks)->whereIn('bank_prices.created_at', function ($query) use ($id) {
                    $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                    ->where('is_checked',1)->groupBy('bank_id');
                })->min('current_rate');
                $rt->p_min = BankPrices::whereIn('bank_id',$selected_banks)->whereIn('bank_prices.created_at', function ($query) use ($id) {
                    $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                    ->where('is_checked',1)->groupBy('bank_id');
                })->min('previous_rate');
                $rt->c_avg = BankPrices::whereIn('bank_id',$selected_banks)->whereIn('bank_prices.created_at', function ($query) use ($id) {
                    $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                    ->where('is_checked',1)->groupBy('bank_id');
                })->avg('current_rate');
                $rt->p_avg = BankPrices::whereIn('bank_id',$selected_banks)->whereIn('bank_prices.created_at', function ($query) use ($id) {
                    $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                    ->where('is_checked',1)->groupBy('bank_id');
                })->avg('previous_rate');

                $get_mod = BankPrices::whereIn('bank_id',$selected_banks)->whereIn('bank_prices.created_at', function ($query) use ($id) {
                    $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                    ->where('is_checked',1)->groupBy('bank_id');
                })->pluck('previous_rate')->toArray();
                if($get_mod != null){
                    $abc = array_map('strval',$get_mod);
                    $counts = array_count_values($abc);
                    arsort($counts);
                    $rt->c_mode = array_keys($counts)[0];
                    sort($abc);
                    $count = count($abc);
                    $middle = floor(($count - 1) / 2);
                    if ($count % 2 == 0) {
                        $rt->c_med = ($abc[$middle] + $abc[$middle + 1]) / 2;
                    } else {
                        $rt->c_med = $abc[$middle];
                    }
                }
                $get_mod = BankPrices::whereIn('bank_id',$selected_banks)->whereIn('bank_prices.created_at', function ($query) use ($id) {
                    $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                    ->where('is_checked',1)->groupBy('bank_id');
                })->pluck('previous_rate')->toArray();
                if($get_mod != null){
                    $abc = array_map('strval',$get_mod);
                    $counts = array_count_values($abc);
                    arsort($counts);
                    $rt->p_mode = array_keys($counts)[0];
                    sort($abc);
                    $count = count($abc);
                    $middle = floor(($count - 1) / 2);
                    if ($count % 2 == 0) {
                        $rt->p_med = ($abc[$middle] + $abc[$middle + 1]) / 2;
                    } else {
                        $rt->p_med = $abc[$middle];
                    }
                }
            }
            return $rate_types;
        }elseif($filter->display_reports == 'state'){
            $rate_types = RateType::orderby('id','ASC')->get();
            foreach ($rate_types as $re_key => $rt) {
                $id = $rt->id;
                $rt->c_max = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
                    $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                    ->where('is_checked',1)->groupBy('bank_id');
                })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
                ->where('banks.state_id',$filter->state)->max('current_rate');
                $rt->p_max = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
                    $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                    ->where('is_checked',1)->groupBy('bank_id');
                })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
                ->where('banks.state_id',$filter->state)->max('previous_rate');
                $rt->c_min = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
                    $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                    ->where('is_checked',1)->groupBy('bank_id');
                })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
                ->where('banks.state_id',$filter->state)->min('current_rate');
                $rt->p_min = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
                    $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                    ->where('is_checked',1)->groupBy('bank_id');
                })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
                ->where('banks.state_id',$filter->state)->min('previous_rate');
                $rt->c_avg = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
                    $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                    ->where('is_checked',1)->groupBy('bank_id');
                })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
                ->where('banks.state_id',$filter->state)->avg('current_rate');
                $rt->p_avg = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
                    $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                    ->where('is_checked',1)->groupBy('bank_id');
                })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
                ->where('banks.state_id',$filter->state)->avg('previous_rate');

                $get_mod = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
                    $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                    ->where('is_checked',1)->groupBy('bank_id');
                })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
                ->where('banks.state_id',$filter->state)->pluck('previous_rate')->toArray();
                if($get_mod != null){
                    $abc = array_map('strval',$get_mod);
                    $counts = array_count_values($abc);
                    arsort($counts);
                    $rt->c_mode = array_keys($counts)[0];
                    sort($abc);
                    $count = count($abc);
                    $middle = floor(($count - 1) / 2);
                    if ($count % 2 == 0) {
                        $rt->c_med = ($abc[$middle] + $abc[$middle + 1]) / 2;
                    } else {
                        $rt->c_med = $abc[$middle];
                    }
                }
                $get_mod = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
                    $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                    ->where('is_checked',1)->groupBy('bank_id');
                })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
                ->where('banks.state_id',$filter->state)->pluck('previous_rate')->toArray();
                if($get_mod != null){
                    $abc = array_map('strval',$get_mod);
                    $counts = array_count_values($abc);
                    arsort($counts);
                    $rt->p_mode = array_keys($counts)[0];
                    sort($abc);
                    $count = count($abc);
                    $middle = floor(($count - 1) / 2);
                    if ($count % 2 == 0) {
                        $rt->p_med = ($abc[$middle] + $abc[$middle + 1]) / 2;
                    } else {
                        $rt->p_med = $abc[$middle];
                    }
                }
            }
            return $rate_types;
        }else{
            $rate_types = RateType::orderby('id','ASC')->get();
            foreach ($rate_types as $re_key => $rt) {
                $id = $rt->id;
                $rt->c_max = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
                    $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                    ->where('is_checked',1)->groupBy('bank_id');
                })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
                ->where('banks.msa_code',$filter->msa_code)->max('current_rate');
                $rt->p_max = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
                    $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                    ->where('is_checked',1)->groupBy('bank_id');
                })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
                ->where('banks.msa_code',$filter->msa_code)->max('previous_rate');
                $rt->c_min = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
                    $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                    ->where('is_checked',1)->groupBy('bank_id');
                })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
                ->where('banks.msa_code',$filter->msa_code)->min('current_rate');
                $rt->p_min = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
                    $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                    ->where('is_checked',1)->groupBy('bank_id');
                })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
                ->where('banks.msa_code',$filter->msa_code)->min('previous_rate');
                $rt->c_avg = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
                    $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                    ->where('is_checked',1)->groupBy('bank_id');
                })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
                ->where('banks.msa_code',$filter->msa_code)->avg('current_rate');
                $rt->p_avg = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
                    $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                    ->where('is_checked',1)->groupBy('bank_id');
                })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
                ->where('banks.msa_code',$filter->msa_code)->avg('previous_rate');

                $get_mod = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
                    $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                    ->where('is_checked',1)->groupBy('bank_id');
                })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
                ->where('banks.msa_code',$filter->msa_code)->pluck('previous_rate')->toArray();
                if($get_mod != null){
                    $abc = array_map('strval',$get_mod);
                    $counts = array_count_values($abc);
                    arsort($counts);
                    $rt->c_mode = array_keys($counts)[0];
                    sort($abc);
                    $count = count($abc);
                    $middle = floor(($count - 1) / 2);
                    if ($count % 2 == 0) {
                        $rt->c_med = ($abc[$middle] + $abc[$middle + 1]) / 2;
                    } else {
                        $rt->c_med = $abc[$middle];
                    }
                }
                $get_mod = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
                    $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                    ->where('is_checked',1)->groupBy('bank_id');
                })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
                ->where('banks.msa_code',$filter->msa_code)->pluck('previous_rate')->toArray();
                if($get_mod != null){
                    $abc = array_map('strval',$get_mod);
                    $counts = array_count_values($abc);
                    arsort($counts);
                    $rt->p_mode = array_keys($counts)[0];
                    sort($abc);
                    $count = count($abc);
                    $middle = floor(($count - 1) / 2);
                    if ($count % 2 == 0) {
                        $rt->p_med = ($abc[$middle] + $abc[$middle + 1]) / 2;
                    } else {
                        $rt->p_med = $abc[$middle];
                    }
                }
            }
            return $rate_types;
        }
    }

    public function get_min_max_func_with_state($state_id)
    {
        $rate_types = RateType::orderby('id','ASC')->get();
        foreach ($rate_types as $re_key => $rt) {
            $id = $rt->id;
            $rt->c_max = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
                $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                ->where('is_checked',1)->groupBy('bank_id');
            })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
            ->join('custom_package_banks', 'banks.id', '=', 'custom_package_banks.customer_selected_bank_id')
            ->where('banks.state_id',$state_id)
            ->max('current_rate');
            $rt->p_max = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
                $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                ->where('is_checked',1)->groupBy('bank_id');
            })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
            ->join('custom_package_banks', 'banks.id', '=', 'custom_package_banks.customer_selected_bank_id')
            ->where('banks.state_id',$state_id)->max('previous_rate');

            $rt->c_min = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
                $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                ->where('is_checked',1)->groupBy('bank_id');
            })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
            ->join('custom_package_banks', 'banks.id', '=', 'custom_package_banks.customer_selected_bank_id')
            ->where('banks.state_id',$state_id)->min('current_rate');
            $rt->p_min = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
                $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                ->where('is_checked',1)->groupBy('bank_id');
            })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
            ->join('custom_package_banks', 'banks.id', '=', 'custom_package_banks.customer_selected_bank_id')
            ->where('banks.state_id',$state_id)->min('previous_rate');

            $rt->c_avg = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
                $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                ->where('is_checked',1)->groupBy('bank_id');
            })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
            ->join('custom_package_banks', 'banks.id', '=', 'custom_package_banks.customer_selected_bank_id')
            ->where('banks.state_id',$state_id)->avg('current_rate');
            $rt->p_avg = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
                $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                ->where('is_checked',1)->groupBy('bank_id');
            })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
            ->join('custom_package_banks', 'banks.id', '=', 'custom_package_banks.customer_selected_bank_id')
            ->where('banks.state_id',$state_id)->avg('previous_rate');

            $get_mod = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
                $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                ->where('is_checked',1)->groupBy('bank_id');
            })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
            ->join('custom_package_banks', 'banks.id', '=', 'custom_package_banks.customer_selected_bank_id')
            ->where('banks.state_id',$state_id)->pluck('previous_rate')->toArray();
            if($get_mod != null){
                $abc = array_map('strval',$get_mod);
                $counts = array_count_values($abc);
                arsort($counts);
                $rt->c_mode = array_keys($counts)[0];
                sort($abc);
                $count = count($abc);
                $middle = floor(($count - 1) / 2);
                if ($count % 2 == 0) {
                    $rt->c_med = ($abc[$middle] + $abc[$middle + 1]) / 2;
                } else {
                    $rt->c_med = $abc[$middle];
                }
            }
            if($get_mod != null){
                $get_mod = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
                    $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                    ->where('is_checked',1)->groupBy('bank_id');
                })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
                ->join('custom_package_banks', 'banks.id', '=', 'custom_package_banks.customer_selected_bank_id')
                ->where('banks.state_id',$state_id)->pluck('previous_rate')->toArray();
                $abc = array_map('strval',$get_mod);
                $counts = array_count_values($abc);
                arsort($counts);
                $rt->p_mode = array_keys($counts)[0];
                sort($abc);
                $count = count($abc);
                $middle = floor(($count - 1) / 2);
                if ($count % 2 == 0) {
                    $rt->p_med = ($abc[$middle] + $abc[$middle + 1]) / 2;
                } else {
                    $rt->p_med = $abc[$middle];
                }
            }
        }
        return $rate_types;
    }
    public function get_min_max_func_with_msa($msa)
    {
        $rate_types = RateType::orderby('id','ASC')->get();
        foreach ($rate_types as $re_key => $rt) {
            $id = $rt->id;

            $rt->c_max = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
                $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                ->where('is_checked',1)->groupBy('bank_id');
            })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
            ->where('banks.msa_code',$msa)
            ->max('current_rate');
            $rt->p_max = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
                $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                ->where('is_checked',1)->groupBy('bank_id');
            })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
            ->where('banks.msa_code',$msa)->max('previous_rate');

            $rt->c_min = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
                $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                ->where('is_checked',1)->groupBy('bank_id');
            })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
            ->where('banks.msa_code',$msa)->min('current_rate');
            $rt->p_min = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
                $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                ->where('is_checked',1)->groupBy('bank_id');
            })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
            ->where('banks.msa_code',$msa)->min('previous_rate');

            $rt->c_avg = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
                $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                ->where('is_checked',1)->groupBy('bank_id');
            })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
            ->where('banks.msa_code',$msa)->avg('current_rate');
            $rt->p_avg = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
                $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                ->where('is_checked',1)->groupBy('bank_id');
            })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
            ->where('banks.msa_code',$msa)->avg('previous_rate');

            $get_mod = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
                $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                ->where('is_checked',1)->groupBy('bank_id');
            })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
            ->where('banks.msa_code',$msa)->pluck('previous_rate')->toArray();
            if($get_mod != null){
                $abc = array_map('strval',$get_mod);
                $counts = array_count_values($abc);
                arsort($counts);
                $rt->c_mode = array_keys($counts)[0];
                sort($abc);
                $count = count($abc);
                $middle = floor(($count - 1) / 2);
                if ($count % 2 == 0) {
                    $rt->c_med = ($abc[$middle] + $abc[$middle + 1]) / 2;
                } else {
                    $rt->c_med = $abc[$middle];
                }
            }
            $get_mod = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
                $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
                ->where('is_checked',1)->groupBy('bank_id');
            })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
            ->where('banks.msa_code',$msa)->pluck('previous_rate')->toArray();
            if($get_mod != null){
                $abc = array_map('strval',$get_mod);
                $counts = array_count_values($abc);
                arsort($counts);
                $rt->p_mode = array_keys($counts)[0];
                sort($abc);
                $count = count($abc);
                $middle = floor(($count - 1) / 2);
                if ($count % 2 == 0) {
                    $rt->p_med = ($abc[$middle] + $abc[$middle + 1]) / 2;
                } else {
                    $rt->p_med = $abc[$middle];
                }
            }
        }
        return $rate_types;
    }

    public function summary_report($id,$selected_bank_type){
        $type = DB::table('customer_bank')->where('id',auth()->user()->bank_id)->first();
        if($type->display_reports == 'state' && $selected_bank_type == ""){
            $banks = Bank::where('state_id',$type->state)->pluck('id')->toArray();
        }elseif($type->display_reports == 'msa' && $selected_bank_type == ""){
            $banks = Bank::where('msa_code',$type->msa_code)->pluck('id')->toArray();
        }elseif($type->display_reports == 'state' && $selected_bank_type != ""){
            $banks = Bank::where('state_id',$type->state)->where('bank_type_id',$selected_bank_type)->pluck('id')->toArray();
        }elseif($type->display_reports == 'msa_code' && $selected_bank_type != ""){
            $banks = Bank::where('msa_code',$type->msa_code)->where('bank_type_id',$selected_bank_type)->pluck('id')->toArray();
        }elseif($type->display_reports == 'custom' && $selected_bank_type == ""){
            $filter = CustomerBank::where('id',auth()->user()->bank_id)->first();
            if($filter->display_reports == 'state'){
                $banks = Bank::where('state_id',$filter->state)->pluck('id')->toArray();
            }elseif ($filter->display_reports == 'msa') {
                $banks = Bank::where('msa_code',$filter->msa_code)->pluck('id')->toArray();
            }else{
                $banks = CustomPackageBanks::where('bank_id',$filter->id)->pluck('customer_selected_bank_id')->toArray();
            }
        }else{
            $filter = CustomerBank::where('id',auth()->user()->bank_id)->first();
            if($filter->display_reports == 'state'){
                $banks = Bank::where('state_id',$filter->state)->where('bank_type_id',$selected_bank_type)->pluck('id')->toArray();
            }elseif ($filter->display_reports == 'msa') {
                $banks = Bank::where('msa_code',$filter->msa_code)->where('bank_type_id',$selected_bank_type)->pluck('id')->toArray();
            }else{
                $banks = CustomPackageBanks::where('bank_id',$filter->id)->pluck('customer_selected_bank_id')->toArray();
            }
        }
        $data = BankPrices::select('bank_prices.id', 'bank_prices.rate_type_id','bank_prices.previous_rate','bank_prices.current_rate','bank_prices.change', 'bank_prices.rate', 'bank_prices.created_at','bank_prices.is_checked','rate_types.name as rate_type_name','banks.name as bk_name','banks.id as bk_id')
            ->whereIn('bank_prices.created_at', function ($query) use ($id,$banks) {
                $query->selectRaw('MAX(created_at)')
                    ->from('bank_prices')
                    ->where('rate_type_id', $id)
                    ->whereIn('bank_id',$banks)
                    ->where('is_checked','1')
                    ->groupBy('bank_id')
                    ->groupBy('rate_type_id');
            })
            ->where('bank_prices.rate_type_id', $id)
            ->join('rate_types', 'bank_prices.rate_type_id', '=', 'rate_types.id')
            ->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
            ->orderBy('bank_prices.current_rate','desc')
            ->get();
        return $data;
    }
}
