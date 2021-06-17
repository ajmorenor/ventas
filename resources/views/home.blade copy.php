@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Lista de Contactos
                
                <a href="{{ url('contact/add') }}" class="btn btn-success btn-sm btn-flat"> <i class="fa fa-add">Add Contact</i> </a>

                </div>


                @if(count($contacts) > 0)
                                <table id="contactstable" class="table table-bordered table-striped table-responsive" style="width:100%">
                                  <thead>
                                  <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>email</th>
                                    <th>Number</th>
                                    <th>Acciones</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($contacts as $contact)
                               <tr>
                                    <td>{{ $contact->firstname }}</td>
                                    <td>{{ $contact->lastname }}</td>
                                    <td>{{ $contact->email }}</td>
                                    <td>{{ $contact->contactnumber }}</td>                                   
                                    <td>
                                
                                    <a href="{{ url('contact/'.$contact->id.'/edit') }}" class="btn btn-success btn-sm btn-flat"> <i class="fa fa-edit">Edit</i> </a>
                                    <a href="{{ url('contact/'.$contact->id.'/delete') }}" class="btn btn-danger btn-sm btn-flat"> <i class="fa fa-delete">Delete</i> </a>
                                
                                    </td>
                                  </tr>
                                 
                                    @endforeach
                                
                                  </tfoot>
                                </table>

                             @else
                         <div class="alert alert-info">
                            <h4><i class="icon fa fa-question"></i> Unregistered Contacts !</h4>
                            
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
</div>

@endsection