<?php

namespace App\Http\Controllers;

use App\Servicio;
use App\Relacion;
use App\Empresa;
use App\Fuente;
use App\Metodo;

use Redirect;

use Illuminate\Http\Request;

class ServicioController extends Controller
{
    //
    public function __construct(){}

    public function index($idempresa){
            $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
                ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo','servicios.id',
                        'servicios.idfuente','fuentes.codigo as codigofuente','fuentes.tipo',
                        'servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
                        'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo',
                        'servicios.tercercorreo')
                ->where('servicios.idempresa', '=', $idempresa)
                ->get();

        $empresa =Empresa::find($idempresa);
        return view('servicioview', compact('empresa','servicios'));
    }

    public function bespecifica()
    { 
        // Todos los servicios
        if (session('estado') == 'all'){
            $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
	        ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
            ->get();
            
        }else{ // Se ingreso a BUSQUEDA y se definieron parametros

            // Solo la fecha de inicio
            if (!empty(session('fechainicio')) &&  empty(session('fechafin')) &&  empty(session('medido')) &&  empty(session('recordatorio')) &&  empty(session('fuente')) &&  empty(session('metodo')) ){
                $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
                ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
                ->where('servicios.fechamedicion', '=', session('fechainicio'))
                ->get();
            }    

            // Solo la fecha fin
            if (empty(session('fechainicio')) &&  !empty(session('fechafin')) &&  empty(session('medido')) &&  empty(session('recordatorio')) &&  empty(session('fuente')) &&  empty(session('metodo')) ){
                $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
                ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
                ->where('servicios.fechamedicion', '=', session('fechafin'))
                ->get();
            }    

            // Solo medido
            if (empty(session('fechainicio')) &&  empty(session('fechafin')) &&  !empty(session('medido')) &&  empty(session('recordatorio')) &&  empty(session('fuente')) &&  empty(session('metodo')) ){
                $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
                ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
                ->where('servicios.medido', '=', session('medido'))
                ->get();
            }    

            // Solo recordatorio
            if (empty(session('fechainicio')) &&  empty(session('fechafin')) &&  empty(session('medido')) &&  !empty(session('recordatorio')) &&  empty(session('fuente')) &&  empty(session('metodo')) ){
                $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
            ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
                ->where('servicios.primercorreo', '=', session('recordatorio'))
                ->get();
            }    

            // Solo fuente
            if (empty(session('fechainicio')) &&  empty(session('fechafin')) &&  empty(session('medido')) &&  empty(session('recordatorio')) &&  !empty(session('fuente')) &&  empty(session('metodo')) ){
                $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
            ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
                ->where('servicios.idfuente', '=', session('fuente'))
                ->get();
            }    

            // Solo metodo
            if (empty(session('fechainicio')) &&  empty(session('fechafin')) &&  empty(session('medido')) &&  empty(session('recordatorio')) &&  empty(session('fuente')) &&  !empty(session('metodo')) ){
                $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
            ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
                ->where('servicios.idmetodo', '=', session('metodo'))
                ->get();
            }    

            // Entre dos fechas
            if (!empty(session('fechainicio')) &&  !empty(session('fechafin')) &&  empty(session('medido')) &&  empty(session('recordatorio')) &&  empty(session('fuente')) &&  empty(session('metodo')) ){
                $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
            ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
                ->where('servicios.fechamedicion', '>=', session('fechainicio'))
                ->where('servicios.fechamedicion', '<=', session('fechafin'))
                ->get();
            } 

            // Todas las opciones
            if (!empty(session('fechainicio')) &&  !empty(session('fechafin')) &&  !empty(session('medido')) &&  !empty(session('recordatorio')) &&  !empty(session('fuente')) &&  !empty(session('metodo')) ){
                $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
            ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
                ->where('servicios.fechamedicion', '>=', session('fechainicio'))
                ->where('servicios.fechamedicion', '<=', session('fechafin'))
                ->where('servicios.medido', '=', session('medido'))
                ->where('servicios.primercorreo', '=', session('recordatorio'))
                ->where('servicios.idfuente', '=', session('fuente'))
                ->where('servicios.idmetodo', '=', session('metodo'))
                ->get();
            } 

            // Fecha Inicio con todas las opciones
            if (!empty(session('fechainicio')) &&  empty(session('fechafin')) &&  !empty(session('medido')) &&  !empty(session('recordatorio')) &&  !empty(session('fuente')) &&  !empty(session('metodo')) ){
                $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
            ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
                ->where('servicios.fechamedicion', '=', session('fechainicio'))
                ->where('servicios.medido', '=', session('medido'))
                ->where('servicios.primercorreo', '=', session('recordatorio'))
                ->where('servicios.idfuente', '=', session('fuente'))
                ->where('servicios.idmetodo', '=', session('metodo'))
                ->get();
            } 

            // Fecha fin con todas las opciones
            if (empty(session('fechainicio')) &&  !empty(session('fechafin')) &&  !empty(session('medido')) &&  !empty(session('recordatorio')) &&  !empty(session('fuente')) &&  !empty(session('metodo')) ){
                $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
            ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
                ->where('servicios.fechamedicion', '=', session('fechafin'))
                ->where('servicios.medido', '=', session('medido'))
                ->where('servicios.primercorreo', '=', session('recordatorio'))
                ->where('servicios.idfuente', '=', session('fuente'))
                ->where('servicios.idmetodo', '=', session('metodo'))
                ->get();
            } 

            // La primera fecha con las combinaciones de opciones
            if (!empty(session('fechainicio')) &&  empty(session('fechafin')) &&  !empty(session('medido')) &&  empty(session('recordatorio')) &&  empty(session('fuente')) &&  empty(session('metodo')) ){
                $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
            ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
                ->where('servicios.fechamedicion', '=', session('fechainicio'))
                ->where('servicios.medido', '=', session('medido'))
                ->get();
            } 

            if (!empty(session('fechainicio')) &&  empty(session('fechafin')) &&  empty(session('medido')) &&  !empty(session('recordatorio')) &&  empty(session('fuente')) &&  empty(session('metodo')) ){
                $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
            ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
                ->where('servicios.fechamedicion', '=', session('fechainicio'))
                ->where('servicios.primercorreo', '=', session('recordatorio'))
                ->get();
            } 

            if (!empty(session('fechainicio')) &&  empty(session('fechafin')) &&  empty(session('medido')) &&  empty(session('recordatorio')) &&  !empty(session('fuente')) &&  empty(session('metodo')) ){
                $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
            ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
                ->where('servicios.fechamedicion', '=', session('fechainicio'))
                ->where('servicios.idfuente', '=', session('fuente'))
                ->get();
            } 

            if (!empty(session('fechainicio')) &&  empty(session('fechafin')) &&  empty(session('medido')) &&  empty(session('recordatorio')) &&  empty(session('fuente')) &&  !empty(session('metodo')) ){
                $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
            ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
                ->where('servicios.fechamedicion', '=', session('fechainicio'))
                ->where('servicios.idmetodo', '=', session('metodo'))
                ->get();
            } 

            if (!empty(session('fechainicio')) &&  empty(session('fechafin')) &&  !empty(session('medido')) &&  !empty(session('recordatorio')) &&  empty(session('fuente')) &&  empty(session('metodo')) ){
                $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
            ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
                ->where('servicios.fechamedicion', '=', session('fechainicio'))
                ->where('servicios.medido', '=', session('medido'))
                ->where('servicios.primercorreo', '=', session('recordatorio'))
                ->get();
            } 

            if (!empty(session('fechainicio')) && empty(session('fechafin')) &&  !empty(session('medido')) &&  !empty(session('recordatorio')) &&  !empty(session('fuente')) &&  empty(session('metodo')) ){
                $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
            ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
                ->where('servicios.fechamedicion', '=', session('fechainicio'))
                ->where('servicios.medido', '=', session('medido'))
                ->where('servicios.primercorreo', '=', session('recordatorio'))
                ->where('servicios.idfuente', '=', session('fuente'))
                ->get();
            } 

            // La segunda fecha con las combinaciones de opciones
            if (empty(session('fechainicio')) &&  !empty(session('fechafin')) &&  !empty(session('medido')) &&  empty(session('recordatorio')) &&  empty(session('fuente')) &&  empty(session('metodo')) ){
                $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
            ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
                ->where('servicios.fechamedicion', '=', session('fechafin'))
                ->where('servicios.medido', '=', session('medido'))
                ->get();
            } 

            if (empty(session('fechainicio')) &&  !empty(session('fechafin')) &&  empty(session('medido')) &&  !empty(session('recordatorio')) &&  empty(session('fuente')) &&  empty(session('metodo')) ){
                $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
            ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
                ->where('servicios.fechamedicion', '=', session('fechafin'))
                ->where('servicios.primercorreo', '=', session('recordatorio'))
                ->get();
            } 

            if (empty(session('fechainicio')) &&  !empty(session('fechafin')) &&  empty(session('medido')) &&  empty(session('recordatorio')) &&  !empty(session('fuente')) &&  empty(session('metodo')) ){
                $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
            ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
                ->where('servicios.fechamedicion', '=', session('fechafin'))
                ->where('servicios.idfuente', '=', session('fuente'))
                ->get();
            } 

            if (empty(session('fechainicio')) &&  !empty(session('fechafin')) &&  empty(session('medido')) &&  empty(session('recordatorio')) &&  empty(session('fuente')) &&  !empty(session('metodo')) ){
                $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
            ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
                ->where('servicios.fechamedicion', '=', session('fechafin'))
                ->where('servicios.idmetodo', '=', session('metodo'))
                ->get();
            } 

            if (empty(session('fechainicio')) &&  !empty(session('fechafin')) &&  !empty(session('medido')) &&  !empty(session('recordatorio')) &&  empty(session('fuente')) &&  empty(session('metodo')) ){
                $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
            ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
                ->where('servicios.fechamedicion', '=', session('fechafin'))
                ->where('servicios.medido', '=', session('medido'))
                ->where('servicios.primercorreo', '=', session('recordatorio'))
                ->get();
            } 

            if (empty(session('fechainicio')) && !empty(session('fechafin')) &&  !empty(session('medido')) &&  !empty(session('recordatorio')) &&  !empty(session('fuente')) &&  empty(session('metodo')) ){
                $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
            ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
                ->where('servicios.fechamedicion', '=', session('fechafin'))
                ->where('servicios.medido', '=', session('medido'))
                ->where('servicios.primercorreo', '=', session('recordatorio'))
                ->where('servicios.idfuente', '=', session('fuente'))
                ->get();
            } 

            // Ambas fechas con las combinaciones de ellas
            if (!empty(session('fechainicio')) &&  !empty(session('fechafin')) &&  !empty(session('medido')) &&  empty(session('recordatorio')) &&  empty(session('fuente')) &&  empty(session('metodo')) ){
                $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
            ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
                ->where('servicios.fechamedicion', '>=', session('fechainicio'))
                ->where('servicios.fechamedicion', '<=', session('fechafin'))
                ->where('servicios.medido', '=', session('medido'))
                ->get();
            } 
            if (!empty(session('fechainicio')) &&  !empty(session('fechafin')) &&  empty(session('medido')) &&  !empty(session('recordatorio')) &&  empty(session('fuente')) &&  empty(session('metodo')) ){
                $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
            ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
                ->where('servicios.fechamedicion', '>=', session('fechainicio'))
                ->where('servicios.fechamedicion', '<=', session('fechafin'))
                ->where('servicios.primercorreo', '=', session('recordatorio'))
                ->get();
            } 
            if (!empty(session('fechainicio')) &&  !empty(session('fechafin')) &&  empty(session('medido')) &&  empty(session('recordatorio')) &&  !empty(session('fuente')) &&  empty(session('metodo')) ){
                $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
            ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
                ->where('servicios.fechamedicion', '>=', session('fechainicio'))
                ->where('servicios.fechamedicion', '<=', session('fechafin'))
                ->where('servicios.idfuente', '=', session('fuente'))
                ->get();
            } 
            if (!empty(session('fechainicio')) &&  !empty(session('fechafin')) &&  empty(session('medido')) &&  empty(session('recordatorio')) &&  empty(session('fuente')) &&  !empty(session('metodo')) ){
                $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
            ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
                ->where('servicios.fechamedicion', '>=', session('fechainicio'))
                ->where('servicios.fechamedicion', '<=', session('fechafin'))
                ->where('servicios.idmetodo', '=', session('metodo'))
                ->get();
            } 
            if (!empty(session('fechainicio')) &&  !empty(session('fechafin')) &&  !empty(session('medido')) &&  !empty(session('recordatorio')) &&  empty(session('fuente')) &&  empty(session('metodo')) ){
                $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
            ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
                ->where('servicios.fechamedicion', '>=', session('fechainicio'))
                ->where('servicios.fechamedicion', '<=', session('fechafin'))
                ->where('servicios.medido', '=', session('medido'))
                ->where('servicios.primercorreo', '=', session('recordatorio'))
                ->get();
            } 
            if (!empty(session('fechainicio')) &&  !empty(session('fechafin')) &&  !empty(session('medido')) &&  !empty(session('recordatorio')) &&  !empty(session('fuente')) &&  empty(session('metodo')) ){
                $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
            ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
                ->where('servicios.fechamedicion', '>=', session('fechainicio'))
                ->where('servicios.fechamedicion', '<=', session('fechafin'))
                ->where('servicios.medido', '=', session('medido'))
                ->where('servicios.primercorreo', '=', session('recordatorio'))
                ->where('servicios.idfuente', '=', session('fuente'))
                ->get();
            } 

            // Medido con recordatorio
            if (empty(session('fechainicio')) &&  empty(session('fechafin')) &&  !empty(session('medido')) &&  !empty(session('recordatorio')) &&  empty(session('fuente')) &&  empty(session('metodo')) ){
                $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
            ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
                ->where('servicios.medido', '=', session('medido'))
                ->where('servicios.primercorreo', '=', session('recordatorio'))
                ->get();
            } 

            // Medido con fuente
            if (empty(session('fechainicio')) &&  empty(session('fechafin')) &&  !empty(session('medido')) &&  empty(session('recordatorio')) &&  !empty(session('fuente')) &&  empty(session('metodo')) ){
                $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
            ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
                ->where('servicios.medido', '=', session('medido'))
                ->where('servicios.idfuente', '=', session('fuente'))
                ->get();
            } 
            // Todas las opciones
            if (empty(session('fechainicio')) &&  empty(session('fechafin')) &&  !empty(session('medido')) &&  empty(session('recordatorio')) &&  empty(session('fuente')) &&  !empty(session('metodo')) ){
                $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
            ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
                ->where('servicios.medido', '=', session('medido'))
                ->where('servicios.idmetodo', '=', session('metodo'))
                ->get();
            } 

            // Recordatorio con fuente
            if (empty(session('fechainicio')) &&  empty(session('fechafin')) &&  empty(session('medido')) &&  !empty(session('recordatorio')) &&  !empty(session('fuente')) &&  empty(session('metodo')) ){
                $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
            ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
                ->where('servicios.primercorreo', '=', session('recordatorio'))
                ->where('servicios.idfuente', '=', session('fuente'))
                ->get();
            } 

            // Recordatorio con metodo
            if (empty(session('fechainicio')) &&  empty(session('fechafin')) &&  empty(session('medido')) &&  !empty(session('recordatorio')) &&  empty(session('fuente')) &&  !empty(session('metodo')) ){
                $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
            ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
                ->where('servicios.primercorreo', '=', session('recordatorio'))
                ->where('servicios.idmetodo', '=', session('metodo'))
                ->get();
            } 

            // Fuente con metodo
            if (empty(session('fechainicio')) &&  empty(session('fechafin')) &&  empty(session('medido')) &&  empty(session('recordatorio')) &&  !empty(session('fuente')) &&  !empty(session('metodo')) ){
                $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
                ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
            ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
                ->where('servicios.idfuente', '=', session('fuente'))
                ->where('servicios.idmetodo', '=', session('metodo'))
                ->get();
            } 


        }


        return view('allservices', compact('servicios'));
    }

    // Metodo de buscar
    public function buscar(Request $request){

        // Seteamos las variables de sesion de acuerdo a los valores seleccionados
        if ( empty($request->fechainicio) && empty($request->fechafin) && empty($request->medido) && empty($request->recordatorio) && empty($request->idfuente) && empty($request->idmetodo) ){

            session(['estado' => 'all']);
        }
        else{

            session(['estado' => '']);
            session(['fechainicio' => $request->fechainicio]);
            session(['fechafin' => $request->fechafin]);
            session(['medido' => $request->medido]);
            session(['recordatorio' => $request->recordatorio]);
            session(['fuente' => $request->idfuente]);
            session(['metodo' => $request->idmetodo]);
        }

        return redirect::to('servicio/bespecifica');
    }

    // Metodo de todos
    public function todos(){

        session(['estado' => 'all']);

        return redirect::to('servicio/bespecifica');
    }

    public function allservices(){

            $servicios = Servicio::join('fuentes', 'fuentes.id', '=', 'servicios.idfuente')
            ->join('metodos', 'metodos.id', '=', 'servicios.idmetodo')
            ->join('empresas', 'empresas.id', '=', 'servicios.idempresa')
            ->select('servicios.registro','metodos.id as idmetodo','metodos.codigo as codigom',
		'servicios.id','servicios.idfuente','servicios.idempresa','fuentes.codigo as codigofuente',
		'fuentes.tipo','servicios.valorcobrado','servicios.fechamedicion','servicios.medido',
		'servicios.observaciones','servicios.primercorreo','servicios.segundocorreo','servicios.tercercorreo', 
		'empresas.rut','empresas.nombre as nombrempresa')
            ->get();

        return view('allservices', compact('servicios'));
    }
    

    public function edit($idservicio)
    {
        $servicio = Servicio::find($idservicio);

        $empresa = Empresa::find($servicio->idempresa);
        $fuente = Fuente::find($servicio->idfuente);
        $fuentes = Fuente::all();
        $metodos = Metodo::all();
        $metodoact = Metodo::find($servicio->idmetodo);

        return view('ActualizarServicio', compact('servicio','empresa','fuente','fuentes','metodos','metodoact'));
    }

    public function agregar($idservicio)
    {
        $servicio = Servicio::find($idservicio);

        $empresa = Empresa::find($servicio->idempresa);
        $fuente = Fuente::find($servicio->idfuente);
        $metodoact = Metodo::find($servicio->idmetodo);

        return view('AgregarServicio', compact('servicio','empresa','fuente','metodoact'));
    }

    // Update    
    public function update(Request $request)
    {
        $contact = Servicio::find($request->idservicio);
        $contact->fill($request->all());
        $contact->save();

        session(['estado' => 'all']);

        return Redirect::to('servicio/'.$request->idempresa.'/index');    
    
    }

    // Delete 
    public function delete()
    {
        //$idservicio, $idempresa

        $idservicio = $_GET['idservicio']; 
        $idempresa = $_GET['idempresa']; 

        $contact = Servicio::find($idservicio);
        $contact->delete();

        //session(['estado' => 'all']);

        //return Redirect::to('servicio/'.$idempresa.'/index');
    }

    // Add
    public function add($idempresa, $mensaje)
    {
        $empresa = Empresa::find($idempresa);
        $metodos = Metodo::all();
        $fuentes = Fuente::all();

        return view('registerServicio',compact('empresa','metodos','fuentes','mensaje'));
    }

    // Busqueda
    public function busqueda()
    {
            $metodos = Metodo::all();
            $fuentes = Fuente::all();
        
            return view('BusquedaServicio',compact('fuentes','metodos'));
    }
    
    // Save 
    public function save(Request $request)
    {
        $emp = new Servicio;

        if (is_numeric($request->valorcobrado)){
            $empresa = $emp->create($request->all());

            return Redirect::to('servicio/'.$request->idempresa.'/index');    
        }else{
            return Redirect::to('servicio/'.$request->idempresa.'/'.'Error al registrar el metodo a la fuente'.'/add');
        }
    }

    // Create 
    protected function create(array $data)
    {
        return Servicio::create([
            'registro' => $data['registro'],
            'idempresa' => $data['idempresa'],
            'idfuente' => $data['idfuente'],                        
            'idmetodo' => $data['idmetodo'],
            'observaciones' => $data['observaciones'],
            'valorcobrado' => $data['valorcobrado'],
            'fechamedicion' => $data['fechamedicion'],
            'medido' => $data['medido'],
        ]);
    }

}

