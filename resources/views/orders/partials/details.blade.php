<!-- Modal -->
<div class="modal fade" id="orderDetailsForm" tabindex="-1" role="dialog" aria-labelledby="orderDetailsForm" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title d-inline" id="exampleModalLongTitle">Adauga detalii
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </h3>
      </div>
    <div class="modal-body">
        <form action="/orders/details/add" method="POST">
            @method('POST')
            @csrf
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="order_id" id="order_id" value="{{ $order->id }}">
            <div class="details d-flex flex-row row">
                <div class="form-group col-md-12">
                  <label for="position">Pozitie</label>
                  <textarea class="form-control" name="position" rows="3" required></textarea>
                </div>
                <div class="form-group col-md-4">
                  <label for="ordered_volume">Volum comandat</label>
                  <input type="number"
                    class="form-control" name="ordered_volume" id="ordered_volume" placeholder="Volum comandat" step="0.010" min="0">
                </div>
                <div class="form-group col-md-4">
                  <label for="confirmed_volume">Volum confirmat</label>
                  <input type="number"
                    class="form-control" name="confirmed_volume" id="confirmed_volume" placeholder="Volum comandat" step="0.010" min="0">
                </div>
                <div class="form-group col-md-4">
                  <label for="delivered_volume">Volum livrat</label>
                  <input type="number"
                    class="form-control" name="delivered_volume" id="delivered_volume" placeholder="Volum comandat" step="0.010" min="0">
                </div>
                <div class="form-group col-md-6">
                    <label for="price">Pret</label>
                    <input type="number"
                    class="form-control" name="price" placeholder="Pret" min="0" step="0.01" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="currency">Valuta</label>
                  <select class="form-control" name="currency">
                    <option>EUR</option>
                    <option>USD</option>
                    <option>RON</option>
                  </select>
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
