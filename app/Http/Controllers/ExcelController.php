<?php

namespace App\Http\Controllers;

use App\Servicio;
use App\Relacion;
use App\Empresa;
use App\Fuente;
use App\Metodo;

use Redirect;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function verdes()
    {
        $empresa = '';
        $servicios = '';
        //$idempresa = $idemp;
        //$idemp = $_GET['idempresa']; Cuando se envia via ajax

        //$empresa = Empresa::find($idemp);

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


        /** Creamos un archivo llamado fromBlade.xlsx */
        Excel::create('Servicios Asociados Empresa', function ($excel) use($servicios) {

            /** La hoja se llamará Usuarios */
            $excel->sheet('Servicios', function ($sheet) use($servicios) {
                /** El método loadView nos carga la vista blade a utilizar */
                $sheet->loadView('serviciosexcel')->with('servicios',$servicios);
            });

  //          $sheet->fromArray($servicios); Esto exportaria el archivo solo, mientras que lo anterior exporta una vista
  //          });
        })->export('xlsx');

    }

    public function exportexcel()
    {
        /** Fuente de Datos (Array) */
        /*$data = [
            ['Nombre', 'Hiram Guerrero'],
            ['Edad', '27'],
            ['Profesión', 'Desarrollador de Software'],
        ];*/

        /** Fuente de Datos Eloquent */
        $data = Empresa::all();

        /** Creamos nuestro archivo Excel */
        Excel::create('Servicios Por Empresa', function ($excel) use ($data) {

            /** Definimos los metadatos
             * $excel->setTitle('Usuarios');
             * $excel->setCreator('Eichgi');
             * $excel->setDescription('Creando mi primera hoja en excel con Laravel!');*/

            /** Creamos una hoja */
            $excel->sheet('Servicios por Empresa', function ($sheet) use ($data) {
                /**
                 * Insertamos los datos en la hoja con el método with/fromArray
                 * Parametros: (
                 * Datos,
                 * Valores del encabezado de la columna,
                 * Celda de Inicio,
                 * Comparación estricta de los valores del encabezado
                 * Impresión de los encabezados
                 * )*/
                $sheet->with($data, null, 'A1', false, false);
            });

            /** Descargamos nuestro archivo pasandole la extensión deseada (xls, xlsx) */
        })->download('xlsx');
    }

    public function importExcel()
    {
        /** El método load permite cargar el archivo definido como primer parámetro */
        Excel::load('productos.csv', function ($reader) {
            /**
             * $reader->get() nos permite obtener todas las filas de nuestro archivo
             */
            foreach ($reader->get() as $key => $row) {
                $producto = [
                    'articulo' => $row['articulo'],
                    'cantidad' => $row['cantidad'],
                    'precio_unitario' => $row['precio_unitario'],
                    'fecha_registro' => $row['fecha_registro'],
                    'status' => $row['status'],
                ];

                /** Una vez obtenido los datos de la fila procedemos a registrarlos */
                if (!empty($producto)) {
                    DB::table('productos')->insert($producto);
                }
            }

            echo 'Los productos han sido importados exitosamente';
        });
    }

    public function importFromFile(Request $request)
    {
        /** Cargando el excel mediante un archivo recibido vía POST con name=productos */
        Excel::load($request->productos->getRealPath(), function ($reader) {
            /**
             * $reader->get() nos permite obtener todas las filas de nuestro archivo
             */
            foreach ($reader->get() as $key => $row) {
                $producto = [
                    'articulo' => $row['articulo'],
                    'cantidad' => $row['cantidad'],
                    'precio_unitario' => $row['precio_unitario'],
                    'fecha_registro' => $row['fecha_registro'],
                    'status' => $row['status'],
                ];

                /** Una vez obtenido los datos de la fila procedemos a registrarlos */
                if (!empty($producto)) {
                    DB::table('productos')->insert($producto);
                }
            }

            echo 'Los productos han sido importados exitosamente';
        });
    }
}

