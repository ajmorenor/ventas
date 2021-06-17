@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-12 col-md-offset">
            <div class="panel panel-default">
                <div class="panel-heading"><b>Metodos Asignados a las Fuentes de las Empresas</b>
                <a href="{{ url('busqueda/servicio') }}" class="btn btn-success btn-sm btn-flat"> <i class="fa fa-add">Busqueda</i> </a>
                <a href="{{ url('servicio/todos') }}" class="btn btn-success btn-sm btn-flat"> <i class="fa fa-add">Mostrar Todos</i> </a>                
                <a href="{{ url('../verdes') }}" class="btn btn-success btn-sm btn-flat"> <i class="fa fa-edit">Exportar Excel</i> </a>
                
                </div>

<div class="box-body">
<div class="table-responsive">
                @if(count($servicios) > 0)
                                <table id="allservices" class="table table-bordered table-striped table-responsive" style="width:100%">
                                  <thead>
                                  <tr>            
                                    <th>Rut</th>
                                    <th>Empresa</th>
                                    <th>Registro</th>
                                    <th>Fuente</th>    
                                    <th>Metodo</th>
                                    <th>Monto</th>
                                    <th>Fecha</th>
                                    <th>Medido</th>
                                    <th>Correo1</th>
                                    <th>Correo2</th>
                                    <th>Correo3</th>

                                  </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($servicios as $servicio)
                               <tr>
                                    <td>{{ $servicio->rut }}</td>
                                    <td>{{ $servicio->nombrempresa }}</td>
                                    <td>{{ $servicio->registro }}</td>
                                    <td>{{ $servicio->tipo }}</td>
                                    <td>{{ $servicio->codigom }}</td>
                                    <td>{{ $servicio->valorcobrado }}</td>
                                    <td>{{ $servicio->fechamedicion }}</td>
                                    <td>{{ $servicio->medido }}</td>
                                    <td>{{ $servicio->primercorreo }}</td>
                                    <td>{{ $servicio->segundocorreo }}</td>
                                    <td>{{ $servicio->tercercorreo }}</td>

                                  </tr>
                                 
                                    @endforeach
                                
                                  </tfoot>
                                </table>
</div>
</div>
                             @else
                         <div class="alert alert-info">
                            <h4><i class="icon fa fa-question"></i> No existen Metodos registrados para las Fuentes de las empresas !</h4>
                            
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
