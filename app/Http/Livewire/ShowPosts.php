<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShowPosts extends Component
{
  use WithFileUploads;
  use WithPagination;

  public $search = '', $post, $image, $identificador;
  public $sort = 'id';
  public $direction = 'desc';
  public $cant = '10';
  public $readyToLoad = false;

  public $open_edit = false;

  protected $listeners = ['render', 'delete'];

  protected $queryString = [
    'cant' => ['except' => '10'],
    'sort' => ['except' => 'id'],
    'direction' => ['except' => 'desc'],
    'search' => ['except' => '']
  ];

  protected $rules = [
    'post.title' => 'required|max:10',
    'post.content' => 'required|max:100',
    'image' => 'max:2048'
  ];

  public function mount()
  {
    $this->identificador = rand();
    $this->post = new Post();
  }

  public function updatingSearch()
  {
    $this->resetPage();
  }

  public function render()
  {
    if ($this->readyToLoad) {
      $posts = Post::where('title', 'LIKE', '%' . $this->search . '%')
        ->orWhere('content', 'LIKE', '%' . $this->search . '%')
        ->orderBy($this->sort, $this->direction)
        ->paginate($this->cant);
    } else {
      $posts = [];
    }
    return view('livewire.show-posts', compact('posts'));
  }

  function loadPosts(): void
  {
    $this->readyToLoad = true;
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

  function delete(Post $post): void
  {
    $post->delete();
    $this->emit('alert', ['icon' => 'success', 'text' => 'El post se eliminó satisfactoriamente', 'title' => 'Post eliminado']);
  }
}
