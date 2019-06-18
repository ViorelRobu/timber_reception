@extends('adminlte::page')

@section('title', env('APP_NAME'))

@section('content_header')
    <h1>Dashboard</h1>
    {{ env('APP_NAME') }}
@stop

@section('content')
    <p>You are logged in!</p>
@stop