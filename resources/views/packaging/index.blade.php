@extends('adminlte::page')

@section('content_header')<h1 class="d-inline"><strong>Ambalaje</strong></h1>

@stop

@section('content')

@if ($errors->any())
  @foreach ($errors->all() as $error)
    <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
        <strong>{{ $error }}</strong>
    </div>
  @endforeach
@endif

  <div class="box">
    <div class="box-body">
      <table id="packaging" class="table table-bordered table-hover">
        <thead>
          <tr>
              <th>Furnizor</th>
              <th>Ambalaj</th>
              <th>Unitate referinta</th>
              <th>Greutate (kg)</th>
              <th>Actiuni</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>

@stop


@section('footer')
    @include('footer')
@endsection

@section('js')
  <script>
    $(document).ready(function () {
      $('#packaging_supplier').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('packaging_supplier.index') }}",
          columns: [
              {data: 'supplier', name: 'supplier'},
              {data: 'subgroup_name', name: 'subgroup_name'},
              {data: 'unitate', name: 'unitate'},
              {data: 'greutate', name: 'greutate'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    });

  </script>
@endsection
