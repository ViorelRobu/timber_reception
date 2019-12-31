@extends('adminlte::page')

@section('content_header')
  <h1 class="d-inline"><strong>Subgrupa ambalaje</strong>
  @can('admin')
    <button id="addGroup" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addSubForm">Adauga subgrupa</button></h1>
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
      <table id="packaging_sub" class="table table-bordered table-hover">
        <thead>
          <tr>
              <th>ID</th>
              <th>Subgrupa</th>
              <th>Grupa principala</th>
              <th>Actiuni</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>

@include('packaging.add_sub')
@include('packaging.history')

@stop


@section('footer')
    @include('footer')
@endsection

@section('js')
  <script>
    $(document).ready(function () {
      $('#packaging_sub').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('packaging_sub.index') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'name', name: 'name'},
              {data: 'main_name', name: 'main_name'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    });

    $(document).on('click', '.edit', function() {
      var id = $(this).attr("id");
      $('.modal-title').text('Editeaza subgrupa');
      $.ajax({
        url: "{{ route('packaging_sub.fetch') }}",
        method: 'get',
        data: {id:id},
        dataType:'json',
        success: function(data)
            {
                $('#id').val(id);
                $('#name').val(data.name);
                $('#main_id').val(data.main_id);
            }
      });
      
      $(document).on('submit', function() {
        var id = $('#id').val();
        $('form').attr('action', '/packaging/sub/' + id + '/update');
        $("input[name='_method']").val('PATCH');
      });
    });

  $(document).on('click', '.history', function() {
      var id = $(this).attr("id");
      $.ajax({
        url: "{{ route('packaging_sub.history') }}",
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

    $("#packagingHistory").on("hidden.bs.modal", function(){
      $("#history").html("");
    });
  </script>
@endsection
