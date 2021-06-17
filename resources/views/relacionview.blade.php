@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-12 col-md-offset">
            <div class="panel panel-default">
                <div class="panel-heading"><b>Fuentes de la Empresa</b>
                
                <a href="{{ url('relacion/'.$empresa->id.'/'.'Fuentes a Asignar a las Empresas'.'/add') }}" class="btn btn-success btn-sm btn-flat"> <i class="fa fa-add">Agregar Fuente</i> </a>
                <a href="{{ url('/home') }}" class="btn btn-danger btn-sm btn-flat"> <i class="fa fa-add">Volver</i> </a>

                <div><b>Rut:</b> {{ $empresa->rut }}</div>
                <div><b>Nombre:</b> {{ $empresa->nombre }}</div>
                </div>
<div class="box-body">
<div class="table-responsive">
                @if(count($relaciones) > 0)
                                <table id="relacionvw" class="table table-bordered table-striped table-responsive" style="width:100%">
                                  <thead>
                                  <tr>
                                    <th>Registro</th>
                                    <th>Codigo</th>
                                    <th>Tipo</th>
                                    <th>Descripcion</th>
                                    <th>Acciones</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($relaciones as $relacion)
                               <tr>
                                    <td>{{ $relacion->registro }}</td>
                                    <td>{{ $relacion->codigo }}</td>
                                    <td>{{ $relacion->tipo }}</td>
                                    <td>{{ $relacion->descripcion }}</td>
                                    <td>

                                    <a href="{{ url('servicio/'.$empresa->id.'/'.$relacion->idfuente.'/'.$relacion->id.'/index') }}" class="btn btn-success btn-sm btn-flat"> <i class="fa fa-edit">Metodos</i> </a>
                                    <a href="{{ url('relacion/'.$relacion->id.'/'.$empresa->id.'/delete') }}" class="btn btn-danger btn-sm btn-flat"> <i class="fa fa-delete">Del </i> </a>
                                
                                    </td>
                                  </tr>
                                 
                                    @endforeach
                                
                                  </tfoot>
                                </table>
</div>
</div>
                             @else
                         <div class="alert alert-info">
                            <h4><i class="icon fa fa-question"></i> No existen Fuentes registradas para esta Empresa !</h4>
                            
                          </div>
                           @endif

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
