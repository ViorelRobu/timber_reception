@extends('adminlte::page')

@section('content_header')
<h1 class="d-inline">
    <strong>Ambalaje</strong>
    @can('user')
      <button id="export" class="btn btn-primary pull-right d-inline" data-toggle="modal" data-target="#exportPackaging">Exporta date ambalaj</button>
      <button id="recalculate" class="btn btn-primary pull-right d-inline" data-toggle="modal" data-target="#recalculateFormMultiple">Recalculeaza ambalaj pentru perioada</button>
    @endcan
</h1>

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
      <table id="packaging" class="table table-bordered table-hover">
        <thead>
          <tr>
              <th>NIR</th>
              <th>Data NIR</th>
              <th>Furnizor</th>
              <th>Ambalaj</th>
              <th>Actiuni</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>

@can('admin')
    @include('packaging.history')
@endcan
@can('user')
    @include('packaging.multiple')
    @include('packaging.recalculate')
    @include('packaging.export')
@endcan

@stop


@section('footer')
    @include('footer')
@endsection

@section('js')
  <script>
    $(document).ready(function () {
      $('#packaging').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('packaging.index') }}",
          columns: [
              {data: 'nir', name: 'nir', orderable: false, searchable: false},
              {data: 'data_nir', name: 'subgroup_name'},
              {data: 'supplier', name: 'supplier'},
              {data: 'data', name: 'data'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    });

    $(document).on('click', '.update', function() {
      var id = $(this).attr("id");
      $('#update_id').val(id);
    });

    $(document).on('click', '.history', function() {
      var id = $(this).attr("id");
      $.ajax({
        url: "{{ route('packaging.history') }}",
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
                  $('#history').append( p1 + element.user + p2 + element.created_at + ' ' + element.event + p3 + element.old_values + p4 + element.new_values + p5)
                });
            }
      });
    });

    $("#packagingHistory").on("hidden.bs.modal", function(){
      $("#history").html("");
    });

  </script>
@endsection
