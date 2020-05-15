@extends('adminlte::page')

@section('content_header')
    <h1 class="d-inline">Furnizori <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#supplierForm">Adauga subfurnizor</button></h1>
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
        <table class="table table-bordered table-hover dataTables" id="all-suppliers">
          <thead>
            <tr>
              <th>Id</th>
              <th>Furnizor</th>
              <th>Subfurnizor</th>
              <th>Tara rezidenta</th>
              <th>Actiuni</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
@include('sub_suppliers.form')
@can('admin')
  @include('sub_suppliers.history')
@endcan
@stop


@section('footer')
    @include('footer')
@endsection

@section('js')
  <script>
    $(document).ready(function () {
      $('#all-suppliers').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('sub.index') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'supplier', name: 'supplier'},
              {data: 'name', name: 'name'},
              {data: 'country', name: 'country'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    });

    $('#vehiclesForm').on('hidden.bs.modal', function() {
      $(this).find('form')[0].reset();
      $('form').attr('action', '/suppliers/add');
      $('.modal-title').text('Adauga furnizor');
      $('#id').val('');
      $(document).off('submit');
    });

    $(document).on('click', '.edit', function() {
      var id = $(this).attr("id");
      $.ajax({
        url: "{{ route('sub.fetch') }}",
        method: 'get',
        data: {id:id},
        dataType:'json',
        success: function(data)
            {
                $('.modal-title').text('Editeaza subfurnizorul');
                $('#id').val(id);
                $('#supplier_id').val(data.supplier);
                $('#name').val(data.name);
                $('#country_id').val(data.country_id);
            }
      });

      $(document).on('submit', function() {
        var id = $('#id').val();
        $('form').attr('action', 'sub_suppliers/' + id + '/update');
        $("input[name='_method']").val('PATCH');
      });
    });

    $(document).on('click', '.history', function() {
      var id = $(this).attr("id");
      $.ajax({
        url: "{{ route('sub.history') }}",
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

    $("#supplierHistory").on("hidden.bs.modal", function(){
      $("#history").html("");
    });

  </script>
@endsection
