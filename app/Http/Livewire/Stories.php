<?php

namespace App\Http\Livewire;

use Livewire\WithFileUploads;
use Livewire\Component;
use App\Models\Stories as Story;

class Stories extends Component
{
    use WithFileUploads;

    protected $rules = [
        'title' => 'required',
        'url' => 'required',
        'status' => 'required',
        'image' => 'image|max:1024',
        'description' => 'required',
    ];

    public $title;
    public $url;
    public $status;
    public $image;
    public $description;

    public function render()
    {
        $data = Story::get();
        return view('livewire.stories',['data'=>$data]);
    }

    public function submitForm(){
        $this->validate();
        $path = $this->image->store('images', 'public');

        $story = Story::create([
            'title' => $this->title,
            'url' => $this->url,
            'status' => $this->status,
            'image' => $path,
            'description' => $this->description,
        ]);
        $this->clear();
        $this->render();
    }

    public function clear(){
        $this->title = '';
        $this->url = '';
        $this->status = '';
        $this->image = '';
        $this->description = '';
    }
}
