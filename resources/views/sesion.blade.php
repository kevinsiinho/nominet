@extends('layouts.menu2')

@section('title','Login')

@section('contenido2')

<div class="col-lg-6 mb-5 mb-lg-0">
            <div class="card">
              <div class="card-body py-5 px-md-5">
                <h1 class="text-center fw-bold ls-tight h1">Iniciar Sesión</h1>
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                <form action="{{'sesion'}}" method="POST">
                    @csrf
                  <div class="form-outline mb-4">
                    <label class="form-label" for="form3Example3">Email</label>
                    <input type="email" name="email" placeholder="example@gmail.com" class="form-control" value="{{old('email')}}" required/>
                  </div>

                  <div class="form-outline mb-4">
                    <label class="form-label" for="form3Example4">Password</label>
                    <input type="password" name="password" placeholder="Escribe aquí" class="form-control" value="{{old('password')}}" required/>
                  </div>

                  <button type="submit" class="btn btn-primary btn-block mb-4 w-100">Ingresar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
@endsection
