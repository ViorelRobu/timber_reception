@extends('adminlte::page')

@section('content_header')
    <h1 class="d-inline">Comisia de receptie<button id="addCountry" class="btn btn-primary pull-right" data-toggle="modal" data-target="#receptionCommitteeForm">Creaza comisie noua</button></h1>
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
      <table id="reception_committee" class="table table-bordered table-hover">
        <thead>
          <tr>
              <th>ID</th>
              <th>Fabrica</th>
              <th>Nume comisie</th>
              <th>Actiuni</th>

          </tr>
        </thead>
      </table>
    </div>
  </div>

@include('reception_committee.add_committee')
@include('reception_committee.history')


@stop


@section('footer')
    @include('footer')
@endsection

@section('js')
  <script>
    $(document).ready(function () {
      $('#reception_committee').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('committee.index') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'company', name: 'company'},
              {data: 'name', name: 'name'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    });

    $(document).on('click', '.edit', function() {
      var id = $(this).attr("id");
      $.ajax({
        url: "{{ route('committee.fetch') }}",
        method: 'get',
        data: {id:id},
        dataType:'json',
        success: function(data)
            {
                $('.modal-title').text('Editeaza nume comisie de receptie');
                $('#id').val(id);
                $("#name").val(data.name);
                $('#company_id').val(data.company_id);
            }
      });

      $(document).on('submit', function() {
        var id = $('#id').val();
        $('form').attr('action', 'reception/' + id + '/update');
        $("input[name='_method']").val('PATCH');
      });

    });

    $(document).on('click', '.history', function() {
      var id = $(this).attr("id");
      $.ajax({
        url: "{{ route('committee.history') }}",
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

    $("#receptionCommitteeHistory").on("hidden.bs.modal", function(){
      $("#history").html("");
    });
  </script>
@endsection
