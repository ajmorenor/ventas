<?php

namespace App\Http\Controllers;

use App\Servicio;
use App\Relacion;
use App\Empresa;
use App\Fuente;
use App\Metodo;

use Redirect;

use Carbon\Carbon;

use App\Http\Controllers\Controller;
use App\Mail\EnviarEmail;
use Illuminate\Support\Facades\Mail;
 
class MailController extends Controller
{
    public function send($registro,$rut,$empresa,$contacto,$email,$codigometodo,$tipofuente,$fechamedicion)
    {    
        $objDemo = new \stdClass();
        $objDemo->sender = 'Miguel Bettiz - Sercoamb';
		$objDemo->registro = $registro;
        $objDemo->rut = $rut;
        $objDemo->empresa = $empresa;
        $objDemo->receiver = $contacto;
        $objDemo->codigometodo = $codigometodo;
        $objDemo->tipofuente = $tipofuente;
        $objDemo->fechamedicion = $fechamedicion;

        Mail::to($email)
			  ->cc(env('MAIL_USERNAME'))
			  ->bcc(env('MAIL_OPERADOR'))              	
			  ->send(new EnviarEmail($objDemo));
    }

    public function barra(){
        $servicios = Servicio::count();
        return view('bar',compact('servicios'));
    }

    public function procesar(){

        // Enviamos los email
        //**************************** */

        // Ubicamos los servicios
        $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
            ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
            ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')            
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigometodo',
                     'servicios.id','servicios.idfuente','fuentes.codigo as codigofuente','fuentes.tipo',
                     'servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
                     'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo',
                     'servicios.idempresa','empresas.rut','empresas.nombre','empresas.contacto','empresas.email')
            ->get();

            // Recorremos los datos
            $hoy = date('Y-m-d');
			//$mailvalido = 1;
            foreach($servicios as $service){
			  //$mailvalido = (filter_var($service->email, FILTER_VALIDATE_EMAIL)) ? 1 : 0;
			  if (!empty($service->email)){ //&& ($mailvalido == 1)){ 	
                $datetime1=date_create($hoy);
                $datetime2=date_create($service->fechamedicion);

                // obtenemos la diferencia entre las dos fechas
                $interval= date_diff ($datetime2,$datetime1);

                // obtenemos la diferencia en meses
                $intervalMeses=$interval->format("%m");
                // obtenemos la diferencia en años y la multiplicamos por 12 para tener los meses
                $intervalAnos = $interval->format("%y")*12;
         
                $meses = $intervalMeses + $intervalAnos;

                // Verificacion del primer envio, luego de 10 meses
                // *************************************************
                if ( ($meses == 10) && (strcmp($service->primercorreo,"No") == 0 )){

                    // Enviamos el email
                    $this->send($service->registro,$service->rut,$service->nombre,$service->contacto,$service->email,
                                $service->codigometodo,$service->tipo,$service->fechamedicion);

                    // Actualizamos el registro de envio de correos
                    $servicio = Servicio::find($service->id);
                    $servicio->primercorreo = "Si";
                    $servicio->save();
					
                }
                // *************************************************

                // Verificacion del segundo envio, luego de 11 meses
                // *************************************************
                if ( ($meses == 11) && (strcmp($service->segundocorreo,"No") == 0 )){

                    // Enviamos el email
                    $this->send($service->registro,$service->rut,$service->nombre,$service->contacto,$service->email,
                                $service->codigometodo,$service->tipo,$service->fechamedicion);

                    // Actualizamos el registro de envio de correos
                    $servicio = Servicio::find($service->id);
                    $servicio->segundocorreo = "Si";
                    $servicio->save();
                }
                // *************************************************

                // Verificacion del tercer envio, luego de 12 meses
                // *************************************************
                if ( ($meses == 12) && (strcmp($service->tercercorreo,"No") == 0 )){

                    // Enviamos el email
                    $this->send($service->registro,$service->rut,$service->nombre,$service->contacto,$service->email,
                                $service->codigometodo,$service->tipo,$service->fechamedicion);

                    // Actualizamos el registro de envio de correos
                    $servicio = Servicio::find($service->id);
                    $servicio->tercercorreo = "Si";
                    $servicio->save();
                }
                // *************************************************
			  }  
            } // Fin Foreach
			
        //**************************** */

        // Cerramos la sesion
        //**************************** */
        return redirect::to('../logout');
        //**************************** */        
    }
}