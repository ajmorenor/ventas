@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><b>Definir Criterios de Busqueda de Servicios</b>
</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('servicio/busqueda') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Fecha Inicio</label>
                            <div class="col-md-6">
                                <input id="fechainicio" type="date" class="form-control" name="fechainicio" value="" autofocus>
                            </div>    
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Fecha Fin</label>
                            <div class="col-md-6">
                                <input id="fechafin" type="date" class="form-control" name="fechafin" value="" >
                            </div>    
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Medido ?</label>
                            <div class="col-md-6">
                                <select id="medido" name="medido" class="form-control" value="" >  
                                        <option value=""></option>
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>                                        
                                </select>
                            </div>    
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Enviado Recordatorio ?</label>
                            <div class="col-md-6">
                                <select id="recordatorio" name="recordatorio" class="form-control" value="" >  
                                        <option value=""></option>
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>                                        
                                </select>
                            </div>    
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Fuente</label>
                            <div class="col-md-6">
                                <select id="idfuente" name="idfuente" class="form-control" >
                                    <option></option>
                                    @foreach($fuentes as $fuente)
                                        <option value="{{ $fuente->id }}">{{ $fuente->tipo }}</option>
                                    @endforeach
                                </select>
                            </div>    
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Metodo Aplicado</label>
                            <div class="col-md-6">
                                <select id="idmetodo" name="idmetodo" class="form-control" >
                                    <option></option>
                                    @foreach($metodos as $metodo)
                                        <option value="{{ $metodo->id }}">{{ $metodo->codigo }}</option>
                                    @endforeach
                                </select>
                            </div>    
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Buscar Servicios
                                </button>
                                <a href="{{ url('servicio/todos') }}" class="btn btn-danger"> <i class="fa fa-add">Volver</i> </a>
                            </div>
                        </div>
                    </form>
                    <span style="color:red">Busqueda por fecha especifica: indique fecha de inicio o fin y, demas criterios</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
