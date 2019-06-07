@extends('layouts.layout')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Lista tari
      </h1>
    </section>
    
    <!-- Main content -->
    <section class="content container-fluid">
    <div class="box col-md-6">
      <div class="box-body">
            <table id="countries" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Denumire</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($countries as $country)
                <tr>
                <td>
                    {{ $country->id }}
                </td>
                <td>
                    {{ $country->name }}
                </td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
      </div>
    </div>        
    </section>
    <!-- /.content -->
  </div>
@endsection
