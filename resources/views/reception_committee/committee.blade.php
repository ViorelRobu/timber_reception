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
  </script>
@endsection
