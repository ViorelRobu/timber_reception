@extends('adminlte::page')

@section('content_header')
  {{-- {{ dd($nir->id) }} --}}
  <h1 class="d-inline"><a href="/nir"><i class="fa fa-arrow-left"></i></a>      <strong>Detalii NIR numarul {{ $nir->numar_nir }} din {{ $nir->data_nir }}</strong> - {{ $company }}</h1>
  <input type="hidden" id="nir_id" name="nir_id" value="{{ $nir->id }}">
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
      <div class="row">
        <div class="col-sm-8">
          <h4><strong>Furnizor:</strong> {{ $supplier }}</h4>
          @if ($nir->numar_we)
            <h4><strong>Numar WE:</strong> {{ $nir->numar_we }}</h4>
          @endif
          @if ($nir->dvi)
            <h4><strong>DVI:</strong> {{ $nir->dvi }} din {{ $nir->data_dvi }}</h4>
          @endif
          <h4><strong>Aviz:</strong> {{ $nir->serie_aviz }} {{ $nir->numar_aviz }} din {{ $nir->data_aviz }}</h4>
          @if ($nir->specificatie)
            <h4><strong>Specificatie:</strong> {{ $nir->specificatie }}</h4>
          @endif
          <h4><strong>Livrat cu:</strong> {{ $vehicle }} {{ $nir->numar_inmatriculare }}</h4>
          <h4><strong>Certificare:</strong> {{ $certification }}</h4>
          @if ($nir->greutate_bruta || $nir->greutate_neta)
            <h4><strong>Greutate (brut / net):</strong> {{ $nir->greutate_bruta }} kg / {{ $nir->greutate_neta }} kg</h4>
          @endif
        </div>
        <div class="col-sm-4">
          @if ($invoice->count() !== 0)
            <h4><strong>Factura:</strong>   {{ $invoice[0]->numar_factura }} / {{ $invoice[0]->data_factura }} <a href="" id="{{ $invoice[0]->id }}" class="delete" data-toggle="modal" data-target="#deleteInvoiceForm"><i class="fa fa-trash pull-right"></i></a><a href="" id="{{ $invoice[0]->id }}" class="editInvoice" data-toggle="modal" data-target="#invoiceForm"><i class="fa fa-edit pull-right"></i></a><a href="/nir/{{ $nir->id }}/print" target="_blank" ><i class="fa fa-print pull-right"></i></a></h4>
            <h4><strong>Valoare:</strong> &euro; {{ $invoice[0]->valoare_factura }}</h4>
            <h4><strong>Transport:</strong> &euro; {{ $invoice[0]->valoare_transport }}</h4>
          @endif
        </div>
        <div class="col-sm-11 d-inline mx-2">
          <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#nirDetailsForm">Adauga detalii</button>
        </div>
        @if (count($invoice) === 0)
          <div class="col-sm-1 d-inline mx-2">
            <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#invoiceForm">Adauga factura</button>
          </div>
        @endif
      </div>
    </div>
  </div>

  <div class="box">
    <div class="box-body">
      <table id="nir_detais" class="table table-bordered table-hover">
        <thead>
          <tr>
              <th>Articol</th>
              <th>Specie</th>
              <th>Umiditate</th>
              <th>Volum aviz</th>
              <th>Volum receptionat</th>
              <th>Numar pachete</th>
              <th>Total ml pachete</th>
              <th>Actiuni</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($nir_details as $detail)
            <tr>
              <td class="text-center">{{ $detail->article }}</td>
              <td class="text-center">{{ $detail->species }}</td>
              <td class="text-center">{{ $detail->moisture }}</td>
              <td class="text-center">{{ $detail->volum_aviz }}</td>
              <td class="text-center">{{ $detail->volum_receptionat }}</td>
              <td class="text-center">{{ $detail->pachete }}</td>
              <td class="text-center">{{ $detail->total_ml }}</td>
              <td class="text-center"><a href="#" id="{{ $detail->id }}" class="editDet" data-toggle="modal" data-target="#nirDetailsForm"><i class="fa fa-edit"></i></a> <a href="#" id="{{ $detail->id }}" class="delete_details" data-toggle="modal" data-target="#deleteDetailsForm"><i class="fa fa-trash"></i></a></td>
            </tr>
          @endforeach
          <tr style="background: lightgrey">
            <td class="text-center" colspan="3"><strong>TOTAL</strong></td>
            <td class="text-center"><strong>{{ $total_aviz }}</strong></td>
            <td class="text-center"><strong>{{ $total_receptionat }}</strong></td>
            <td class="text-center"><strong>{{ $total_pachete }}</strong></td>
            <td class="text-center"><strong>{{ $total_ml }}</strong></td>
            <td class="text-center"><strong></strong></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
@include('nir.invoice')
@include('nir.details')
@include('nir.delete_invoice')
@include('nir.delete_detail')
@stop


@section('footer')
    @include('footer')
@endsection

@section('js')
  <script>
    $('#invoiceForm').on('hidden.bs.modal', function() {
      $(this).find('form')[0].reset();
      $('form').attr('action', '/nir/invoice/add');
      $('.modal-title').text('Adauga factura');
      $('#id').val('');
      $(document).off('submit');
    });

    $(document).on('click', '.editInvoice', function() {
      var id = $(this).attr("id");
      $.ajax({
        url: "{{ route('invoice.fetch') }}",
        method: 'get',
        data: {id:id},
        dataType:'json',
        success: function(data)
            {
                $('.modal-title').text('Editeaza factura');
                $('#id').val(id);
                $('#numar_factura').val(data.numar_factura);
                $('#data_factura').val(data.data_factura);
                $('#valoare_factura').val(data.valoare_factura);
                $('#valoare_transport').val(data.valoare_transport);
            }
      });

      $(document).on('submit', function() {
        var id = $('#id').val();
        $('form').attr('action', '/nir/invoice/' + id + '/update');
        $("input[name='_method']").val('PATCH');
      });
    });

    $(document).on('click', '.delete', function() {
      const id = $(this).attr("id");
      $('#delete_id').val(id);
    });

    $('.editDet').on('click', function() {
        var id = $(this).attr("id");
        $.ajax({
          url: "{{ route('details.fetch') }}",
          method: 'get',
          data: {id:id},
          dataType:'json',
          success: function(data)
              {
                  $('.modal-title').text('Editeaza pozitie');
                  $('#id').val(id);
                  $('#article_id').val(data.article_id);
                  $('#species_id').val(data.species_id);
                  $('#moisture_id').val(data.moisture_id);
                  $('#volum_aviz').val(data.volum_aviz);
                  $('#volum_receptionat').val(data.volum_receptionat);
                  $('#pachete').val(data.pachete);
                  $('#total_ml').val(data.total_ml);
              }
        });
        $(document).on('submit', function() {
          var id = $('#id').val();
          $('form').attr('action', '/nir/details/' + id + '/update');
          $("input[name='_method']").val('PATCH');
      });
    });

    $('#nirDetailsForm').on('hidden.bs.modal', function() {
      $(this).find('form')[0].reset();
      $('form').attr('action', '/nir/details/add');
      $('.modal-title').text('Adauga detalii');
      $('#id').val('');
      $(document).off('submit');
    });

    $('.delete_details').on('click', function() {
      const id = $(this).attr("id");
      $('#delete_detail_id').val(id);
    });

  </script>
@endsection