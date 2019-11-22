<!-- Modal -->
<div class="modal fade" id="recalculateForm" tabindex="-1" role="dialog" aria-labelledby="recalculateForm" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title d-inline" id="exampleModalLongTitle">Recalculeaza date ambalaje
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </h3>
      </div>
      <div class="modal-body">
        <form action="/packaging/nir/recalculate" method="POST">
            @method('PATCH')
            @csrf
            <input type="hidden" name="update_id" id="update_id" value="">
            Sunteti sigur ca doriti recalcularea datelor despre ambalaje?
      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuleaza</button>
            <button type="submit" class="btn btn-primary">Continua</button>
        </form>
      </div>
    </div>
  </div>
</div>
