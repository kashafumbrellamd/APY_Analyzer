<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Role;
use Illuminate\Support\Str;

class RolesTable extends Component
{
    public $role = '';
    public $update = false;
    public $update_name = '';
    public $edit_info = '';
    public $user_id = '';

    public function render()
    {
        $data = Role::get();
        return view('livewire.roles-table',['data'=>$data,'update'=>$this->update]);
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
            }else{
                $this->addError('role', 'Role Already Exists');
            }
        }else{
            $this->addError('role', 'Role Can\'t be Empty');
        }
        $this->role = '';
    }

    public function delete($id){
        Role::find($id)->delete();
        $this->render();
    }

    public function edit($id){
        $this->user_id = $id;
        $this->update_name = Role::find($id)->name;
        $this->update = true;
        $this->render();
    }

    public function update(){
        if($this->update_name!='')
        {
            $slug = Str::slug($this->update_name, '-');
            $check = Role::where('slug',$slug)->first();
            if($check == null)
            {
                Role::find($this->user_id)->update([
                    'name' => $this->update_name,
                    'slug'=> $slug,
                ]);
                $this->update_name = '';
                $this->update = false;
                $this->edit_info = '';
                $this->user_id = '';
            }else{
                $this->addError('update_name', 'Role Already Exists');
            }
        }else{
            $this->addError('update_name', 'Role Can\'t be Empty');
        }
        $this->cancel();
        $this->render();
    }

    public function cancel(){
        $this->update_name = '';
        $this->update = false;
        $this->edit_info = '';
        $this->user_id = '';
        $this->render();
    }


}
