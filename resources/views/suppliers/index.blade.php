@extends('adminlte::page')

@section('title', env('APP_NAME') . ' - Furnizori')

{{-- @endsection --}}

@section('content_header')
    <h1>Furnizori</h1>
@stop

@section('content')
    <div class="box">
      <div class="box-body">
        <table class="table table-bordered table-hover dataTables" id="all-suppliers">
          <thead>
            <tr>
              <th>Nr crt</th>
              <th>Fibu</th>
              <th>Nume</th>
              <th>CUI</th>
              <th>J</th>
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

@section('js')
  <script>
    $(document).ready(function () {
      $('#all-suppliers').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('suppliers.index') }}",
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'fibu', name: 'fibu'},
              {data: 'name', name: 'name'},
              {data: 'cui', name: 'cui'},
              {data: 'j', name: 'j'},
              {data: 'address', name: 'address'},
              {data: 'country_id', name: 'country_id'},
              {data: 'supplier_group_id', name: 'supplier_group_id'},
              {data: 'supplier_status_id', name: 'supplier_status_id'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    });
  </script>
@endsection
