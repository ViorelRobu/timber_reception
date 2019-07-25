@extends('adminlte::page')

@section('content_header')
  {{-- {{ dd($nir->id) }} --}}
  <h1 class="d-inline"><a href="{{ url()->previous() }}"><i class="fa fa-arrow-left"></i></a>      <strong>Detalii NIR numarul {{ $nir->numar_nir }} din {{ $nir->data_nir }}</strong> - {{ $company }}</h1>
  <input type="hidden" id="id" name="id" value="{{ $nir->id }}">
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
            <h4><strong>Factura:</strong>   {{ $invoice[0]->numar_factura }} / {{ $invoice[0]->data_factura }} <i class="fa fa-edit pull-right"></i><i class="fa fa-trash pull-right"></i></h4>
            <h4><strong>Valoare:</strong> &euro; {{ $invoice[0]->valoare_factura }}</h4>
            <h4><strong>Transport:</strong> &euro; {{ $invoice[0]->valoare_transport }}</h4>
          @endif
        </div>
        <div class="col-sm-12">
          <button type="button" class="btn btn-primary pull-right">Adauga detalii</button>
        </div>
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
              <td class="text-center"><i class="fa fa-edit"></i> <i class="fa fa-trash"></i></td>
            </tr>
          @endforeach
          <tr>
            <td class="text-center" colspan="3"><strong>TOTAL</strong></td>
            <td class="text-center"><strong>{{ $total_aviz }}</strong></td>
            <td class="text-center"><strong>{{ $total_receptionat }}</strong></td>
            <td class="text-center"><strong></strong></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
@stop


@section('footer')
    @include('footer')
@endsection