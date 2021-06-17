@extends('layouts.app')

@section('content')

<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
<script src="//code.jquery.com/jquery-2.1.1.js"></script>
<script src="{{ asset('dist/sweetalert.js') }}"></script>
<link rel="stylesheet" href="{{ asset('dist/sweetalert.css') }}">
<!--<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>-->
<script>
function confirmDelete(idproyeccion) {
  
  swal({
          title: "Esta seguro de eliminar ?",
          text: "Se eliminara la proyeccion indicada",
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
                  url : 'proyeccion.delete', 
                  data: {
                    idproyeccion: idproyeccion
                  },
                  success: function(response) {
                    //var direccion = "../../servicio/"+idempresa+"/index"
                    swal("Borrar", "Proyeccion borrada correctamente !", "success");
                    location.reload(true);
                    //window.location = direccion;
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
                <div class="panel-heading"><b>Proyecciones Anuales</b>
                
                <a href="{{ url('proyeccion/-1/agregar') }}" class="btn btn-success btn-sm btn-flat"> <i class="fa fa-add">Agregar Proyeccion</i> </a>
                <a href="{{ url('/home') }}" class="btn btn-danger btn-sm btn-flat"> <i class="fa fa-add">Volver</i> </a>

                </div>
<div class="box-body">
<div class="table-responsive">
                @if(count($proyecciones) > 0)
                                <table id="serviciovw" class="table table-bordered table-striped table-responsive" style="width:100%">
                                  <thead>
                                  <tr>   
                                    <th>Año</th> 
                                    <th>Enero</th>
                                    <th>Febrero</th>
                                    <th>Marzo</th>
                                    <th>Abril</th>
                                    <th>Mayo</th>
                                    <th>Junio</th>
                                    <th>Julio</th>
                                    <th>Agosto</th>
                                    <th>Septiembre</th>
                                    <th>Octubre</th>
                                    <th>Noviembre</th>
                                    <th>Diciembre</th>

                                    <th>Acciones</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($proyecciones as $p)
                               <tr>
                                    <td>{{ $p->anno }}</td>
                                    <td>{{ $p->enero }}</td>
                                    <td>{{ $p->febrero }}</td>
                                    <td>{{ $p->marzo }}</td>
                                    <td>{{ $p->abril }}</td>
                                    <td>{{ $p->mayo }}</td>
                                    <td>{{ $p->junio }}</td>
                                    <td>{{ $p->julio }}</td>
                                    <td>{{ $p->agosto }}</td>
                                    <td>{{ $p->septiembre }}</td>
                                    <td>{{ $p->octubre }}</td>
                                    <td>{{ $p->noviembre }}</td>
                                    <td>{{ $p->diciembre }}</td>

                                    <td>
                                    <a href="{{ url('proyeccion/'.$p->id.'/agregar') }}" class="btn btn-success btn-sm btn-flat"> <i class="fa fa-edit">Editar/Ver</i> </a>
                                    <a href="href=javascript:;" class="btn btn-danger btn-sm btn-flat" onclick="confirmDelete('{{ $p->id }}');return false;"> <i class="fa fa-add">Borrar</i> </a>

                                    </td>
                                  </tr>
                                 
                                    @endforeach
                                
                                  </tfoot>
                                </table>
</div>
</div>
                             @else
                         <div class="alert alert-info">
                            <h4><i class="icon fa fa-question"></i> No Existen Proyecciones Registradas !</h4>
                            
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
