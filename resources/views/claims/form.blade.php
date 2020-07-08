<!-- Modal -->
<div class="modal fade" id="claimsForm" tabindex="-1" role="dialog" aria-labelledby="claimsForm" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title d-inline" id="exampleModalLongTitle">Adauga certificare
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </h3>
      </div>
      <div class="modal-body">
        <form id="claimForm" action="/claims/add" method="POST">
            @method('POST')
            @csrf
            <div class="form-row">
                <input type="hidden" name="id" id="id">
                <div class="form-group col-md-8">
                    <select name="supplier_id" id="supplier_id" class="form-control" required>
                        <option value="">-- Selecteaza un furnizor --</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" id="claim_date" name="claim_date" placeholder="Data reclamatie" data-provide="datepicker" data-date-format="yyyy-mm-dd" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" id="start" name="start" placeholder="Livrari de la" data-provide="datepicker" data-date-format="yyyy-mm-dd" autocomplete="off">
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" id="end" name="end" placeholder="Livrari pana la" data-provide="datepicker" data-date-format="yyyy-mm-dd" autocomplete="off">
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <select name="nir[]" id="nir" class="form-control" multiple>

                    </select>
                </div>
                <div class="form-group col-md-12">
                    <input type="text" class="form-control" id="defects" name="defects" placeholder="Principalele defecte" required>
                </div>
                <div class="form-group col-md-4">
                    <input type="number" class="form-control" id="claim_amount" name="claim_amount" placeholder="Cantitate reclamata" min="0" step="0.001" required>
                </div>
                <div class="form-group col-md-4">
                    <input type="number" class="form-control" id="claim_value" name="claim_value" placeholder="Valoare reclamatie" min="0" step="0.01" required>
                </div>
                <div class="form-group col-md-4">
                    <select name="claim_currency" id="claim_currency" class="form-control" required>
                        <option value="EUR">EUR</option>
                        <option value="USD">USD</option>
                        <option value="USD">RON</option>
                    </select>
                </div>
                <div class="form-group col-md-12">
                    <input type="text" name="observations" id="observations" class="form-control" placeholder="Observatii">
                </div>
          </div>
          <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuleaza</button>
                <button type="submit" class="btn btn-primary">Salveaza</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
