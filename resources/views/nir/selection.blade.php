@extends('adminlte::page')

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
<h2>Printeaza NIR</h2>
  <div class="box">
    <div class="box-body">
        <div class="row">
            <form action="/nir/print" method="POST">
                @method('POST')
                @csrf
                <div class="form-group col-md-2">
                    <input type="hidden">
                </div>
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" id="from_date" name="from_date" data-provide="datepicker" data-date-format="yyyy-mm-dd" placeholder="Data inceput" autocomplete="off">
                </div>
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" id="to_date" name="to_date" data-provide="datepicker" data-date-format="yyyy-mm-dd" placeholder="Data final" autocomplete="off">
                </div>
                <div class="form-group col-md-2">
                    <button type="submit" class="btn btn-primary">Genereaza PDF</button>
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