<!-- Modal -->
<div class="modal fade" id="invoiceForm" tabindex="-1" role="dialog" aria-labelledby="invoiceForm" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title d-inline" id="exampleModalLongTitle">Adauga factura
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </h3>
      </div>
    <div class="modal-body">
        <form action="/nir/invoice/add" method="POST">
            @method('POST')
            @csrf
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="nir_id" id="nir_id" value="{{ isset($nir->id) ? $nir->id : '' }}">
            <div class="form-row">
                <div class="grup-factura">
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control pull-right" id="numar_factura" name="numar_factura" placeholder="Numar factura" autocomplete="off" required>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" id="data_factura" name="data_factura" data-provide="datepicker" data-date-format="yyyy-mm-dd" placeholder="Data Factura" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="number" class="form-control pull-right" id="valoare_factura" step="0.01" name="valoare_factura" placeholder="Valoare factura" autocomplete="off" required>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="number" class="form-control pull-right" id="valoare_transport" step="0.01" name="valoare_transport" placeholder="Valoare transport / Comision" autocomplete="off" required>
                    </div>
                </div>
            </div>
        </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuleaza</button>
            <button type="submit" class="btn btn-primary">Salveaza</button>
        </form>
      </div>
    </div>
  </div>
</div>