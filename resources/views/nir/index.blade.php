@extends('adminlte::page')

@section('content_header')
  <h1 class="d-inline"><strong>Lista NIR</strong> - {{ $company_name[0] }} <button id="addCountry" class="btn btn-primary pull-right" data-toggle="modal" data-target="#nirForm">Adauga NIR</button></h1>
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
      <table id="nir" class="table table-bordered table-hover">
        <thead>
          <tr>
              <th>Company ID</th>
              <th>NIR</th>
              <th>Data NIR</th>
              <th>Numar WE</th>
              <th>Furnizor</th>
              <th>DVI</th>
              <th>Data DVI</th>
              <th>Serie aviz</th>
              <th>Numar aviz</th>
              <th>Data aviz</th>
              <th>Specificatie</th>
              <th>Transport</th>
              <th>Numar inmatriculare</th>
              <th>Certificare</th>
              <th>Actiuni</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
@stop

@include('nir.form')

@section('footer')
    @include('footer')
@endsection

@section('js')
  <script>
    $(document).ready(function () {
      $('#nir').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('nir.index') }}",
          columns: [
              {data: 'company_id', name: 'company_id'},
              {data: 'numar_nir', name: 'numar_nir'},
              {data: 'data_nir', name: 'data_nir'},
              {data: 'numar_we', name: 'numar_we'},
              {data: 'supplier', name: 'supplier'},
              {data: 'dvi', name: 'dvi'},
              {data: 'data_dvi', name: 'data_dvi'},
              {data: 'serie_aviz', name: 'serie_aviz'},
              {data: 'numar_aviz', name: 'numar_aviz'},
              {data: 'data_aviz', name: 'data_aviz'},
              {data: 'specificatie', name: 'specificatie'},
              {data: 'vehicle', name: 'vehicle'},
              {data: 'numar_inmatriculare', name: 'numar_inmatriculare'},
              {data: 'certificare', name: 'certificare'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    });

    $('#nirForm').on('hidden.bs.modal', function() {
      $(this).find('form')[0].reset();
      $('form').attr('action', '/nir/add');
      $('.modal-title').text('Adauga NIR');
      $('#id').val('');
      $(document).off('submit');
    });

    $('#nirForm').on('shown.bs.modal', function() {
      var company_id = document.querySelector('#company_id').value();
      alert('test');
    });

    // $(document).on('click', '.edit', function() {
    //   var id = $(this).attr("id");
    //   $.ajax({
    //     url: "{{ route('countries.fetch') }}",
    //     method: 'get',
    //     data: {id:id},
    //     dataType:'json',
    //     success: function(data)
    //         {
    //             $('.modal-title').text('Editeaza tara');
    //             $('#id').val(id);
    //             $('#name').val(data.name);
    //             $('#name_en').val(data.name_en);
    //         }
    //   });

    //   $(document).on('submit', function() {
    //     var id = $('#id').val();
    //     $('form').attr('action', 'countries/' + id + '/update');
    //     $("input[name='_method']").val('PATCH');
    //   });
    // });
  </script>
@endsection
