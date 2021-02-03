<!-- Modal -->
<div class="modal fade" id="deliveryForm" tabindex="-1" role="dialog" aria-labelledby="deliveryForm" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title d-inline" id="exampleModalLongTitle">Adauga livrare
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </h3>
      </div>
    <div class="modal-body">
        <form action="/orders/add/delivery" method="POST">
            @method('PATCH')
            @csrf
            <div class="details d-flex flex-row row">
                <input type="hidden" name="delivery_id" id="delivery_id">
                <div class="form-group col-md-12">
                  <label for="delivered_volume">Volum livrat</label>
                  <input type="number"
                    class="form-control" name="delivered_volume" id="delivered_volume" placeholder="Volum confirmat" step="0.001" min="0">
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
