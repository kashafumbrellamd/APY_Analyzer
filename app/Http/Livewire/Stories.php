<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Stories as Story;

class Stories extends Component
{
    protected $rules = [
        'title' => 'required',
        'url' => 'required',
        'status' => 'required',
    ];

    public $title;
    public $url;
    public $status;

    public function render()
    {
        $data = Story::get();
        return view('livewire.stories',['data'=>$data]);
    }

    public function submitForm(){
        $this->validate();
        $story = Story::create([
            'title' => $this->title,
            'url' => $this->url,
            'status' => $this->status,
        ]);
        $this->clear();
        $this->render();
    }

    public function clear(){
        $title = '';
        $url = '';
        $status = '';
    }
}
