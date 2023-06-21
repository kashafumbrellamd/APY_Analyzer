<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\PendingUsers;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

class GeneralController extends Controller
{
    public function manage_banks()
    {
        return view('manage_banks.index');
    }
    
    public function add_bank_rates()
    {
        return view('manage_banks.add_rates');
    }

    public function manage_rate_types()
    {
        return view('manage_rate_types.index');
    }
}
