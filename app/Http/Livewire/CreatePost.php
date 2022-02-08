<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatePost extends Component
{
    use WithFileUploads;
    
    public $image;
    public $titulo, $contenido;
    public $isOpen=false;
    protected $rules=[
        'titulo'=>['required', 'string', 'min:3', 'unique:posts,titulo'],
        'contenido'=>['required', 'string', 'min:8'],
        'image'=>['required', 'image', 'max:1024']
    ];

    public function render()
    {
        return view('livewire.create-post');
    }
    public function guardar(){
        $this->validate();
        //hemos pasado las validaciones
        //1.- guardamos la imagen en el disco
        $imagen = $this->image->store('posts');
        //2.- guardamos el registro en la bbdd
        Post::create([
            'titulo'=>ucfirst($this->titulo),
            'contenido'=>ucfirst($this->contenido),
            'image'=>$imagen
        ]);
        $this->reset(['isOpen', 'titulo', 'contenido']);
        //necesito que el show-posts s renderice
        //para ello crearemos un listener que solo lo escuche show.posts
        //y para las alertas un listener que para todos los sitios
        
        $this->emitTo('show-posts', 'renderizarPosts');

        //evento para las alertas de crear post
        $this->emit('alerta', 'Post Creado con éxito');

    }
    
}
