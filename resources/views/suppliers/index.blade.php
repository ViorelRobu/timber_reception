@extends('adminlte::page')

@section('content_header')
    <h1 class="d-inline">Furnizori <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#supplierForm">Adauga furnizor</button></h1>
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
              <th>Fibu</th>
              <th>Calcul Ambalaj</th>
              <th>Nume</th>
              <th>Cod Unic Inregistrare</th>
              <th>Nr. Registru Comert</th>
              <th>Adresa</th>
              <th>Tara rezidenta</th>
              <th>Grup</th>
              <th>Status</th>
              <th>Actiuni</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>        
@include('suppliers.form')
@can('admin')
  @include('suppliers.history')
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
          ajax: "{{ route('suppliers.index') }}",
          columns: [
              {data: 'fibu', name: 'fibu'},
              {data: 'packaging_calculation', name: 'packaging_calculation'},
              {data: 'name', name: 'name'},
              {data: 'cui', name: 'cui'},
              {data: 'j', name: 'j'},
              {data: 'address', name: 'address'},
              {data: 'country', name: 'country'},
              {data: 'supplier_group', name: 'supplier_group'},
              {data: 'supplier_status', name: 'supplier_status'},
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
        url: "{{ route('suppliers.fetch') }}",
        method: 'get',
        data: {id:id},
        dataType:'json',
        success: function(data)
            {
                $('.modal-title').text('Editeaza furnizorul');
                $('#id').val(id);
                $('#fibu').val(data.fibu);
                $('#packaging_calculation').val(data.packaging_calculation);
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

    $(document).on('click', '.history', function() {
      var id = $(this).attr("id");
      $.ajax({
        url: "{{ route('suppliers.history') }}",
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
