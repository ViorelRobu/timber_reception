@extends('adminlte::page')

@section('content_header')
    <h1 class="d-inline">Drepturi de acces utilizator/companie <button id="addCountry" class="btn btn-primary pull-right" data-toggle="modal" data-target="#userAssginmentForm"> Creaza drepturi de acces</button></h1>
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
      <table id="userAssignments" class="table table-bordered table-hover">
        <thead>
          <tr>
              <th>ID</th>
              <th>Nume utilizator</th>
              <th>Nume companie</th>
              <th>Actiuni</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
@stop

@include('company_assignment.form')

@section('js')
  <script>
    $(document).ready(function () {
      $('#userAssignments').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('user_assignment.index') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'user', name: 'user'},
              {data: 'company', name: 'company'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    });

    // $('#countriesForm').on('hidden.bs.modal', function() {
    //   $(this).find('form')[0].reset();
    //   $('form').attr('action', '/countries/add');
    //   $('.modal-title').text('Adauga tara');
    //   $('#id').val('');
    //   $(document).off('submit');
    // });

    // $(document).on('click', '.edit', function() {
    //   var id = $(this).attr("id");
    //   $.ajax({
    //     url: "{{ route('countries.fetch') }}",
    //     method: 'get',
    //     data: {id:id},
    //     dataType:'json',
    //     success: function(data)
    //         {
    //             $('.modal-title').text('Editeaza tara');
    //             $('#id').val(id);
    //             $('#name').val(data.name);
    //             $('#name_en').val(data.name_en);
    //         }
    //   });

    //   $(document).on('submit', function() {
    //     var id = $('#id').val();
    //     $('form').attr('action', 'countries/' + id + '/update');
    //     $("input[name='_method']").val('PATCH');
    //   });

    // });
  </script>
@endsection
