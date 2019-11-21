@extends('adminlte::page')

@section('content_header')
  <h1 class="d-inline"><strong>Grupa principala ambalaje</strong>
  @can('admin')
    <button id="addGroup" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addMainForm">Adauga grupa</button></h1>
  @endcan
@stop

@section('content')

@if ($errors->any())
  @foreach ($errors->all() as $error)
    <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
        <strong>{{ $error }}</strong>
    </div>
  @endforeach
@endif

  <div class="box">
    <div class="box-body">
      <table id="packaging_main" class="table table-bordered table-hover">
        <thead>
          <tr>
              <th>Nume grup principal amabalaje</th>
              <th>Actiuni</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
  
@can('admin')
  @include('packaging.add_main')
@endcan

@stop


@section('footer')
    @include('footer')
@endsection

@section('js')
  <script>
    $(document).ready(function () {
      $('#packaging_main').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('packaging_main.index') }}",
          columns: [
              {data: 'name', name: 'name'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    });

    $(document).on('click', '.edit', function() {
      var id = $(this).attr("id");
      $('.modal-title').text('Editeaza grupa');
      $.ajax({
        url: "{{ route('packaging_main.fetch') }}",
        method: 'get',
        data: {id:id},
        dataType:'json',
        success: function(data)
            {
                $('#id').val(id);
                $('#name').val(data.name);
            }
      });
      
      $(document).on('submit', function() {
        var id = $('#id').val();
        $('form').attr('action', '/packaging/main/' + id + '/update');
        $("input[name='_method']").val('PATCH');
      });
    });

  </script>
@endsection
