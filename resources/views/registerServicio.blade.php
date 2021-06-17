@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><b>Registrar Metodo de las Fuentes a Empresa</b>
                <div><b>Rut:</b> {{ $empresa->rut }}</div>
                <div><b>Nombre:</b> {{ $empresa->nombre }}</div>
</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('servicio/save') }}">
                        {{ csrf_field() }}
                        <input id="idempresa" type="hidden" class="form-control" name="idempresa" value={{ $empresa->id }}>

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Numero Registro</label>
                            <div class="col-md-6">
                                <input id="registro" type="text" class="form-control" name="registro" value="" required autofocus>
                            </div>    
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Fuente</label>
                            <div class="col-md-6">
                                <select id="idfuente" name="idfuente" class="form-control" required>
                                    <option></option>
                                    @foreach($fuentes as $fuente)
                                        <option value="{{ $fuente->id }}">{{ $fuente->tipo }}</option>
                                    @endforeach
                                </select>
                            </div>    
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Metodo</label>
                            <div class="col-md-6">
                                <select id="idmetodo" name="idmetodo" class="form-control" required>
                                    <option></option>
                                    @foreach($metodos as $metodo)
                                        <option value="{{ $metodo->id }}">{{ $metodo->codigo }}</option>
                                    @endforeach
                                </select>
                            </div>    
                        </div>
                        
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Fecha Medicion</label>
                            <div class="col-md-6">
                                <input id="fechamedicion" type="date" class="form-control" name="fechamedicion" value="" required>
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
                                <select id="medido" name="medido" class="form-control" required>
                                    <option></option>
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>                                        
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Observaciones</label>

                            <div class="col-md-6">
                                <textarea id="observaciones" name="observaciones" rows="2" cols="40"></textarea>
                        </div>

                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Registrar
                                </button>
                                <a href="{{ url('servicio/'.$empresa->id.'/index') }}" class="btn btn-danger"> <i class="fa fa-add">Volver</i> </a>
                            </div>
                        </div>
                    </form>
                    <span style="color:red">{{ $mensaje }}</span>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
