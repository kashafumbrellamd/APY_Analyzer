<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bank;
use App\Models\CustomerBank;
use App\Models\CustomPackageBanks;
use App\Models\BankSelectedCity;
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

    public static function BankPricesWithType($id)
    {
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
        return $latestRates;
    }

    public static function BankReports($selected_bank_type)
    {
        $filter = CustomerBank::where('id',auth()->user()->bank_id)->first();
        if($filter->display_reports == 'state' && $selected_bank_type == ""){
            $cities = BankSelectedCity::where('bank_id',$filter->id)->pluck('city_id')->toArray();
            $banks = Bank::join('bank_prices','bank_prices.bank_id','banks.id')
                ->select('banks.*')
                ->groupBy('banks.id')
                ->whereIn('city_id',$cities)->get();
        }
        elseif ($filter->display_reports == 'msa' && $selected_bank_type == ""){
            $banks = Bank::where('msa_code',$filter->msa_code)->get();
        }
        elseif ($filter->display_reports == 'state' && $selected_bank_type != ""){
            $cities = BankSelectedCity::where('bank_id',$filter->id)->pluck('city_id')->toArray();
            $banks = Bank::join('bank_prices','bank_prices.bank_id','banks.id')
                ->select('banks.*')
                ->groupBy('banks.id')
                ->whereIn('city_id',$cities)->where('bank_type_id',$selected_bank_type)->get();
        }
        elseif ($filter->display_reports == 'msa' && $selected_bank_type != ""){
            $banks = Bank::where('msa_code',$filter->msa_code)->where('bank_type_id',$selected_bank_type)->get();
        }
        elseif($filter->display_reports == 'custom' && $selected_bank_type == ""){
            $selected_banks = CustomPackageBanks::where('bank_id',$filter->id)->pluck('customer_selected_bank_id')->toArray();
            $banks = Bank::join('bank_prices','bank_prices.bank_id','banks.id')
                ->select('banks.*')
                ->groupBy('banks.id')
                ->whereIn('banks.id',$selected_banks)
                ->get();
        }
        else{
            $selected_banks = CustomPackageBanks::where('bank_id',$filter->id)
                ->join('banks','banks.id','custom_package_banks.customer_selected_bank_id')
                ->where('banks.bank_type_id',$selected_bank_type)
                ->pluck('customer_selected_bank_id')
                ->toArray();
            $banks = Bank::join('bank_prices','bank_prices.bank_id','banks.id')
                ->select('banks.*')
                ->groupBy('banks.id')
                ->whereIn('banks.id',$selected_banks)
                ->get();
        }
        $rate_types = RateType::orderby('display_order')->get();
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

    // public static function SeperateReports($type,$state,$code,$selected_bank_type)
    // {
    //     $bankQuery = Bank::query();
    //     if ($type == 'state') {
    //         $filter = CustomerBank::where('id', auth()->user()->bank_id)->first();
    //         if($filter->display_reports == "custom"){
    //             $bankQuery = $bankQuery->join('custom_package_banks','banks.id','custom_package_banks.customer_selected_bank_id')
    //             ->where('custom_package_banks.bank_id', $filter->id)
    //             ->where('banks.state_id', $state);
    //         }else{
    //             $bankQuery->where('state_id', $state);
    //         }

    //         if ($selected_bank_type != "") {
    //             $bankQuery->whereIn('bank_type_id', $selected_bank_type);
    //         }

    //         if ($code != "") {
    //             $bankQuery->where('msa_code', $code);
    //         }

    //         $banks = $bankQuery->pluck('banks.id')->toArray();
    //     } elseif ($type == 'msa') {
    //         $bankQuery->where('msa_code', $code);

    //         if ($selected_bank_type != "") {
    //             $bankQuery->whereIn('bank_type_id', $selected_bank_type);
    //         }
    //         $banks = $bankQuery->pluck('id')->toArray();
    //     } elseif ($type == 'all') {
    //         $filter = CustomerBank::where('id', auth()->user()->bank_id)->first();

    //         if ($filter->display_reports == 'state') {
    //             $cities = BankSelectedCity::where('bank_id', $filter->id)->pluck('city_id')->toArray();
    //             $bankQuery->whereIn('city_id', $cities);
    //             if ($selected_bank_type != "") {
    //                 $bankQuery->whereIn('banks.bank_type_id', $selected_bank_type);
    //             }
    //             $banks = $bankQuery->pluck('id')->toArray();
    //         } elseif ($filter->display_reports == 'msa') {
    //             $bankQuery->where('msa_code', $filter->msa_code);
    //             $banks = $bankQuery->pluck('id')->toArray();
    //         } elseif ($filter->display_reports == 'custom') {
    //             $customQuery = CustomPackageBanks::where('bank_id', $filter->id);
    //             if ($selected_bank_type != "") {
    //                 $customQuery->join('banks', 'banks.id', 'custom_package_banks.customer_selected_bank_id')
    //                             ->whereIn('banks.bank_type_id', $selected_bank_type);
    //             }
    //             $banks = $customQuery->pluck('customer_selected_bank_id')->toArray();
    //         }
    //     }

    //     $rate_types['rate_types'] = RateType::orderBy('display_order')->get();
    //     $latest_bank_prices_by_type = [];
    //     foreach ($rate_types['rate_types'] as $rt) {
    //         $id = $rt->id;
    //         $latest_bank_prices = BankPrices::select('bank_prices.*', 'banks.name as bank_name','banks.cbsa_name as cbsa_name','banks.zip_code as zip_code')
    //             ->join('banks', 'bank_prices.bank_id', 'banks.id')
    //             ->whereIn('bank_prices.created_at', function ($query) use ($id,$banks) {
    //                 $query->selectRaw('MAX(created_at)')
    //                     ->from('bank_prices')
    //                     ->where('rate_type_id', $id)
    //                     ->where('is_checked', 1)
    //                     ->whereIn('bank_id', $banks)
    //                     ->groupBy('bank_id');
    //             })
    //             ->where('rate_type_id', $id)
    //             ->where('is_checked', 1)
    //             ->whereIn('bank_id', $banks)
    //             ->groupBy('bank_id')
    //             ->orderBy('current_rate', 'DESC')
    //             ->get();
    //         $rt['banks'] = $latest_bank_prices;
    //     }

    //     $rate_types['show_banks'] = Bank::whereIn('id',$banks)->get();
    //     return $rate_types;
    // }
    public static function SeperateReports($type, $state, $code, $selectedBankType,$unique)
    {
        $userBank = auth()->user();
        $bankQuery = Bank::query();
        $filter = CustomerBank::find($userBank->bank_id);
        switch ($type) {
            case 'state':
                if ($filter->display_reports == 'custom') {
                    $bankQuery->join('custom_package_banks', 'banks.id', 'custom_package_banks.customer_selected_bank_id')
                        ->where('custom_package_banks.bank_id', $filter->id)
                        ->where('banks.state_id', $state);
                } else {
                    $bankQuery->where('state_id', $state);
                }
                if ($unique) {
                    $bankQuery->groupBy('banks.name');
                }
                break;
            case 'msa':
                $bankQuery->where('cbsa_code', $code);
                if ($unique) {
                    $bankQuery->groupBy('banks.name');
                }
                break;
            case 'all':
                // $filter = CustomerBank::find($userBank->bank_id);
                if ($filter->display_reports == 'state') {
                    $cities = BankSelectedCity::where('bank_id', $filter->id)->pluck('city_id')->toArray();
                    $bankQuery->whereIn('cbsa_code', $cities);
                } elseif ($filter->display_reports == 'msa') {
                    $bankQuery->where('msa_code', $filter->msa_code);
                } elseif ($filter->display_reports == 'custom') {
                    // $customQuery = CustomPackageBanks::where('bank_id', $filter->id);
                    $bankQuery->join('custom_package_banks', 'custom_package_banks.bank_id', 'banks.id')
                        ->where('custom_package_banks.bank_id',$filter->id);
                    if (!empty($selectedBankType)) {
                        $bankQuery->whereIn('banks.bank_type_id', $selectedBankType);
                    }
                    $banks = $bankQuery->pluck('customer_selected_bank_id')->toArray();
                    break;
                }
                if (!empty($selectedBankType)) {
                    $bankQuery->whereIn('bank_type_id', $selectedBankType);
                }
                if (!empty($code)) {
                    $bankQuery->where('msa_code', $code);
                }
                if ($unique) {
                    $bankQuery->groupBy('banks.name');
                }
                break;
        }
        if($filter->display_reports == "custom"){
            $banks = $bankQuery->pluck('customer_selected_bank_id')->toArray();
        }else{
            $banks = $bankQuery->pluck('id')->toArray();
        }
        $rateTypes['rate_types'] = RateType::orderBy('display_order')->get();
        foreach ($rateTypes['rate_types'] as $rateType) {
            $id = $rateType->id;
            $latestBankPrices = BankPrices::select('bank_prices.*', 'banks.name as bank_name', 'banks.cbsa_name as cbsa_name', 'banks.zip_code as zip_code')
                ->join('banks', 'bank_prices.bank_id', 'banks.id')
                ->whereIn('bank_prices.created_at', function ($query) use ($id, $banks) {
                    $query->selectRaw('MAX(created_at)')
                        ->from('bank_prices')
                        ->where('rate_type_id', $id)
                        ->where('is_checked', 1)
                        ->whereIn('bank_id', $banks)
                        ->groupBy('bank_id');
                })
                ->where('rate_type_id', $id)
                ->where('is_checked', 1)
                ->whereIn('bank_id', $banks)
                ->groupBy('bank_id')
                ->orderByDesc('current_rate')
                ->get();
            $rateType['banks'] = $latestBankPrices;
        }
        $rateTypes['show_banks'] = Bank::whereIn('banks.id', $banks)->join('bank_prices','banks.id','bank_prices.bank_id')
            ->orderBy('banks.name')
            ->groupBy('banks.id','banks.name')
            ->select('banks.id','banks.name')->get();
        return $rateTypes;
    }


    public static function BankReportsWithState($state_id,$code,$selected_bank_type)
    {
        if($selected_bank_type == ""){
            if($code!=""){
                $banks = Bank::where('state_id',$state_id)
                ->join('bank_prices','bank_prices.bank_id','banks.id')
                ->join('custom_package_banks','banks.id','custom_package_banks.customer_selected_bank_id')
                ->where('banks.msa_code',$code)
                ->where('custom_package_banks.bank_id',auth()->user()->bank_id)
                ->groupBy('custom_package_banks.customer_selected_bank_id')
                ->select('banks.*')
                ->get();
            }else{
                $banks = Bank::where('state_id',$state_id)
                ->join('bank_prices','bank_prices.bank_id','banks.id')
                ->join('custom_package_banks','banks.id','custom_package_banks.customer_selected_bank_id')
                ->where('custom_package_banks.bank_id',auth()->user()->bank_id)
                ->groupBy('custom_package_banks.customer_selected_bank_id')
                ->select('banks.*')
                ->get();
            }
        }else{
            if($code!=""){
                $banks = Bank::where('state_id',$state_id)
                ->join('custom_package_banks','banks.id','custom_package_banks.customer_selected_bank_id')
                ->join('bank_prices','bank_prices.bank_id','banks.id')
                ->where('banks.bank_type_id',$selected_bank_type)
                ->where('banks.msa_code',$code)
                ->where('custom_package_banks.bank_id',auth()->user()->bank_id)
                ->groupBy('custom_package_banks.customer_selected_bank_id')
                ->select('banks.*')
                ->get();
            }else{
                $banks = Bank::where('state_id',$state_id)
                ->join('custom_package_banks','banks.id','custom_package_banks.customer_selected_bank_id')
                ->join('bank_prices','bank_prices.bank_id','banks.id')
                ->where('banks.bank_type_id',$selected_bank_type)
                ->where('custom_package_banks.bank_id',auth()->user()->bank_id)
                ->groupBy('custom_package_banks.customer_selected_bank_id')
                ->select('banks.*')
                ->get();
            }
        }
        $rate_types = RateType::orderby('display_order')->get();
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
    public static function BankReportsWithMsa($msa,$selected_bank_type)
    {
        $filter = CustomerBank::where('id',auth()->user()->bank_id)->first();
        if($selected_bank_type == ""){
            $banks = Bank::where('msa_code',$msa)
            ->join('custom_package_banks','banks.id','custom_package_banks.customer_selected_bank_id')
            ->groupBy('custom_package_banks.customer_selected_bank_id')
            ->select('banks.*')
            ->get();
        }else{
            $banks = Bank::where('msa_code',$msa)
            ->join('custom_package_banks','banks.id','custom_package_banks.customer_selected_bank_id')
            ->where('banks.bank_type_id',$selected_bank_type)
            ->groupBy('custom_package_banks.customer_selected_bank_id')
            ->select('banks.*')
            ->get();
        }
        $rate_types = RateType::orderby('display_order')->get();
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

    public static function get_min_max_func($type,$state,$code,$selected_bank_type)
    {
        $filter = CustomerBank::where('id',auth()->user()->bank_id)->first();
        $rate_types = RateType::orderby('display_order')->get();
        if($selected_bank_type == ""){
            if($type == 'state'){
                $cities = BankSelectedCity::where('bank_id',$filter->id)->pluck('city_id')->toArray();
                $selected_banks = Bank::whereIn('cbsa_code',$cities)->pluck('id')->toArray();
            }elseif($type == 'msa'){
                $selected_banks = Bank::where('msa_code',$code)->pluck('id')->toArray();
            }else{
                if($filter->display_reports == 'custom'){
                    $selected_banks = CustomPackageBanks::where('bank_id',$filter->id)->pluck('customer_selected_bank_id')->toArray();
                }elseif($filter->display_reports == 'state'){
                    $city_ids = BankSelectedCity::where('bank_id',$filter->id)->pluck('city_id')->toArray();
                    $selected_banks = Bank::where('cbsa_code',$city_ids)->pluck('id')->toArray();
                }else{
                    $selected_banks = Bank::where('msa_code',$filter->msa_code)->pluck('id')->toArray();
                }
            }
        }else{
            if($type == 'state'){
                if($code!= ""){
                    $selected_banks = Bank::where('state_id',$state)->where('msa_code',$code)->whereIn('bank_type_id',$selected_bank_type)->pluck('id')->toArray();
                }else{
                    $selected_banks = Bank::where('state_id',$state)->whereIn('bank_type_id',$selected_bank_type)->pluck('id')->toArray();
                }
            }elseif($type == 'msa'){
                $selected_banks = Bank::where('msa_code',$code)->whereIn('bank_type_id',$selected_bank_type)->pluck('id')->toArray();
            }else{
                if($filter->display_reports == 'custom'){
                    $selected_banks = CustomPackageBanks::where('bank_id',$filter->id)
                    ->join('banks','banks.id','custom_package_banks.customer_selected_bank_id')
                    ->whereIn('banks.bank_type_id',$selected_bank_type)
                    ->pluck('custom_package_banks.customer_selected_bank_id')
                    ->toArray();
                }elseif($filter->display_reports == 'state'){
                    $city_ids = BankSelectedCity::where('bank_id',$filter->id)->pluck('city_id')->toArray();
                    $selected_banks = Bank::where('cbsa_code',$city_ids)->pluck('id')->toArray();
                }else{
                    $selected_banks = Bank::where('msa_code',$filter->msa_code)->pluck('id')->toArray();
                }
            }
        }
        foreach ($rate_types as $re_key => $rt) {
            $id = $rt->id;
            $rt->c_max = BankPrices::whereIn('created_at', function ($query) use ($id,$selected_banks) {
                $query->selectRaw('MAX(created_at)')->from('bank_prices')->whereIn('bank_id',$selected_banks)
                ->where('rate_type_id', $id)->where('is_checked',1)->groupBy('bank_id');
            })->where('rate_type_id',$id)->where('is_checked',1)->whereIn('bank_id',$selected_banks)
            ->groupBy('bank_id')->get()->max('current_rate');
            $rt->p_max = BankPrices::whereIn('created_at', function ($query) use ($id,$selected_banks) {
                $query->selectRaw('MAX(created_at)')->from('bank_prices')->whereIn('bank_id',$selected_banks)
                ->where('rate_type_id', $id)->where('is_checked',1)->groupBy('bank_id');
            })->where('rate_type_id',$id)->where('is_checked',1)->whereIn('bank_id',$selected_banks)
            ->groupBy('bank_id')->get()->max('previous_rate');
            $rt->c_min = BankPrices::whereIn('created_at', function ($query) use ($id,$selected_banks) {
                $query->selectRaw('MAX(created_at)')->from('bank_prices')->whereIn('bank_id',$selected_banks)
                ->where('rate_type_id', $id)->where('is_checked',1)->groupBy('bank_id');
            })->where('rate_type_id',$id)->where('is_checked',1)->whereIn('bank_id',$selected_banks)
            ->groupBy('bank_id')->get()->min('current_rate');
            $rt->p_min = BankPrices::whereIn('created_at', function ($query) use ($id,$selected_banks) {
                $query->selectRaw('MAX(created_at)')->from('bank_prices')->whereIn('bank_id',$selected_banks)
                ->where('rate_type_id', $id)->where('is_checked',1)->groupBy('bank_id');
            })->where('rate_type_id',$id)->where('is_checked',1)->whereIn('bank_id',$selected_banks)
            ->groupBy('bank_id')->get()->min('previous_rate');
            $rt->c_avg = BankPrices::whereIn('created_at', function ($query) use ($id,$selected_banks) {
                $query->selectRaw('MAX(created_at)')->from('bank_prices')->whereIn('bank_id',$selected_banks)
                ->where('rate_type_id', $id)->where('is_checked',1)->groupBy('bank_id');
            })->where('rate_type_id',$id)->where('is_checked',1)->whereIn('bank_id',$selected_banks)
            ->groupBy('bank_id')->get()->avg('current_rate');
            $rt->p_avg = BankPrices::whereIn('created_at', function ($query) use ($id,$selected_banks) {
                $query->selectRaw('MAX(created_at)')->from('bank_prices')->whereIn('bank_id',$selected_banks)
                ->where('rate_type_id', $id)->where('is_checked',1)->groupBy('bank_id');
            })->where('rate_type_id',$id)->where('is_checked',1)->whereIn('bank_id',$selected_banks)
            ->groupBy('bank_id')->get()->avg('previous_rate');

            $get_mod = BankPrices::whereIn('created_at', function ($query) use ($id,$selected_banks) {
                $query->selectRaw('MAX(created_at)')->from('bank_prices')->whereIn('bank_id',$selected_banks)
                ->where('rate_type_id', $id)->where('is_checked',1)->groupBy('bank_id');
            })->where('rate_type_id',$id)->where('is_checked',1)->whereIn('bank_id',$selected_banks)
            ->groupBy('bank_id')->get()->pluck('current_rate')->toArray();
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
            $get_mod = BankPrices::whereIn('created_at', function ($query) use ($id,$selected_banks) {
                $query->selectRaw('MAX(created_at)')->from('bank_prices')->whereIn('bank_id',$selected_banks)
                ->where('rate_type_id', $id)->where('is_checked',1)->groupBy('bank_id');
            })->where('rate_type_id',$id)->where('is_checked',1)->whereIn('bank_id',$selected_banks)
            ->groupBy('bank_id')->get()->pluck('previous_rate')->toArray();
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

    // public function get_min_max_func_with_state($state_id)
    // {
    //     $rate_types = RateType::orderby('display_order')->get();
    //     foreach ($rate_types as $re_key => $rt) {
    //         $id = $rt->id;
    //         $rt->c_max = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
    //             $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
    //             ->where('is_checked',1)->groupBy('bank_id');
    //         })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
    //         ->join('custom_package_banks', 'banks.id', '=', 'custom_package_banks.customer_selected_bank_id')
    //         ->where('banks.state_id',$state_id)
    //         ->max('current_rate');
    //         $rt->p_max = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
    //             $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
    //             ->where('is_checked',1)->groupBy('bank_id');
    //         })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
    //         ->join('custom_package_banks', 'banks.id', '=', 'custom_package_banks.customer_selected_bank_id')
    //         ->where('banks.state_id',$state_id)->max('previous_rate');

    //         $rt->c_min = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
    //             $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
    //             ->where('is_checked',1)->groupBy('bank_id');
    //         })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
    //         ->join('custom_package_banks', 'banks.id', '=', 'custom_package_banks.customer_selected_bank_id')
    //         ->where('banks.state_id',$state_id)->min('current_rate');
    //         $rt->p_min = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
    //             $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
    //             ->where('is_checked',1)->groupBy('bank_id');
    //         })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
    //         ->join('custom_package_banks', 'banks.id', '=', 'custom_package_banks.customer_selected_bank_id')
    //         ->where('banks.state_id',$state_id)->min('previous_rate');

    //         $rt->c_avg = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
    //             $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
    //             ->where('is_checked',1)->groupBy('bank_id');
    //         })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
    //         ->join('custom_package_banks', 'banks.id', '=', 'custom_package_banks.customer_selected_bank_id')
    //         ->where('banks.state_id',$state_id)->avg('current_rate');
    //         $rt->p_avg = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
    //             $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
    //             ->where('is_checked',1)->groupBy('bank_id');
    //         })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
    //         ->join('custom_package_banks', 'banks.id', '=', 'custom_package_banks.customer_selected_bank_id')
    //         ->where('banks.state_id',$state_id)->avg('previous_rate');

    //         $get_mod = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
    //             $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
    //             ->where('is_checked',1)->groupBy('bank_id');
    //         })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
    //         ->join('custom_package_banks', 'banks.id', '=', 'custom_package_banks.customer_selected_bank_id')
    //         ->where('banks.state_id',$state_id)->pluck('previous_rate')->toArray();
    //         if($get_mod != null){
    //             $abc = array_map('strval',$get_mod);
    //             $counts = array_count_values($abc);
    //             arsort($counts);
    //             $rt->c_mode = array_keys($counts)[0];
    //             sort($abc);
    //             $count = count($abc);
    //             $middle = floor(($count - 1) / 2);
    //             if ($count % 2 == 0) {
    //                 $rt->c_med = ($abc[$middle] + $abc[$middle + 1]) / 2;
    //             } else {
    //                 $rt->c_med = $abc[$middle];
    //             }
    //         }
    //         if($get_mod != null){
    //             $get_mod = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
    //                 $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
    //                 ->where('is_checked',1)->groupBy('bank_id');
    //             })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
    //             ->join('custom_package_banks', 'banks.id', '=', 'custom_package_banks.customer_selected_bank_id')
    //             ->where('banks.state_id',$state_id)->pluck('previous_rate')->toArray();
    //             $abc = array_map('strval',$get_mod);
    //             $counts = array_count_values($abc);
    //             arsort($counts);
    //             $rt->p_mode = array_keys($counts)[0];
    //             sort($abc);
    //             $count = count($abc);
    //             $middle = floor(($count - 1) / 2);
    //             if ($count % 2 == 0) {
    //                 $rt->p_med = ($abc[$middle] + $abc[$middle + 1]) / 2;
    //             } else {
    //                 $rt->p_med = $abc[$middle];
    //             }
    //         }
    //     }
    //     return $rate_types;
    // }
    // public function get_min_max_func_with_msa($msa)
    // {
    //     $rate_types = RateType::orderby('display_order')->get();
    //     foreach ($rate_types as $re_key => $rt) {
    //         $id = $rt->id;

    //         $rt->c_max = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
    //             $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
    //             ->where('is_checked',1)->groupBy('bank_id');
    //         })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
    //         ->where('banks.msa_code',$msa)
    //         ->max('current_rate');
    //         $rt->p_max = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
    //             $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
    //             ->where('is_checked',1)->groupBy('bank_id');
    //         })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
    //         ->where('banks.msa_code',$msa)->max('previous_rate');

    //         $rt->c_min = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
    //             $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
    //             ->where('is_checked',1)->groupBy('bank_id');
    //         })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
    //         ->where('banks.msa_code',$msa)->min('current_rate');
    //         $rt->p_min = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
    //             $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
    //             ->where('is_checked',1)->groupBy('bank_id');
    //         })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
    //         ->where('banks.msa_code',$msa)->min('previous_rate');

    //         $rt->c_avg = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
    //             $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
    //             ->where('is_checked',1)->groupBy('bank_id');
    //         })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
    //         ->where('banks.msa_code',$msa)->avg('current_rate');
    //         $rt->p_avg = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
    //             $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
    //             ->where('is_checked',1)->groupBy('bank_id');
    //         })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
    //         ->where('banks.msa_code',$msa)->avg('previous_rate');

    //         $get_mod = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
    //             $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
    //             ->where('is_checked',1)->groupBy('bank_id');
    //         })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
    //         ->where('banks.msa_code',$msa)->pluck('previous_rate')->toArray();
    //         if($get_mod != null){
    //             $abc = array_map('strval',$get_mod);
    //             $counts = array_count_values($abc);
    //             arsort($counts);
    //             $rt->c_mode = array_keys($counts)[0];
    //             sort($abc);
    //             $count = count($abc);
    //             $middle = floor(($count - 1) / 2);
    //             if ($count % 2 == 0) {
    //                 $rt->c_med = ($abc[$middle] + $abc[$middle + 1]) / 2;
    //             } else {
    //                 $rt->c_med = $abc[$middle];
    //             }
    //         }
    //         $get_mod = BankPrices::whereIn('bank_prices.created_at', function ($query) use ($id) {
    //             $query->selectRaw('MAX(created_at)')->from('bank_prices')->where('rate_type_id', $id)
    //             ->where('is_checked',1)->groupBy('bank_id');
    //         })->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
    //         ->where('banks.msa_code',$msa)->pluck('previous_rate')->toArray();
    //         if($get_mod != null){
    //             $abc = array_map('strval',$get_mod);
    //             $counts = array_count_values($abc);
    //             arsort($counts);
    //             $rt->p_mode = array_keys($counts)[0];
    //             sort($abc);
    //             $count = count($abc);
    //             $middle = floor(($count - 1) / 2);
    //             if ($count % 2 == 0) {
    //                 $rt->p_med = ($abc[$middle] + $abc[$middle + 1]) / 2;
    //             } else {
    //                 $rt->p_med = $abc[$middle];
    //             }
    //         }
    //     }
    //     return $rate_types;
    // }

    public static function summary_report($id,$selected_bank_type,$unique){
        $type = DB::table('customer_bank')->where('id',auth()->user()->bank_id)->first();
        if($type->display_reports == 'state' && $selected_bank_type == ""){
            $cities = BankSelectedCity::where('bank_id',auth()->user()->bank_id)->pluck('city_id')->toArray();
            // if($unique){
            //     $banks = Bank::whereIn('cbsa_code',$cities)->groupBy('banks.name')->pluck('id')->toArray();
            // }else{
                $banks = Bank::whereIn('cbsa_code',$cities)->pluck('id')->toArray();
            // }
        }elseif($type->display_reports == 'msa' && $selected_bank_type == ""){
            $banks = Bank::where('msa_code',$type->msa_code)->pluck('id')->toArray();
        }elseif($type->display_reports == 'state' && $selected_bank_type != ""){
            $cities = BankSelectedCity::where('bank_id',auth()->user()->bank_id)->pluck('city_id')->toArray();
            // if($unique){
            //     $banks = Bank::whereIn('cbsa_code',$cities)->whereIn('bank_type_id',$selected_bank_type)->groupBy('banks.name')->pluck('id')->toArray();
            // }else{
                $banks = Bank::whereIn('cbsa_code',$cities)->whereIn('bank_type_id',$selected_bank_type)->pluck('id')->toArray();
            // }
        }elseif($type->display_reports == 'msa_code' && $selected_bank_type != ""){
            $banks = Bank::where('msa_code',$type->msa_code)->whereIn('bank_type_id',$selected_bank_type)->pluck('id')->toArray();
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
                $banks = Bank::where('state_id',$filter->state)
                    ->whereIn('bank_type_id',$selected_bank_type)
                    ->pluck('id')->toArray();
            }elseif ($filter->display_reports == 'msa') {
                $banks = Bank::where('msa_code',$filter->msa_code)
                ->whereIn('bank_type_id',$selected_bank_type)
                ->pluck('id')->toArray();
            }else{
                $banks = CustomPackageBanks::where('bank_id',$filter->id)
                ->join('banks','banks.id','custom_package_banks.customer_selected_bank_id')
                ->whereIn('banks.bank_type_id',$selected_bank_type)
                ->pluck('customer_selected_bank_id')
                ->toArray();
            }
        }
        $data = BankPrices::select('bank_prices.*', 'banks.name as bank_name','banks.cbsa_name as cbsa_name','banks.zip_code as zip_code')
            ->join('banks', 'bank_prices.bank_id', 'banks.id')
            ->whereIn('bank_prices.created_at', function ($query) use ($id,$banks) {
                $query->selectRaw('MAX(created_at)')
                    ->from('bank_prices')
                    ->where('rate_type_id', $id)
                    ->where('is_checked', 1)
                    ->whereIn('bank_id', $banks)
                    ->groupBy('bank_id');
            })
            ->where('rate_type_id', $id)
            ->where('is_checked', 1)
            ->whereIn('bank_id', $banks) // Assuming $banks is an array containing selected bank IDs
            ->groupBy('bank_id') // Group by bank_id to get the latest rate for each bank in the current rate type
            ->orderBy('current_rate', 'DESC')
            ->get();
        return $data;
    }
}
