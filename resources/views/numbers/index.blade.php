@extends('adminlte::page')

@section('content_header')
    <h1 class="d-inline">Numere NIR initiale <button id="addCountry" class="btn btn-primary pull-right" data-toggle="modal" data-target="#numbersForm">Declara numar NIR</button></h1>
@stop

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

  <div class="box">
    <div class="box-body">
      <table id="numbers" class="table table-bordered table-hover">
        <thead>
          <tr>
              <th>ID</th>
              <th>Numar NIR de inceput</th>
              <th>Data creare inregistrare</th>
              <th>Fabrica</th>
              <th>Definit de</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
@include('numbers.form')
@stop


@section('footer')
    @include('footer')
@endsection

@section('js')
  <script>
    $(document).ready(function () {
      $('#numbers').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('numbers.index') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'numar_nir', name: 'numar_nir'},
              {data: 'created_at', name: 'created_at'},
              {data: 'name', name: 'name'},
              {data: 'user', name: 'user'}
          ]
      });
    });
  </script>
@endsection
