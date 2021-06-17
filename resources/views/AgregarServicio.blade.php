@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><b>Crear Servicio de las Fuentes a Empresa</b>
                <div><b>Rut:</b> {{ $empresa->rut }}</div>
                <div><b>Nombre:</b> {{ $empresa->nombre }}</div>
</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('servicio/save') }}">
                        {{ csrf_field() }}
                        <input id="idempresa" type="hidden" class="form-control" name="idempresa" value={{ $empresa->id }}>
                        <input id="idfuente" type="hidden" class="form-control" name="idfuente" value={{ $fuente->id }}>
                        <input id="idmetodo" type="hidden" class="form-control" name="idmetodo" value={{ $metodoact->id }}>
                        <input id="registro" type="hidden" class="form-control" name="registro" value={{ $servicio->registro }}>

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Numero Registro</label>
                            <div class="col-md-6">
                                <input id="registro" type="text" class="form-control" name="registro" value="{{ $servicio->registro }}" required disabled>
                            </div>    
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Fuente</label>
                            <div class="col-md-6">
                                <input id="idf" type="text" class="form-control" name="idf" value="{{ $fuente->tipo }}" required disabled>
                            </div>    
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Metodo</label>
                            <div class="col-md-6">
                                <input id="idm" type="text" class="form-control" name="idm" value="{{ $metodoact->codigo }}" required disabled>
                            </div>    
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Fecha Medicion</label>
                            <div class="col-md-6">
                                <input id="fechamedicion" type="date" class="form-control" name="fechamedicion" value="" required autofocus>
                            </div>    
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Venta Real</label>
                            <div class="col-md-6">
                                <input id="valorcobrado" type="decimal" class="form-control" name="valorcobrado" value="" required>
                            </div>    
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Medido ?</label>
                            <div class="col-md-6">
                                <select id="medido" name="medido" class="form-control" value="" required>  
                                    <option value=""></option>
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>                                        
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Observaciones</label>

                            <div class="col-md-6">
                                <textarea id="observaciones" name="observaciones" rows="3" cols="40"></textarea>
                        </div>

                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Crear Servicio
                                </button>
                                <a href="{{ url('servicio/'.$empresa->id.'/index') }}" class="btn btn-danger"> <i class="fa fa-add">Volver</i> </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
