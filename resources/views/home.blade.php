@extends('adminlte::page')

@section('title', env('APP_NAME'))

@section('content_header')
    <h1>
        <strong>{{ $company_name[0] }}</strong>
    </h1>
@stop

@section('content')
    {!! $deliveries->container() !!}
    
    <div class="row">
        <br>
    </div>
    
    <div class="row">
        <div class="col-lg-3 text-center">
            <h3>Pret mediu luna curenta</h3>
            <h4>{{ round(($current_month['valoare'] / $current_month['volum']),2) }} EUR</h4>
        </div>
        <div class="col-lg-3 text-center">
            <h3>Pret mediu luna curenta/furnizor</h3>
            @foreach ($data_current_month as $data)
                <h4>{{ $data->supplier }} &mdash; {{ round((($data->valoare_factura + $data->transport)/$data->volum),2) }} EUR</h4>
            @endforeach
        </div>
        <div class="col-lg-3 text-center">
            <h3>Pret mediu luna anterioara</h3>
            <h4>{{ round(($last_month['valoare'] / $last_month['volum']),2) }} EUR</h4>
        </div>
        <div class="col-lg-3 text-center">
            <h3>Pret mediu luna anterioara/furnizor</h3>
            @foreach ($data_last_month as $data)
                <h4>{{ $data->supplier }} &mdash; {{ round((($data->valoare_factura + $data->transport)/$data->volum),2) }} EUR</h4>
            @endforeach
        </div>
    </div>
@stop

@section('footer')
    @include('footer')
@endsection

@section('js')
      {!! $deliveries->script() !!}
@endsection