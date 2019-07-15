@extends('adminlte::page')

@section('content_header')
    <h1>Date firma
      <button id="addCountry" class="btn btn-primary pull-right" data-toggle="modal" data-target="#companyForm">Adauga firma</button>
    </h1>
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

    $('#supplierGroupForm').on('hidden.bs.modal', function(){
      $(this).find('form')[0].reset();
      $('form').attr('action', '/supplier_group/add');
      $('.modal-title').text('Adauga grup');
      $('#id').val('');
      $(document).off('submit');
    });

    $(document).on('click', '.edit', function () {
      var id = $(this).attr("id");
      $.ajax({
        url: "{{ route('companies.fetch') }}",
        method: 'get',
        data: {id:id},
        dataType:'json',
        success: function(data)
            {
                $('.modal-title').text('Editeaza datele firmei');
                $('#id').val(id);
                $('#name').val(data.name);
                $('#cui').val(data.cui);
                $('#j').val(data.j);
                $('#address').val(data.address);
                $('#account_number').val(data.account_number);
                $('#bank').val(data.bank);
            }
      });

      $(document).on('submit', function() {
        var id = $('#id').val();
        $('form').attr('action', 'companies/' + id + '/update');
        $("input[name='_method']").val('PATCH');
      });
    });
  </script>
@endsection