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
              <th>Creat la</th>
              <th>Actiuni</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
@include('users.form')
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

    $(document).on('click', '.edit', function() {
      var id = $(this).attr("id");
      $.ajax({
        url: "{{ route('suppliers.fetch') }}",
        method: 'get',
        data: {id:id},
        dataType:'json',
        success: function(data)
            {
                $('.modal-title').text('Editeaza utilizator');
                $('#id').val(id);
                $('#fibu').val(data.fibu);
                $('#name').val(data.name);
                $('#cui').val(data.cui);
                $('#j').val(data.j);
                $('#address').val(data.address);
                $('#country_id').val(data.country_id);
                $('#supplier_group_id').val(data.supplier_group_id);
                $('#supplier_status_id').val(data.supplier_status_id);
            }
      });

      $(document).on('submit', function() {
        var id = $('#id').val();
        $('form').attr('action', 'suppliers/' + id + '/update');
        $("input[name='_method']").val('PATCH');
      });
    });
  </script>
@endsection
