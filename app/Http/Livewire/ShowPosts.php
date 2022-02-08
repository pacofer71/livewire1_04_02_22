<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class ShowPosts extends Component
{
    use WithPagination;
    public $search = "";
    public $campo = "id";
    public $orden = "desc";

    //listners
    protected $listeners = ['renderizarPosts' => 'render'];

    public function render()
    {
        $posts = Post::orderBy($this->campo, $this->orden)
            ->where('titulo', 'like', "%" . $this->search . "%")
            ->orWhere('contenido', 'like', "%{$this->search}%")->paginate(3);

        return view('livewire.show-posts', compact('posts'));
    }
    public function ordenar(String $campo)
    {
        if ($campo == $this->campo) {
            $this->orden = ($this->orden == 'desc') ? 'asc' : 'desc';
        }
        $this->campo = $campo;
    }
    public function borrar(Post $post){
        //borro fisicamente el archivo de imagen asociado a este post
        Storage::delete($post->image);
        //eliminio el post
        $post->delete();
        //emitimos una alerta
        $this->emit('alerta', "Post Borrado con éxito");
    }
}
