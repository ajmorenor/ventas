<?php

namespace App\Http\Controllers;
use App\Metodo;
use App\Fuente;
use App\Servicio;

use Redirect;

use Illuminate\Http\Request;

class MetodoController extends Controller
{
    //
    public function __construct(){}

    public function index()
    {
        // We transfer contact data to view    
        $metodos = Metodo::All();
        return view('metodoview', compact('metodos'));
    }

    public function edit($id)
    {
        $metodo = Metodo::find($id);
        return view('updateMetodo', compact('metodo'));
    }

    // Update contact   
    public function update(Request $request,$id)
    {
        $contact = Metodo::find($id);
        $contact->fill($request->all());
        $contact->save();
    
        return Redirect::to('/metodov');
    
    }

    // Delete contact
    public function delete()
    {
        $id = $_GET['idmetodo'];
        $contact = Metodo::find($id);

        // Ubicamos los servicios asociados
        $servicios = Servicio::where('idmetodo','=',$id)->get();
        foreach($servicios as $ser){
            $ser->delete();
        }

        $contact->delete();
        //return Redirect::to('/metodov');
    }

    // Add contact
    public function add()
    {
        return view('registerMetodo');
    }

    // Save contact
    public function save(Request $request)
    {
        $emp = new Metodo;

        $empresa = $emp->create($request->all());

        return Redirect::to('/metodov');
    }

    // Create contact
    protected function create(array $data)
    {
        return Metodo::create([
            'codigo' => $data['codigo'],
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
        ]);
    }

}

