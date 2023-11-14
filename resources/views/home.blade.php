@extends('layouts.menu')

@section('title','Home')

@section('contenido')

@can('crear user')
<button type="button" class="btn btn-outline-primary add" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
  Add User <i class="bi bi-clipboard-plus-fill"></i>
</button>
@endcan

@can('crear tipoid')
<button type="button" class="btn btn-outline-primary tipo" data-bs-toggle="modal" data-bs-target="#staticBackdrop2">
   CRUD Tipo Documento
</button>
@endcan

<table class="table principal">
  <thead>
    <tr class="table-primary">
      <th scope="col">#</th>
      <th scope="col">ID</th>
      <th scope="col">Nombre</th>
      <th scope="col">Apellido</th>
      @can('editar user')<th scope="col">Editar</th>@endcan
      @can('eliminar user')<th scope="col">Eliminar</th>@endcan
    </tr>
  </thead>
  <tbody>
    @foreach ($users as $user)
    <tr>
      <th scope="row">{{ $loop->iteration }}</th>
      <td>{{$user->id}}</td>
      <td>{{$user->name}}</td>
      <td>{{$user->lastname}}</td>
     @can('editar user') <td><a class="btn btn-warning"   href="{{ route('home.edit', ['home' => $user->id]) }}" role="button"><i class="bi bi-pencil-square"></i></a></td>@endcan
      @can('eliminar user')<td><form  action="{{ route('home.destroy', ['home' => $user->id]) }}" method="post" id="form4">
        @method("DELETE") @csrf
        <input type="hidden" name="form" value="form4">
         <button class="btn btn-danger" type="submit"><i class="bi bi-clipboard2-x"></i></button>
        </form>
     </td>@endcan
     </tr>
    @endforeach
  </tbody>
</table>


<!-- Modal para añadir usuario-->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Añadir Nuevo usuario</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <form action="{{url('home')}}"  method="POST" class="row g-3">
                @method("POST")
                @csrf
                <input type="hidden" name="form" value="form1">
                <div class="col-md-6">
                    <select class="form-select" name="tipoid" value="{{old('tipoid')}}" required aria-label="Tipo de identifiación">
                        <option selected>Tipo de identifiación</option>
                        @foreach ($tipoids as $tipo)
                         <option value="{{$tipo->id}}">{{$tipo->name}}</option>
                        @endforeach

                      </select>
                </div>
               <div class="col-md-6">
                    <input type="number" class="form-control" value="{{old('id')}}" name="id" placeholder="Número de identificación" id="numeroID" required>
                </div>
                <div class="col-md-6">
                  <label for="validationDefault01" class="form-label">Nombres</label>
                  <input type="text" class="form-control" value="{{old('name')}}" name="name" id="nombres" required>
                </div>
                <div class="col-md-6">
                  <label for="validationDefault02" class="form-label">Apellidos</label>
                  <input type="text" class="form-control" value="{{old('lastname')}}" name="lastname" id="apellidos" required>
                </div>
                <div class="col-md-6">
                    <label for="validationDefault02" class="form-label">Email</label>
                    <input type="email" class="form-control" value="{{old('email')}}" name="email" id="email" required>
                  </div>
                  <div class="col-md-6">
                    <label for="validationDefault02" class="form-label">Salario</label>
                    <input type="number" class="form-control" value="{{old('salario')}}" name="salario" required>
                  </div>
                  <div class="col-md-6">
                    <label for="validationDefault02" class="form-label">Cargo</label>
                    <input type="text" class="form-control" value="{{old('cargo')}}" name="cargo" id="cargo" required>
                  </div>
                <div class="col-12">
                  <button class="btn btn-primary" type="submit">Enviar</button>
                </div>
              </form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

 <!-- Modal crud tipo de identificacion-->
<div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">CRUD Tipo de documento</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form  action="{{'home'}}" method="POST" class="row g-3">
                @csrf
                <input type="hidden" name="form" value="form2">
                <div class="col-md-6">
                  <input type="text" class="form-control" name="name" value="{{old('name')}}" placeholder="Escribe aquí" required>
                </div>
                <div class="col-md-6">
                  <button class="btn btn-primary" type="submit">Guardar</button>
                </div>
              </form>
            <table class="table seguandaria">
                <thead>
                  <tr class="table-primary">
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Editar</th>
                    <th scope="col">Eliminar</th>
                  </tr>
                </thead>
                <tbody>
                 @foreach ($tipoids as $tipo)
                 <tr>
                    <form  action="{{ route('home.update', ['home' => $tipo->id]) }}" method="post" id="form3">
                        @method("PUT") @csrf
                    <th scope="row">{{$tipo->id}}</th>
                    <td> <input type="text" name="name" value="{{$tipo->name}}" required></td>
                    <td><button class="btn btn-warning" type="submit"><i class="bi bi-pencil-square"></i></button>
                    </form></td>

                    @can('eliminar user') <td><form  action="{{ route('home.destroy', ['home' => $tipo->id]) }}" method="post">
                        @method("DELETE") @csrf
                        <input type="hidden" name="form" value="form5">
                         <button class="btn btn-danger" type="submit"><i class="bi bi-clipboard2-x"></i></button>
                        </form>
                    </td>@endcan

                  </tr>
                 @endforeach
                </tbody>
              </table>

        </div>
      </div>
    </div>
  </div>
  @endsection
