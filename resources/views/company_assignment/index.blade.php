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
@include('company_assignment.form')
@include('company_assignment.delete')
@stop

@section('footer')
    @include('footer')
@endsection

@section('js')
  <script>
    // load DataTables
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
    // Load the unassigned companies for the user
    $('#user_id').change(function() {
      $.ajax({
        url: "{{ route('loadUnassignedCompanies') }}?user_id=" + $(this).val(),
        method: 'GET',
        success: function(data) {
            $('#company_id').html(data.response);
        }
    });
    });
    // reset the form
    $('#userAssginmentForm').on('hidden.bs.modal', function() {
      $(this).find('form')[0].reset();
      $('form').attr('action', '/companies/assign/add');
      $('.modal-title').text('Drepturi de acces');
      $('#id').val('');
      $(document).off('submit');
    });

    $(document).on('click', '.delete', function() {
      const id = $(this).attr("id");
      $('#delete_id').val(id);
    });


  </script>
@endsection
