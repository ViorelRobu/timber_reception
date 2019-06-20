@extends('adminlte::page')

@section('content_header')
    <h1 class="d-inline">Lista tari <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#countriesForm">Adauga tara</button></h1>
@stop

@section('content')
  <div class="box">
    <div class="box-body">
      <table id="countries" class="table table-bordered table-hover">
        <thead>
          <tr>
              <th>ID</th>
              <th>Denumire</th>
              <th>Denumire engleza</th>
              <th>Actiuni</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
@stop

@include('countries.form')

@section('js')
  <script>
    $(document).ready(function () {
      $('#countries').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('countries.index') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'name', name: 'name'},
              {data: 'name_en', name: 'name_en'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    });
  </script>
@endsection
