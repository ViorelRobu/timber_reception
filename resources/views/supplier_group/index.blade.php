@extends('adminlte::page')

@section('content_header')
    <h1 class="d-inline">Grupuri furnizori <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#supplierGroupForm">Creaza grup</button></h1>
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
      <table id="supplier_group" class="table table-bordered table-hover">
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
@include('supplier_group.form')
@can('admin')
  @include('supplier_group.history')
@endcan
@stop


@section('footer')
    @include('footer')
@endsection

@section('js')
  <script>
    $(document).ready(function () {
      $('#supplier_group').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('supplier_group.index') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'name', name: 'name'},
              {data: 'name_en', name: 'name_en'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    });

    $('#supplierGroupForm').on('hidden.bs.modal', function(){
      $(this).find('form')[0].reset();
      $('form').attr('action', '/supplier_group/add');
      $('.modal-title').text('Adauga grup');
      $('#id').val('');
      $(document).off('submit');
    });

    $(document).on('click', '.edit', function () {
      var id = $(this).attr("id");
      $.ajax({
        url: "{{ route('supplier_group.fetch') }}",
        method: 'get',
        data: {id:id},
        dataType:'json',
        success: function(data)
            {
                $('.modal-title').text('Editeaza grupul');
                $('#id').val(id);
                $('#name').val(data.name);
                $('#name_en').val(data.name_en);
            }
      });

      $(document).on('submit', function() {
        var id = $('#id').val();
        $('form').attr('action', 'supplier_group/' + id + '/update');
        $("input[name='_method']").val('PATCH');
      });

    });

    $(document).on('click', '.history', function() {
      var id = $(this).attr("id");
      $.ajax({
        url: "{{ route('supplier_group.history') }}",
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

    $("#supplierGroupHistory").on("hidden.bs.modal", function(){
      $("#history").html("");
    });
  </script>
@endsection
