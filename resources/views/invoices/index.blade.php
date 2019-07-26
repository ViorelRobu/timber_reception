@extends('adminlte::page')

@section('content_header')
    <h1 class="d-inline"><strong>Lista facturi</strong> - {{ $company_name }}</h1>
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
      <table id="invoices" class="table table-bordered table-hover">
        <thead>
          <tr>
              <th>NIR</th>
              <th>Data NIR</th>
              <th>Furnizor</th>
              <th>Factura</th>
              <th>Data factura</th>
              <th>Valoare factura</th>
              <th>Valoare transport</th>
              <th>Actiuni</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
@include('nir.invoice')
@stop


@section('footer')
    @include('footer')
@endsection

@section('js')
  <script>
    $(document).ready(function () {
      $('#invoices').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('invoices.index') }}",
          columns: [
              {data: 'nir', name: 'nir'},
              {data: 'data_nir', name: 'data_nir'},
              {data: 'supplier', name: 'supplier'},
              {data: 'numar_factura', name: 'numar_factura'},
              {data: 'data_factura', name: 'data_factura'},
              {data: 'valoare_factura', name: 'valoare_factura'},
              {data: 'valoare_transport', name: 'valoare_transport'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    });

    $(document).on('click', '.edit', function() {
      var id = $(this).attr("id");
      $('.modal-title').text('Editeaza factura');
      $.ajax({
        url: "{{ route('invoice.fetch') }}",
        method: 'get',
        data: {id:id},
        dataType:'json',
        success: function(data)
            {
                $('.modal-title').text('Editeaza tara');
                $('#id').val(id);
                $('#nir_id').val(data.nir_id);
                $('#numar_factura').val(data.numar_factura);
                $('#data_factura').val(data.data_factura);
                $('#valoare_factura').val(data.valoare_factura);
                $('#valoare_transport').val(data.valoare_transport);
            }
      });

      $(document).on('submit', function() {
        var id = $('#id').val();
        $('form').attr('action', 'invoice/' + id + '/update');
        $("input[name='_method']").val('PATCH');
      });
    });
  </script>
@endsection
