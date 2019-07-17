@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/iCheck/square/blue.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">
    @yield('css')
@stop

@section('body_class', 'login-page')

@section('body')
    <div class="login-box">
        <div class="login-logo">
            <h1 class="text-center">Selecteaza fabrica</h1>
        </div>
        <div class="login-box-body">
            <form action="/set_company" method="POST">
                @method('GET')
                @csrf
                <div class="form-group text-center">
                    <select class="form-control" name="company_id" id="company_id" required>
                        <option value="" selected>--- Selecteaza fabrica ---</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                    <br>
                    <button type="submit" class="form-control btn btn-primary">Continua</button>
                </div>
            </form>
        </div>
    </div>
@stop

