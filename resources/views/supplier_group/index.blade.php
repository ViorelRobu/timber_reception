@extends('adminlte::page')

@section('content_header')
    <h1>Grupuri furnizori</h1>
@stop

@section('content')
  <div class="box">
    <div class="box-body">
      <table id="supplier_group" class="table table-bordered table-hover">
        <thead>
          <tr>
              <th>ID</th>
              <th>Denumire</th>
              <th>Actiuni</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
@stop

@section('js')
  <script>
    $(document).ready(function () {
      $('#supplier_group').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('supplier_group.index') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'name', name: 'name'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    });
  </script>
@endsection
