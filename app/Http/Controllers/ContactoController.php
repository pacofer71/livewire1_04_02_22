<?php

namespace App\Http\Controllers;

use App\Mail\ContactoMailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactoController extends Controller
{
    
    public function pintarFormulario(){
        return view('contacto.index');
    }
    public function procesarFormulario(Request $request){
        $request->validate([
            'nombre'=>['required', 'string', 'min:3'],
            'mensaje'=>['required', 'string', 'min:10'],
        ]);

        //si paso de aquí la validación ha ido bien
        $correo = new ContactoMailable($request->all(), auth()->user()->email);
        try{
            Mail::to('admin@correo.es')->send($correo);
        }catch(\Exception $ex){
           // dd($ex->getMessage());
        return redirect()->route('posts.show')->with('correo', "No se pudo enviar el correo");


        }
        return redirect()->route('posts.show')->with('correo', "Correo enviado, gracias");



    }
}
