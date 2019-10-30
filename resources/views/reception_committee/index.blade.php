@extends('adminlte::page')

@section('content_header')
    <h1 class="d-inline">Comisia de receptie<button id="addCountry" class="btn btn-primary pull-right" data-toggle="modal" data-target="#receptionCommitteeForm">Adauga membru comisie receptie</button></h1>
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
      <table id="reception_committee" class="table table-bordered table-hover">
        <thead>
          <tr>
              <th>ID</th>
              <th>Fabrica</th>
              <th>Nume membru comisie de receptie</th>
              <th>Valabil pana la</th>
        
          </tr>
        </thead>
      </table>
    </div>
  </div>
@include('reception_committee.form')
@stop


@section('footer')
    @include('footer')
@endsection

@section('js')
  <script>
    $(document).ready(function () {
      $('#reception_committee').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('reception.index') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'company', name: 'company'},
              {data: 'user', name: 'user'},
              {data: 'active_until', name: 'active_until'},
          ]
      });
    });
  </script>
@endsection
