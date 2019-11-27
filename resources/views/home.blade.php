@extends('adminlte::page')

@section('title', env('APP_NAME'))

@section('content_header')
    <h1>
        <strong>{{ $company_name[0] }}</strong>
    </h1>
@stop

@section('content')
    {!! $deliveries->container() !!}
@stop

@section('footer')
    @include('footer')
@endsection

@section('js')
      {!! $deliveries->script() !!}
@endsection