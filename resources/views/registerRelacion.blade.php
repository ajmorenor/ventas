@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><b>Registrar Fuente a Empresa</b>
                <div><b> Rut:</b> {{ $empresa->rut }}, <b>Nombre:</b> {{ $empresa->nombre }}</div>
</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('relacion/save') }}">
                        {{ csrf_field() }}
                        <input id="idempresa" type="hidden" class="form-control" name="idempresa" value={{ $empresa->id }} required>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Fuente</label>
                            <div class="col-md-6">
                                <select id="idfuente" name="idfuente" class="form-control" required>
                                    <option></option>
                                    @foreach($fuentes as $fuente)
                                        <option value="{{ $fuente->id }}">{{ $fuente->codigo }} - {{ $fuente->tipo }}</option>
                                    @endforeach
                                </select>
                        </div>

                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Registrar
                                </button>
                                <a href="{{ url('relacion/'.$empresa->id.'/index') }}" class="btn btn-danger"> <i class="fa fa-add">Volver</i> </a>
                            </div>
                        </div>
                    </form>
                </div>
                <span style="color:red">{{ $mensaje }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
