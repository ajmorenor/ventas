
    <div class="row">
        <div class="col-md-12 col-md-offset">
            <div class="panel panel-default">
<div class="box-body">
<div class="table-responsive">
                @if(count($servicios) > 0)
                                <table id="serviciovw" class="table table-bordered table-striped table-responsive" style="width:100%">
                                  <thead>
                                  <tr>                                       
                                    <th>Rut</th> 
                                    <th>Empresa</th> 
                                    <th>Registro</th> 
                                    <th>Fuente</th>
                                    <th>Metodo</th>
                                    <th>Monto</th>
                                    <th>Fecha</th>
                                    <th>Medido ?</th>
                                    <th>Enviado Recordatorio ?</th>
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
                                    <td style="text-align:center;">{{ $servicio->medido }}</td>
                                    @if(($servicio->primercorreo == 'Si') || ($servicio->segundocorreo == 'Si') || ($servicio->tercercorreo == 'Si'))
                                      <td style="color:white;background-color:#83CFD3;text-align:center;"><b>Si</b></td>
                                    @else
                                      <td style="text-align:center;">No</td>
                                    @endif

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

            </div>
        </div>
    </div>
