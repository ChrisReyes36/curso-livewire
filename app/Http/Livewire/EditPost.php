<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class EditPost extends Component
{
  use WithFileUploads;

  public $open = false;
  public $post, $image, $identificador;

  protected $rules = [
    'post.title' => 'required|max:10',
    'post.content' => 'required|max:100',
    'image' => 'required|image|max:2048'
  ];

  public function mount(Post $post)
  {
    $this->post = $post;
    $this->identificador = rand();
  }

  public function save()
  {
    $this->validate();

    if ($this->image) {
      Storage::delete([$this->post->image]);
      $this->post->image = $this->image->store('public/posts');
    }

    $this->post->save();

    $this->reset(['open', 'image']);
    $this->identificador = rand();

    $this->emitTo('show-posts', 'render');
    $this->emit('alert', ['icon' => 'success', 'text' => 'El post se actualizó satisfactoriamente', 'title' => 'Post actualizado']);
  }

  public function render()
  {
    return view('livewire.edit-post');
  }
}
