@extends('adminlte::page')

@section('content_header')
    <h1 class="d-inline">Lista mijloace de transport <button id="addCountry" class="btn btn-primary pull-right" data-toggle="modal" data-target="#vehiclesForm">Adauga mijloc de transport</button></h1>
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
      <table id="vehicles" class="table table-bordered table-hover">
        <thead>
          <tr>
              <th>ID</th>
              <th>Denumire</th>
              <th>Denumire engleza</th>
              <th>Actiuni</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
@stop

@include('vehicles.form')

@section('footer')
    @include('footer')
@endsection

@section('js')
  <script>
    $(document).ready(function () {
      $('#vehicles').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('vehicles.index') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'name', name: 'name'},
              {data: 'name_en', name: 'name_en'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    });

    $('#vehiclesForm').on('hidden.bs.modal', function() {
      $(this).find('form')[0].reset();
      $('form').attr('action', '/vehicles/add');
      $('.modal-title').text('Adauga mijloc de transport');
      $('#id').val('');
      $(document).off('submit');
    });

    $(document).on('click', '.edit', function() {
      var id = $(this).attr("id");
      $.ajax({
        url: "{{ route('vehicles.fetch') }}",
        method: 'get',
        data: {id:id},
        dataType:'json',
        success: function(data)
            {
                $('.modal-title').text('Editeaza mijlocul de transport');
                $('#id').val(id);
                $('#name').val(data.name);
                $('#name_en').val(data.name_en);
            }
      });

      $(document).on('submit', function() {
        var id = $('#id').val();
        $('form').attr('action', 'vehicles/' + id + '/update');
        $("input[name='_method']").val('PATCH');
      });

    });
  </script>
@endsection
