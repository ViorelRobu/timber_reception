<!-- Modal -->
<div class="modal fade" id="editOrdersForm" tabindex="-1" role="dialog" aria-labelledby="editOrdersForm" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title d-inline" id="exampleModalLongTitle">Editeaza comanda
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </h3>
      </div>
      <div class="modal-body">
        <form id="editOrder" method="POST">
            @method('PATCH')
            @csrf
            <div class="form-row">
                <input type="hidden" name="id" id="edit_id">
                <div class="form-group col-md-12">
                    <select name="supplier_id" id="edit_supplier_id" class="form-control" required>
                        <option value="">-- Selecteaza un furnizor --</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                  <label for="destination">Destination</label>
                  <input type="text"
                    class="form-control" name="destination" id="edit_destination" placeholder="Destinatie" required>
                </div>
                <div class="form-group col-md-4">
                  <label for="delivery_term">Termen de livrare</label>
                  <input type="text"
                    class="form-control" name="delivery_term" id="edit_delivery_term" placeholder="Termen de livrare" required>
                </div>
                <div class="form-group col-md-4">
                  <label for="incoterms">Conditie de livrare</label>
                  <input type="text"
                    class="form-control" name="incoterms" id="edit_incoterms" placeholder="Conditie de livrare" required>
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
