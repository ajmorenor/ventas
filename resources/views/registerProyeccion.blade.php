@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><b>Registrar / Actualizar Proyeccion de Venta</b></div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('proyeccion/save') }}">
                        {{ csrf_field() }}

                        @if ($capitales[0] > 0)
                            <input id="id" type="hidden" class="form-control" name="id" value={{ $capitales[0] }}>
                        @endif

                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#home">Proyeccion</a></li>
                            </ul>

                        <div class="tab-content">
                            <div id="home" class="tab-pane fade in active">
                            </br>

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Año <span style="color:red">(*)</span></label>

                            <div class="col-md-6">
                                @if ($capitales[1] > 0)
                                    <input id="anno" type="number" class="form-control" name="anno" value="{{ $capitales[1] }}" disabled required>
                                @else

                                    <select id="anno" name="anno" class="form-control" required>
                                        <option></option>
                                        @foreach($annos as $a)
                                            <option value="{{ $a->anno }}">{{ $a->anno }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Enero <span style="color:red">(*)</span></label>

                            <div class="col-md-6">
                                @if ($capitales[2] > 0)
                                    <input id="enero" type="number" class="form-control" name="enero" value="{{ $capitales[2] }}" required>
                                @else
                                    <input id="enero" type="number" class="form-control" name="enero" value=""  required>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Febrero <span style="color:red">(*)</span></label>

                            <div class="col-md-6">
                                @if ($capitales[3] > 0)
                                    <input id="febrero" type="number" class="form-control" name="febrero" value="{{ $capitales[3] }}" required>
                                @else
                                    <input id="febrero" type="number" class="form-control" name="febrero" value=""  required>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Marzo <span style="color:red">(*)</span></label>

                            <div class="col-md-6">
                                @if ($capitales[4] > 0)
                                    <input id="marzo" type="number" class="form-control" name="marzo" value="{{ $capitales[4] }}" required>
                                @else
                                    <input id="marzo" type="number" class="form-control" name="marzo" value=""  required>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Abril <span style="color:red">(*)</span></label>

                            <div class="col-md-6">
                                @if ($capitales[5] > 0)
                                    <input id="abril" type="number" class="form-control" name="abril" value="{{ $capitales[5] }}" required>
                                @else
                                    <input id="abril" type="number" class="form-control" name="abril" value=""  required>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Mayo <span style="color:red">(*)</span></label>

                            <div class="col-md-6">
                                @if ($capitales[6] > 0)
                                    <input id="mayo" type="number" class="form-control" name="mayo" value="{{ $capitales[6] }}" required>
                                @else
                                    <input id="mayo" type="number" class="form-control" name="mayo" value=""  required>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Junio <span style="color:red">(*)</span></label>

                            <div class="col-md-6">
                                @if ($capitales[7] > 0)
                                    <input id="junio" type="number" class="form-control" name="junio" value="{{ $capitales[7] }}" required>
                                @else
                                    <input id="junio" type="number" class="form-control" name="junio" value=""  required>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Julio <span style="color:red">(*)</span></label>

                            <div class="col-md-6">
                                @if ($capitales[8] > 0)
                                    <input id="julio" type="number" class="form-control" name="julio" value="{{ $capitales[8] }}" required>
                                @else
                                    <input id="julio" type="number" class="form-control" name="julio" value=""  required>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Agosto <span style="color:red">(*)</span></label>

                            <div class="col-md-6">
                                @if ($capitales[9] > 0)
                                    <input id="agosto" type="number" class="form-control" name="agosto" value="{{ $capitales[9] }}" required>
                                @else
                                    <input id="agosto" type="number" class="form-control" name="agosto" value=""  required>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Septiembre <span style="color:red">(*)</span></label>

                            <div class="col-md-6">
                                @if ($capitales[10] > 0)
                                    <input id="septiembre" type="number" class="form-control" name="septiembre" value="{{ $capitales[10] }}" required>
                                @else
                                    <input id="septiembre" type="number" class="form-control" name="septiembre" value=""  required>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Octubre <span style="color:red">(*)</span></label>

                            <div class="col-md-6">
                                @if ($capitales[11] > 0)
                                    <input id="octubre" type="number" class="form-control" name="octubre" value="{{ $capitales[11] }}" required>
                                @else
                                    <input id="octubre" type="number" class="form-control" name="octubre" value=""  required>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Noviembre <span style="color:red">(*)</span></label>

                            <div class="col-md-6">
                                @if ($capitales[12] > 0)
                                    <input id="noviembre" type="number" class="form-control" name="noviembre" value="{{ $capitales[12] }}" required>
                                @else
                                    <input id="noviembre" type="number" class="form-control" name="noviembre" value=""  required>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Diciembre <span style="color:red">(*)</span></label>

                            <div class="col-md-6">
                                @if ($capitales[13] > 0)
                                    <input id="diciembre" type="number" class="form-control" name="diciembre" value="{{ $capitales[13] }}" required>
                                @else
                                    <input id="diciembre" type="number" class="form-control" name="diciembre" value=""  required>
                                @endif
                            </div>
                        </div>


                            </div>

                            </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Registrar / Actualizar
                                </button>
                                <a href="{{ url('/proyeccion') }}" class="btn btn-danger"> <i class="fa fa-add">Volver</i> </a>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
