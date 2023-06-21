<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class CreatePost extends Component
{
  public $open = false;
  public $title, $content, $image, $identificador;

  protected $rules = [
    'title' => 'required|max:10',
    'content' => 'required|max:100',
    'image' => 'required|image|max:2048'
  ];

  public function mount()
  {
    $this->identificador = rand();
  }

  public function save()
  {
    Post::create([
      'title' => $this->title,
      'content' => $this->content
    ]);

    $this->reset(['open', 'title', 'content', 'image']);
    $this->identificador = rand();
    $this->emitTo('show-posts', 'render');
    $this->emit('alert', ['icon' => 'success', 'text' => 'El post se creó satisfactoriamente', 'title' => 'Post creado']);
  }

  public function render()
  {
    return view('livewire.create-post');
  }
}
