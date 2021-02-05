<!-- Modal -->
<div class="modal fade" id="copyOrder" tabindex="-1" role="dialog" aria-labelledby="copyOrder" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h3 class="modal-title d-inline" id="exampleModalLongTitle">Copiere comanda
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </h3>
    </div>
    <div class="modal-body">
        <form action="/orders/copy" method="POST">
            @method('POST')
            @csrf
            <input type="hidden" name="copy_id" id="copy_id">
            <h4>Esti sigur ca vrei sa creezi o copie dupa comanda <span id="copy_order"></span> ?</h4>
    </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuleaza</button>
            <button type="submit" class="deleteDetailsBtn btn btn-danger">Creaza copie comanda!</button>
        </form>
      </div>
    </div>
  </div>
</div>
