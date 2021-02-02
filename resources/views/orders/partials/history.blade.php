<!-- Modal -->
<div class="modal fade" id="orderHistory" tabindex="-1" role="dialog" aria-labelledby="orderHistory" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title d-inline" id="exampleModalLongTitle">Istoric comanda
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </h3>
      </div>
      <div class="modal-content">
        <div class="row col-lg-12">
            <div class="col-lg-2">
                <h4>Utilizator</h4>
            </div>
            <div class="col-lg-5">
                <h4>Date vechi</h4>
            </div>
            <div class="col-lg-5">
                <h4>Date noi</h4>
            </div>
            @foreach ($audit_order as $audit)
                <div class="col-lg-2">
                    {{ $audit['user'] }}
                    <br>
                    <sup>{{ $audit['created_at'] }} {{ $audit['event'] }}</sup>
                    <br>
                    <sup>Comanda</sup>
                </div>
                <div class="col-lg-5">
                    @foreach ($audit['old_values'] as $key => $value)
                            <div>
                                {{ $key }} &mdash; {{ $value }}
                            </div>
                    @endforeach
                </div>
                <div class="col-lg-5">
                    @foreach ($audit['new_values'] as $key => $value)
                            <div>
                                {{ $key }} &mdash; {{ $value }}
                            </div>
                    @endforeach
                </div>
                <div class="col-lg-12"><hr></div>
            @endforeach
        </div>
        <div class="row col-lg-12">
            @foreach ($audit_order_details as $details)
                <div class="col-lg-2">
                    {{ $details['user'] }}
                    <br>
                    <sup>{{ $details['created_at'] }} {{ $details['event'] }}</sup>
                    <br>
                    <sup>Detalii comanda</sup>
                </div>
                <div class="col-lg-5">
                    @foreach ($details['old_values'] as $key => $value)
                            <div>
                                {{ $key }} &mdash; {{ $value }}
                            </div>
                    @endforeach
                </div>
                <div class="col-lg-5">
                    @foreach ($details['new_values'] as $key => $value)
                            <div>
                                {{ $key }} &mdash; {{ $value }}
                            </div>
                    @endforeach
                </div>
                <div class="col-lg-12"><hr></div>
            @endforeach
        </div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
