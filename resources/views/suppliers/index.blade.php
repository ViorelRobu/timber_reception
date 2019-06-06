@extends('layouts.layout')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Furnizori
      </h1>
    </section>
    
    <!-- Main content -->
    <section class="content container-fluid">
            <div class="box">
      <div class="box-body">
        <table id="all_suppliers" class="table table-bordered table-hover">
          <thead>
          <tr>
            <th>Fibu</th>
            <th>Nume</th>
            <th colspan="2">Date fiscale</th>
            <th>Adresa</th>
            <th>Tara rezidenta</th>
            <th>Grup</th>
            <th>Status</th>
          </tr>
          </thead>
          <tbody>
            @foreach ($suppliers as $supplier)
            <tr>
              <td>
                {{ $supplier->fibu }}
              </td>
              <td>
                {{ $supplier->name }}
              </td>
              <td>
                {{ $supplier->cui }}
              </td>
              <td>
                {{ $supplier->j }}
              </td>
              <td>
                {{ $supplier->address }}
              </td>
              <td>
                {{ $supplier->countryOfResidence->name }}
              </td>
              <td>
                {{ $supplier->supplierGroup->name }}
              </td>
              <td>
                {{ $supplier->supplierStatus->name }}
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>        
    </section>
    <!-- /.content -->
  </div>
@endsection
