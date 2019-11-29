<!-- Modal -->
<div class="modal fade" id="NIRHistory" tabindex="-1" role="dialog" aria-labelledby="NIRHistory" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title d-inline" id="exampleModalLongTitle">Istoric NIR   <small>NIR, detalii NIR si factura</small>
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
            @foreach ($audit_nir as $audit)
                <div class="col-lg-2">
                    {{ $audit->user->name }}
                    <br>
                    <sup>{{ $audit->created_at->toDateTimeString() }} {{ $audit->event }}</sup>
                    <br>
                    <sup>NIR</sup>
                </div>
                <div class="col-lg-5">
                    @foreach ($audit->old_values as $key => $value)
                            <div>
                                {{ $key }} - {{ $value }}
                            </div>
                    @endforeach
                </div>
                <div class="col-lg-5">
                    @foreach ($audit->new_values as $key => $value)
                            <div>
                                {{ $key }} - {{ $value }}
                            </div>
                    @endforeach
                </div>
                <div class="col-lg-12"><hr></div>
            @endforeach
        </div>
        <div class="row col-lg-12">
            @foreach ($nir_details_audits as $details)
                <div class="col-lg-2">
                    {{ $details['user'] }}
                    <br>
                    <sup>{{ $details['created_at'] }} {{ $details['event'] }}</sup>
                    <br>
                    <sup>Detalii nir</sup>
                </div>
                <div class="col-lg-5">
                    @foreach ($details['old_values'] as $key => $value)
                            <div>
                                {{ $key }} - {{ $value }}
                            </div>
                    @endforeach
                </div>
                <div class="col-lg-5">
                    @foreach ($details['new_values'] as $key => $value)
                            <div>
                                {{ $key }} - {{ $value }}
                            </div>
                    @endforeach
                </div>
                <div class="col-lg-12"><hr></div>
            @endforeach
        </div>
        {{-- <div class="row col-lg-12">
            @if ($audit_nir_invoice != null)
            @foreach ($audit_nir_invoice as $invoices)
                @foreach ($invoice as $audit)
                    <div class="col-lg-2">
                        {{ $audit->user->name }}
                        <br>
                        <sup>{{ $audit->created_at->toDateTimeString() }}</sup>
                        <br>
                        <sup>Detalii factura</sup>
                    </div>
                    <div class="col-lg-5">
                        @foreach ($audit->old_values as $key => $value)
                                <div>
                                    {{ $key }} - {{ $value }}
                                </div>
                        @endforeach
                    </div>
                    <div class="col-lg-5">
                        @foreach ($audit->new_values as $key => $value)
                                <div>
                                    {{ $key }} - {{ $value }}
                                </div>
                        @endforeach
                    </div>
                    <div class="col-lg-12"><hr></div>
                @endforeach
            @endforeach
            @endif
        </div> --}}
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>