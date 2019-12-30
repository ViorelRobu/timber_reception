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
@include('info.form')
@include('info.history')
@stop


@section('footer')
    @include('footer')
@endsection

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

    $(document).on('click', '.history', function() {
      var id = $(this).attr("id");
      $.ajax({
        url: "{{ route('companies.history') }}",
        method: 'get',
        data: {id:id},
        dataType:'json',
        success: function(data)
            {
              var p1 = '<div class="col-lg-2">';
              var p2 = '<br><sup>';
              var p3 = '</sup></div><div class="col-lg-5"><div>';
              var p4 = '</div></div><div class="col-lg-5"><div>';
              var p5 = '</div></div><div class="col-lg-12"><hr></div>';


                data.forEach(element => {
                  var newValues = '';
                  var new_values = Object.entries(element.new_values);
                  new_values.forEach(value => {
                    newValues += '<p>' + value[0] + ' &mdash; ' + value[1] + '</p>';
                  });
                  var oldValues = '';
                  var old_values = Object.entries(element.old_values);
                  old_values.forEach(value => {
                    oldValues += '<p>' + value[0] + ' &mdash; ' + value[1] + '</p>';
                  });
                  $('#history').append( p1 + element.user + p2 + element.created_at + ' ' + element.event + p3 + oldValues + p4 + newValues + p5)
                });
            }
      });
    });

    $("#history").on("hidden.bs.modal", function(){
      $("#history").html("");
    });
  </script>
@endsection
