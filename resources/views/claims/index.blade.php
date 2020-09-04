@extends('adminlte::page')

@section('content_header')
    <h1 class="d-inline">Lista reclamatii <button id="addClaim" class="btn btn-primary pull-right" data-toggle="modal" data-target="#claimsForm">Adauga reclamatie</button></h1>
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
      <table id="claims" class="table table-bordered table-hover">
        <thead>
          <tr>
              <th>ID</th>
              <th>Furnizor</th>
              <th>Data reclamatie</th>
              <th>NIR-uri reclamate</th>
              <th>Defecte</th>
              <th>Cantitate reclamata</th>
              <th>Valoare reclamata</th>
              <th>Valuta</th>
              <th>Observatii</th>
              <th>Rezolvare</th>
              <th>Status</th>
              <th>Actiuni</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
@include('claims.form')
@include('claims.status')
@include('claims.delete')

@can('superadmin')
    @include('claims.reactivate')
@endcan

@can('admin')
  @include('claims.history')
@endcan
@stop

@section('footer')
    @include('footer')
@endsection

@section('js')
  <script>
    $(document).ready(function () {
      $('#claims').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('claims.index') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'name', name: 'name'},
              {data: 'date', name: 'date'},
              {data: 'nir', name: 'nir'},
              {data: 'defects', name: 'defects'},
              {data: 'amount', name: 'amount'},
              {data: 'value', name: 'value'},
              {data: 'currency', name: 'currency'},
              {data: 'observations', name: 'observations'},
              {data: 'resolution', name: 'resolution'},
              {data: 'status', name: 'status'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    });

    $('#nir').focus(function() {
        var supplier_id = $('#supplier_id').val();
        var start = $('#start').val();
        var end = $('#end').val();

        $.ajax({
            url: "{{ route('claims.fetch.nir') }}",
            method: 'get',
            data: {
                supplier_id:supplier_id,
                start:start,
                end:end
            },
            dataType:'json',
            success: function(data)
                {
                    $('#nir').html('');
                    for (const key in data) {
                        if (data.hasOwnProperty(key)) {
                            const element = data[key];
                            $('#nir').append('<option value="' + key + '">' + element + '</option>')
                        }
                    }
                }
        });
    });

    $('#claimsForm').on('hidden.bs.modal', function() {
      $(this).find('form')[0].reset();
      $('form').attr('action', '/claims/add');
      $('.modal-title').text('Adauga reclamatie');
      $('#id').val('');
      $(document).off('submit');
    });

    $('#historyForm').on('hidden.bs.modal', function() {
      $('#history').empty();
    });

    $(document).on('click', '.status', function() {
        var id = $(this).attr("id");
        $.ajax({
            url: "{{ route('claims.fetch') }}",
            method: 'get',
            data: {id:id},
            dataType:'json',
            success: function(data)
            {
                $('#claim_status_id').val(data.claim_status_id);
            }
        });
        $('#changeStatForm').attr('action', 'claims/' + id + '/updateStatus');
        $("input[name='_method']").val('PATCH');
    });

    $(document).on('click', '.reactivate', function() {
        var id = $(this).attr('id');
        $('#reactivate_claim_id').val(id);
    });

    $(document).on('click', '.edit', function() {
      var id = $(this).attr("id");
      $.ajax({
        url: "{{ route('claims.fetch') }}",
        method: 'get',
        data: {id:id},
        dataType:'json',
        success: function(data)
            {
                $('.modal-title').text('Editeaza reclamatia');
                $('#id').val(id);
                $('#supplier_id').val(data.supplier_id);
                $('#claim_date').val(data.claim_date);
                $('#defects').val(data.defects);
                $('#claim_amount').val(data.claim_amount);
                $('#claim_value').val(data.claim_value);
                $('#claim_currency').val(data.claim_currency);
                $('#observations').val(data.observations);
                data.nir.forEach((element, index) => {
                    $('#nir').append('<option value="' + data.nir_id[index] + '" selected>' + element + '</option>');
                });
            }
      });

      $(document).on('submit', function() {
        var id = $('#id').val();
        $('#claimForm').attr('action', '/claims/' + id + '/update');
        $("input[name='_method']").val('PATCH');
      });

    });

    $(document).on('click', '.delete', function() {
        var id = $(this).attr("id");
        $('form').attr('action', 'claims/' + id + '/delete');

    });

    $(document).on('click', '.history', function() {
      var id = $(this).attr("id");
      $.ajax({
        url: "{{ route('claims.history') }}",
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

    $("#certificationHistory").on("hidden.bs.modal", function(){
      $("#history").html("");
    });
  </script>
@endsection
