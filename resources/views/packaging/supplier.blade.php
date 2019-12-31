@extends('adminlte::page')

@section('content_header')
<h1 class="d-inline">
    <strong>Cantitate ambalaj / furnizor</strong>
    @can('user')
        <button id="addGroup" class="btn btn-primary pull-right d-inline" data-toggle="modal" data-target="#addSupplierForm">Adauga</button></h1>
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
      <table id="packaging_supplier" class="table table-bordered table-hover">
        <thead>
          <tr>
              <th>Furnizor</th>
              <th>Ambalaj</th>
              <th>Unitate referinta</th>
              <th>Greutate (kg)</th>
              <th>Actiuni</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>

@can('user')
  @include('packaging.add_supplier')
@endcan

@can('admin')
  @include('packaging.history')
@endcan

@stop


@section('footer')
    @include('footer')
@endsection

@section('js')
  <script>
    $(document).ready(function () {
      $('#packaging_supplier').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('packaging_supplier.index') }}",
          columns: [
              {data: 'supplier', name: 'supplier'},
              {data: 'subgroup_name', name: 'subgroup_name'},
              {data: 'unitate', name: 'unitate'},
              {data: 'greutate', name: 'greutate'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    });

    $(document).on('click', '.edit', function() {
      var id = $(this).attr("id");
      $('.modal-title').text('Editeaza greutate');
      $.ajax({
        url: "{{ route('packaging_supplier.fetch') }}",
        method: 'get',
        data: {id:id},
        dataType:'json',
        success: function(data)
            {
                $('#id').val(id);
                $('#supplier_id').val(data.supplier_id);
                $('#subgroup_id').val(data.subgroup_id);
                $('#unitate').val(data.unitate);
                $('#greutate').val(data.greutate);
            }
      });

      $(document).on('submit', function() {
        var id = $('#id').val();
        $('form').attr('action', '/packaging/supplier/' + id + '/update');
        $("input[name='_method']").val('PATCH');
      });
    });

    $(document).on('click', '.history', function() {
      var id = $(this).attr("id");
      $.ajax({
        url: "{{ route('packaging_supplier.history') }}",
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
