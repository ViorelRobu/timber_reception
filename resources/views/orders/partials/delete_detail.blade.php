<!-- Modal -->
<div class="modal fade" id="deleteDetailsForm" tabindex="-1" role="dialog" aria-labelledby="deleteDetailsForm" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h3 class="modal-title d-inline" id="exampleModalLongTitle">Sterge pozitie
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </h3>
    </div>
    <div class="modal-body">
        <form action="/orders/details/delete" method="POST">
            @method('DELETE')
            @csrf
            <input type="hidden" name="delete_detail_id" id="delete_detail_id">
            <h4>Esti sigur ca vrei sa stergi aceasta pozitie? Veti pierde aceste date in mod definitiv!</h4>
    </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuleaza</button>
            <button type="submit" class="deleteDetailsBtn btn btn-danger">Sunt sigur! Sterge!</button>
        </form>
      </div>
    </div>
  </div>
</div>
