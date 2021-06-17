<?php

namespace App\Http\Controllers;
use App\Relacion;
use App\Empresa;
use App\Fuente;

use Redirect;

use Illuminate\Http\Request;

class RelacionController extends Controller
{
    //
    public function __construct(){}

    public function index($id)
    {
        // We transfer contact data to view    
        //$relaciones = Relacion::Where('idempresa',$id);
        
        $relaciones = Relacion::join('fuentes', 'fuentes.id', '=', 'relaciones.idfuente')
                ->select('fuentes.codigo','fuentes.tipo','fuentes.descripcion','relaciones.id','relaciones.idfuente')
                ->where('relaciones.idempresa', '=', $id)
                ->get();

        $empresa =Empresa::find($id);
        return view('relacionview', compact('relaciones','empresa'));
    }

    public function edit($id)
    {
        $fuente = Relacion::find($id);
        return view('updateFuente', compact('fuente'));
    }

    // Update    
/*    
    public function update(Request $request,$id)
    {
        $contact = Relacion::find($id);
        $contact->fill($request->all());
        $contact->save();
    
        return Redirect::to('/fuentev');
    }
*/
    // Delete 
    public function delete($id, $idempresa)
    {
        $contact = Relacion::find($id);
        $contact->delete();

        return Redirect::to('relacion/'.$idempresa.'/index');
    }

    // Add fuente
    public function add($id, $mensaje)
    {
        $empresa = Empresa::find($id);
        $fuentes = Fuente::all();
        return view('registerRelacion',compact('empresa','fuentes','mensaje'));
    }

    // Save 
    public function save(Request $request)
    {
        $emp = new Relacion;

        $relac = Relacion::where('idempresa','=',$request->idempresa)
                ->where('idfuente','=',$request->idfuente)
                ->get();

        if(count($relac) > 0){
            return Redirect::to('relacion/'.$request->idempresa.'/'.'La fuente seleccionada, ya esta asignada a esta empresa'.'/add');
        }else{
            $empresa = $emp->create($request->all());

            return Redirect::to('relacion/'.$request->idempresa.'/index');    
        }
    }

    // Create 
    protected function create(array $data)
    {
        return Relacion::create([
            'idempresa' => $data['idempresa'],
            'idfuente' => $data['idfuente'],
        ]);
    }
}

