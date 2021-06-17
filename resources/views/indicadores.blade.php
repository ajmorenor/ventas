@extends('layouts.app')

@section('content')

<script src="{{ asset('/dist/Chart.min.js') }}"></script>
<script src="{{ asset('/dist/utils.js') }}"></script>

<style>
	canvas {
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
	}
</style>

<!-- Modal informativo relativo a capitales de trabajo -->
<div class="modal" tabindex="-1" role="dialog" id="openModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Proyeccion de Ventas</h5>
        <button type="button" class="close" onclick="javascript:CloseModal();" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>No se han definido proyecciones de ventas para los años de ejercicio. Dirigase al menu: Registros->Proyeccion Venta</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="javascript:CloseModal();">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- End modal informativo -->

<div class="row">
    <div class="col-md-12 col-md-offset">
        <div class="panel panel-default">
			<div class = "col-md-12 col-md-offset">
                <div class="panel-heading">
                           <div class="col-md-12">
                                <select id="tipo" name="tipo" class="form-control">
                                    <option value="">Año de Gestion</option>
                                    @foreach($annos as $a)
                                        <option value="{{ $a->anno }}">{{ $a->anno }}</option>
                                    @endforeach
                                </select>
                            </div>
                </div> <!-- -->
            </div> 
        </div> 
    </div>          
</div>
<div class="row">
    <div class="col-md-12 col-md-offset">
        <div class="panel panel-default">
			<div class = "col-md-12 col-md-offset">
                <div class="panel-heading">
                    <div> </div>
                </div> <!-- -->
                    <div class="container">
                    <h4><b><span style="color:blue">Indicadores De Gestion Por Metodos</span></b></h4>
                        <div class="column">
                            <div class="col-md-6 col-md-offset">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><b>Empresas Por Años</b></div>
                                        <div class="panel-body">
                                            <div id="container" style="width: 100%; heigth: 100%;">
					                            <canvas id="canvas"></canvas>
				                            </div>
				                        </div>				
                                    </div>				
                                </div>				
                            </div>	
                            <div class="col-md-6 col-md-offset">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><b>Empresas Vs Proyectado - Año <span style="color:blue">{{ $anno }}</span></b></div>
                                        <div class="panel-body">
                                            <div id="container" style="width: 100%; heigth: 100%;">
					                            <canvas id="canvas_area"></canvas>
				                            </div>
				                        </div>				
                                    </div>				
                                </div>				
                            </div>				
                        </div>	<!-- End column -->			
                    </div>         

<div class="panel panel-default">
    <div class="panel-heading"><b>Resumen de Gestion</b></div>
        <div class="panel-body">

<div class="container">
<h4><b>Valores Totales a la Fecha</b></h4>

<div class="row">
        <div class="col-xs-12 col-md-2">
            <div class="form-group two-fields">
                <label for="">Empresas</label>
                <div class="input-group">
                    <input name="remitosucursal" id="remitosucursal" type="text" style="text-align:center;" class="form-control" placeholder="Total Empresas" value="{{ $totalempresas }}" disabled>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-2">
            <div class="form-group two-fields">
                <label for="">Metodos</label>
                <div class="input-group">
                    <input name="remitosucursal" id="remitosucursal" type="text" style="text-align:center;" class="form-control" placeholder="Total Fuentes" value="{{ $totalfuentes}}" disabled>
                </div>
            </div>
        </div>              
    </div>
</div>

<p><a href="javascript:mostrar();"><h4><b>Desgloce de Metodos</b></h4></a></p>
<div class="container" id="flotante" style="display:none;">
<!-- <h4><b>Desgloce de Fuentes</b></h4> -->
    <div class="row">
    @foreach($fuentes as $a)
    <div class="abs-center">
        <div class="col-xs-12 col-md-3">
            <div class="form-group two-fields" style="text-align: center">
                <label for="">{{$a->codigo}}</label>
                <div class="input-group">
                    <input name="remitosucursal" id="remitosucursal" style="text-align: center" type="text" class="form-control" placeholder="Fuentes" value="{{$a->valor}}" disabled>
                </div>
            </div>
        </div>  
    </div>
    @endforeach            
    </div>
	<div id="close"><a href="javascript:cerrar();">Ocultar</a></div>
