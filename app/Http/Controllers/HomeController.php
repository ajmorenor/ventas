<?php

namespace App\Http\Controllers;

use App\Empresa;
use Carbon\Carbon;
use App\Proyeccion;
use App\Servicio;
use App\Metodo;
use App\Fuente;

use Redirect;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {                        
        // We transfer empresa data to view    
        $empresas = Empresa::All();
        return view('home', compact('empresas'));
    }

    // Invoca a la presentacion de los indicadores
    public function indicadores_old($anno = '')
    {                        
        $empresas = array(12); // Contiene las empresas por año
        $fuentes = [];         // Contendra la informacion de fuentes
        $vproyectado = array(12);
        $vreal = array(12);

        if($anno == '')
            $anno = Carbon::Now()->format('Y');

        // Inicializamos los vectores
        for($n = 0; $n < 12; $n++){
            $vproyectado[$n] = 0;
            $vreal[$n] = 0;    
        }

        // Ubicamos los valores proyectados de acuerdo al año indicado
        $valoresproy = Proyeccion::find($anno);
        // Se encontro
        if($valoresproy){

            $vproyectado[0] = $valoresproy->enero;
            $vproyectado[1] = $valoresproy->febrero;
            $vproyectado[2] = $valoresproy->marzo;
            $vproyectado[3] = $valoresproy->abril;
            $vproyectado[4] = $valoresproy->mayo;
            $vproyectado[5] = $valoresproy->junio;
            $vproyectado[6] = $valoresproy->julio;
            $vproyectado[7] = $valoresproy->agosto;
            $vproyectado[8] = $valoresproy->septiembre;
            $vproyectado[9] = $valoresproy->octubre;
            $vproyectado[10] = $valoresproy->noviembre;
            $vproyectado[11] = $valoresproy->diciembre;                                                            
        }

        // Valores reales de empresas por mes un año determinado
        //***************************************************** */
        $vreal[0]  =  $this->empresasxmes($anno, '01');
        $vreal[1]  =  $this->empresasxmes($anno, '02');
        $vreal[2]  =  $this->empresasxmes($anno, '03');
        $vreal[3]  =  $this->empresasxmes($anno, '04');
        $vreal[4]  =  $this->empresasxmes($anno, '05');
        $vreal[5]  =  $this->empresasxmes($anno, '06');
        $vreal[6]  =  $this->empresasxmes($anno, '07');
        $vreal[7]  =  $this->empresasxmes($anno, '08');
        $vreal[8]  =  $this->empresasxmes($anno, '09');
        $vreal[9]  =  $this->empresasxmes($anno, '10');
        $vreal[10] =  $this->empresasxmes($anno, '11');   
        $vreal[11] =  $this->empresasxmes($anno, '12');
        //***************************************************** */
        // Cargamos las fuentes
        $fuentesexistentes = Metodo::all();
        $tfuentesexistentes = count($fuentesexistentes);
        $valoresfuentes = array($tfuentesexistentes);

        // Inicializamos ese arreglo
        for($l = 0; $l < $tfuentesexistentes; $l++)
            $valoresfuentes [$l] = 0;

        // Años de evaluacion
        $iniproy = env('INI_PROY');
        $finproy = env('FIN_PROY');
        $annos = [];

        $i = $iniproy;
        $j = 0;
        $totalempresas = 0; // Total empresas
        while($i <= $finproy){
            $annos[] =  [
                'anno' => $i
            ];

            // Meses por año
            $empresas[$j] = $this->empresasxannos($i);            
            //$totalempresas += $empresas[$j];

            $i++;
            $j++;            
        }

        $object = json_encode($annos);
        $annos  = json_decode($object);

        $proy = Proyeccion::all();
        $proyeccion = count($proy);

        // Calculamos los valores de fuentes (metodos) en forma global
        //**************************************************** */
        $empresaservicio = Servicio::select('idempresa')
                                    ->distinct()
                                    ->get();

        $tempresasreales = Empresa::all();
		$totalempresas = count($tempresasreales); // Empresas existentes, con o sin servicios asociados
        foreach($empresaservicio as $emps){

            //Ubicamos las fuentes distintas para cada empresa
            $fuentesdistintas = Servicio::select('idmetodo')
                                    ->distinct()
                                    ->where('idempresa',$emps->idempresa)
                                    ->get();     
            
            // Identificamos que fuentes son
            $k = 0;
            foreach($fuentesexistentes as $fe){

                foreach($fuentesdistintas as $fd){
                    if($fe->id == $fd->idmetodo){
                        $valoresfuentes[$k] += 1;
                    }
                }

                $k++;
            }                                    
        }              
        
        // Armamos la estructura a enviar
        $m = 0;
        $totalfuentes = 0;
        foreach($fuentesexistentes as $fe){
            $fuentes[] =  [
                'codigo' => $fe->codigo,
                'valor'  => $valoresfuentes[$m]
            ];

            $totalfuentes += $valoresfuentes[$m]; 

            $m++;
        }
        $object2 = json_encode($fuentes);
        $fuentes  = json_decode($object2);
        //**************************************************** */

        return view('indicadores', compact('annos','proyeccion','empresas','totalempresas','anno','fuentes','totalfuentes','vproyectado','vreal'));
    }

    // Invoca a la presentacion de los indicadores
    public function indicadoresfuentes($anno = '')
    {                        
        $empresas = array(12); // Contiene las empresas por año
        $fuentes = [];         // Contendra la informacion de fuentes
        $metodos = [];         // Contendra la informacion de metodos

        $vproyectado = array(12);
        $vreal = array(12);

        if($anno == '')
            $anno = Carbon::Now()->format('Y');

        // Inicializamos los vectores
        for($n = 0; $n < 12; $n++){
            $vproyectado[$n] = 0;
            $vreal[$n] = 0;    
        }

        // Ubicamos los valores proyectados de acuerdo al año indicado
        $valoresproy = Proyeccion::find($anno);
        // Se encontro
        if($valoresproy){

            $vproyectado[0] = $valoresproy->enero;
            $vproyectado[1] = $valoresproy->febrero;
            $vproyectado[2] = $valoresproy->marzo;
            $vproyectado[3] = $valoresproy->abril;
            $vproyectado[4] = $valoresproy->mayo;
            $vproyectado[5] = $valoresproy->junio;
            $vproyectado[6] = $valoresproy->julio;
            $vproyectado[7] = $valoresproy->agosto;
            $vproyectado[8] = $valoresproy->septiembre;
            $vproyectado[9] = $valoresproy->octubre;
            $vproyectado[10] = $valoresproy->noviembre;
            $vproyectado[11] = $valoresproy->diciembre;                                                            
        }

        // Valores reales de empresas por mes un año determinado
        //***************************************************** */
        $vreal[0]  =  $this->empresasxmes($anno, '01');
        $vreal[1]  =  $this->empresasxmes($anno, '02');
        $vreal[2]  =  $this->empresasxmes($anno, '03');
        $vreal[3]  =  $this->empresasxmes($anno, '04');
        $vreal[4]  =  $this->empresasxmes($anno, '05');
        $vreal[5]  =  $this->empresasxmes($anno, '06');
        $vreal[6]  =  $this->empresasxmes($anno, '07');
        $vreal[7]  =  $this->empresasxmes($anno, '08');
        $vreal[8]  =  $this->empresasxmes($anno, '09');
        $vreal[9]  =  $this->empresasxmes($anno, '10');
        $vreal[10] =  $this->empresasxmes($anno, '11');   
        $vreal[11] =  $this->empresasxmes($anno, '12');
        //***************************************************** */
        // Cargamos las fuentes
        $fuentesexistentes = Fuente::all();
        $tfuentesexistentes = count($fuentesexistentes);
        $valoresfuentes = array($tfuentesexistentes);

        // Inicializamos ese arreglo
        for($l = 0; $l < $tfuentesexistentes; $l++)
            $valoresfuentes [$l] = 0;

        // Años de evaluacion
        $iniproy = env('INI_PROY');
        $finproy = env('FIN_PROY');
        $annos = [];

        $i = $iniproy;
        $j = 0;
        $totalempresas = 0;
        while($i <= $finproy){
            $annos[] =  [
                'anno' => $i
            ];

            // Meses por año
            $empresas[$j] = $this->empresasxannos($i);            

            $i++;
            $j++;            
        }

        $object = json_encode($annos);
        $annos  = json_decode($object);

        $proy = Proyeccion::all();
        $proyeccion = count($proy);

        // Calculamos los valores de fuentes en forma global
        //**************************************************** */
        $empresaservicio = Servicio::select('idempresa')
                                    ->distinct()
                                    ->get();
									
        $tempresasreales = Empresa::all();
        $totalempresas = count($tempresasreales); // Empresas existentes, con o sin servicios asociados       
        foreach($empresaservicio as $emps){

            //Ubicamos las fuentes distintas para cada empresa
            $fuentesdistintas = Servicio::select('idfuente')
                                    ->distinct()
                                    ->where('idempresa',$emps->idempresa)
                                    ->get();     
            
            // Identificamos que fuentes son
            $k = 0;
            foreach($fuentesexistentes as $fe){

                foreach($fuentesdistintas as $fd){
                    if($fe->id == $fd->idfuente){
                        $valoresfuentes[$k] += 1;
                    }
                }

                $k++;
            }                                    
        }              
        
        // Armamos la estructura a enviar
        $m = 0;
        $totalfuentes = 0;
        foreach($fuentesexistentes as $fe){
            $fuentes[] =  [
                'codigo' => $fe->codigo,
                'valor'  => $valoresfuentes[$m]
            ];

            $totalfuentes += $valoresfuentes[$m]; 

            $m++;
        }
        $object2 = json_encode($fuentes);
        $fuentes  = json_decode($object2);
        //**************************************************** */

        return view('indicadoresfuentes', compact('annos','proyeccion','empresas','totalempresas','anno','fuentes','totalfuentes','vproyectado','vreal'));
    }

    // Invoca a la presentacion de los indicadores
    public function indicadores($anno = '')
    {                        
        $empresas = array(12); // Contiene las empresas por año
        $fuentes = [];         // Contendra la informacion de fuentes
        $metodos = [];         // Contendra la informacion de metodos

        $vproyectado  = array(12); // Ventas Proyectadas
        $vreal        = array(12);       // Ventas Reales

        if($anno == '')
            $anno = Carbon::Now()->format('Y');

        // Inicializamos los vectores
        for($n = 0; $n < 12; $n++){
            $vproyectado[$n] = 0;
            $vreal[$n] = 0;    
        }

        // Ubicamos los valores proyectados de acuerdo al año indicado
        $valoresproy = Proyeccion::where('anno', $anno)->get();

        if(count($valoresproy) > 0){

            foreach($valoresproy as $vproy){
                $vproyectado[0] = $vproy->enero;
                $vproyectado[1] = $vproy->febrero;
                $vproyectado[2] = $vproy->marzo;
                $vproyectado[3] = $vproy->abril;
                $vproyectado[4] = $vproy->mayo;
                $vproyectado[5] = $vproy->junio;
                $vproyectado[6] = $vproy->julio;
                $vproyectado[7] = $vproy->agosto;
                $vproyectado[8] = $vproy->septiembre;
                $vproyectado[9] = $vproy->octubre;
                $vproyectado[10] = $vproy->noviembre;
                $vproyectado[11] = $vproy->diciembre;                                                            
            }
        }

        // Valores reales de empresas por mes un año determinado
        //***************************************************** */
        $vreal[0]  =  $this->montorealxmes($anno, '01');
        $vreal[1]  =  $this->montorealxmes($anno, '02');
        $vreal[2]  =  $this->montorealxmes($anno, '03');
        $vreal[3]  =  $this->montorealxmes($anno, '04');
        $vreal[4]  =  $this->montorealxmes($anno, '05');
        $vreal[5]  =  $this->montorealxmes($anno, '06');
        $vreal[6]  =  $this->montorealxmes($anno, '07');
        $vreal[7]  =  $this->montorealxmes($anno, '08');
        $vreal[8]  =  $this->montorealxmes($anno, '09');
        $vreal[9]  =  $this->montorealxmes($anno, '10');
        $vreal[10] =  $this->montorealxmes($anno, '11');   
        $vreal[11] =  $this->montorealxmes($anno, '12');
        //***************************************************** */
        // Cargamos las fuentes
        //$fuentesexistentes = Fuente::all();
        $fuentesexistentes = Servicio::select('registro')
                                    ->distinct()
                                    ->get();

        $tfuentesexistentes = count($fuentesexistentes);
        $valoresfuentes = array($tfuentesexistentes);

        // Inicializamos ese arreglo
        for($l = 0; $l < $tfuentesexistentes; $l++)
            $valoresfuentes [$l] = 0;

        // Cargamos los metodos
        $metodosexistentes = Metodo::all();
        $tmetodosexistentes = count($metodosexistentes);
        $valoresmetodos = array($tmetodosexistentes);

        // Inicializamos ese arreglo
        for($l = 0; $l < $tmetodosexistentes; $l++)
            $valoresmetodos [$l] = 0;
            
        // Años de evaluacion
        $iniproy = env('INI_PROY');
        $finproy = env('FIN_PROY');
        $annos = [];

        $i = $iniproy;
        $j = 0;
        $totalempresas = 0;
        while($i <= $finproy){
            $annos[] =  [
                'anno' => $i
            ];

            // Meses por año
            $empresas[$j] = $this->empresasxannos($i);            

            $i++;
            $j++;            
        }

        $object = json_encode($annos);
        $annos  = json_decode($object);

        $proy = Proyeccion::all();
        $proyeccion = count($proy);

        // Calculamos los valores de fuentes en forma global
        //**************************************************** */
        $empresaservicio = Servicio::select('idempresa')
                                    ->distinct()
                                    ->get();
									
        $tempresasreales = Empresa::all();
        $totalempresas = count($tempresasreales); // Empresas existentes, con o sin servicios asociados      
        
      foreach($empresaservicio as $emps){

            //Ubicamos las fuentes distintas para cada empresa
            $fuentesdistintas = Servicio::select('registro')
                                    ->distinct()
                                    ->where('idempresa',$emps->idempresa)
                                    ->get();     

            // Identificamos que fuentes son
            
            $k = 0;
            foreach($fuentesexistentes as $fe){

                foreach($fuentesdistintas as $fd){
                    if($fe->registro == $fd->registro){
                        $valoresfuentes[$k] += 1;
                    }
                }

                $k++;
            }                                    
        }              

        // Armamos la estructura a enviar
        
        $m = 0;
        $totalfuentes = 0;
        foreach($fuentesexistentes as $fe){
            $fuentes[] =  [
                'codigo' => $fe->codigo,
                'valor'  => $valoresfuentes[$m]
            ];

            $totalfuentes += $valoresfuentes[$m]; 

            $m++;
        }
        $object2 = json_encode($fuentes);
        $fuentes  = json_decode($object2);
        
        //**************************************************** */
//        $totalfuentes = $tfuentesexistentes;
        // Calculamos los valores de metodos en forma global
        //**************************************************** */

        // Criterio de calculo por empresa                                
        //************************************************************* */            
/*                            
        foreach($empresaservicio as $emps){

            //Ubicamos las fuentes distintas para cada empresa
            $fuentesdistintas = Servicio::select('idmetodo')
                                    ->distinct()
                                    ->where('idempresa',$emps->idempresa)
                                    ->get();     
            
            // Identificamos que metodos son
            $k = 0;
            foreach($metodosexistentes as $fe){

                foreach($fuentesdistintas as $fd){
                    if($fe->id == $fd->idmetodo){
                        $valoresmetodos[$k] += 1;
                    }
                }

                $k++;
            }                                    
        }              
*/        
        //************************************************************* */

        // Criterio de calculo por registro
        //************************************************************* */                                
        $registros = Servicio::select('registro')
                                ->distinct()
                                ->get();     

        foreach($registros as $emps){

            //Ubicamos las fuentes distintas para cada registro
            $metodosdistintos = Servicio::select('idmetodo')
                                    ->distinct()
                                    ->where('registro',$emps->registro)
                                    ->get();     
            
            // Identificamos que metodos son
            $k = 0;
            foreach($metodosexistentes as $fe){

                foreach($metodosdistintos as $fd){
                    if($fe->id == $fd->idmetodo){
                        $valoresmetodos[$k] += 1;
                    }
                }

                $k++;
            }                                    
        }              
        //************************************************************* */

        // Armamos la estructura a enviar
        $m = 0;
        $totalmetodos = 0;
        foreach($metodosexistentes as $fe){
            $metodos[] =  [
                'codigo' => $fe->codigo,
                'valor'  => $valoresmetodos[$m]
            ];

            $totalmetodos += $valoresmetodos[$m]; 

            $m++;
        }
        $object3 = json_encode($metodos);
        $metodos  = json_decode($object3);
        //**************************************************** */

        // Controla las fuentes globales por año
        //***************************************************** */
        $tamg = $finproy - $iniproy + 1;
        $fuentesglobalxanno = array($tamg);

        // Inicializamos
        for($o = 0; $o < $tamg; $o++)
            $fuentesglobalxanno[$o] = 0;

            $i = $iniproy;
            $j = 0;
            while($i <= $finproy){

                $from = date("Y-m-d", strtotime($i.'-01-01'));
                $to = date("Y-m-d", strtotime($i.'-12-31'));

//                $fechainicio = $i.'-01-01';
//                $fechafin = $i.'-12-31';

                $temporal = 0;
                foreach($empresaservicio as $ftemp){

                    //Ubicamos las fuentes distintas para cada empresa
                    $fuent = Servicio::select('registro')
                                        ->distinct()
                                        ->where('idempresa',$ftemp->idempresa)
                                        ->whereBetween('fechamedicion', [$from, $to])
                                        ->get();    
      

                    $temporal += count($fuent);                
                }

                $fuentesglobalxanno[$j] = $temporal;

                $i++;
                $j++;            
            }
        //***************************************************** */


        // Calculamos los valores de fuentes y metodos por mes en el año seleccionado
        //**************************************************** */
        $fuentesxanno = array(12);
        $metodosxanno = array(12);
        for($i = 0; $i < 12; $i++){
            $fuentesxanno[$i] = 0;
            $metodosxanno[$i] = 0;    
        }
        foreach($empresaservicio as $emps){

            for($mes = 1; $mes <= 12; $mes++){

                if ($mes < 10){
                    $fechainicio = $anno.'-'.'0'.$mes.'-01';
                    $fechafin = $anno.'-'.'0'.$mes.'-31';
                }else{
                    $fechainicio = $anno.'-'.$mes.'-01';
                    $fechafin = $anno.'-'.$mes.'-31';
                }
                $fechainicio = date("Y-m-d", strtotime($fechainicio));
                $fechafin = date("Y-m-d", strtotime($fechafin));
                    
                //Ubicamos las fuentes distintas para cada empresa
                $fuentesdistintas = Servicio::select('registro')
                                            ->distinct()
                                            ->where('idempresa',$emps->idempresa)
                                            ->whereBetween('fechamedicion', [$fechainicio, $fechafin])
                                            ->get();     

                $valorf = count($fuentesdistintas);
                $fuentesxanno[$mes - 1] += $valorf;

                //Ubicamos los metodos distintas para cada empresa
                $metodosdistintas = Servicio::select('idmetodo')
                                            ->distinct()
                                            ->where('idempresa',$emps->idempresa)
                                            ->whereBetween('fechamedicion', [$fechainicio, $fechafin])
                                            ->get();     
            
                $metodosxanno[$mes - 1] += count($metodosdistintas);

            }

        }              
        //**************************************************** */  

        // Totales por año determinado
        //**************************************************** */
        $totalfuentesxanno = 0;
        $totalmetodosxanno = 0;    
        for($m = 0; $m < 12; $m++){
            $totalfuentesxanno += $fuentesxanno[$m];
            $totalmetodosxanno += $metodosxanno[$m];    
        }
        //**************************************************** */          
        

        return view('indicadoresfm', compact('annos','proyeccion','empresas','totalempresas','anno','fuentes','totalfuentes','vproyectado','vreal','totalmetodos','metodos','fuentesxanno','metodosxanno','totalfuentesxanno','totalmetodosxanno','fuentesglobalxanno'));
    }
    
    // Calcula la cantidad de empresas por años
    public function empresasxannos($anno){
//        $fechainicio = $anno.'-01-01';
//        $fechafin = $anno.'-12-31';
$fechainicio = date("Y-m-d", strtotime($anno.'-01-01'));
$fechafin = date("Y-m-d", strtotime($anno.'-12-31'));

        $empresas = Servicio::select('idempresa')
                            ->distinct()
                            ->whereBetween('fechamedicion', [$fechainicio, $fechafin])
                            ->get();
        return count($empresas);
    }

    // Calcular empresas por mes un año determinado
    public function empresasxmes($anno, $mes){
//        $fechainicio = $anno.'-'.$mes.'-01';
//        $fechafin = $anno.'-'.$mes.'-31';
        $fechainicio = date("Y-m-d", strtotime($anno.'-'.$mes.'-01'));
        $fechafin = date("Y-m-d", strtotime($anno.'-'.$mes.'-31'));

        $empresas = Servicio::select('idempresa')
                            ->distinct()
                            ->whereBetween('fechamedicion', [$fechainicio, $fechafin])
                            ->get();

        return count($empresas);
    }

    public function montorealxmes($anno, $mes){

        $fechainicio = date("Y-m-d", strtotime($anno.'-'.$mes.'-01'));
        $fechafin = date("Y-m-d", strtotime($anno.'-'.$mes.'-31'));

        $resul = Servicio::select(\DB::raw('SUM(valorcobrado) as total'))
                        ->whereBetween('fechamedicion', [$fechainicio, $fechafin])
                        ->get();


        return $resul[0]->total;

    }
}
