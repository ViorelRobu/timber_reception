@extends('adminlte::page')

@section('content_header')
    <h1 class="d-inline">Lista comenzi
        <button id="addClaim" class="btn btn-primary pull-right" data-toggle="modal" data-target="#ordersForm">Adauga comanda</button>
        <a class="btn btn-primary pull-right" href="/claims/export">Descarca lista comenzi</a>
    </h1>
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
      <table id="orders" class="table table-bordered table-hover">
        <thead>
          <tr>
              <th>ID</th>
              <th>Numar</th>
              <th>Data</th>
              <th>Furnizor</th>
              <th>Volum cda</th>
              <th>Volum confirmat</th>
              <th>Volum livrat</th>
              <th>Destinatie</th>
              <th>Termen livrare</th>
              <th>Actiuni</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
@include('orders.form')
@include('orders.delete')

@stop

@section('footer')
    @include('footer')
@endsection

@section('js')
  <script>
    $(document).ready(function () {
      $('#orders').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('orders.index') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'order', name: 'order'},
              {data: 'order_date', name: 'order_date'},
              {data: 'supplier', name: 'supplier'},
              {data: 'ordered_volume', name: 'ordered_volume'},
              {data: 'confirmed_volume', name: 'confirmed_volume'},
              {data: 'delivered_volume', name: 'delivered_volume'},
              {data: 'destination', name: 'destination'},
              {data: 'delivery_term', name: 'delivery_term'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    });

        // add / remove nir details to add nir form
    $(document).ready(function() {
      var limit = 10;
      var limit_invoice = 1;
      var x = 1;
      var x_invoice = 0;
      $('.addBtn').click(function(e) {
        e.preventDefault();
        if (x < limit) {
          $('#order_details').append(`
            <div class="group-order">
            <div class="col-md-12"><hr></div>
                <div class="form-group col-md-10">
                  <label for="position">Pozitie</label>
                  <textarea class="form-control" name="position[]" rows="3" required></textarea>
                </div>
                <div style="margin-top: 40px" class="form-group col-md-2">
                    <button type="button" class="deleteBtn btn btn-danger">Sterge</button>
                </div>
                <div class="form-group col-md-6">
                    <label for="price">Pret</label>
                    <input type="number"
                    class="form-control" name="price[]" placeholder="Pret" min="0" step="0.01" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="currency">Valuta</label>
                  <select class="form-control" name="currency[]">
                    <option>EUR</option>
                    <option>USD</option>
                    <option>RON</option>
                  </select>
                </div>
          </div>`
        );
          x++;
        }
      });
      $('#order_details').on('click', '.deleteBtn', function(e) {
        e.preventDefault();
        $(this).parent('div').parent('div').remove();
        x--;
      });
    });

    $('#ordersForm').on('hidden.bs.modal', function() {
      $(this).find('form')[0].reset();
      $('#id').val('');
      $(document).off('submit');
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
  </script>
@endsection
