@extends('adminlte::page')

@section('content_header')
    <h1 class="d-inline">Exporta date NIR</h1>
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
            <form action="/nir/export/download" method="POST" target="_blank">
                @method('POST')
                @csrf
                <div class="form-group col-md-2">
                    <input type="hidden">
                </div>
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" id="from" name="from" data-provide="datepicker" data-date-format="yyyy-mm-dd" placeholder="Data inceput" autocomplete="off" required>
                </div>
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" id="to" name="to" data-provide="datepicker" data-date-format="yyyy-mm-dd" placeholder="Data final" autocomplete="off" required>
                </div>
                <div class="form-group col-md-2">
                    <button type="submit" class="btn btn-primary">Exporta</button>
                </div>
                <div class="form-group col-md-2">
                    <input type="hidden">
                </div>
            </form>
        </div>
    </div>
  </div>
@stop


@section('footer')
    @include('footer')
@endsection