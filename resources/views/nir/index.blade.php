@extends('adminlte::page')

@section('content_header')
  <h1 class="d-inline"><strong>Lista NIR</strong> - {{ $company_name[0] }} 
  @can('user')
    <button id="addCountry" class="btn btn-primary pull-right" data-toggle="modal" data-target="#nirFormAdd">Adauga NIR</button></h1>
  @endcan
@stop

@section('content')
@if (session()->get('details_error'))
  <div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>	
      <strong>{{ session()->get('details_error') }}</strong>
  </div>
@endif

@if (session()->get('invoice_error'))
  <div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>	
      <strong>{{ session()->get('invoice_error') }}</strong>
  </div>
@endif

@if ($errors->any())
  @foreach ($errors->all() as $error)
    <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
        <strong>{{ $error }}</strong>
    </div>
  @endforeach
@endif

  <div class="box">
    <div class="box-body">
      <table id="nir" class="table table-bordered table-hover">
        <thead>
              <th>NIR</th>
              <th>Data NIR</th>
              <th>Numar WE</th>
              <th>Furnizor</th>
              <th>DVI</th>
              <th>Data DVI</th>
              <th>Serie aviz</th>
              <th>Numar aviz</th>
              <th>Data aviz</th>
              <th>Specificatie</th>
              <th>Transport</th>
              <th>Numar inmatriculare</th>
              <th>Certificare</th>
              <th>Actiuni</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
  
@can('user')
  @include('nir.form')
  @include('nir.add')
@endcan

@stop


@section('footer')
    @include('footer')
@endsection

