<!-- Modal -->
<div class="modal fade" id="ordersForm" tabindex="-1" role="dialog" aria-labelledby="ordersForm" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title d-inline" id="exampleModalLongTitle">Adauga comanda noua
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </h3>
      </div>
      <div class="modal-body">
        <form id="claimForm" action="/orders/add" method="POST">
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
                        <input type="text" class="form-control pull-right" id="order_date" name="order_date" placeholder="Data " data-provide="datepicker" data-date-format="yyyy-mm-dd" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group col-md-6">
                  <label for="destination">Destination</label>
                  <input type="text"
                    class="form-control" name="destination" id="destination" placeholder="Destinatie" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="delivery_term">Termen de livrare</label>
                  <input type="text"
                    class="form-control" name="delivery_term" id="delivery_term" placeholder="Termen de livrare" required>
                </div>
            </div>
            <div id="order_details" class="form-row d-flex flex-row">
                <div class="col-md-12"><hr></div>
                <h4 class="text-center col-md-12">
                    Detalii comanda
                </h4>
                <div class="col-md-12"><hr></div>
                <div class="form-group col-md-10">
                  <label for="position">Pozitie</label>
                  <textarea class="form-control" name="position[]" rows="3" required></textarea>
                </div>
                <div style="margin-top: 40px" class="form-group col-md-2">
                    <button type="button" class="addBtn btn btn-secondary">Adauga pozitie</button>
                </div>
                <div class="form-group col-md-6">
                    <label for="price">Pret</label>
                    <input type="number"
                    class="form-control" name="price[]" placeholder="Pret" min="0" step="0.01" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="currency">Valuta</label>
                  <select class="form-control" name="currency[]">
                    <option>EUR</option>
                    <option>USD</option>
                    <option>RON</option>
                  </select>
                </div>
            </div>
            <div class="col-md-12"><hr></div>
          <div class="modal-footer">
              <div class="col-md-12">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuleaza</button>
                  <button type="submit" class="btn btn-primary">Salveaza</button>
              </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
