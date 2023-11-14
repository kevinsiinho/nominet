@extends('layouts.menu2')

@section('title','Registrar horas extras')

@section('contenido2')

<div class="col-lg-6 mb-5 mb-lg-0">
            <div class="card">
              <div class="card-body py-5 px-md-5">
                <h1 class="text-center fw-bold ls-tight h1">Registrar Hora de Llegada o Salida</h1>
                <form id="form" method="POST">
                    @csrf
                  <div class="form-outline mb-4">
                    <select class="form-select" name="tipoid" id="tipoid" required>
                        <option selected>Tipo de identifiación</option>
                        @foreach ($tipoids as $tipo)
                         <option value="{{$tipo->id}}">{{$tipo->name}}</option>
                        @endforeach
                      </select>
                  </div>

                  <div class="form-outline mb-4">
                    <label class="form-label" for="form3Example4">Número de Identificación</label>
                    <input type="number" name="id" id="id" placeholder="Escribe aquí" class="form-control" required/>
                  </div>

                  <button type="button" id="btn-verificar" class="btn btn-primary btn-block mb-4 w-100">Verificar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
@endsection

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/app.js') }}"></script>