</div>
<div class="container">
<h4><b>Valores Mensuales Año <span style="color:blue">{{ $anno }}</span></b></h4>
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="input-nombre" class="col-sm-4 control-label"><h4><b>Leyenda</b></h4></label>
                <div class="col-sm-4">
                    <input name="remitonumero" id="remitonumero" type="text" style="text-align:center; background-color:blue; color:white;" class="form-control" value="PROYECTADO" disabled>
                </div>
                <div class="col-sm-4">
                    <input name="remitonumero" id="remitonumero" type="text" style="text-align:center; background-color:teal; color:white;" class="form-control" value="REAL" disabled>
                </div>
            </div>
        </div>  
    </div>
    <br>
    <div class="row">
        <div class="col-xs-12 col-md-2">
            <div class="form-group two-fields" style="text-align: center">
                <label for="">Enero</label>
                <div class="input-group">
                    <input name="remitosucursal" id="remitosucursal" type="text" style="text-align:center; background-color:blue; color:white;" class="form-control"  value="{{ $vproyectado[0] }}" disabled>
                    <input name="remitosucursal" id="remitosucursal" type="text" style="text-align:center; background-color:teal; color:white;" class="form-control"  value="{{ $vreal[0] }}" disabled>                
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-2">
            <div class="form-group two-fields" style="text-align: center">
                <label for="">Febrero</label>
                <div class="input-group">
                    <input name="remitosucursal" id="remitosucursal" type="text" style="text-align:center; background-color:blue; color:white;" class="form-control"  value="{{ $vproyectado[1] }}" disabled>
                    <input name="remitosucursal" id="remitosucursal" type="text" style="text-align:center; background-color:teal; color:white;" class="form-control"  value="{{ $vreal[1]}}" disabled>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-2">
            <div class="form-group two-fields" style="text-align: center">
                <label for="">Marzo</label>
                <div class="input-group">
                    <input name="remitosucursal" id="remitosucursal" type="text" style="text-align:center; background-color:blue; color:white;" class="form-control"  value="{{ $vproyectado[2] }}" disabled>
                    <input name="remitosucursal" id="remitosucursal" type="text" style="text-align:center; background-color:teal; color:white;" class="form-control"  value="{{ $vreal[2] }}" disabled>
                </div>
            </div>
        </div>                  
        <div class="col-xs-12 col-md-2">
            <div class="form-group two-fields" style="text-align: center">
                <label for="">Abril</label>
                <div class="input-group">
                    <input name="remitosucursal" id="remitosucursal" type="text" style="text-align:center; background-color:blue; color:white;" class="form-control"  value="{{ $vproyectado[3] }}" disabled>
                    <input name="remitosucursal" id="remitosucursal" type="text" style="text-align:center; background-color:teal; color:white;" class="form-control"  value="{{ $vreal[3] }}" disabled>
                </div>
            </div>
        </div>                  
        <div class="col-xs-12 col-md-2">
            <div class="form-group two-fields" style="text-align: center">
                <label for="">Mayo</label>
                <div class="input-group">
                    <input name="remitosucursal" id="remitosucursal" type="text" style="text-align:center; background-color:blue; color:white;" class="form-control"  value="{{ $vproyectado[4] }}" disabled>
                    <input name="remitosucursal" id="remitosucursal" type="text" style="text-align:center; background-color:teal; color:white;" class="form-control"  value="{{ $vreal[4] }}" disabled>
                </div>
            </div>
        </div>                  
        <div class="col-xs-12 col-md-2">
            <div class="form-group two-fields" style="text-align: center">
                <label for="">Junio</label>
                <div class="input-group">
                    <input name="remitosucursal" id="remitosucursal" type="text" style="text-align:center; background-color:blue; color:white;" class="form-control"  value="{{ $vproyectado[5] }}" disabled>
                    <input name="remitosucursal" id="remitosucursal" type="text" style="text-align:center; background-color:teal; color:white;" class="form-control"  value="{{ $vreal[5] }}" disabled>
                </div>
            </div>
        </div>                  
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-2">
            <div class="form-group two-fields" style="text-align: center">
                <label for="">Julio</label>
                <div class="input-group">
                    <input name="remitosucursal" id="remitosucursal" type="text" style="text-align:center; background-color:blue; color:white;" class="form-control"  value="{{ $vproyectado[6] }}" disabled>
                    <input name="remitosucursal" id="remitosucursal" type="text" style="text-align:center; background-color:teal; color:white;" class="form-control"  value="{{ $vreal[6] }}" disabled>                
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-2">
            <div class="form-group two-fields" style="text-align: center">
                <label for="">Agosto</label>
                <div class="input-group">
                    <input name="remitosucursal" id="remitosucursal" type="text" style="text-align:center; background-color:blue; color:white;" class="form-control"  value="{{ $vproyectado[7] }}" disabled>
                    <input name="remitosucursal" id="remitosucursal" type="text" style="text-align:center; background-color:teal; color:white;" class="form-control"  value="{{ $vreal[7] }}" disabled>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-2">
            <div class="form-group two-fields" style="text-align: center">
                <label for="">Septiembre</label>
                <div class="input-group">
                    <input name="remitosucursal" id="remitosucursal" type="text" style="text-align:center; background-color:blue; color:white;" class="form-control"  value="{{ $vproyectado[8] }}" disabled>
                    <input name="remitosucursal" id="remitosucursal" type="text" style="text-align:center; background-color:teal; color:white;" class="form-control"  value="{{ $vreal[8] }}" disabled>
                </div>
            </div>
        </div>                  
        <div class="col-xs-12 col-md-2">
            <div class="form-group two-fields" style="text-align: center">
                <label for="">Octubre</label>
                <div class="input-group">
                    <input name="remitosucursal" id="remitosucursal" type="text" style="text-align:center; background-color:blue; color:white;" class="form-control"  value="{{ $vproyectado[9] }}" disabled>
                    <input name="remitosucursal" id="remitosucursal" type="text" style="text-align:center; background-color:teal; color:white;" class="form-control"  value="{{ $vreal[9] }}" disabled>
                </div>
            </div>
        </div>                  
        <div class="col-xs-12 col-md-2">
            <div class="form-group two-fields" style="text-align: center">
                <label for="">Noviembre</label>
                <div class="input-group">
                    <input name="remitosucursal" id="remitosucursal" type="text" style="text-align:center; background-color:blue; color:white;" class="form-control"  value="{{ $vproyectado[10] }}" disabled>
                    <input name="remitosucursal" id="remitosucursal" type="text" style="text-align:center; background-color:teal; color:white;" class="form-control"  value="{{ $vreal[10] }}" disabled>
                </div>
            </div>
        </div>                  
        <div class="col-xs-12 col-md-2">
            <div class="form-group two-fields" style="text-align: center">
                <label for="">Diciembre</label>
                <div class="input-group">
                    <input name="remitosucursal" id="remitosucursal" type="text" style="text-align:center; background-color:blue; color:white;" class="form-control"  value="{{ $vproyectado[11] }}" disabled>
                    <input name="remitosucursal" id="remitosucursal" type="text" style="text-align:center; background-color:teal; color:white;" class="form-control"  value="{{ $vreal[11] }}" disabled>
                </div>
            </div>
        </div>                  
    </div>
