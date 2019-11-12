@extends('adminlte::page')

@section('content_header')
    <h1 class="d-inline">Comisia de receptie<button id="addCountry" class="btn btn-primary pull-right" data-toggle="modal" data-target="#receptionCommitteeForm">Adauga membru comisie receptie</button></h1>
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
              <th>Nume membru comisie de receptie</th>
              <th>Activ</th>
              <th>Actiuni</th>

          </tr>
        </thead>
      </table>
    </div>
  </div>
@include('reception_committee.form')
@include('reception_committee.upload')
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
          ajax: "{{ route('reception.index') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'company', name: 'company'},
              {data: 'member', name: 'member'},
              {data: 'active', name: 'active'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    });

    $(document).on('click', '.edit', function() {
      var id = $(this).attr("id");
      $.ajax({
        url: "{{ route('reception_committee.fetch') }}",
        method: 'get',
        data: {id:id},
        dataType:'json',
        success: function(data)
            {
                $('.modal-title').text('Editeaza date membru');
                $('#id').val(id);
                $("#member").val(data.member);
                $('#active').val(data.active);
            }
      });

      $(document).on('submit', function() {
        var id = $('#id').val();
        $('form').attr('action', 'reception/' + id + '/update');
        $("input[name='_method']").val('PATCH');
      });

    });

    $(document).on('click', '.upload', function() {
      var id = $(this).attr("id");
      $.ajax({
        url: "{{ route('reception_committee.fetch') }}",
        method: 'get',
        data: {id:id},
        dataType:'json',
        success: function(data)
            {
                $('#id_upload').val(id);
                $("#member_upload").val(data.member);
                $('#active_upload').val(data.active);
            }
      });

      $(document).on('submit', function() {
        var id = $('#id_upload').val();
        $('form').attr('action', 'reception/' + id + '/upload');
        $("input[name='_method']").val('PATCH');
      });

    });
  </script>
@endsection
