@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><b>Actualizar Metodo de las Fuentes a Empresa</b>
                <div><b>Rut:</b> {{ $empresa->rut }}</div>
                <div><b>Nombre:</b> {{ $empresa->nombre }}</div>
</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('servicio/update') }}">
                        {{ csrf_field() }}
                        <input id="idempresa" type="hidden" class="form-control" name="idempresa" value={{ $empresa->id }}>
                        <input id="idfuente" type="hidden" class="form-control" name="idfuente" value={{ $fuente->id }}>
                        <input id="idservicio" type="hidden" class="form-control" name="idservicio" value={{ $servicio->id }}>

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Fuente</label>
                            <div class="col-md-6">
                                <select id="idfuente" name="idfuente" class="form-control">
                                <option value="{{$fuente->id}}">{{$fuente->tipo}}</option>
                                    @foreach($fuentes as $fuente)
                                        <option value="{{ $fuente->id }}">{{ $fuente->tipo }}</option>
                                    @endforeach
                                </select>
                            </div>    
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Metodo</label>
                            <div class="col-md-6">
                                <select id="idmetodo" name="idmetodo" class="form-control">
                                <option value="{{$metodoact->id}}">{{$metodoact->codigo}}</option>
                                    @foreach($metodos as $metodo)
                                        <option value="{{ $metodo->id }}">{{ $metodo->codigo }}</option>
                                    @endforeach
                                </select>
                            </div>    
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Venta Real</label>
                            <div class="col-md-6">
                                <input id="valorcobrado" type="decimal" class="form-control" name="valorcobrado" value="{{$servicio->valorcobrado}}" required>
                            </div>    
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Fecha Medicion</label>
                            <div class="col-md-6">
                                <input id="fechamedicion" type="date" class="form-control" name="fechamedicion" value="{{$servicio->fechamedicion}}" required>
                            </div>    
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Medido ?</label>
                            <div class="col-md-6">
                                <select id="medido" name="medido" class="form-control" value="{{ $servicio->medido }}">
                                    <option value="{{$servicio->medido}}">{{$servicio->medido}}</option>
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>                                        
                                </select>
                        </div>

                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Actualizar
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
