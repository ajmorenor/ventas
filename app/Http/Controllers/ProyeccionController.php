<?php

namespace App\Http\Controllers;
use App\Empresa;
use App\Equipo;
use App\Area;
use App\Banco;
use App\Proyecto;
use App\Trabajador;
use App\Capitalestrabajo;
use App\Movimientocapital;

use App\Servicio;
use App\Proyeccion;

use Redirect;

use Illuminate\Http\Request;

class ProyeccionController extends Controller
{
    public function __construct(){}

    public function index()
    {   
        $proyecciones = Proyeccion::all();
        return view('proyecciones', compact('proyecciones'));
    }

    public function add($id)
    {   
        $iniproy = env('INI_PROY');
        $finproy = env('FIN_PROY');
        $capitales = array(14);
        $annos = [];

        $allproy = Proyeccion::select('anno')->get();
        $i = $iniproy;
        $existe = 0;
        while($i <= $finproy){

            foreach($allproy as $all){
                if ($i == $all->anno)
                    $existe = 1;
            }

            if (!$existe){
                $annos[] =  [
                    'anno' => $i
                ];
            }
            
            $existe = 0;
            $i++;
        }

        $object = json_encode($annos);
        $annos  = json_decode($object);
        // We transfer empresa data to view    
        if ($id != -1){

            $capi = Proyeccion::find($id);

            $capitales[0] = $capi->id;
            $capitales[1] = $capi->anno;                
            $capitales[2] = $capi->enero;            
            $capitales[3] = $capi->febrero;            
            $capitales[4] = $capi->marzo;            
            $capitales[5] = $capi->abril;            
            $capitales[6] = $capi->mayo;            
            $capitales[7] = $capi->junio;            
            $capitales[8] = $capi->julio;            
            $capitales[9] = $capi->agosto;            
            $capitales[10] = $capi->septiembre;            
            $capitales[11] = $capi->octubre;            
            $capitales[12] = $capi->noviembre;            
            $capitales[13] = $capi->diciembre;            

        }
        else{

            $capitales[0]  = 0;
            $capitales[1]  = 0;
            $capitales[2]  = 0;
            $capitales[3]  = 0;                        
            $capitales[4]  = 0;
            $capitales[5]  = 0;
            $capitales[6]  = 0;
            $capitales[7]  = 0;                        
            $capitales[8]  = 0;
            $capitales[9]  = 0;
            $capitales[10] = 0;
            $capitales[11] = 0;                        
            $capitales[12] = 0;
            $capitales[13] = 0;            

        }

        return view('registerProyeccion', compact('capitales','annos'));
    }

    public function save(Request $request)
    {
        if (isset($request->id)){

            $contact = Proyeccion::find($request->id);
            $contact->fill($request->all());
            $contact->save();

        }else{
            $capi = new Proyeccion;
            $cap = $capi->create($request->all());
        }

        return Redirect::to('/proyeccion');
    }

    // Delete 
    public function delete()
    {

        $idproyeccion = $_GET['idproyeccion']; 

        $contact = Proyeccion::find($idproyeccion);
        $contact->delete();

    }

}

