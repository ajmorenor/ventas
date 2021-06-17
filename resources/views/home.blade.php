@extends('layouts.app')

@section('content')

<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
<script src="//code.jquery.com/jquery-2.1.1.js"></script>
<script src="../../dist/sweetalert.js"></script>
<link rel="stylesheet" href="../../dist/sweetalert.css">
<!--<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>-->

<script>
function confirmDelete(idempresa) {

  swal({
          title: "Esta seguro de eliminar ?",
          text: "Se eliminara la empresa y los servicios asociados a ella !",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: 'btn-danger',
          confirmButtonText: 'Si, eliminar !',
          cancelButtonText: "No, cancelar !",
          closeOnConfirm: false,
          closeOnCancel: false
        },
        function(isConfirm){
          if (isConfirm){
              $.ajax({ 
                  type: 'GET',
                  //dataType: "json",
                  url : 'empresa.delete', 
                  data: {
                    idempresa: idempresa
                  },
                  success: function(response) {
                    swal("Borrar", "Empresa borrada correctamente !", "success");
                    location.reload(true);
                  },
                  error: function(XMLHttpRequest, textStatus, errorThrown) {
                      if (textStatus == 'parsererror') {
                        textStatus = 'Technical error: Unexpected response returned by server. Sending stopped.';
                      }
                      swal("Error", "Ocurrio un error al eliminar !", "error");
                  }
              });

          } else {
              swal("Cancelado", "Ha cancelado la eliminacion", "error");
            }
        });
}
</script>


    <div class="row">
        <div class="col-md-12 col-md-offset">
            <div class="panel panel-default">
                <div class="panel-heading"><b>Gestion de Empresas</b>
                
                <a href="{{ url('empresa/add') }}" class="btn btn-success btn-sm btn-flat"> <i class="fa fa-add">Agregar Empresa</i> </a>

                </div>

<div class="box-body">
<div class="table-responsive">
                @if(count($empresas) > 0)
                                <table id="proceso" class="table table-bordered table-striped table-responsive" style="width:100%">
                                  <thead>
                                  <tr>
                                    <th>Rut</th>
                                    <th>Nombre</th>
                                    <th>Contacto</th>
                                    <th>Email</th>
                                    <th>Telefono</th>
                                    <th>Acciones</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($empresas as $empresa)
                               <tr>
                                    <td>{{ $empresa->rut }}</td>
                                    <td>{{ $empresa->nombre }}</td>
                                    <td>{{ $empresa->contacto }}</td> 
                                    <td>{{ $empresa->email }}</td>
                                    <td>{{ $empresa->celular }}</td>
                                    <td>

                                    <a href="{{ url('servicio/'.$empresa->id.'/index') }}" class="btn btn-success btn-sm btn-flat"> <i class="fa fa-edit">Fuentes</i> </a>
                                    <a href="{{ url('empresa/'.$empresa->id.'/edit') }}" class="btn btn-success btn-sm btn-flat"> <i class="fa fa-edit">Editar</i> </a>
                                    <a href="href=javascript:;" class="btn btn-danger btn-sm btn-flat" onclick="confirmDelete('{{ $empresa->id }}');return false;"> <i class="fa fa-add">Borrar</i> </a>
                                
                                    </td>
                                  </tr>
                                 
                                    @endforeach
                                
                                  </tfoot>
                                </table>
</div>
</div>
                             @else
                         <div class="alert alert-info">
                            <h4><i class="icon fa fa-question"></i> No existen Empresas registradas !</h4>
                            
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