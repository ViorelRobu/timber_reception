@extends('adminlte::page')

@section('content_header')
    <h1 class="d-inline">Furnizori <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#supplierForm">Adauga furnizor</button></h1>
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
        <table class="table table-bordered table-hover dataTables" id="all-suppliers">
          <thead>
            <tr>
              <th>Fibu</th>
              <th>Nume</th>
              <th>Cod Unic Inregistrare</th>
              <th>Nr. Registru Comert</th>
              <th>Adresa</th>
              <th>Tara rezidenta</th>
              <th>Grup</th>
              <th>Status</th>
              <th>Actiuni</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>        
@stop

@include('suppliers.form')

@section('js')
  <script>
    $(document).ready(function () {
      $('#all-suppliers').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('suppliers.index') }}",
          columns: [
              {data: 'fibu', name: 'fibu'},
              {data: 'name', name: 'name'},
              {data: 'cui', name: 'cui'},
              {data: 'j', name: 'j'},
              {data: 'address', name: 'address'},
              {data: 'country', name: 'country'},
              {data: 'supplier_group', name: 'supplier_group'},
              {data: 'supplier_status', name: 'supplier_status'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    });
  </script>
@endsection