@section('js')
  <script>
    $(document).ready(function () {
      $('#nir').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('nir.index') }}",
          columns: [
              {data: 'numar_nir', name: 'numar_nir'},
              {data: 'data_nir', name: 'data_nir'},
              {data: 'numar_we', name: 'numar_we'},
              {data: 'supplier', name: 'supplier'},
              {data: 'dvi', name: 'dvi'},
              {data: 'data_dvi', name: 'data_dvi'},
              {data: 'serie_aviz', name: 'serie_aviz'},
              {data: 'numar_aviz', name: 'numar_aviz'},
              {data: 'data_aviz', name: 'data_aviz'},
              {data: 'specificatie', name: 'specificatie'},
              {data: 'vehicle', name: 'vehicle'},
              {data: 'numar_inmatriculare', name: 'numar_inmatriculare'},
              {data: 'certificare', name: 'certificare'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    });

    $('#nirForm').on('shown.bs.modal', function() {
      var company_id = document.querySelector('#company_id').value;
    });

    $(document).ready(function(e) {
      
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
          $('.details').append(`
            <div class="group-nir">
              <div class="form-group col-md-4">
                  <select class="custom-select form-control" name="article_id[]" id="article_id" required>
                      <option value="" selected>--- Articol ---</option>
                      @foreach ($articles as $article)
                          <option value="{{ $article->id }}">{{ $article->name }}</option>
                      @endforeach
                  </select>
              </div>
              <div class="form-group col-md-3">
                  <select class="custom-select form-control" name="species_id[]" id="species_id" required>
                      <option value="" selected>--- Specie ---</option>
                      @foreach ($species as $species)
                          <option value="{{ $species->id }}">{{ $species->name }}</option>
                      @endforeach
                  </select>
              </div>
              <div class="form-group col-md-3">
                  <select class="custom-select form-control" name="moisture_id[]" id="moisture_id" required>
                      <option value="" selected>--- Grup ---</option>
                      @foreach ($moistures as $moisture)
                          <option value="{{ $moisture->id }}">{{ $moisture->name }}</option>
                      @endforeach
                  </select>
              </div>
              <div class="form-group col-md-2">
                  <button type="button" class="remBtn btn btn-danger">Sterge</button>
              </div>
              <div class="form-group col-md-3">
                  <input type="number" class="form-control" id="volum_aviz" step="0.01" min="0" name="volum_aviz[]" placeholder="Volum aviz" required>
              </div>
              <div class="form-group col-md-3">
                  <input type="number" class="form-control" id="volum_receptionat" step="0.001" min="0" name="volum_receptionat[]" placeholder="Volum factura" required>
              </div>
              <div class="form-group col-md-3">
                  <input type="number" class="form-control" id="pachete" step="1" name="pachete[]" min="0" placeholder="Numar pachete" required>
              </div>
              <div class="form-group col-md-3">
                  <input type="number" class="form-control" id="total_ml" step="0.01" min="0" name="total_ml[]" placeholder="Total lungimi pachete" required>
              </div>
              <div class="col-xs-12"><hr></div>
          </div>`
        );
          x++;
        } 
      });
      $('.details').on('click', '.remBtn', function(e) {
        e.preventDefault();
        $(this).parent('div').parent('div').remove();
        x--;
      });

      $('.addInvBtn').click(function(e) {
        e.preventDefault();
        if (x_invoice < limit_invoice) {
          $('.factura').append(`
            <div class="grup-factura">
              <div class="fom-group col-md-12">
                <h4 class="text-center">Factura</h4>
                <hr>
              </div>
              <div class="form-group col-md-3">
                <input type="hidden" name="invoice_to_add" value="true">
                <input type="text" class="form-control pull-right" id="numar_factura" name="numar_factura" placeholder="Numar factura" autocomplete="off" required>
              </div>
              <div class="form-group col-md-3">
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="data_factura" name="data_factura" data-provide="datepicker" data-date-format="yyyy-mm-dd" placeholder="Data Factura" autocomplete="off" required>
                </div>
              </div>
              <div class="form-group col-md-2">
                <input type="number" class="form-control pull-right" id="valoare_factura" name="valoare_factura" step="0.01" placeholder="Valoare factura" autocomplete="off" required>
              </div>
              <div class="form-group col-md-2">
                <input type="number" class="form-control pull-right" id="valoare_transport" name="valoare_transport" step="0.01" placeholder="Valoare transport" autocomplete="off" required>
              </div>
              <div class="form-group col-md-2">
                <button type="button" class="remInvBtn btn btn-danger">Sterge factura</button>
              </div>
            </div>`
            );
          x_invoice++;
        }
      });

      $('.factura').on('click', '.remInvBtn', function(e) {
        e.preventDefault();
        $(this).parent('div').parent('div').remove();
        x_invoice--;
      });
    });

    $(document).on('click', '.edit', function() {
      var id = $(this).attr("id");
      $.ajax({
        url: "{{ route('nir.fetch') }}",
        method: 'get',
        data: {id:id},
        dataType:'json',
        success: function(data)
            {
                $('#id').val(id);
                $('#committee_id').val(data.committee_id);
                $('#numar_nir').val(data.numar_nir).prop('disabled', true);
                $('#data_nir').val(data.data_nir);
                $('#numar_we').val(data.numar_we);
                $('#supplier_id').val(data.supplier_id);
                $('#dvi').val(data.dvi);
                $('#data_dvi').val(data.data_dvi);
                $('#greutate_bruta').val(data.greutate_bruta);
                $('#greutate_neta').val(data.greutate_neta);
                $('#serie_aviz').val(data.serie_aviz);
                $('#numar_aviz').val(data.numar_aviz);
                $('#data_aviz').val(data.data_aviz);
                $('#specificatie').val(data.specificatie);
                $('#vehicle_id').val(data.vehicle_id);
                $('#numar_inmatriculare').val(data.numar_inmatriculare);
                $('#certification_id').val(data.certification_id);
            }
      });
      
      $(document).on('submit', function() {
        var id = $('#id').val();
        $('form').attr('action', 'nir/' + id + '/update');
        $("input[name='_method']").val('PATCH');
      });
    });
  </script>
@endsection
