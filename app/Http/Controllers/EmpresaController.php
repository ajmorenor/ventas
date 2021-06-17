<?php

namespace App\Http\Controllers;
use App\Empresa;
use App\Servicio;

use Redirect;

use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    //
    public function __construct(){}

    public function edit($id)
    {
        $empresa = Empresa::find($id);
        return view('updateEmpresa', compact('empresa'));
    }

    // Update contact   
    public function update(Request $request,$id)
    {
        $contact = Empresa::find($id);
        $contact->fill($request->all());
        $contact->save();
    
        return Redirect::to('/home');
    
    }

    // Delete empresa
    public function delete()
    {
        $id = $_GET['idempresa'];
        $contact = Empresa::find($id);

        // Ubicamos los servicios asociados
        $servicios = Servicio::where('idempresa','=',$id)->get();
        foreach($servicios as $ser){
            $ser->delete();
        }

        $contact->delete();
        //return Redirect::to('/home');
    }

    // Add contact
    public function add()
    {
        return view('registerEmpresa');
    }

    // Save contact
    public function save(Request $request)
    {
        $emp = new Empresa;

        $empresa = $emp->create($request->all());

        return Redirect::to('/home');
    }

    // Create contact
    protected function create(array $data)
    {
        return Empresa::create([
            'rut' => $data['rut'],
            'nombre' => $data['nombre'],
            'contacto' => $data['contacto'],
            'email' => $data['email'],
            'celular' => $data['celular'],
        ]);
    }

}

