<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ShowPosts extends Component
{
  use WithFileUploads;

  public $search = '', $post, $image, $identificador;
  public $sort = 'id';
  public $direction = 'desc';

  public $open_edit = false;

  protected $rules = [
    'post.title' => 'required|max:10',
    'post.content' => 'required|max:100',
    'image' => 'max:2048'
  ];

  protected $listeners = ['render'];

  public function mount()
  {
    $this->identificador = rand();
    $this->post = new Post();
  }

  public function render()
  {
    $posts = Post::where('title', 'LIKE', '%' . $this->search . '%')
      ->orWhere('content', 'LIKE', '%' . $this->search . '%')
      ->orderBy($this->sort, $this->direction)
      ->get();
    return view('livewire.show-posts', compact('posts'));
  }

  public function order($sort)
  {
    if ($this->sort == $sort) {
      if ($this->direction == 'desc') {
        $this->direction = 'asc';
      } else {
        $this->direction = 'desc';
      }
    } else {
      $this->sort = $sort;
      $this->direction = 'asc';
    }
  }

  public function edit(Post $post)
  {
    $this->post = $post;
    $this->open_edit = true;
  }

  public function update()
  {
    $this->validate();

    if ($this->image) {
      if ($this->post->image) {
        Storage::delete([$this->post->image]);
      }
      $this->post->image = $this->image->store('public/posts');
    }

    $this->post->save();

    $this->reset(['open_edit', 'image']);
    $this->identificador = rand();

    $this->emitTo('show-posts', 'render');
    $this->emit('alert', ['icon' => 'success', 'text' => 'El post se actualizó satisfactoriamente', 'title' => 'Post actualizado']);
  }
}
