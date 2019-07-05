@extends('adminlte::page')

@section('content_header')
    <h1>Date firma
      <button id="addCountry" class="btn btn-primary pull-right" data-toggle="modal" data-target="#companyForm">Adauga firma</button>
    </h1>
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

@include('info.form')

@section('js')
  <script>
    $(document).ready(function () {
      $('#company_info').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('companies.index') }}",
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