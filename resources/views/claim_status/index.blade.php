@extends('adminlte::page')

@section('content_header')
    <h1 class="d-inline">Lista status reclamatii <button id="addClaimStatus" class="btn btn-primary pull-right" data-toggle="modal" data-target="#claimStatusForm">Adauga status</button></h1>
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
      <table id="claim_status" class="table table-bordered table-hover">
        <thead>
          <tr>
              <th>ID</th>
              <th>Status</th>
              <th>Actiuni</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
@include('claim_status.form')
@stop

@section('footer')
    @include('footer')
@endsection

@section('js')
  <script>
    $(document).ready(function () {
      $('#claim_status').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('claim_status.index') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'status', name: 'status'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    });

    $('#addClaimStatusForm').on('hidden.bs.modal', function() {
      $(this).find('form')[0].reset();
      $('form').attr('action', '/claim_status/add');
      $('.modal-title').text('Adauga status certificare');
      $('#id').val('');
      $(document).off('submit');
    });

    $(document).on('click', '.edit', function() {
      var id = $(this).attr("id");
      $.ajax({
        url: "{{ route('claim_status.fetch') }}",
        method: 'get',
        data: {id:id},
        dataType:'json',
        success: function(data)
            {
                $('.modal-title').text('Editeaza status reclamatie');
                $('#id').val(id);
                $('#status').val(data.status);
            }
      });

      $(document).on('submit', function() {
        var id = $('#id').val();
        $('form').attr('action', 'claim_status/' + id + '/update');
        $("input[name='_method']").val('PATCH');
      });

    });
  </script>
@endsection
