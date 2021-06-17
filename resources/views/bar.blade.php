@extends('layouts.app')

@section('content')

<script type="text/javascript">
function executeProcess(offset, batch = false) {
    if (batch == false) {
        batch = parseInt($('#batch').val());
    } else {
        batch = parseInt(batch);
    }
    
    if (offset == 0) {
        $('#start_form').hide();
        $('#sending').show();
        $('#sended').text(0);
        $('#total').text($('#total_comments').val());
        
        //reset progress bar
        $('.progress-bar').css('width', '0%');
        $('.progress-bar').text('0%');
        $('.progress-bar').attr('data-progress', '0');
    }

    $.ajax({ 
        type: 'POST',
        //dataType: "json",
        url : '../procesar', 
        /*data: {
            id_process: 1,
            offset: offset,
            batch: batch
        },*/
        success: function(response) {
            $('.progress-bar').show(6000, function() { $('.progress-bar').css('width', 100 +'%'); });

            $('.progress-bar').text(100+'%');
            $('.progress-bar').attr('data-progress', 100);
            
            $('.end-process').show();
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            if (textStatus == 'parsererror') {
                textStatus = 'Technical error: Unexpected response returned by server. Sending stopped.';
            }
            alert('Error al procesar la transaccion !');//alert(textStatus); 
       }
    });
}
</script>
@if (!(Auth::guest()))
    <br>
    <br>
<div class="container">
    <h2><span style="color:black">Envio de Correos Recordatorios de Servicios</span></h2>
    <h3><span style="color:black">Servicios a Evaluar: <?php echo $servicios; ?></span></h3>
    
    
    <div class="row">
        <div id="content" class="col-lg-12">
<form id="start_form" action="#" method="post">
    <input type="hidden" id="total_comments" name="total_comments" value="<?php echo $servicios; ?>" />
    <div class="form-group">
        <a href="#" class="btn btn-primary" onclick="executeProcess(0);return false;">
            <i class="fa fa-eye"></i> Procesar y Salir
        </a>
    </div>
</form>
        </div>
<div id="sending" class="col-lg-12" style="display:none;">
    <h3>Procesando...</h3>
    <div class="progress">
        <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" data-progress="0" style="width: 0%;">
            0%
        </div>
    </div>
    <br>
    <div class="end-process" style="display:none;">
        <div class="alert alert-success">El proceso ha sido completado. Feliz dia.</div>
    </div>    

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
@endif
@endsection
