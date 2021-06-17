@extends('layouts.app')

@section('content')

<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
<script src="//code.jquery.com/jquery-2.1.1.js"></script>
<script src="../../dist/sweetalert.js"></script>
<link rel="stylesheet" href="../../dist/sweetalert.css">

<script>
function confirmDelete(idmetodo) {
  
  swal({
          title: "Esta seguro de eliminar ?",
          text: "Se eliminara el metodo y todos los servicios asociados !",
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
                  url : 'metodo.delete', 
                  data: {
                    idmetodo: idmetodo
                  },
                  success: function(response) {
                    swal("Borrar", "Metodo borrado correctamente !", "success");
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
                <div class="panel-heading"><b>Metodos</b>
                
                <a href="{{ url('metodo/add') }}" class="btn btn-success btn-sm btn-flat"> <i class="fa fa-add">Agregar Metodo</i> </a>
                <a href="{{ url('/indicadores') }}" class="btn btn-danger btn-sm btn-flat"> <i class="fa fa-add">Volver</i> </a>

                </div>

<div class="box-body">
<div class="table-responsive">
                @if(count($metodos) > 0)
                                <table id="metodosvw" class="table table-bordered table-striped table-responsive" style="width:100%">
                                  <thead>
                                  <tr>
                                    <th>Codigo</th>
                                    <th>nombre</th>
                                    <th>Descripcion</th>
                                    <th>Acciones</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($metodos as $metodo)
                               <tr>
                                    <td>{{ $metodo->codigo }}</td>
                                    <td>{{ $metodo->nombre }}</td>
                                    <td>{{ $metodo->descripcion }}</td>
                                    <td>
                                    <a href="{{ url('metodo/'.$metodo->id.'/edit') }}" class="btn btn-success btn-sm btn-flat"> <i class="fa fa-edit">Editar</i> </a>
                                    <a href="href=javascript:;" class="btn btn-danger btn-sm btn-flat" onclick="confirmDelete('{{ $metodo->id }}');return false;"> <i class="fa fa-add">Borrar</i> </a>

                                    </td>
                                  </tr>
                                 
                                    @endforeach
                                
                                  </tfoot>
                                </table>
</div>
</div>
                             @else
                         <div class="alert alert-info">
                            <h4><i class="icon fa fa-question"></i> No existen Metodos registradas !</h4>
                            
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
