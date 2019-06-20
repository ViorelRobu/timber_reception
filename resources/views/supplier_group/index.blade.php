@extends('adminlte::page')

@section('content_header')
    <h1 class="d-inline">Grupuri furnizori <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#supplierGroupForm">Creaza grup</button></h1>
@stop

@section('content')
  <div class="box">
    <div class="box-body">
      <table id="supplier_group" class="table table-bordered table-hover">
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

@include('supplier_group.form')

@section('js')
  <script>
    $(document).ready(function () {
      $('#supplier_group').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('supplier_group.index') }}",
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
