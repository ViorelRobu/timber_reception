@extends('adminlte::page')

@section('title', env('APP_NAME'))

@section('content_header')
    <h1>
        <strong>{{ $company_name[0] }}</strong>
    </h1>
@stop

@section('content')
    <p>You are logged in!</p>
@stop