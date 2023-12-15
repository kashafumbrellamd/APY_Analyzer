<?php

namespace App\Http\Livewire;

use Livewire\WithFileUploads;
use Livewire\Component;
use App\Models\Stories as Story;
use Livewire\WithPagination;

class Stories extends Component
{
    use WithFileUploads;
    use WithPagination;

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
    public $update;
    public $story_id;

    public function render()
    {
        $data = Story::paginate(10);
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

    public function updateForm(){
        $story = Story::find($this->story_id)->update([
            'title' => $this->title,
            'url' => $this->url,
            'status' => $this->status,
            'description' => $this->description,
        ]);
        $this->update = false;
        $this->clear();
        $this->render();
    }

    public function edit($id){
        $bt = Story::find($id);
        $this->story_id = $id;
        $this->title = $bt->title;
        $this->url = $bt->url;
        $this->status = $bt->status;
        $this->description = $bt->description;
        $this->update = true;
        $this->render();
    }

    public function delete($id){
        Story::find($id)->delete();
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
