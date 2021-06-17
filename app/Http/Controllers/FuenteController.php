<?php

namespace App\Http\Controllers;
use App\Fuente;
use App\Servicio;

use Redirect;

use Illuminate\Http\Request;

class FuenteController extends Controller
{
    //
    public function __construct(){}

    public function index()
    {
        // We transfer contact data to view    
        $fuentes = Fuente::All();
        return view('fuenteview', compact('fuentes'));
    }

    public function edit($id)
    {
        $fuente = Fuente::find($id);
        return view('updateFuente', compact('fuente'));
    }

    // Update contact   
    public function update(Request $request,$id)
    {
        $contact = Fuente::find($id);
        $contact->fill($request->all());
        $contact->save();
    
        return Redirect::to('/fuentev');
    
    }

    // Delete contact
    public function delete()
    {
        $id = $_GET['idfuente'];
        $contact = Fuente::find($id);

        // Ubicamos los servicios asociados
        $servicios = Servicio::where('idfuente','=',$id)->get();
        foreach($servicios as $ser){
            $ser->delete();
        }

        $contact->delete();
        //return Redirect::to('/fuentev');
    }

    // Add contact
    public function add()
    {
        return view('registerFuente');
    }

    // Save contact
    public function save(Request $request)
    {
        $emp = new Fuente;

        $empresa = $emp->create($request->all());

        return Redirect::to('/fuentev');
    }

    // Create contact
    protected function create(array $data)
    {
        return Fuente::create([
            'codigo' => $data['codigo'],
            'tipo' => $data['tipo'],
            'descripcion' => $data['descripcion'],
        ]);
    }

}

