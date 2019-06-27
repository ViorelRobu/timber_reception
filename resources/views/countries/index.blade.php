@extends('adminlte::page')

@section('content_header')
    <h1 class="d-inline">Lista tari <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#countriesForm">Adauga tara</button></h1>
@stop

@section('content')
  <div class="box">
    <div class="box-body">
      <table id="countries" class="table table-bordered table-hover">
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

@include('countries.form')

@section('js')
  <script>
    $(document).ready(function () {
      $('#countries').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('countries.index') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'name', name: 'name'},
              {data: 'name_en', name: 'name_en'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    });

    $('#countriesForm').on('hidden.bs.modal', function(){
      $(this).find('form')[0].reset();
      $('.modal-title').text('Adauga tara');
      $('#id').val('');
    });

    $(document).on('click', '.edit', function () {
      var id = $(this).attr("id");
      $.ajax({
        url: "{{ route('countries.fetch') }}",
        method: 'get',
        data: {id:id},
        dataType:'json',
        success: function(data)
            {
                $('.modal-title').text('Editeaza tara');
                $('#id').val(id);
                $('#name').val(data.name);
                $('#name_en').val(data.name_en);
            }
      });

      $(document).on('submit', function() {
        var id = $('#id').val();
        $('form').attr('action', 'countries/' + id + '/update');
        $("input[name='_method']").val('PATCH');
      });

    });
  </script>
@endsection
