@extends('layouts.menu')

@section('title','Ingresados')

@section('contenido')

<div class="en">
<h1>Se en encuentra en la empresa</h1>
<table class="table principal w-50">
  <thead>
    <tr class="table-primary">
      <th scope="col">#</th>
      <th scope="col">ID</th>
      <th scope="col">Nombre</th>
      <th scope="col">Hora</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($users as $user)
    <tr>
      <th scope="row">{{ $loop->iteration }}</th>
      <td>{{$user->id}}</td>
      <td>{{$user->name}}</td>
      <td>{{$user->llegada}}</td>
     </tr>
    @endforeach
  </tbody>
</table>
</div>
  @endsection
