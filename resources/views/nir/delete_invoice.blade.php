<!-- Modal -->
<div class="modal fade" id="deleteInvoiceForm" tabindex="-1" role="dialog" aria-labelledby="deleteInvoiceForm" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h3 class="modal-title d-inline" id="exampleModalLongTitle">Sterge factura
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </h3>
    </div>
    <div class="modal-body">
        <form action="/nir/invoice/delete" method="POST">
            @method('DELETE')
            @csrf
            <input type="hidden" name="delete_id" id="delete_id">
            <h4>Esti sigur ca vrei sa stergi factura? Veti pierde aceste date in mod definitiv!</h4>
    </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuleaza</button>
            <button type="submit" class="deleteInvoiceBtn btn btn-danger">Sunt sigur! Sterge!</button>
        </form>
      </div>
    </div>
  </div>
</div>