</div>
</div>                  
</div>
</div>

            </div> <!-- End panel -->
		</div>
	</div>
				<div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
</div>    

<script>
		var annob = 0;
		var dato = 'bar';
		var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
		var color = Chart.helpers.color;
		var barChartData = {
			labels: ['2015', '2016', '2017', '2018', '2019', '2020', '2021', '2022', '2023', '2024', '2025', '2026'],
			datasets: [{
				label: 'Empresas',
				//backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
				borderColor: window.chartColors.yellow,
				borderWidth: 2,
				data: [            
                    {{ $empresas[0] }},        
                    {{ $empresas[1] }},                            
                    {{ $empresas[2] }},                            
                    {{ $empresas[3] }},                            
                    {{ $empresas[4] }},
                    {{ $empresas[5] }},
                    {{ $empresas[6] }},
                    {{ $empresas[7] }},
                    {{ $empresas[8] }},
                    {{ $empresas[9] }},
                    {{ $empresas[10] }},
                    {{ $empresas[11] }},
				],
                backgroundColor: 'teal', //['#42a5f5', 'silver', 'green','blue','violet','teal', 'yellow', 'lime','olive','purple','salmon', 'aqua'],
			},

			]

		};

		var barChartDataarea = {
			labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
			datasets: [{
				label: 'Empresas',
				//backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
				borderColor: window.chartColors.yellow,
				borderWidth: 2,
				data: [
                    {{ $vreal[0] }},
                    {{ $vreal[1] }},
                    {{ $vreal[2] }},
                    {{ $vreal[3] }},
                    {{ $vreal[4] }},
                    {{ $vreal[5] }},
                    {{ $vreal[6] }},
                    {{ $vreal[7] }},
                    {{ $vreal[8] }},
                    {{ $vreal[9] }},
                    {{ $vreal[10] }},
                    {{ $vreal[11] }}
				],
                backgroundColor: 'teal', //['#42a5f5', 'silver', 'green','blue','violet','teal', 'yellow', 'lime','olive','purple','salmon', 'aqua'],
			},

			{
				label: 'Proyectado',
				//backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
				borderColor: window.chartColors.yellow,
				borderWidth: 2,
				data: [
                    {{ $vproyectado[0] }},
                    {{ $vproyectado[1] }},
                    {{ $vproyectado[2] }},
                    {{ $vproyectado[3] }},
                    {{ $vproyectado[4] }},
                    {{ $vproyectado[5] }},
                    {{ $vproyectado[6] }},
                    {{ $vproyectado[7] }},
                    {{ $vproyectado[8] }},
                    {{ $vproyectado[9] }},
                    {{ $vproyectado[10] }},
                    {{ $vproyectado[11] }}
				],
                backgroundColor: 'blue', //['aqua', 'salmon', 'purple', 'olive', 'lime', 'black', 'teal', 'violet', 'blue', 'green', 'silver', '#42a5f5'],
			}			
			
			]

		};
        function mostrar() {
            div = document.getElementById('flotante');
            div.style.display = '';
        }

        function cerrar() {
            div = document.getElementById('flotante');
            div.style.display = 'none';
        }
		
        function showModal() {
            document.getElementById('openModal').style.display = 'block';
        };

        function CloseModal() {
            document.getElementById('openModal').style.display = 'none';
        };

		window.onload = function() {
            var proyeccion = <?php echo $proyeccion ?>;

            if (proyeccion == 0)
                showModal();

			// Se coloca en el onload para que reconozca el evento: addEventListener
			var mb = document.getElementById("tipo");
    		mb.addEventListener("change", handler);

		    var ctx3 = document.getElementById('canvas').getContext('2d');
		    var ctx4 = document.getElementById('canvas_area').getContext('2d');

            // ctx4
            //********************************************************************************************** */
			Chart.defaults.global.tooltips.enabled = true;

			window.myBar = new Chart(ctx4, {
				type: 'bar', //'', pie				
				data: barChartDataarea,

			options:{
        		responsive: true,
            	layout: {
                	padding: {
                	left: 0,
                	right: 0,
                	top: 15,
                	bottom: 0
                }
				},
            	animation: {
            duration : 1,
                onComplete : function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;
        
                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle,
                Chart.defaults.global.defaultFontFamily);
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';
/*        
                    this.data.datasets.forEach(function(dataset, i) {
                    var meta = chartInstance.controller.getDatasetMeta(i);
                        meta.data.forEach(function(bar, index) {
                            if (dataset.data[index] > 0) {
                            var data = dataset.data[index];
                            ctx.fillText(data, bar._model.x, bar._model.y);
                            }
                         });
                     });
*/                     
                }
            }
			}

			}); // ctx4
            //********************************************************************************************** */

            // ctx3
            //********************************************************************************************** */
			Chart.defaults.global.tooltips.enabled = true;

			window.myBar = new Chart(ctx3, {
				type: 'bar', //'', pie				
				data: barChartData,

			options:{
        		responsive: true,
            	layout: {
                	padding: {
                	left: 0,
                	right: 0,
                	top: 15,
                	bottom: 0
                }
				},
            	animation: {
            duration : 1,
                onComplete : function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;
        
                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle,
                Chart.defaults.global.defaultFontFamily);
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';
        
                    this.data.datasets.forEach(function(dataset, i) {
                    var meta = chartInstance.controller.getDatasetMeta(i);
                        meta.data.forEach(function(bar, index) {
                            if (dataset.data[index] > 0) {
                            var data = dataset.data[index];
                            ctx.fillText(data, bar._model.x, bar._model.y);
                            }
                         });
                     });
                     
                }
            }
			}

			}); // ctx3
            //********************************************************************************************** */

		};

function handler(){
	var tiposelec = $('#tipo').val();

	//window.myBar.destroy();

    if (tiposelec != ''){
        var url = '{!! route('home.anno', ['anno' => 'temp']) !!}';
	    url = url.replace('temp', tiposelec);
	
        location.href = url;
    }
}
</script>
@endsection