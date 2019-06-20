@extends('adminlte::page')

@section('content_header')
    <h1>Date firma</h1>
@stop

@section('content')
    <div class="box">
      <div class="box-body">
        <table class="table table-bordered table-hover dataTables" id="company_info">
          <thead>
            <tr>
              <th>Nume</th>
              <th>Cod Unic Inregistrare</th>
              <th>Nr. Registru Comert</th>
              <th>Adresa</th>
              <th>Cont bancar</th>
              <th>Banca</th>
              <th>Editeaza</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>        
@stop

@section('js')
  <script>
    $(document).ready(function () {
      $('#company_info').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('info.index') }}",
          columns: [
              {data: 'name', name: 'name'},
              {data: 'cui', name: 'cui'},
              {data: 'j', name: 'j'},
              {data: 'address', name: 'address'},
              {data: 'account_number', name: 'account_number'},
              {data: 'bank', name: 'bank'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    });
  </script>
@endsection