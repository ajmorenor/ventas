@extends('layouts.app')

@section('content')

<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
<script src="//code.jquery.com/jquery-2.1.1.js"></script>
<script src="../../../../dist/sweetalert.js"></script>
<link rel="stylesheet" href="../../../../dist/sweetalert.css">
<!--<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>-->
<script>
function confirmDelete(e,idservicio) {
  
  var idempresa = e.getAttribute('data-id');

  swal({
          title: "Esta seguro de eliminar ?",
          text: "Se eliminara el servicio y los elementos asociados a el",
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
                  url : '../../servicio.delete', 
                  data: {
                    idservicio: idservicio,
                    idempresa: idempresa
                  },
                  success: function(response) {
                    //var direccion = "../../servicio/"+idempresa+"/index"
                    swal("Borrar", "Servicio borrado correctamente !", "success");
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
                <div class="panel-heading"><b>Servicios Asignados a las Fuentes de la Empresa</b>
                
                <a href="{{ url('servicio/'.$empresa->id.'/'.'Metodos agregados a las fuentes'.'/add') }}" class="btn btn-success btn-sm btn-flat"> <i class="fa fa-add">Agregar Servicio</i> </a>
                <a href="{{ url('/home') }}" class="btn btn-danger btn-sm btn-flat"> <i class="fa fa-add">Volver</i> </a>

                <div><b>Rut:</b> {{ $empresa->rut }}</div>
                <div><b>Nombre:</b> {{ $empresa->nombre }}</div>
                </div>
<div class="box-body">
<div class="table-responsive">
                @if(count($servicios) > 0)
                                <table id="serviciovw" class="table table-bordered table-striped table-responsive" style="width:100%">
                                  <thead>
                                  <tr>   
                                    <th>Registro</th> 
                                    <th>Fuente</th>
                                    <th>Metodo</th>
                                    <th>Venta Real</th>
                                    <th>Fecha</th>
                                    <th>Medido ?</th>
                                    <th>Enviado Recordatorio ?</th>
                                    <th>Acciones</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($servicios as $servicio)
                               <tr>
                                    <td>{{ $servicio->registro }}</td>
                                    <td>{{ $servicio->tipo }}</td>
                                    <td>{{ $servicio->codigo }}</td>
                                    <td>{{ $servicio->valorcobrado }}</td>
                                    <td>{{ $servicio->fechamedicion }}</td>
                                    <td style="text-align:center;">{{ $servicio->medido }}</td>
                                    @if(($servicio->primercorreo == 'Si') || ($servicio->segundocorreo == 'Si') || ($servicio->tercercorreo == 'Si'))
                                      <td style="color:white;background-color:#83CFD3;text-align:center;"><b>Si</b></td>
                                    @else
                                      <td style="text-align:center;">No</td>
                                    @endif

                                    <td>
                                    <a href="{{ url('servicio/'.$servicio->id.'/agregar') }}" class="btn btn-success btn-sm btn-flat"> <i class="fa fa-edit">Servicio</i> </a>
                                    <a href="{{ url('servicio/'.$servicio->id.'/edit') }}" class="btn btn-success btn-sm btn-flat"> <i class="fa fa-edit">Editar/Ver</i> </a>
                                    <a href="href=javascript:;" class="btn btn-danger btn-sm btn-flat" data-id="{{ $empresa->id }}" onclick="confirmDelete(this, '{{ $servicio->id }}');return false;"> <i class="fa fa-add">Borrar</i> </a>

                                    </td>
                                  </tr>
                                 
                                    @endforeach
                                
                                  </tfoot>
                                </table>
</div>
</div>
                             @else
                         <div class="alert alert-info">
                            <h4><i class="icon fa fa-question"></i> No Existen Servicios Registrados para la Empresa Indicada !</h4>
                            
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
