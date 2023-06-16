<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Role;
use Illuminate\Support\Str;

class RolesTable extends Component
{
    public $role = '';

    public function render()
    {
        $data = Role::get();
        return view('livewire.roles-table',['data'=>$data]);
    }

    public function submitForm()
    {
        if($this->role!='')
        {
            $slug = Str::slug($this->role, '-');
            $check = Role::where('slug',$slug)->first();
            if($check == null)
            {
                Role::create([
                    'name' => $this->role,
                    'slug'=> $slug,
                ]);
                $this->role = '';
                $this->render();
            }
        }
        $this->role = '';
    }
}
