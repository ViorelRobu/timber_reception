@extends('adminlte::page')

@section('content_header')
<h1 class="d-inline">
    <strong>Ambalaje</strong>
    @can('admin')
        <button id="recalculate" class="btn btn-primary pull-right d-inline" data-toggle="modal" data-target="#recalculateFormMultiple">Recalculeaza ambalaj pentru perioada</button></h1>
    @endcan
</h1>

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
              <th>NIR</th>
              <th>Data NIR</th>
              <th>Furnizor</th>
              <th>Ambalaj</th>
              <th>Actiuni</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>

@can('admin')
  @include('packaging.recalculate')
  @include('packaging.multiple')
@endcan

@stop


@section('footer')
    @include('footer')
@endsection

@section('js')
  <script>
    $(document).ready(function () {
      $('#packaging').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('packaging.index') }}",
          columns: [
              {data: 'nir', name: 'nir'},
              {data: 'data_nir', name: 'subgroup_name'},
              {data: 'supplier', name: 'supplier'},
              {data: 'data', name: 'data'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    });

    $(document).on('click', '.update', function() {
      var id = $(this).attr("id");
      $('#update_id').val(id);
    });

  </script>
@endsection
