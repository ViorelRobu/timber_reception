@extends('adminlte::page')

@section('content_header')
    <h1 class="d-inline">Utilizatori <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#usersForm">Adauga utilizator</button></h1>
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
        <table class="table table-bordered table-hover dataTables" id="users">
          <thead>
            <tr>
              <th>Nume</th>
              <th>Email</th>
              <th>Activ</th>
              <th>Rol</th>
              <th>Creat la</th>
              <th>Actiuni</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
@include('users.form')
@include('users.edit')
@include('users.change')
@stop


@section('footer')
    @include('footer')
@endsection

@section('js')
  <script>
    $(document).ready(function () {
      $('#users').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('users.index') }}",
          columns: [
              {data: 'name', name: 'name'},
              {data: 'email', name: 'email'},
              {data: 'active', name: 'active'},
              {data: 'role', name: 'role'},
              {data: 'created_at', name: 'created_at'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    });

    $('#usersForm').on('hidden.bs.modal', function() {
      $(this).find('form')[0].reset();
      $('form').attr('action', '/users/add');
      $('.modal-title').text('Adauga utilizator');
      $('#id').val('');
      $(document).off('submit');
    });

    $(document).on('click', '.new-user', function () {
        var error = false
        var pass1 = $('#password1').val();
        var pass2 = $('#password2').val();
        if(pass1 != pass2) {
            $('#password1').after('<span class="error">Parolele nu sunt identice!</span>');
            error = true;
        }
        if(error == true) {return false;}
    });

    $(document).on('click', '.edit-user', function () {
        var error = false
        var pass1 = $('#edit_password1').val();
        var pass2 = $('#edit_password2').val();
        if(pass1 != pass2) {
            $('#edit_password1').after('<span class="error">Parolele nu sunt identice!</span>');
            error = true;
        }
        if(error == true) {return false;}
    });

    $(document).on('click', '.edit', function() {
      var id = $(this).attr("id");
      $.ajax({
        url: "{{ route('users.fetch') }}",
        method: 'get',
        data: {id:id},
        dataType:'json',
        success: function(data)
            {
                $('#edit_id').val(id);
                $('#edit_name').val(data.name);
                $('#edit_email').val(data.email);
                $('#active').val(data.active);
            }
      });

      $(document).on('submit', function() {
        var id = $('#edit_id').val();
        $('form').attr('action', '/users/' + id + '/update');
        $("input[name='_method']").val('PATCH');
      });
    });

    $(document).on('click', '.role-form', function() {
      var id = $(this).attr("id");
      $.ajax({
        url: "{{ route('users.fetch') }}",
        method: 'get',
        data: {id:id},
        dataType:'json',
        success: function(data)
            {
                $('#username').html(data.name);
                $('#role').val(data.role);
                $('#role_id').val(data.role_id);
            }
      });

      $(document).on('submit', function() {
        var id = $('#role_id').val();
        $('form').attr('action', '/users/' + id + '/change');
        $("input[name='_method']").val('PATCH');
      });
    });
  </script>
@endsection
