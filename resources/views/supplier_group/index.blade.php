@extends('layouts.layout')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Grupa furnizori
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
                @foreach ($supplier_group as $group)
                <tr>
                <td>
                    {{ $group->id }}
                </td>
                <td>
                    {{ $group->name }}
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
