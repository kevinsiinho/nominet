@extends('layouts.menu')

@section('title','Actualizar')

@section('contenido')

<div class="editar">
    <h1>Informaicón de Usuario</h1>
    <form action="{{ route('home.update', ['home' => $user->id]) }}" method="POST" class="row g-3">
        @method("PUT")
        @csrf
        <input type="hidden" name="form" value="form3">
        <div class="col-md-6">
            <select class="form-select" name="tipoid" value="{{old('tipoid')}}" required aria-label="Tipo de identifiación"
            @can('crear user'){{ '' }}@else{{ 'disabled' }}@endcan required>
                <option selected>Tipo de identifiación</option>
                @foreach ($tipoids as $tipo)
                 <option value="{{$tipo->id}}" @if($tipo->id == $user->TipoID){{'selected'}}  @endif>{{$tipo->name}}</option>
                @endforeach
              </select>
        </div>
       <div class="col-md-6">
            <input type="number" disabled class="form-control" value="{{$user->id}}" name="id" placeholder="Número de identificación" id="numeroID" required>
        </div>
        <div class="col-md-6">
          <label for="validationDefault01" class="form-label">Nombres</label>
          <input type="text" class="form-control" value="{{$user->name}}" name="name" id="nombres" required>
        </div>
        <div class="col-md-6">
          <label for="validationDefault02" class="form-label">Apellidos</label>
          <input type="text" class="form-control" value="{{$user->lastname}}" name="lastname" id="apellidos" required>
        </div>
        <div class="col-md-6">
            <label for="validationDefault02" class="form-label">Email</label>
            <input type="email" class="form-control" value="{{$user->email}}" name="email" id="email" required>
          </div>
          <div class="col-md-6">
            <label for="validationDefault02" class="form-label">Cargo</label>
            <input type="text" class="form-control" value="{{$user->cargo}}" name="cargo" id="cargo" @can('crear user'){{ '' }}@else{{ 'disabled' }}@endcan required>
          </div>
          <div class="col-md-6">
            <label for="validationDefault02" class="form-label">Salario</label>
            <input type="number" class="form-control" value="{{$user->salario}}" name="salario" @can('crear user'){{ '' }}@else{{ 'disabled' }}@endcan required>
          </div>
          <div class="col-md-2">
            <label for="validationDefault02" class="form-label">Horas extras</label>
            <input type="text" class="form-control" disabled required value="{{$totalh}}">
          </div>
          <div class="col-md-2">
            <label for="validationDefault02" class="form-label">Valor Extras</label>
            <input type="text" class="form-control" disabled required value="{{$totalh*7000}}">
          </div>
          <div class="col-md-2">
            <label for="validationDefault02" class="form-label">Salario Neto</label>
            <input type="text" class="form-control" disabled required value="{{$totalp}}">
          </div>
          <div class="col-md-6">
            <label for="validationDefault02" class="form-label">Hora de Llegada</label>
            <input type="datetime-local" class="form-control" value="{{old('llegada')}}" name="llegada">
          </div>
          <div class="col-md-6">
            <label for="validationDefault02" class="form-label">Hora de salida</label>
            <input type="datetime-local" class="form-control" value="{{old('salida')}}" name="salida" >
          </div>
          <div class="col-md-6">
            <select class="form-select" name="rol" value="{{old('rol')}}" required
            @can('crear user'){{ '' }}@else{{ 'disabled' }}@endcan>
                @foreach ($roles as $rol)
                 <option value="{{$rol->id}}" @if($rol->id == $roluser){{'selected'}} @endif>{{$rol->name}}</option>
                @endforeach
              </select>
        </div>
        <div class="col-12">
          <button class="btn btn-primary" type="submit">Actualizar</button>
          <a class="btn btn-outline-primary" href="{{url('home')}}">Regresar</a>
          <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Ver Horas</button>
        </div>
      </form>
</div>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Horario de empleado</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table class="table seguandaria">
                <thead>
                  <tr class="table-primary">
                    <th scope="col">#</th>
                    <th scope="col">Llegada</th>
                    <th scope="col">Salida</th>
                    <th scope="col">Extras</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($horas as $hora)
                        <tr>
                            <td>{{ $loop->iteration}}</td>
                            <td>{{ $hora->llegada}}</td>
                            <td>{{ $hora->salida}}</td>
                            <td>{{ $hora->cantidad}}</td>
                        </tr>
                    @endforeach
                </tbody>
              </table>

        </div>
      </div>
    </div>
  </div>

@endsection
