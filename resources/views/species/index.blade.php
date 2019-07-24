@extends('adminlte::page')

@section('content_header')
    <h1 class="d-inline">Lista specii <button id="addSpecie" class="btn btn-primary pull-right" data-toggle="modal" data-target="#speciesForm">Adauga specie</button></h1>
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
      <table id="species" class="table table-bordered table-hover">
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
@include('species.form')
@stop


@section('footer')
    @include('footer')
@endsection

@section('js')
  <script>
    $(document).ready(function () {
      $('#species').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('species.index') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'name', name: 'name'},
              {data: 'name_en', name: 'name_en'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    });

    $('#speciesForm').on('hidden.bs.modal', function() {
      $(this).find('form')[0].reset();
      $('form').attr('action', '/species/add');
      $('.modal-title').text('Adauga specie');
      $('#id').val('');
      $(document).off('submit');
    });

    $(document).on('click', '.edit', function() {
      var id = $(this).attr("id");
      $.ajax({
        url: "{{ route('species.fetch') }}",
        method: 'get',
        data: {id:id},
        dataType:'json',
        success: function(data)
            {
                $('.modal-title').text('Editeaza specia');
                $('#id').val(id);
                $('#name').val(data.name);
                $('#name_en').val(data.name_en);
            }
      });

      $(document).on('submit', function() {
        var id = $('#id').val();
        $('form').attr('action', 'species/' + id + '/update');
        $("input[name='_method']").val('PATCH');
      });

    });
  </script>
@endsection