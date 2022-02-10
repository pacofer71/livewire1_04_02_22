<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\{WithPagination, WithFileUploads};
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class ShowPosts extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search = "";
    public $campo = "id";
    public $orden = "desc";
    public $isOpen=false;
    public Post $post;
    public $image;

    //listners
    protected $listeners = ['renderizarPosts' => 'render'];
    protected $rules=[
        'post.titulo'=>"",
        'post.contenido'=>['required', 'string', 'min:8'], 
        'image'=>['null', 'image', 'max:1024']
        ] ;
    
    
    
    public function mount(){
        $this->post=new Post;
    }
    
    
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

    public function mostrarEdit(Post $post){
        $this->isOpen=true;
        $this->post = $post;
    }
    //método que realmente me actuaizará el registro
    public function update(){
        //Validamos
        $this->validate([
            'post.titulo'=>['required', 'string', 'min:3', 'unique:posts,titulo,'.$this->post->id]
        ]);
        //comprobamos si he subido una imagen nueva
        //si es así debemos borrar la antigua
        if($this->image){
            //borramos la vieja
            Storage::delete($this->post->image);
            //guardo la nueva
            $imagenNueva = $this->image->store('posts');
            $this->post->image=$imagenNueva;
        }
        $this->post->save();
        
        $this->reset(['isOpen', 'image']);
        $this->emit('alerta', 'Post Modificado con relativo exito');


    }
}
