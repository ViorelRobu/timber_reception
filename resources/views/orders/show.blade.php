@extends('adminlte::page')

@section('content_header')
  <h1 class="d-inline"><a href="/orders"><i class="fa fa-arrow-left"></i></a>
    <strong>Detalii comanda cherestea {{ $order->order }} din {{ date("d.m.Y", strtotime($order->order_date)) }}</strong> - {{ $company->name }} &nbsp;
    @can('user')
        <a href="/orders/{{ $order->id }}/print/ro" target="_blank" style="color: green"><i class="fa fa-print"></i></a>
        <a href="/orders/{{ $order->id }}/print/en" target="_blank" style="color: red"><i class="fa fa-print"></i></a>
    @endcan
@can('admin')
  <a href="#" class="pull-right" data-toggle="modal" data-target="#orderHistory"><i class="fa fa-history"></i></a>
@endcan
  </h1>
  <input type="hidden" id="order_id" name="order_id" value="{{ $order->id }}">
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
        <div class="col-sm-12">
          <h4><strong>Furnizor:</strong> {{ $supplier->name }}</h4>
          <h4><strong>Destinatie:</strong> {{ $order->destination }}</h4>
          <h4><strong>Termen de livrare:</strong> {{ $order->delivery_term }}</h4>
          <h4><strong>Contitie de livrare:</strong> {{ $order->incoterms }}</h4>
        <div class="col-sm-11 d-inline mx-2">
          @can('user')
            <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#orderDetailsForm">Adauga detalii</button>
          @endcan
        </div>
      </div>
    </div>
  </div>

  <div class="box">
    <div class="box-body">
      <table id="order_details" class="table table-bordered table-hover">
        <thead>
          <tr>
              <th>Descriere</th>
              <th>Dimensiuni</th>
              <th>Volum comandat</th>
              <th>Volum confirmat</th>
              <th>Volum livrat</th>
              <th>Pret/mc</th>
              <th>Valoare comanda</th>
              @can('user')
                <th>Actiuni</th>
              @endcan
          </tr>
        </thead>
        <tbody>
          @foreach ($order_details as $detail)
            <tr>
              <td class="text-center">{{ $detail->position }}</td>
              <td class="text-center">{{ $detail->dimensions }}</td>
              <td class="text-center">{{ $detail->ordered_volume }}</td>
              <td class="text-center">{{ $detail->confirmed_volume }}</td>
              <td class="text-center">{{ $detail->delivered_volume }}</td>
              <td class="text-center">{{ $detail->price . ' ' . $detail->currency }}</td>
              <td class="text-center">{{ $detail->value . ' ' . $detail->currency }}</td>
              @can('user')
                <td class="text-center">
                    <a href="#" id="{{ $detail->id }}" class="addDelivery" data-toggle="modal" data-target="#deliveryForm">
                        <i class="fa fa-truck"></i>
                    </a>
                    <a href="#" id="{{ $detail->id }}" class="editDet" data-toggle="modal" data-target="#orderDetailsForm">
                        <i class="fa fa-edit"></i>
                    </a>
                    <a href="#" id="{{ $detail->id }}" class="delete_details" data-toggle="modal" data-target="#deleteDetailsForm">
                        <i class="fa fa-trash"></i>
                    </a>
                </td>
              @endcan
            </tr>
          @endforeach
          <tr style="background: lightgrey">
            <td class="text-center" colspan="2"><strong>TOTAL</strong></td>
            <td class="text-center"><strong>{{ $total_ordered }}</strong></td>
            <td class="text-center"><strong>{{ $total_confirmed }}</strong></td>
            <td class="text-center"><strong>{{ $total_delivered }}</strong></td>
            <td class="text-center" colspan="2"><strong>{{ $total_value . ' ' . $detail->currency }}</strong></td>
            @can('user')
              <td class="text-center"><strong></strong></td>
            @endcan
          </tr>
        </tbody>
      </table>
    </div>
  </div>

@can('user')
  @include('orders.partials.details')
  @include('orders.partials.delivery')
  @include('orders.partials.delete_detail')
@endcan
@can('admin')
  @include('orders.partials.history')
@endcan

@stop


@section('footer')
    @include('footer')
@endsection

@section('js')
  <script>
    $('.editDet').on('click', function() {
        var id = $(this).attr("id");
        $.ajax({
          url: "{{ route('orders.fetchDetail') }}",
          method: 'get',
          data: {id:id},
          dataType:'json',
          success: function(data)
              {
                  $('.modal-title').text('Editeaza pozitie');
                  $('#id').val(id);
                  $('#position').val(data.position);
                  $('#dimensions').val(data.dimensions);
                  $('#ordered_volume').val(data.ordered_volume);
                  $('#confirmed_volume').val(data.confirmed_volume);
                  $('#price').val(data.price);
                  $('#currency').val(data.currency);
              }
        });
        $(document).on('submit', function() {
          var id = $('#id').val();
          $('form').attr('action', '/orders/update/detail');
          $("input[name='_method']").val('PATCH');
      });
    });

    $('#orderDetailsForm').on('hidden.bs.modal', function() {
      $(this).find('form')[0].reset();
      $('form').attr('action', '/orders/' + {{ $order->id }} + '/add/detail');
      $('.modal-title').text('Adauga detalii');
      $('#id').val('');
      $(document).off('submit');
    });

    $('.delete_details').on('click', function() {
      const id = $(this).attr("id");
      $('#delete_id').val(id);
    });

    $('.addDelivery').on('click', function() {
      const id = $(this).attr("id");
      $('#delivery_id').val(id);
        $.ajax({
          url: "{{ route('orders.fetchDetail') }}",
          method: 'get',
          data: {id:id},
          dataType:'json',
          success: function(data)
              {
                  $('#delivered_volume').val(data.delivered_volume);
              }
        });
    });

  </script>
@endsection
